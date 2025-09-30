<?php 
    require '../incld/verify.php';
    require '../stloc/check_auth.php';
    require '../incld/autoload.php';
    $util = new Model\Util();
    if(isset($_GET['objky'])) {
        $rqst = json_decode(json_encode($_GET));
        $query = "select * from veh_item where objky = ?";
        $param = array($rqst->objky);
        $item  = $util->execQuery($query,$param,1);
        $item->matnr = ltrim($item->matnr,'0');
        $query = "select b.lifnr,b.objnm from veh_chln as a inner join supplier as b on b.lifnr = a.supp_id where a.pass_id = ? and chln_id = ?";
        $param = array($item->pass_id,$item->chln_id);
        $chln  = $util->execQuery($query,$param,1);
        $chln->lifnr = ltrim($chln->lifnr,'0');
        $query = "select * from veh_data where pass_id = ?";
        $param = array(substr($item->objky,0,10));
        $pass = $util->execQuery($query,$param,1);
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

     $style = array(
        'border' => 2,
        'padding' => 'auto',
        'fgcolor' => array(0,0,0), // Black foreground
        'bgcolor' => array(255,255,255) // White background
    );

    $pdf->AddPage();
    $pdf->write2DBarcode("{$pass->pass_id}", 'QRCODE,H', 80, 2, 15, 15, $style, 'N');
       
    $html = '<table border="1" cellpadding="5">
                <tr>
                    <td width="40%">Vehicle No</td>
                    <td width="60%">'.$pass->zvehn.'</td>
                </tr>
                <tr>
                    <td>Veh Pass No</td>
                    <td>'.$pass->pass_id.'</td>
                </tr>
                <tr>
                    <td>Date & Time</td>
                    <td>'.$pass->erdat.' '.$pass->erzet.'</td>
                </tr>
                <tr>
                    <td>Plant</td>
                    <td>'.$item->werks.'</td>
                </tr>
                <tr>
                    <td>Material</td>
                    <td>'.$item->matnr.' '.$item->txz01.'</td>
                </tr>
            </table>';
    
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('pass_mtag.pdf', 'I');


?>