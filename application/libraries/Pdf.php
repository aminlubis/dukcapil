<?php 
require_once('tcpdf/tcpdf.php');

class PDF extends TCPDF {
	function print_pdf($html, $title) { 

        $pdf = new TCPDF('P', PDF_UNIT, array(297,210), true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        
        $pdf->SetAuthor('SWAP - Single Window Application');
        $pdf->SetTitle($title);

    // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

    // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT,PDF_MARGIN_BOTTOM);

    // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    
    // auto page break //
        $pdf->SetAutoPageBreak(TRUE, 30);

        //set page orientation
        
    // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->SetFont('helvetica', '', 11);
        $pdf->ln();

        //kotak form
        $pdf->AddPage('P', 'A4');
        $pdf->setY(10);
        $pdf->setXY(10,10);
        $pdf->SetMargins(10, 10, 10, 10); 
        /* $pdf->Cell(150,42,'',1);*/

        $result = $html;

        // output the HTML content
        $pdf->writeHTML($result, true, false, true, false, '');
            
        ob_end_clean();
        $pdf->Output(''.$title.'.pdf', 'I'); 
        

    }
}