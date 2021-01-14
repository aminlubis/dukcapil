<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class GenerateHtml extends MX_Controller {

	var $address_invoice = "";
	var $address_tiket = "";

	function __construct() {
		parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
		$this->load->library('pdf');
	}

	function ExecutiveSummary($id) { 

		// data bencana
        $disaster = $this->db->get_where('v_bencana', array('id_bencana' => $id) )->row();

        // dampak
        $this->db->select('t_bencana_dampak.*, table_dampak.label as kategori_dampak');
		$this->db->from('t_bencana_dampak');
        $this->db->join('(SELECT label, value FROM global_parameter WHERE flag='."'kategori_dampak'".') as table_dampak','table_dampak.value=t_bencana_dampak.flag','left');
        $this->db->order_by('tanggal','DESC');
        $this->db->where('id_bencana', $id);
        $dampak = $this->db->get()->result();

        // korban
        $this->db->select('t_bencana_history_korban.*');
        $this->db->from('t_bencana_history_korban');
        $this->db->order_by('tanggal','DESC');
        $this->db->where('id_bencana', $id);
        $korban = $this->db->get()->result();

        // logistik
        $this->db->select('t_bencana_logistik.*');
        $this->db->from('t_bencana_logistik');
        $this->db->order_by('tanggal','DESC');
        $this->db->where('id_bencana', $id);
        $logistik = $this->db->get()->result();

        // perkembangan
        $this->db->select('t_bencana_perkembangan.*');
        $this->db->from('t_bencana_perkembangan');
        $this->db->order_by('tanggal','DESC');
        $this->db->where('id_bencana', $id);
        $perkembangan = $this->db->get()->result();

        // personil
        $this->db->select('t_bencana_relawan.*');
        $this->db->from('t_bencana_relawan');
        $this->db->order_by('tanggal_kedatangan','DESC');
        $this->db->where('id_bencana', $id);
        $personil = $this->db->get()->result();


		$data = array();
		$data['disaster'] = $disaster;
		$data['dampak'] = $dampak;
		$data['korban'] = $korban;
		$data['logistik'] = $logistik;
		$data['perkembangan'] = $perkembangan;
		$data['personil'] = $personil;
		// echo '<pre>'; print_r($data);die;
        $pdf = new TCPDF('P', PDF_UNIT, array(240,200), true, 'UTF-8', false);
        $pdf->SetCreator('i Tangguh BNPB');
        
        $pdf->SetAuthor('BNPB');
        $pdf->SetTitle('Executive Summary');

        // set margins
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(5);

    // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

    // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 5);

    // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    
    // auto page break //
        $pdf->SetAutoPageBreak(TRUE, 5);

    //set margin
        
    // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        $pdf->setJPEGQuality(75);

        //add page
		$pdf->AddPage('P', 'A4');

        $pdf->SetFont('dejavusans', '', 11);
		$pdf->ln();

		$result = $this->load->view('templates/executive_summary_view', $data, true);
		
        // output the HTML content
        $pdf->writeHTML($result, true, false, true, false, '');
        $pdf->lastPage();
        
		ob_end_clean();
		$name = str_replace(' ','_', $data['disaster']->nama_bencana);
        $filename = 'Executive_Summary_'.$name.'';
        $pdf->Output(''.$filename.'.pdf', 'I'); 
        

    }


}
