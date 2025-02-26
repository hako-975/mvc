<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '../vendor/autoload.php';
use setasign\Fpdi\Fpdi;

class File extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Admin_model', 'admo');
    }

    public function download($filename) {
        $file_path = APPPATH . 'private_files/laporan/' . $filename;
        $dst_path = APPPATH . 'private_files/laporan/' . str_replace(".", "_preview.", $filename);

        $output = $this->set_watermark($file_path, $dst_path);

        if (!file_exists($file_path)) {
            show_404();
        }

        $this->load->helper('download');
        force_download($output['file_preview'], NULL);
    }

    public function downloadOriginal($filename) {
        $file_path = APPPATH . 'private_files/laporan/' . $filename;

        if (!file_exists($file_path)) {
            show_404();
        }

        $this->load->helper('download');
        force_download($file_path, NULL);
    }

    public function serve($filename) {
        $file_path = APPPATH . 'private_files/laporan/' . $filename;
        $dst_path = APPPATH . 'private_files/laporan/' . str_replace(".", "_preview.", $filename);

        $output = $this->set_watermark($file_path, $dst_path);

        if (!file_exists($output['file_preview'])) {
            show_404();
        }

        $this->load->helper('file');
        $mime = get_mime_by_extension($output['file_preview']);
        header('Content-Type: ' . $mime);
        readfile($output['file_preview']);
    }

    public function backup_db() 
    {
        $this->admo->userPrivilege('auth', 'mencoba backup data');
        $this->load->dbutil();
        $this->load->library('zip');
        $this->load->helper('file');
        $this->load->helper('download');

        // Database backup preferences
        $prefs = array(
            'format' => 'txt',
            'filename' => 'db_backup.sql'
        );

        // Create database backup
        $backup = $this->dbutil->backup($prefs);

        // Add the database backup to the zip
        $this->zip->add_data('db_backup.sql', $backup);

        // Add the private_files folder to the zip
        $this->zip->read_dir(APPPATH . 'private_files/', false);

        // Save the zip file
        $db_name = 'backup-on-' . date("d-m-Y-H-i-s") . '.zip';

        // Download the zip file
        $this->zip->download($db_name);
    }


    private function set_watermark($src, $dst)
    {
        $file = $src; 
        $text_image = FCPATH.'assets/img/img_properties/favicon.png';
        // $watermark = new Watermark($src);
        // $watermark->setFontSize(65)->setRotate(310)->setOpacity(.1)->withText('djpprkemenkeu', $dst);


        // $watermark->setFontSize(9)->setPosition(Watermark::POSITION_BOTTOM_RIGHT)->setOpacity(.4)->withText('Generated By : '.$this->session->userdata('user')->nama.' @ '.date('Y-m-d H:i:s'), $dst);


        // Set source PDF file 
        $pdf = new TPDF(); 
        $pagecount = $pdf->setSourceFile($file); 
        // if(file_exists("./".$file)){ 
        //  $pagecount = $pdf->setSourceFile($file); 
        // }else{ 
        //  die('Source PDF not found!'); 
        // } 
        // Add watermark image to PDF pages 
        $output['size'] = [];
        for($i=1;$i<=$pagecount;$i++){ 
        $tpl = $pdf->importPage($i); 
        $size = $pdf->getTemplateSize($tpl); 
        $pdf->addPage(); 
        $pdf->useTemplate($tpl, 1, 1, $size['width'], $size['height'], TRUE); 

        //Put the watermark 
        // $xxx_final = ($size['width']); 
        // $yyy_final = ($size['height']); 
        // $pdf->Image($text_image, $xxx_final, $yyy_final, 0, 0, 'png'); 
        //Go to 1.5 cm from bottom
        $pdf->SetFont('Arial','B',150);
        $pdf->SetTextColor(150,150,150);
        $pdf->SetAlpha(0.4);
        $pdf->RotatedText(35,240,'SALINAN',45);

        // $pdf->SetY($cord_y-(10*$cord_y/100));
        //Select Arial italic 8
        $pdf->SetFont('Arial','B',11);
        $pdf->SetTextColor(125,125,125);
        $pdf->SetAlpha(0.5);
        //Print centered cell with a text in it
        $pdf->Text(20, 280, 'Generated By : Sistem @ '.date('d-m-Y, H:i:s'));
        $output['size'] = $size;
        $output['Y'] = $pdf->GetY();
        $output['X'] = $pdf->GetX();
        } 

        // Output PDF with watermark 
        $pdf->Output('F', $dst);
        $output['file_preview'] = $dst;
        $output['text_image'] = $text_image;
        $output['pagecount'] = $pagecount;
        return $output;
    }
}

class PDF_Rotate extends Fpdi {
    var $angle = 0;

    function Rotate($angle, $x = -1, $y = -1) {
        if ($x == -1) $x = $this->x;
        if ($y == -1) $y = $this->y;
        if ($this->angle != 0) $this->_out('Q');
        $this->angle = $angle;
        if ($angle != 0) {
            $angle *= M_PI/180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }
}

class RPDF extends PDF_Rotate {
    function RotatedText($x, $y, $txt, $angle) {
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

    function RotatedImage($file, $x, $y, $w, $h, $angle) {
        $this->Rotate($angle, $x, $y);
        $this->Image($file, $x, $y, $w, $h);
        $this->Rotate(0);
    }
}

class TPDF extends RPDF {
    protected $extgstates = array();

    function SetAlpha($alpha, $bm = 'Normal') {
        $gs = $this->AddExtGState(array('ca' => $alpha, 'CA' => $alpha, 'BM' => '/' . $bm));
        $this->SetExtGState($gs);
    }

    function AddExtGState($parms) {
        $n = count($this->extgstates) + 1;
        $this->extgstates[$n]['parms'] = $parms;
        return $n;
    }

    function SetExtGState($gs) {
        $this->_out(sprintf('/GS%d gs', $gs));
    }

    function _enddoc() {
        if (!empty($this->extgstates) && $this->PDFVersion < '1.4') $this->PDFVersion = '1.4';
        parent::_enddoc();
    }

    function _putextgstates() {
        for ($i = 1; $i <= count($this->extgstates); $i++) {
            $this->_newobj();
            $this->extgstates[$i]['n'] = $this->n;
            $this->_put('<</Type /ExtGState');
            $parms = $this->extgstates[$i]['parms'];
            $this->_put(sprintf('/ca %.3F', $parms['ca']));
            $this->_put(sprintf('/CA %.3F', $parms['CA']));
            $this->_put('/BM ' . $parms['BM']);
            $this->_put('>>');
            $this->_put('endobj');
        }
    }

    function _putresourcedict() {
        parent::_putresourcedict();
        $this->_put('/ExtGState <<');
        foreach ($this->extgstates as $k => $extgstate)
            $this->_put('/GS' . $k . ' ' . $extgstate['n'] . ' 0 R');
        $this->_put('>>');
    }

    function _putresources() {
        $this->_putextgstates();
        parent::_putresources();
    }
}
