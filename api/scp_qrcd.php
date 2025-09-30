<?php 
    
    require '../vendor/autoload.php';
    
    use Endroid\QrCode\QrCode;
    use Endroid\QrCode\Writer\PngWriter;
    $rqst = json_decode(json_encode($_GET));
    $qr_text = "https://www.agilesaptech.com/scp/api/scp_pass.php?pass_id={$rqst->pass_id}";
    $qr_code = QrCode::create($qr_text);
    $writer = new PngWriter;
    $image = $writer->write($qr_code);
        
    header("Content-Type:".$image->getMimeType());
    echo $image->getString();
?>