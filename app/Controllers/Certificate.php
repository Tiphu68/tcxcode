<?php  


namespace App\Controllers;
//resync grocery
use CodeIgniter\Config\AutoloadConfig;
use Config\Database as ConfigDatabase;
use Config\GroceryCrud as ConfigGroceryCrud;
use GroceryCrud\Core\GroceryCrud;
use App\Libraries\PdfLibrary;
use CodeIgniter\Database\RawSql;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Files\File;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Controller;

session_start(); // Remember things across pages
class Certificate extends BaseController {

function __construct()
{
      
 
helper('text');
helper('form');
helper('html');
//$this->load->library('Pdf');
//$this->session->set_userdata('updated', "unset");
}
 
	public function index()
	{
		echo "<h1>TestConX - TestConX Office use only</h1>";
		echo "<h4>TestConX</h4>";
		echo "<OL>";
		echo "<LI>Print <a href=" . site_url('/Certificate/Certificates') . ">Certificates</a></LI>";
		echo "<LI>Print <a href=" . site_url('/Certificate/CertificatesGeneral') . ">CertificatesGeneral</a></LI>";
		echo "</OL>";
		echo "<br><br>";
		
	}
	

	function CertificatesGeneral()
 { 
 
$db = db_connect();
$builder = $db->table('presentations');
$builder -> join('authors', 'presentations.PresentationID = authors.PresentationID');
$builder -> where('Year', 2023);
$builder -> where('Event', 'Mesa');
$builder -> where('Session !=', 'Cancel');
$builder -> where('Session !=', 'Cancel-Poster');;
$builder -> where('Session !=', '3AB');;
$builder -> where('Session !=', '2AB');;
$builder -> where('Session !=', 'dropped');
$builder -> orderBy('Session','ASC');
$builder -> orderBy('PresentationNumber','ASC');
$builder -> orderBy('Title','ASC');
$query = $builder->get(); 
$people = $query->getNumRows();
$results = $query->getResultArray();
	//test
/* $this->db->select('*');    
$this->db->from('presentations');
$this->db->join('authors', 'presentations.PresentationID = authors.PresentationID');
$this->db->where('Year', 2023);
$this->db->where('Event', 'Mesa');
$this->db->where('Session !=', 'Cancel');
$this->db->where('Session !=', 'Cancel-Poster');
$this->db->where('Session !=', '3AB');
$this->db->where('Session !=', '2AB');
$this->db->where('Session !=', 'Best Poster');
$this->db->where('Session !=', 'dropped');

	$this->db->order_by('Session ASC, PresentationNumber ASC');
	$this->db->order_by('Title ASC');

	$query = $this->db->get();
	$people = $query->num_rows();
	$results = $query->result_array();  */
		
//echo $people;
    $width = 279.4;  
	$height = 215.9;
	$pageLayout = array($width, $height);
	
$pdf = new PdfLibrary('L', 'mm', $pageLayout, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('CMPVTESTCONX');
$pdf->SetTitle('Certificates');
$pdf->SetSubject('');
$pdf->SetKeywords('');

//remove header and footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->setTopMargin(0);
$pdf->SetRightMargin(0);
$pdf->SetLeftMargin(0);
//$pdf->SetBottomMargin(0);
//$pdf->SetRightMargin(10.16);

$pdf->setHeaderMargin(0);
$pdf->SetFooterMargin(0); //13mm

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 0);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);




$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage('L');



// -----------------------------------------------------------------------------

$pdf->SetFont('helvetica', '', 10);

// define barcode style





//for($i=1 ; $i <= 1 ; $i++)


for($i=1 ; $i <= $people ; $i++)
{
//this determines how many rows the sheet has

    
$n=$i-1;


$FIRSTNAME=$results[$n]["GivenName"];
$LASTNAME=$results[$n]["FamilyName"];
$TITLE=$results[$n]["Title"];
$SESSION=$results[$n]["Session"];

   
    $pdf->setCellMargins(0,0,0,0);
  //  $pdf->setCellMargins(0,0,2.5,0);
    
    // The width is set to the the same as the cell containing the name.
    // The Y position is also adjusted slightly.
  // $pdf->Image($_SERVER["DOCUMENT_ROOT"].'/images/return2.png', $x, $y, 94, 16, 'PNG', '', '',false,0, '', false, false, 0, false, false, false);
   $pdf->Image($_SERVER["DOCUMENT_ROOT"].'/images/TestConX2020Certificates.png', 0, 0, 279.5, 215.4, 'PNG', '', 'M',true,300, 'C', false, false, 0, false, false, false);
	$y=55;
	$z=10;
   $pdf->SetFont('times', '', 24);  
  $pdf->MultiCell(100, 25,"Certificate of Appreciation", 0, 'C', 0, 0, 89.7, $y, true);
  $pdf->SetFont('times', '', 18);
    $pdf->MultiCell(100, 25,"This Certificate is Awarded to", 0, 'C', 0, 0, 89.7, $y+1.5*$z, true);
     $pdf->SetFont('times', '', 24);
     
   $pdf->MultiCell(100, 25,$FIRSTNAME." ".$LASTNAME, 0, 'C', 0, 0, 89.7, $y+2.5*$z, true);
    $pdf->SetFont('times', '', 18);
    if($SESSION == 'Poster' || $SESSION == 'Best Poster')
    {
    $pdf->MultiCell(100, 25,"for the poster", 0, 'C', 0, 0, 89.7,$y+3.9*$z, true);
    }
    else if($SESSION == 'Keynote')
    {
    $pdf->MultiCell(100, 25,"for the Keynote", 0, 'C', 0, 0, 89.7,$y+3.9*$z, true);
    } else
   {
   $pdf->MultiCell(100, 25,"for the presentation", 0, 'C', 0, 0, 89.7,$y+3.9*$z, true);
   }
    $pdf->SetFont('times', '', 24);
    $length = strlen($TITLE);
    if($length > 75)
	{
	$pdf->SetFont('times', '', 20);
	}
	if($length > 95)
	{
	$pdf->SetFont('times', '', 18);
	}
	$pdf->MultiCell(200, 25,$TITLE, 0, 'C', 0, 0, 39.7, $y+5*$z, true);
	$pdf->SetFont('times', '', 18);
	$pdf->MultiCell(200, 25,"presented at TestConX 2023 workshop \n March 5-8, 2023 - Mesa Arizona", 0, 'C', 0, 0, 39.7, $y+7*$z+5, true);
	$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)); 
    $pdf->Line( 25.58+10+4.4, 170,25.58+63+4.4, 170, $style = array() );
    $pdf->Line( 25.58+83+4.4, 170,25.58+136+4.4, 170, $style = array() );
    $pdf->Line( 25.58+156+4.4, 170,25.58+209+4.4, 170, $style = array() );
    $pdf->SetFont('times', '', 12);
    $pdf->MultiCell(60, 25,"Ila Pal \nTechnical Program Co-Chair", 0, 'L', 0, 0, 25.58+12.7+4.4, 172, true);
    $pdf->MultiCell(60, 25,"Morten Jensen \nTechnical Program Co-Chair", 0, 'L', 0, 0, 25.58+85.7+4.4, 172, true);
    $pdf->MultiCell(60, 25,"Ira Feldman \nTestConX General Chair", 0, 'L', 0, 0, 25.58+158.7+4.4, 172, true);
   
 //$pdf->AddPage();
 $pdf->AddPage('L');

    

}




// ---------------------------------------------------------
ob_end_clean();
//Close and output PDF document
$pdf->Output(md5(time()).'.pdf', 'D');
}	
 
  
 function Certificates()
 { 
 
 

$db = db_connect();
$builder = $db->table('presentations');
$builder -> join('authors', 'presentations.PresentationID = authors.PresentationID');
$builder -> where('Year', 2020);
$builder -> where('Event', 'Mesa');
$builder -> where('Session !=', 'Cancel');
$builder -> where('Session !=', 'Cancel-Poster');;
$builder -> where('Session !=', '3AB');;
$builder -> where('Session !=', '2AB');;
$builder -> where('Session !=', 'dropped');
$builder-> where('Session !=', 'Best Poster');
$builder -> orderBy('Session','ASC');
$builder -> orderBy('PresentationNumber','ASC');
$builder -> orderBy('Title','ASC');
$query = $builder->get(); 
$people = $query->getNumRows();
$results = $query->getResult();
	
/* 	
$this->db->select('*');    
$this->db->from('presentations');
$this->db->join('authors', 'presentations.PresentationID = authors.PresentationID');
$this->db->where('Year', 2020);
$this->db->where('Event', 'Mesa');
$this->db->where('Session !=', 'Cancel');
$this->db->where('Session !=', 'Cancel-Poster');
$this->db->where('Session !=', '3AB');
$this->db->where('Session !=', '2AB');
$this->db->where('Session !=', 'Best Poster');

	$this->db->order_by('Session ASC, PresentationNumber ASC');
	//$this->db->order_by('Title ASC');

	$query = $this->db->get();
	$people = $query->num_rows();
	$results = $query->result_array();  */
		
echo $people;
    $width = 279.4;  
	$height = 215.9;
	$pageLayout = array($width, $height);
	
$pdf = new TCPDF('L', 'mm', $pageLayout, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('CMPVTESTCONX');
$pdf->SetTitle('Certificates');
$pdf->SetSubject('');
$pdf->SetKeywords('');

//remove header and footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->setTopMargin(0);
$pdf->SetRightMargin(0);
$pdf->SetLeftMargin(0);
//$pdf->SetRightMargin(10.16);

$pdf->setHeaderMargin(0);
$pdf->SetFooterMargin(0); //13mm

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5.0);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);




$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage('L');



// -----------------------------------------------------------------------------

$pdf->SetFont('helvetica', '', 10);

// define barcode style








for($i=1 ; $i <= $people ; $i++)
{
//this determines how many rows the sheet has

    
$n=$i-1;

$FIRSTNAME=$results[$n]["GivenName"];
$LASTNAME=$results[$n]["FamilyName"];
$TITLE=$results[$n]["Title"];
$SESSION=$results[$n]["Session"];

   
    $pdf->setCellMargins(0,0,2.5,0);
    // The width is set to the the same as the cell containing the name.
    // The Y position is also adjusted slightly.
  // $pdf->Image($_SERVER["DOCUMENT_ROOT"].'/images/return2.png', $x, $y, 94, 16, 'PNG', '', '',false,0, '', false, false, 0, false, false, false);
   $pdf->Image($_SERVER["DOCUMENT_ROOT"].'/images/TestConX2020Certificates.png', 0, 0, 279.5, 215.4, 'PNG', '', '',false,0, '', false, false, 0, false, false, false);
	$y=55;
	$z=10;
   $pdf->SetFont('times', '', 24);  
  $pdf->MultiCell(100, 25,"Certificate of Appreciation", 0, 'C', 0, 0, 87.5, $y, true);
  $pdf->SetFont('times', '', 18);
    $pdf->MultiCell(100, 25,"This Certificate is Awarded to", 0, 'C', 0, 0, 87.5, $y+1.5*$z, true);
     $pdf->SetFont('times', '', 24);
     
   $pdf->MultiCell(100, 25,$FIRSTNAME." ".$LASTNAME, 0, 'C', 0, 0, 87.5, $y+2.5*$z, true);
    $pdf->SetFont('times', '', 18);
    if($SESSION == 'Poster' || $SESSION == 'Best Poster')
    {
    $pdf->MultiCell(100, 25,"for the poster", 0, 'C', 0, 0, 87.5,$y+3.9*$z, true);
    }
    else if($SESSION == 'Keynote')
    {
    $pdf->MultiCell(100, 25,"for the Keynote", 0, 'C', 0, 0, 87.5,$y+3.9*$z, true);
    } else
   {
   $pdf->MultiCell(100, 25,"for the presentation", 0, 'C', 0, 0, 87.5,$y+3.9*$z, true);
   }
    $pdf->SetFont('times', '', 24);
    $length = strlen($TITLE);
    if($length > 75)
	{
	$pdf->SetFont('times', '', 20);
	}
	if($length > 95)
	{
	$pdf->SetFont('times', '', 18);
	}
	$pdf->MultiCell(200, 25,$TITLE, 0, 'C', 0, 0, 37.5, $y+5*$z, true);
	$pdf->SetFont('times', '', 18);
	$pdf->MultiCell(200, 25,"presented at TestConX 2020 Virtual Event \n May 2020", 0, 'C', 0, 0, 37.5, $y+7*$z+5, true); 
   
   
   
 //$pdf->AddPage();
 $pdf->AddPage('L');

    

}




// ---------------------------------------------------------
ob_end_clean();
//Close and output PDF document
$pdf->Output('certificates.pdf', 'I');
}	

 
}

/* End of file Main.php */
/* Location: ./application/controllers/Main.php */
?>