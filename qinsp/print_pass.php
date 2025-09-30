<?php 
    require '../incld/verify.php';
    require '../stloc/check_auth.php';
    require '../incld/autoload.php';
    $util = new Model\Util();
    if(isset($_GET['pass_id'])) {
        $rqst = json_decode(json_encode($_GET));
        $query = "select a.*,b.zvehn,b.erdat,b.erzet from veh_item as a inner join veh_pass as b on b.pass_id = a.pass_id where a.pass_id = ?";
        $param = array($rqst->pass_id);
        $items = $util->execQuery($query,$param);
    }
    require '../vendor/autoload.php';
    $pdf = new TCPDF('L', 'mm', [75, 100], true, 'UTF-8', false);
    $pdf->SetCreator('QA Department');
    $pdf->SetAuthor('QA Department');
    $pdf->SetTitle('Material Tag');
    $pdf->SetSubject('Material Identification Tag');
    $pdf->SetKeywords('TCPDF, PDF, composer');

    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    $pdf->SetMargins(5, 5, 5);
    $pdf->SetAutoPageBreak(FALSE, 3);
    $pdf->SetFont('helvetica', '', 12);
    foreach($items as $item) {
        $query = "select b.lifnr,b.objnm from veh_chln as a inner join supplier as b on b.lifnr = a.supp_id where a.pass_id = ? and chln_id = ?";
        $param = array($item->pass_id,$item->chln_id);
        $chln  = $util->execQuery($query,$param,1);
        $item->matnr = ltrim($item->matnr,'0');
        $chln->lifnr = ltrim($chln->lifnr,'0');
        $pdf->AddPage();
       
        $html = <<<HTML
                    <style>
                        table {
                            border-collapse: collapse;
                            width: 100%;
                        }
                        td {
                            border: 1px solid #000;
                            line-height: 20px;   /* Controls row height */
                            padding: 2px 5px;
                            font-size: 10pt;
                        }
                    </style>
                    HTML;
        $html .= "<h4 style='align:center;'>Baramati CattleFeed Private Limited</h4>
                  <table border='1'>
                    <tr><td style='width:50px;'><h2>Vehicle No</h2></td>
                        <td style='width:70px;'><h2>{$item->zvehn}</h2></td>
                    </tr>
                    <tr>
                        <td>
                            Pass No
                        </td>
                        <td>
                            {$item->pass_id} {$item->erdat} {$item->erzet}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Vendor No
                        </td>
                        <td>
                            <?php echo {$chln->lifnr}_{$chln->objnm}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Material
                        </td>
                        <td>
                            {$item->matnr}_{$item->txz01}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Packing
                        </td>
                        <td>
                            {$item->zchbg} : {$item->zpmat}
                        </td>
                    </tr>
                </table>";
        $pdf->writeHTML($html, true, false, true, false, '');
    }
    

    $pdf->Output('pass_mtag.pdf', 'I');


?>