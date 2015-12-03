<?php    
    include_once '../html2pdf/html2pdf.class.php';

    $pdf = new HTML2PDF('P', 'A4', 'fr', 'true', 'UTF-8');
    $pdf->writeHTML('<p style="color:red;">test</p>');
    ob_end_clean();
    $pdf->Output('liste.pdf');
?>