<?php 


namespace App\Controllers;

use Config\Database as ConfigDatabase;
use Config\GroceryCrud as ConfigGroceryCrud;
use GroceryCrud\Core\GroceryCrud;

class Badgemesa extends CI_Controller {

 
	function __construct()
	{
		
		helper('text');
		
	}
 
	public function index()
	{
		echo "<h1>Tinyml Badges - tinyML Office use only</h1>";
		echo "<h4>tinyml Summit Confidential</h4>";
		echo "<OL>";
		echo "<LI>Manage <a href=" . site_url('/badgemesa/testconx_guests') . ' target="_blank" ">Manage badge</a></LI>';
		//Still use able functions, they are  commented off to prevent  confusion
		echo "<LI>Print <a href=" . site_url('/badgemesa/BadgestinymlProfessional') . ">Summit</a></LI>";
		echo "<LI>Print <a href=" . site_url('/badgemesa/BadgestinymlSymposium') . ">Symposium</a></LI>";
		echo "<LI>Print <a href=" . site_url('/badgemesa/BadgestinymlEXPOONLY') . ">EXPOtinyml ONLY</a></LI>";
		echo "<LI>Print <a href=" . site_url('/badgemesa/BadgestinymlBlankProfessional') . ' target="_blank" ">Blank Summit</a></LI>';
		echo "<LI>Print <a href=" . site_url('/badgemesa/BadgestinymlBlankExhibitor') . ' target="_blank" ">Blank Symposium</a></LI>';
		echo "<LI>Print <a href=" . site_url('/badgemesa/BadgestinymlBlankEXPO') . ' target="_blank" ">Blank EXPOtinyml ONLY</a></LI>';
		"</OL>";
		echo "<h1>Tinyml EMEA Badges - tinyML Office use only</h1>";
		echo "<h4>tinyml EMEA Confidential</h4>";
		echo "<OL>";
		echo "<LI>Manage <a href=" . site_url('/badgemesa/testconx_guests') . ' target="_blank" ">Manage badge</a></LI>';
		//Still use able functions, they are  commented off to prevent  confusion
		echo "<LI>Print <a href=" . site_url('/badgemesa/BadgesEMEAAttendee') . ">Attendee</a></LI>";
		
		echo "<LI>Print <a href=" . site_url('/badgemesa/BadgesEMEABlankAttendee') . ' target="_blank" ">Blank Attendee</a></LI>';
		
		"</OL>";
		echo "<h1>TestConX Badges - TestConX Office use only</h1>";
		echo "<h4>TestConX Workshop Confidential</h4>";
		echo "<OL>";
		echo "<LI>Manage <a href=" . site_url('/badgemesa/testconx_guests') . ' target="_blank" ">Manage badge</a></LI>';
		echo "<LI>Print <a href=" . site_url('/badgemesa/BadgesMesaProfessional') . ">Professional</a></LI>";
		echo "<LI>Print <a href=" . site_url('/badgemesa/BadgesMesaExhibitor') . ">Exhibitor</a></LI>";
		echo "<LI>Print <a href=" . site_url('/badgemesa/BadgesMesaEXPOONLY') . ">EXPO ONLY</a></LI>";
		echo "<LI>Print <a href=" . site_url('/badgemesa/BadgesMesaBlankProfessional') . ' target="_blank" ">Blank Professional</a></LI>';
		echo "<LI>Print <a href=" . site_url('/badgemesa/BadgesMesaBlankExhibitor') . ' target="_blank" ">Blank Exhibitor</a></LI>';
		echo "<LI>Print <a href=" . site_url('/badgemesa/BadgesMesaBlankEXPO') . ' target="_blank" ">Blank EXPO ONLY</a></LI>';
		echo "<LI>Clear <a href=" . site_url('/badgemesa/clearprint') . ">To Print flag</a></LI>";
		echo "</OL>";
		echo "<br><br>";
		
	}
	
	function testconx_guests()
	{
	/* $this->db = $this->load->database('RegistrationDataBase', TRUE);
	$this->grocery_crud->set_theme('bootstrap');
	$this->grocery_crud->set_subject('Badge');
	$this->grocery_crud->set_table('guests');
	$this->grocery_crud->where([
    'guests.EventYear' => 'tinyml2023'
]);	 */
// New way
		$crud = $this->_getGroceryCrudEnterprise();

        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());

        $crud->setTable('guests');
        $crud->setSubject('Guest', 'Guests');
		$crud->where([
    'guests.EventYear' => 'tinyml2023'
]);
		
		$crud->columns (['EventYear','ToPrint','GivenName','FamilyName','NameOnBadge','Company','Type','Tutorial']);

		$crud->uniqueFields(['ContactID']);

		$this->grocery_crud->add_action('Print Badge', '', site_url('/badgemesa/TestConXsingle/'),'ui-icon-image'); 
		
		// Try restricting fields...
		$crud->fields (['ContactID','EventYear','ToPrint','GivenName','FamilyName','NameOnBadge','Company','Email','Type','Tutorial','Dinner']);
		$crud ->fieldtype('Type','enum',array('Professional','EXPO','Exhibitor','Summit','Symposium','EXPOtiny'));
		$crud ->fieldtype('ToPrint','enum',array('Yes','No'));
		
		
	
		$output = $crud->render();

	return $this->_example_output($output);  

		
	


	} 
/* function _example_output($output = null)
 
{
	$this->load->view('bits_template.php',$output);    
}  */


 private function _example_output($output = null) {
        if (isset($output->isJSONResponse) && $output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }

        return view('testconx_template.php', (array)$output);
    }

function TestConXsingle($graphics = TRUE)
 {
 if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
    $link = "https"; 
else
    $link = "http"; 
  
// Here append the common URL characters. 
$link .= "://"; 
  
// Append the host(domain name, ip) to the URL. 
$link .= $_SERVER['HTTP_HOST']; 
  
// Append the requested resource location to the URL 
$link .= $_SERVER['REQUEST_URI']; 
      
// Print the link 
echo $link;
$id = ltrim($link, "https://www.testconx.org/tools/secure.php/badgemesa/TestConXsingle/");
echo  $id;

	$this->db = $this->load->database('RegistrationDataBase', TRUE);

	$this->db->select('NameOnBadge,GivenName,Company,Email,EventYear,FamilyName,ContactID,InvitedByCompanyID,Control,HardCopy,Tutorial,Type,Dinner');
	$this->db->from('guests');
	$this->db->where('ContactID', $id);
	$this->db->order_by('FamilyName ASC, GivenName ASC');

	$query = $this->db->get();
	$people = $query->num_rows();
	$results = $query->result_array();
	
	 $height = '152.4';
 	$width = '101.6';
	
	// $height = '158.75';
// 	$width = '107.95';
	
$pageLayout = array($width, $height);



$pdf = new Pdf('P', 'MM',$pageLayout, true, 'UTF-8', false);
$pdf->SetTitle('Badge Single');
$pdf->SetMargins(10,10,10,10);
$pdf->SetHeaderMargin(0);
$pdf->SetTopMargin(0);
$pdf->setFooterMargin(0);
$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Author');
$pdf->SetDisplayMode('real', 'default');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$graphics = TRUE;
//$pdf->AddPage('P',$pageLayout);
		$q=0; 
		$filler=0;
		$pages=0;
		
for($i=1; $i<=$people; $i++){ 
		$n = $i-1;
		// Define what special labels go on the badges
		$label ="0";
		
		
		if (!empty($results[$n]["GivenName"])){
		$this->qrstamp($results[$n]["GivenName"]." ".$results[$n]["FamilyName"],$results[$n]["Email"],$results[$n]["Company"],$n);
		}	
	
		$NameOnBadge=$results[$n]["NameOnBadge"];
		
		$GivenName=$results[$n]["GivenName"];
		echo "<h1>".$GivenName."</h1>";
		
		
		//$CN_Company=$results[$n]["CN_Company"];
		$FamilyName=$results[$n]["FamilyName"];
		$EventYear=$results[$n]["EventYear"];
		$Company=$results[$n]["Company"];
		$ContactID=$results[$n]["ContactID"];
		$InvitedByCompanyID=$results[$n]["InvitedByCompanyID"];
		$HardCopy=$results[$n]["HardCopy"];
		$Tutorial=$results[$n]["Tutorial"];
		$Control=$results[$n]["Control"];
		//$Message=$results[$n]["Message"];
		$Dinner=$results[$n]["Dinner"];
		$type = $results[$n]["Type"];
		
		$pdf->AddPage('P',$pageLayout);
		
		if($HardCopy==1){
		$HardCopy="HC";
		}
		else{
		$HardCopy="0";
		}
		if($EventYear == "tinyml2023"){
			if($Tutorial==1){
			$Tutorial="SYMPOSIUM";
			}
			else{
			$Tutorial="";
			}
			}
			
		if($EventYear == "tinyml2023"){
			if($Dinner==1){
			$Dinnertext="Dinner";
			}
			else{
			$Dinnertext="";
			}
			}
		
		
		$pdf->SetFont('stsongstdlight', 'B', 75);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('helvetica', 'B', 75);
		$pdf->Ln(40);
	if (!empty($results[$n]["NameOnBadge"])){
		$pdf->SetFont('helvetica', 'B', 55);
		$pdf->Cell(0, 0, $NameOnBadge, 0, 1, 'C', 0, '', 1);
		
		$pdf->SetFont('stsongstdlight', 'B', 25);

			
	}
	else if (!empty($results[$n]["GivenName"])){
		$pdf->SetFont('helvetica', 'B', 55);
		$pdf->Cell(0, 0, $GivenName, 0, 1, 'C', 0, '', 1);
		
		$pdf->SetFont('stsongstdlight', 'B', 25);
		
		
	}
	else {
		$pdf->SetFont('stsongstdlight', 'B', 55);
		
		
	}
		$pdf->SetFont('stsongstdlight', 'B', 25);
	
		//$pdf->Cell(0, 0,$CN_Company, 0, 1, 'C', 0, '', 1);
		$pdf->SetFont('helvetica', 'B', 25);
		if(strlen($FamilyName)>8){
		$pdf->SetFont('helvetica', 'B', 22);
		}
		$pdf->Cell(0, 0,$GivenName." ".$FamilyName, 0, 1, 'C', 0, '', 1);
		$pdf->SetFont('helvetica', 'B', 25);
		if(strlen($Company)>12){
		$pdf->SetFont('helvetica', 'B', 17);
		}
		$pdf->Cell(0, 0,$Company, 0, 1, 'C', 0, '', 1);
		
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/tmpqr/'.$n.'08.png', 7,115, 30, 30, 'PNG', '', '',false, 1000, '', false, false, 1, false, false, false);
		
		$pdf->SetFillColor(224,146,47);
		$pdf->SetTextColor(255,255,255);
		$pdf->SetFont('helvetica', 'B', 15);
		$pdf->setCellPaddings(0, 6, 0, 0);
		
		$pdf->setCellPaddings(0, 0, 0, 0);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0,0,0);
		
		if($type=="EXPOtiny"){
		$pdf->SetFont('helvetica', '', 40);
		$pdf->MultiCell(45, 20,"EXPO", 0, 'L', 0, 0, 45,120, true);
		//$pdf->Rect(45, 123, 80, 30, 'F',array(), array(250,174,2));
		}
		
		$pdf->SetFont('helvetica', '', 10);
		
		$pdf->MultiCell(90,10,$Dinnertext." ".$Tutorial." ".$Control." ".$i, 0, 'R', 0, 0, -8.5,140, true);
		//$pdf->MultiCell(90,10,$Tutorial." ".$Control." ".$i, 0, 'R', 0, 0, -8.5,144, true);
			
		 $q++;
		 		 
	 
	 
	 
	 }
ob_clean();
$pdf->Output('My-File-Name.pdf', 'I');	
}
function qrstamp($a,$b,$c,$d)
 {
	
//include('/phpqrcode/qrlib.php'); 
//file_put_contents("test5.png",file_get_contents("test6.png"));
	$tempDir = $_SERVER["DOCUMENT_ROOT"]."tmpqr/" . $d; 
 
    $name = $a; 
	$email= $b;
	$orgName = $c; 
	$codeContents  = 'BEGIN:VCARD'."\n"; 
    $codeContents .= 'FN:'.$name."\n";
	$codeContents .= 'EMAIL:'.$email."\n"; 
	$codeContents .= 'ORG:'.$orgName."\n"; 
    $codeContents .= 'END:VCARD'; 
	
	//return QRcode::svg($codeContents,false, $tempDir.'08.svg', QR_ECLEVEL_L, false,false); 
	return QRcode::png($codeContents, $tempDir.'08.png', QR_ECLEVEL_L, 200,0);
	}
	
private function printBadge ($label, $nickname, $firstname, $lastname,$company, $QRfile,$type) {

echo '<div id = "rect1"><h1>';
/*switch ($label) {
    case "0":
        echo '<p class="Tutorial">&nbsp;</p><h1>';
        break;
    case "1":
        echo '<p class="Tutorial">Tutorial</p><h1>';
        break;
    case "2":
        echo '<p class="Tutorial">Companion</p><h1>';
        break;
    default:
        echo '<p class="Tutorial">&nbsp;</p><h1>';
}*/
		
			echo $nickname;
			echo '</h1><p><h3 class="small">'. $firstname. " " .$lastname."<br>".$company."</h3></p>";
			//echo '<p class="bar">'.$type.'</p>';
			echo '<img class="logo" src="/images/TestConX-China-Black_750x133.png" height= 50px alt = "TestConx Logo">';
			echo '<img class="qr" src=/tmpqr/'.$QRfile."08.png".' height= 75px    alt = "Qr Code">';
			echo '<p class="barbottom">Suzhou - October 23, 2018</p></div>';
			

}

private function printPDFBadge ($label, $nickname, $firstname, $lastname,$company, $QRfile,$type) {



$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle('My Title');
$pdf->SetHeaderMargin(0);
$pdf->SetTopMargin(0);
$pdf->setFooterMargin(0);
$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Author');
$pdf->SetDisplayMode('real', 'default');

$pdf->AddPage();

			$html= '<div id = "rect1"><h1>';
			$html.= $nickname;
			$html.= '</h1><p><h3 class="small">'. $firstname. " " .$lastname."<br>".$company."</h3></p>";
			$html.= '<img class="logo" src="/images/TestConX-China-Black_750x133.png" height= 50px alt = "TestConx Logo">';
			$html.= '<img class="qr" src=/tmpqr/'.$QRfile."08.png".' height= 75px    alt = "Qr Code">';
			$html.= '<p class="barbottom">Suzhou - October 23, 2018</p></div>';
			
$pdf->writeHTML($html, true, 0, true, 0);

}

private function printEXPOBadge ($label, $nickname, $firstname, $lastname,$company, $QRfile,$type) {
	echo '<div id = "rect1">';

		
			echo "<h1>".$nickname;
			echo '</h1><img class="logo" src="/images/TestConX-China-Black_750x133.png" height= 50px alt = "TestConx Logo">';
			echo '<img class="qr" src=/tmpqr/'.$QRfile."08.svg".' height= 75px    alt = "Qr Code">';
			echo'<p><h3 class="small">'. $firstname. " " .$lastname."<br>".$company."</h3></p>";
			switch ($label) {
    case "0":
        echo '<p class="Tutorial">&nbsp;</p>';
        break;
    case "1":
        echo '<p class="Tutorial">Tutorial</p>';
        break;
    case "2":
        echo '<p class="Tutorial">Companion</p>';
        break;
    default:
        echo '<p class="Tutorial">&nbsp;</p>';
}
			echo'<p class ="Expo">&nbsp;<br>EXPO ONLY</p></div>';
			
			
}
    



function Testbadge($convention = "testconx",$event = "test2022", $graphics = FALSE,$type = "Professional")
{

	$this->db = $this->load->database('RegistrationDataBase', TRUE);

	$this->db->select('NameOnBadge,GivenName,CN_Company,Company,Email,EventYear,FamilyName,ContactID,InvitedByCompanyID,Control,HardCopy,Tutorial,Type,Message,Dinner');
	$this->db->from('guests');
	$this->db->where('EventYear', $event);
	$this->db->where('ToPrint', 'Yes');
	$this->db->where('Type', $type);

	$this->db->order_by('FamilyName ASC, GivenName ASC');

	$query = $this->db->get();
	$people = $query->num_rows();
	
	$results = $query->result_array();
	
	$height = '158.75';
	$width = '107.95';
$pageLayout = array($width, $height);


$pdf = new Pdf('P', 'MM',$pageLayout, true, 'UTF-8', false);
$pdf->SetTitle('My Title');
$pdf->SetMargins(10,10,10,10);
$pdf->SetHeaderMargin(0);
$pdf->SetTopMargin(0);
$pdf->setFooterMargin(0);
$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Author');
$pdf->SetDisplayMode('real', 'default');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

//$pdf->AddPage('P',$pageLayout);
		$q=0; 
		$filler=0;
		$pages=0;
		
for($i=1; $i<=$people; $i++){ 
		$n = $i-1;
		// Define what special labels go on the badges
		$label ="0";
		
		
		if (!empty($results[$n]["GivenName"])){
		$this->qrstamp($results[$n]["GivenName"]." ".$results[$n]["FamilyName"],$results[$n]["Email"],$results[$n]["Company"],$n);
	}
	
		$NameOnBadge=$results[$n]["NameOnBadge"];
		
		$GivenName=$results[$n]["GivenName"];
		echo "<h1>".$GivenName."</h1>";
		
		
		$CN_Company=$results[$n]["CN_Company"];
		$FamilyName=$results[$n]["FamilyName"];
		$EventYear=$results[$n]["EventYear"];
		$Company=$results[$n]["Company"];
		$ContactID=$results[$n]["ContactID"];
		$InvitedByCompanyID=$results[$n]["InvitedByCompanyID"];
		$HardCopy=$results[$n]["HardCopy"];
		$Tutorial=$results[$n]["Tutorial"];
		$Control=$results[$n]["Control"];
		$Message=$results[$n]["Message"];
		$Dinner=$results[$n]["Dinner"];
		
		$pdf->AddPage('P',$pageLayout);
		
		if($HardCopy==1){
		$HardCopy="HC";
		}
		else{
		$HardCopy="0";
		}
		if($convention == "testconx"){
			if($Tutorial==1){
			$Tutorial="TUTORIAL";
			}
			else{
			$Tutorial="";
			}
			}
		if($convention == "tinyml"){
			if($Tutorial==1){
			$Tutorial="SYMPOSIUM";
			}
			else{
			$Tutorial="";
			}
			}
		if($convention == "emea"){
			if($Tutorial==1){
			$Tutorial="Social";
			}
			else{
			$Tutorial="";
			}
			}	
		if($convention == "emea"){
			if($Dinner==1){
			$Dinnertext="Dinner";
			}
			else{
			$Dinnertext="";
			}
			}	
		if($convention == "tinyml"){
			if($Dinner==1){
			$Dinnertext="Dinner";
			}
			else{
			$Dinnertext="";
			}
			}
		if($type == "Professional"){
		if($graphics){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/images/Combo Badge 2023.jpg',0,0,107.95,158.75, 'JPG', '', '',false, 10, 'C', false, false, 0, false, false, false);
		}
		}
		if($type == "Exhibitor"){
		if($graphics){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/images/Combo Badge 20235.jpg',0,0,107.95,158.75, 'JPG', '', '',false, 10, 'C', false, false, 0, false, false, false);
		}
		}
		if($type == "EXPO"){
		if($graphics){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/images/Combo Badge 20233.jpg',0,0,107.95,158.75, 'JPG', '', '',false, 10, 'C', false, false, 0, false, false, false);
		}
		}
		if($type == "Summit"){
		if($graphics){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/images/tinyML2023Summit.jpg',0,0,107.95,158.75, 'JPG', '', '',false, 10, 'C', false, false, 0, false, false, false);
		}
		}
		if($type == "Symposium"){
		if($graphics){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/images/tinyML2023Symposium.jpg',0,0,107.95,158.75, 'JPG', '', '',false, 10, 'C', false, false, 0, false, false, false);
		}
		}
		if($type == "EXPOtiny"){
		if($graphics){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/images/tinyML2023EXPO.jpg',0,0,107.95,158.75, 'JPG', '', '',false, 10, 'C', false, false, 0, false, false, false);
		}
		}
		if($type == "Attendee"){
		if($graphics){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/images/tinyML-EMEA2023-Badge-PRINT.jpg',0,0,107.95,158.75, 'JPG', '', '',false, 10, 'C', false, false, 0, false, false, false);
		}
		}
		$pdf->SetFont('stsongstdlight', 'B', 75);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('helvetica', 'B', 75);
		$pdf->Ln(45);
if($convention == "testconx"){		
	if (!empty($results[$n]["NameOnBadge"])){
		$pdf->SetFont('helvetica', 'B', 55);
		$pdf->Cell(0, 0, $NameOnBadge, 0, 1, 'C', 0, '', 1);
		
		$pdf->SetFont('stsongstdlight', 'B', 25);

			
	}
	else if (!empty($results[$n]["GivenName"])){
		$pdf->SetFont('helvetica', 'B', 55);
		$pdf->Cell(0, 0, $GivenName, 0, 1, 'C', 0, '', 1);
		
		$pdf->SetFont('stsongstdlight', 'B', 25);
		
		
	}
	else {
		$pdf->SetFont('stsongstdlight', 'B', 55);
		
		
	}
		$pdf->SetFont('stsongstdlight', 'B', 25);
	
		$pdf->Cell(0, 0,$CN_Company, 0, 1, 'C', 0, '', 1);
		$pdf->SetFont('helvetica', 'B', 25);
		if(strlen($FamilyName)>8){
		$pdf->SetFont('helvetica', 'B', 22);
		}
		$pdf->Cell(0, 0,$GivenName." ".$FamilyName, 0, 1, 'C', 0, '', 1);
		$pdf->SetFont('helvetica', 'B', 25);
		if(strlen($Company)>12){
		$pdf->SetFont('helvetica', 'B', 17);
		}
		$pdf->Cell(0, 0,$Company, 0, 1, 'C', 0, '', 1);
		if($type=="EXPO"){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/tmpqr/'.$n.'08.png', 5,121, 33, 33, 'PNG', '', '',false, 1000, '', false, false, 1, false, false, false);
		}
		else{
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/tmpqr/'.$n.'08.png', 5,121, 33, 33, 'PNG', '', '',false, 1000, '', false, false, 1, false, false, false);
		}
		$pdf->SetFillColor(224,146,47);
		$pdf->SetTextColor(255,255,255);
		$pdf->SetFont('helvetica', 'B', 15);
		$pdf->setCellPaddings(0, 6, 0, 0);
		
		$pdf->setCellPaddings(0, 0, 0, 0);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0,0,0);
		
		$pdf->SetFont('helvetica', '', 10);
		if($type=="EXPO"){
		$pdf->MultiCell(90,10,$Tutorial." ".$Control." ".$i, 0, 'R', 0, 0, -8.5,148, true);
		}
		else{
		$pdf->MultiCell(90,10,$Tutorial." ".$Control." ".$i, 0, 'R', 0, 0, -8.5,148, true);
			}
		 $q++;
}	
if($convention == "tinyml"){		
	if (!empty($results[$n]["NameOnBadge"])){
		$pdf->SetFont('helvetica', 'B', 55);
		$pdf->Cell(0, 0, $NameOnBadge, 0, 1, 'C', 0, '', 1);
		
		$pdf->SetFont('stsongstdlight', 'B', 25);

			
	}
	else if (!empty($results[$n]["GivenName"])){
		$pdf->SetFont('helvetica', 'B', 55);
		$pdf->Cell(0, 0, $GivenName, 0, 1, 'C', 0, '', 1);
		
		$pdf->SetFont('stsongstdlight', 'B', 25);
		
		
	}
	else {
		$pdf->SetFont('stsongstdlight', 'B', 55);
		
		
	}
		$pdf->SetFont('stsongstdlight', 'B', 25);
		$pdf->Ln(5);
		//$pdf->Cell(0, 0,$CN_Company, 0, 1, 'C', 0, '', 1);
		$pdf->SetFont('helvetica', 'B', 25);
		if(strlen($FamilyName)>8){
		$pdf->SetFont('helvetica', 'B', 22);
		}
		$pdf->Cell(0, 0,$GivenName." ".$FamilyName, 0, 1, 'C', 0, '', 1);
		$pdf->SetFont('helvetica', 'B', 25);
		if(strlen($Company)>12){
		$pdf->SetFont('helvetica', 'B', 17);
		}
		$pdf->Cell(0, 0,$Company, 0, 1, 'C', 0, '', 1);
		$pdf->Ln(5);
		if($convention == 'tinyml'){
		$pdf->SetFont('helvetica', 'B', 16);
		$pdf->Cell(0, 0,'Ask me about:', 0, 1, 'C', 0, '', 1);
			if(strlen($Message)>8){
			$pdf->SetFont('helvetica', 'B', 22);
		}
		
		$pdf->Cell(0, 0,$Message, 0, 1, 'C', 0, '', 1);
		}
		
		
		if($type=="EXPO"){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/tmpqr/'.$n.'08.png', 7,121, 33, 33, 'PNG', '', '',false, 1000, '', false, false, 1, false, false, false);
		}
		else{
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/tmpqr/'.$n.'08.png', 7,121, 33, 33, 'PNG', '', '',false, 1000, '', false, false, 1, false, false, false);
		}
		$pdf->SetFillColor(224,146,47);
		$pdf->SetTextColor(255,255,255);
		$pdf->SetFont('helvetica', 'B', 15);
		$pdf->setCellPaddings(0, 6, 0, 0);
		
		$pdf->setCellPaddings(0, 0, 0, 0);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0,0,0);
		
		$pdf->SetFont('helvetica', '', 10);
		
		if($type=="Symposium"){
		$pdf->Rect(45, 123, 80, 30, 'F',array(), array(118,215,61));
		}
		if($type=="EXPOtiny"){
		$pdf->Rect(45, 123, 80, 30, 'F',array(), array(250,174,2));
		}
		
		if($type=="EXPO"){
		$pdf->MultiCell(90,10,$Dinnertext." ".$Tutorial." ".$Control." ".$i, 0, 'R', 0, 0, -8.5,148, true);
		}
		else{
		$pdf->MultiCell(90,10,$Dinnertext." ".$Tutorial." ".$Control." ".$i, 0, 'R', 0, 0, -8.5,148, true);
			}
		
		 $q++;
}		
if($convention == "emea"){		
	if (!empty($results[$n]["NameOnBadge"])){
		$pdf->SetFont('helvetica', 'B', 55);
		$pdf->Cell(0, 0, $NameOnBadge, 0, 1, 'C', 0, '', 1);
		
		$pdf->SetFont('stsongstdlight', 'B', 25);

			
	}
	else if (!empty($results[$n]["GivenName"])){
		$pdf->SetFont('helvetica', 'B', 55);
		$pdf->Cell(0, 0, $GivenName, 0, 1, 'C', 0, '', 1);
		
		$pdf->SetFont('stsongstdlight', 'B', 25);
		
		
	}
	else {
		$pdf->SetFont('stsongstdlight', 'B', 55);
		
		
	}
		$pdf->SetFont('stsongstdlight', 'B', 25);
		$pdf->Ln(5);
		//$pdf->Cell(0, 0,$CN_Company, 0, 1, 'C', 0, '', 1);
		$pdf->SetFont('helvetica', 'B', 25);
		if(strlen($FamilyName)>8){
		$pdf->SetFont('helvetica', 'B', 22);
		}
		$pdf->Cell(0, 0,$GivenName." ".$FamilyName, 0, 1, 'C', 0, '', 1);
		$pdf->SetFont('helvetica', 'B', 25);
		if(strlen($Company)>12){
		$pdf->SetFont('helvetica', 'B', 17);
		}
		$pdf->Cell(0, 0,$Company, 0, 1, 'C', 0, '', 1);
		$pdf->Ln(5);
		if($convention == 'emea'){
		$pdf->SetFont('helvetica', 'B', 16);
		$pdf->Cell(0, 0,'Ask me about:', 0, 1, 'C', 0, '', 1);
			if(strlen($Message)>8){
			$pdf->SetFont('helvetica', 'B', 22);
		}
		
		$pdf->Cell(0, 0,$Message, 0, 1, 'C', 0, '', 1);
		}
		
		
	// 	if($type=="EXPO"){
// 		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/tmpqr/'.$n.'08.png', 7,121, 33, 33, 'PNG', '', '',false, 1000, '', false, false, 1, false, false, false);
// 		}
// 		else{
// 		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/tmpqr/'.$n.'08.png', 7,121, 33, 33, 'PNG', '', '',false, 1000, '', false, false, 1, false, false, false);
// 		}
		$pdf->SetFillColor(224,146,47);
		$pdf->SetTextColor(255,255,255);
		$pdf->SetFont('helvetica', 'B', 15);
		$pdf->setCellPaddings(0, 6, 0, 0);
		
		$pdf->setCellPaddings(0, 0, 0, 0);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0,0,0);
		
		$pdf->SetFont('helvetica', '', 10);
		
		
		$pdf->SetTextColor(255,255,255);
		if($type=="EXPO"){
		$pdf->MultiCell(90,10,$Dinnertext." ".$Tutorial." ".$Control." ".$i, 0, 'R', 0, 0, -8.5,148, true);
		}
		else{
		$pdf->MultiCell(90,10,$Dinnertext." ".$Tutorial." ".$Control." ".$i, 0, 'R', 0, 0, 10,148, true);
			}
		
		 $q++;
} 		 		 
//back of badge	 
if ($convention != "emea")
{
$pdf->AddPage('P',$pageLayout);

		if($type == "Professional"){
		if($graphics){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/images/Combo Badge 20232.jpg',0,0,107.95,158.75, 'JPG', '', '',false, 10, 'C', false, false, 0, false, false, false);
		}
		}
		if($type == "Exhibitor"){
		if($graphics){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/images/Combo Badge 20236.jpg',0,0,107.95,158.75, 'JPG', '', '',false, 10, 'C', false, false, 0, false, false, false);
		}
		}
		if($type == "EXPO"){
		if($graphics){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/images/Combo Badge 20234.jpg',0,0,107.95,158.75, 'JPG', '', '',false, 10, 'C', false, false, 0, false, false, false);
		}
		}	 
		if($type == "Summit"){
		if($graphics){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/images/tinyML2023Back.jpg',0,0,107.95,158.75, 'JPG', '', '',false, 10, 'C', false, false, 0, false, false, false);
		}
		}
		if($type == "Symposium"){
		if($graphics){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/images/tinyML2023Back.jpg',0,0,107.95,158.75, 'JPG', '', '',false, 10, 'C', false, false, 0, false, false, false);
		}
		}
		if($type == "EXPOtiny"){
		if($graphics){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/images/tinyML2023Back.jpg',0,0,107.95,158.75, 'JPG', '', '',false, 10, 'C', false, false, 0, false, false, false);
		}
		}
		if($type == "Attendee"){
		if($graphics){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/images/Combo Badge 20232.jpg',0,0,107.95,158.75, 'JPG', '', '',false, 10, 'C', false, false, 0, false, false, false);
		}
		}
}
	 }
 
		
			
ob_clean();
$pdf->Output('My-File-Name.pdf', 'I');
		

	} 

function Blankbadge($convention = "testconx", $event = "test2022", $graphics = FALSE,$type = "Professional")
{

	$this->db = $this->load->database('RegistrationDataBase', TRUE);

	$this->db->select('NameOnBadge,GivenName,CN_Company,Company,Email,EventYear,FamilyName,ContactID,InvitedByCompanyID,Control,HardCopy,Tutorial,Type,Message,Dinner');
	$this->db->from('guests');
	$this->db->where('EventYear', $event);
	$this->db->where('ToPrint', 'Yes');
	$this->db->where('Type', $type);

	$this->db->order_by('FamilyName ASC, GivenName ASC');

	$query = $this->db->get();
	$people = $query->num_rows();
	
	$results = $query->result_array();
	
	// $height = '158.75';
// 	$width = '107.95';
	
	 $height = '152.4';
 	$width = '101.6';
$pageLayout = array($width, $height);


$pdf = new Pdf('P', 'MM',$pageLayout, true, 'UTF-8', false);
$pdf->SetTitle('My Title');
$pdf->SetMargins(10,10,10,10);
$pdf->SetHeaderMargin(0);
$pdf->SetTopMargin(0);
$pdf->setFooterMargin(0);
$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Author');
$pdf->SetDisplayMode('real', 'default');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);


		$q=0; 
		$filler=0;
		$pages=0;
		
// for($i=1; $i<=$people; $i++){ 
// 		$n = $i-1;
// 		// Define what special labels go on the badges
// 		$label ="0";
// 		
// 		
// 		if (!empty($results[$n]["GivenName"])){
// 		$this->qrstamp($results[$n]["GivenName"]." ".$results[$n]["FamilyName"],$results[$n]["Email"],$results[$n]["Company"],$n);
// 	}
// 	
// 		$NameOnBadge=$results[$n]["NameOnBadge"];
// 		
// 		$GivenName=$results[$n]["GivenName"];
// 		echo "<h1>".$GivenName."</h1>";
// 		
// 		
// 		$CN_Company=$results[$n]["CN_Company"];
// 		$FamilyName=$results[$n]["FamilyName"];
// 		$EventYear=$results[$n]["EventYear"];
// 		$Company=$results[$n]["Company"];
// 		$ContactID=$results[$n]["ContactID"];
// 		$InvitedByCompanyID=$results[$n]["InvitedByCompanyID"];
// 		$HardCopy=$results[$n]["HardCopy"];
// 		$Tutorial=$results[$n]["Tutorial"];
// 		$Control=$results[$n]["Control"];
// 		
// 		$pdf->AddPage('P',$pageLayout);
// 		
// 		if($HardCopy==1){
// 		$HardCopy="HC";
// 		}
// 		else{
// 		$HardCopy="0";
// 		}
// 		if($convention == "testconx"){
// 			if($Tutorial==1){
// 			$Tutorial="TUTORIAL";
// 			}
// 			else{
// 			$Tutorial="";
// 			}
// 		}
// 		if($convention == "tinyml"){
// 			if($Tutorial==1){
// 			$Tutorial="SYMPOSIUM";
// 			}
// 			else{
// 			$Tutorial="";
// 			}
// 		}
// 		
// 		
// 		$pdf->SetFont('stsongstdlight', 'B', 75);
// 		$pdf->SetFillColor(255, 255, 255);
// 		$pdf->SetTextColor(0,0,0);
// 		$pdf->SetFont('helvetica', 'B', 75);
// 		$pdf->Ln(40);
// 	if (!empty($results[$n]["NameOnBadge"])){
// 		$pdf->SetFont('helvetica', 'B', 55);
// 		$pdf->Cell(0, 0, $NameOnBadge, 0, 1, 'C', 0, '', 1);
// 		
// 		$pdf->SetFont('stsongstdlight', 'B', 25);
// 
// 			
// 	}
// 	else if (!empty($results[$n]["GivenName"])){
// 		$pdf->SetFont('helvetica', 'B', 55);
// 		$pdf->Cell(0, 0, $GivenName, 0, 1, 'C', 0, '', 1);
// 		
// 		$pdf->SetFont('stsongstdlight', 'B', 25);
// 		
// 		
// 	}
// 	else {
// 		$pdf->SetFont('stsongstdlight', 'B', 55);
// 		
// 		
// 	}
// 		$pdf->SetFont('stsongstdlight', 'B', 25);
// 	
// 		$pdf->Cell(0, 0,$CN_Company, 0, 1, 'C', 0, '', 1);
// 		$pdf->SetFont('helvetica', 'B', 25);
// 		if(strlen($FamilyName)>8){
// 		$pdf->SetFont('helvetica', 'B', 22);
// 		}
// 		$pdf->Cell(0, 0,$GivenName." ".$FamilyName, 0, 1, 'C', 0, '', 1);
// 		$pdf->SetFont('helvetica', 'B', 25);
// 		if(strlen($Company)>12){
// 		$pdf->SetFont('helvetica', 'B', 17);
// 		}
// 		$pdf->Cell(0, 0,$Company, 0, 1, 'C', 0, '', 1);
// 		
// 		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/tmpqr/'.$n.'08.png', 4,115, 30, 30, 'PNG', '', '',false, 1000, '', false, false, 1, false, false, false);
// 		
// 		$pdf->SetFillColor(224,146,47);
// 		$pdf->SetTextColor(255,255,255);
// 		$pdf->SetFont('helvetica', 'B', 15);
// 		$pdf->setCellPaddings(0, 6, 0, 0);
// 		
// 		$pdf->setCellPaddings(0, 0, 0, 0);
// 		$pdf->SetFillColor(255,255,255);
// 		$pdf->SetTextColor(0,0,0);
// 		
// 		$pdf->SetFont('helvetica', '', 10);
// 		
// 		$pdf->MultiCell(90,10,$Tutorial." ".$Control." ".$i, 0, 'R', 0, 0, -8.5,144, true);
// 			
// 		 $q++;
// 		 		 
// 	 
// 	 
// 	 
// 	 }
 
for($i=1; $i<=$people; $i++){ 
		$n = $i-1;
		// Define what special labels go on the badges
		$label ="0";
		
		
		if (!empty($results[$n]["GivenName"])){
		$this->qrstamp($results[$n]["GivenName"]." ".$results[$n]["FamilyName"],$results[$n]["Email"],$results[$n]["Company"],$n);
	}
	
		$NameOnBadge=$results[$n]["NameOnBadge"];
		
		$GivenName=$results[$n]["GivenName"];
		echo "<h1>".$GivenName."</h1>";
		
		
		$CN_Company=$results[$n]["CN_Company"];
		$FamilyName=$results[$n]["FamilyName"];
		$EventYear=$results[$n]["EventYear"];
		$Company=$results[$n]["Company"];
		$ContactID=$results[$n]["ContactID"];
		$InvitedByCompanyID=$results[$n]["InvitedByCompanyID"];
		$HardCopy=$results[$n]["HardCopy"];
		$Tutorial=$results[$n]["Tutorial"];
		$Control=$results[$n]["Control"];
		$Message=$results[$n]["Message"];
		$Dinner=$results[$n]["Dinner"];
		
		$pdf->AddPage('P',$pageLayout);
		
		if($HardCopy==1){
		$HardCopy="HC";
		}
		else{
		$HardCopy="0";
		}
		if($convention == "testconx"){
			if($Tutorial==1){
			$Tutorial="TUTORIAL";
			}
			else{
			$Tutorial="";
			}
			}
		if($convention == "tinyml"){
			if($Tutorial==1){
			$Tutorial="SYMPOSIUM";
			}
			else{
			$Tutorial="";
			}
			}
			
		if($convention == "tinyml"){
			if($Dinner==1){
			$Dinnertext="Dinner";
			}
			else{
			$Dinnertext="";
			}
			}
			if($convention == "emea"){
			if($Tutorial==1){
			$Tutorial="Social";
			}
			else{
			$Tutorial="";
			}
			}	
		if($convention == "emea"){
			if($Dinner==1){
			$Dinnertext="Dinner";
			}
			else{
			$Dinnertext="";
			}
			}
		if($type == "Professional"){
		if($graphics){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/images/Combo Badge 2023.jpg',0,0,107.95,158.75, 'JPG', '', '',false, 10, 'C', false, false, 0, false, false, false);
		}
		}
		if($type == "Exhibitor"){
		if($graphics){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/images/Combo Badge 20235.jpg',0,0,107.95,158.75, 'JPG', '', '',false, 10, 'C', false, false, 0, false, false, false);
		}
		}
		if($type == "EXPO"){
		if($graphics){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/images/Combo Badge 20233.jpg',0,0,107.95,158.75, 'JPG', '', '',false, 10, 'C', false, false, 0, false, false, false);
		}
		}
		if($type == "Summit"){
		if($graphics){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/images/tinyML2023Summit.jpg',0,0,107.95,158.75, 'JPG', '', '',false, 10, 'C', false, false, 0, false, false, false);
		}
		}
		if($type == "Symposium"){
		if($graphics){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/images/tinyML2023Symposium.jpg',0,0,107.95,158.75, 'JPG', '', '',false, 10, 'C', false, false, 0, false, false, false);
		}
		}
		if($type == "EXPOtiny"){
		if($graphics){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/images/tinyML2023EXPO.jpg',0,0,107.95,158.75, 'JPG', '', '',false, 10, 'C', false, false, 0, false, false, false);
		}
		}
		if($type == "Attendee"){
		if($graphics){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/images/emea2023.png',0,0,107.95,158.75, 'PNG', '', '',false, 10, 'C', false, false, 0, false, false, false);
		}
		}
		$pdf->SetFont('stsongstdlight', 'B', 75);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('helvetica', 'B', 75);
		$pdf->Ln(45);
if($convention == "testconx"){		
	if (!empty($results[$n]["NameOnBadge"])){
		$pdf->SetFont('helvetica', 'B', 55);
		$pdf->Cell(0, 0, $NameOnBadge, 0, 1, 'C', 0, '', 1);
		
		$pdf->SetFont('stsongstdlight', 'B', 25);

			
	}
	else if (!empty($results[$n]["GivenName"])){
		$pdf->SetFont('helvetica', 'B', 55);
		$pdf->Cell(0, 0, $GivenName, 0, 1, 'C', 0, '', 1);
		
		$pdf->SetFont('stsongstdlight', 'B', 25);
		
		
	}
	else {
		$pdf->SetFont('stsongstdlight', 'B', 55);
		
		
	}
		$pdf->SetFont('stsongstdlight', 'B', 25);
	
		$pdf->Cell(0, 0,$CN_Company, 0, 1, 'C', 0, '', 1);
		$pdf->SetFont('helvetica', 'B', 25);
		if(strlen($FamilyName)>8){
		$pdf->SetFont('helvetica', 'B', 22);
		}
		$pdf->Cell(0, 0,$GivenName." ".$FamilyName, 0, 1, 'C', 0, '', 1);
		$pdf->SetFont('helvetica', 'B', 25);
		if(strlen($Company)>12){
		$pdf->SetFont('helvetica', 'B', 17);
		}
		$pdf->Cell(0, 0,$Company, 0, 1, 'C', 0, '', 1);
		if($type=="EXPO"){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/tmpqr/'.$n.'08.png', 7,115, 30, 30, 'PNG', '', '',false, 1000, '', false, false, 1, false, false, false);
		}
		else{
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/tmpqr/'.$n.'08.png', 7,115, 30, 30, 'PNG', '', '',false, 1000, '', false, false, 1, false, false, false);
		}
		$pdf->SetFillColor(224,146,47);
		$pdf->SetTextColor(255,255,255);
		$pdf->SetFont('helvetica', 'B', 15);
		$pdf->setCellPaddings(0, 6, 0, 0);
		
		$pdf->setCellPaddings(0, 0, 0, 0);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0,0,0);
		
		$pdf->SetFont('helvetica', '', 10);
		if($type=="EXPO"){
		$pdf->MultiCell(90,10,$Tutorial." ".$Control." ".$i, 0, 'R', 0, 0, -8.5,140, true);
		}
		else{
		$pdf->MultiCell(90,10,$Tutorial." ".$Control." ".$i, 0, 'R', 0, 0, -8.5,140, true);
			}
		 $q++;
}	
if($convention == "tinyml"){		
	if (!empty($results[$n]["NameOnBadge"])){
		$pdf->SetFont('helvetica', 'B', 55);
		$pdf->Cell(0, 0, $NameOnBadge, 0, 1, 'C', 0, '', 1);
		
		$pdf->SetFont('stsongstdlight', 'B', 25);

			
	}
	else if (!empty($results[$n]["GivenName"])){
		$pdf->SetFont('helvetica', 'B', 55);
		$pdf->Cell(0, 0, $GivenName, 0, 1, 'C', 0, '', 1);
		
		$pdf->SetFont('stsongstdlight', 'B', 25);
		
		
	}
	else {
		$pdf->SetFont('stsongstdlight', 'B', 55);
		
		
	}
		$pdf->SetFont('stsongstdlight', 'B', 25);
		$pdf->Ln(5);
		//$pdf->Cell(0, 0,$CN_Company, 0, 1, 'C', 0, '', 1);
		$pdf->SetFont('helvetica', 'B', 25);
		if(strlen($FamilyName)>8){
		$pdf->SetFont('helvetica', 'B', 22);
		}
		$pdf->Cell(0, 0,$GivenName." ".$FamilyName, 0, 1, 'C', 0, '', 1);
		$pdf->SetFont('helvetica', 'B', 25);
		if(strlen($Company)>12){
		$pdf->SetFont('helvetica', 'B', 17);
		}
		$pdf->Cell(0, 0,$Company, 0, 1, 'C', 0, '', 1);
		$pdf->Ln(1);
		if($convention == 'tinyml'){
		$pdf->SetFont('helvetica', 'B', 16);
		$pdf->Cell(0, 0,'Ask me about:', 0, 1, 'C', 0, '', 1);
			if(strlen($Message)>8){
			$pdf->SetFont('helvetica', 'B', 22);
		}
		
		$pdf->Cell(0, 0,$Message, 0, 1, 'C', 0, '', 1);
		}
		
		
		if($type=="EXPO"){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/tmpqr/'.$n.'08.png', 6,117, 30, 30, 'PNG', '', '',false, 1000, '', false, false, 1, false, false, false);
		}
		else{
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/tmpqr/'.$n.'08.png', 6,117, 30, 30, 'PNG', '', '',false, 1000, '', false, false, 1, false, false, false);
		}
		$pdf->SetFillColor(224,146,47);
		$pdf->SetTextColor(255,255,255);
		$pdf->SetFont('helvetica', 'B', 15);
		$pdf->setCellPaddings(0, 6, 0, 0);
		
		$pdf->setCellPaddings(0, 0, 0, 0);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0,0,0);
		
		$pdf->SetFont('helvetica', '', 40);
		
		
		//colored rectangle
		if($type=="Symposium"){
		$pdf->SetFont('helvetica', '', 50);
		$pdf->MultiCell(45, 123,"RS", 0, 'C', 0, 0, 45,120, true);
		//$pdf->Rect(45, 123, 80, 30, 'F',array(), array(118,215,61));
		}
		if($type=="EXPOtiny"){
		$pdf->SetFont('helvetica', '', 40);
		$pdf->MultiCell(45, 123,"EXPO", 0, 'L', 0, 0, 45,120, true);
		//$pdf->Rect(45, 123, 80, 30, 'F',array(), array(250,174,2));
		}
		$pdf->SetFont('helvetica', '', 10);
		if($type=="EXPO"){
		$pdf->MultiCell(90,10,$Dinnertext." ".$Tutorial." ".$Control." ".$i, 0, 'R', 0, 0, -8.5,140, true);
		}
		else{
		$pdf->MultiCell(90,10,$Dinnertext." ".$Tutorial." ".$Control." ".$i, 0, 'R', 0, 0, -8.5,140, true);
			}
		
		 $q++;
}		 		 		 
if($convention == "emea"){		
	if (!empty($results[$n]["NameOnBadge"])){
		$pdf->SetFont('helvetica', 'B', 55);
		$pdf->Cell(0, 0, $NameOnBadge, 0, 1, 'C', 0, '', 1);
		
		$pdf->SetFont('stsongstdlight', 'B', 25);

			
	}
	else if (!empty($results[$n]["GivenName"])){
		$pdf->SetFont('helvetica', 'B', 55);
		$pdf->Cell(0, 0, $GivenName, 0, 1, 'C', 0, '', 1);
		
		$pdf->SetFont('stsongstdlight', 'B', 25);
		
		
	}
	else {
		$pdf->SetFont('stsongstdlight', 'B', 55);
		
		
	}
		$pdf->SetFont('stsongstdlight', 'B', 25);
		$pdf->Ln(5);
		//$pdf->Cell(0, 0,$CN_Company, 0, 1, 'C', 0, '', 1);
		$pdf->SetFont('helvetica', 'B', 25);
		if(strlen($FamilyName)>8){
		$pdf->SetFont('helvetica', 'B', 22);
		}
		$pdf->Cell(0, 0,$GivenName." ".$FamilyName, 0, 1, 'C', 0, '', 1);
		$pdf->SetFont('helvetica', 'B', 25);
		if(strlen($Company)>12){
		$pdf->SetFont('helvetica', 'B', 17);
		}
		$pdf->Cell(0, 0,$Company, 0, 1, 'C', 0, '', 1);
		$pdf->Ln(5);
		if($convention == 'emea'){
		$pdf->SetFont('helvetica', 'B', 16);
		$pdf->Cell(0, 0,'Ask me about:', 0, 1, 'C', 0, '', 1);
			if(strlen($Message)>8){
			$pdf->SetFont('helvetica', 'B', 22);
		}
		
		$pdf->Cell(0, 0,$Message, 0, 1, 'C', 0, '', 1);
		}
		
		
		if($type=="EXPO"){
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/tmpqr/'.$n.'08.png', 7,121, 33, 33, 'PNG', '', '',false, 1000, '', false, false, 1, false, false, false);
		}
		else{
		$pdf->Image($_SERVER["DOCUMENT_ROOT"].'/tmpqr/'.$n.'08.png', 7,121, 33, 33, 'PNG', '', '',false, 1000, '', false, false, 1, false, false, false);
		}
		$pdf->SetFillColor(224,146,47);
		$pdf->SetTextColor(255,255,255);
		$pdf->SetFont('helvetica', 'B', 15);
		$pdf->setCellPaddings(0, 6, 0, 0);
		
		$pdf->setCellPaddings(0, 0, 0, 0);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0,0,0);
		
		$pdf->SetFont('helvetica', '', 10);
		
		if($type=="Symposium"){
		$pdf->Rect(45, 123, 80, 30, 'F',array(), array(118,215,61));
		}
		if($type=="EXPOtiny"){
		$pdf->Rect(45, 123, 80, 30, 'F',array(), array(250,174,2));
		}
		
		if($type=="EXPO"){
		$pdf->MultiCell(90,10,$Dinnertext." ".$Tutorial." ".$Control." ".$i, 0, 'R', 0, 0, -8.5,148, true);
		}
		else{
		$pdf->MultiCell(90,10,$Dinnertext." ".$Tutorial." ".$Control." ".$i, 0, 'R', 0, 0, -8.5,148, true);
			}
		
		 $q++;
} 

	 
	 }		
			
ob_clean();
$pdf->Output('My-File-Name.pdf', 'I');
		

	} 

		
		


		
		
	
	

function BadgesMesaProfessional () {
	$this->Testbadge("testconx","Mesa2023", TRUE,"Professional");
}
function BadgesMesaExhibitor () {
	$this->Testbadge("testconx","Mesa2023", True,"Exhibitor");
}
function BadgesMesaEXPOONLY () {
	$this->Testbadge("testconx","Mesa2023", True,"EXPO");
}


function BadgestinymlProfessional () {
	$this->Testbadge("tinyml","tinyml2023", TRUE,"Summit");
}
function BadgestinymlSymposium () {
	$this->Testbadge("tinyml","tinyml2023", TRUE,"Symposium");
}
function BadgestinymlEXPOONLY () {
	$this->Testbadge("tinyml","tinyml2023", TRUE,"EXPOtiny");
}


function BadgesMesaBlankProfessional (){
	$this->Blankbadge("testconx","Mesa2023", FALSE,"Professional");
}
function BadgesMesaBlankExhibitor (){
	$this->Blankbadge("testconx","Mesa2023", FALSE,"Exhibitor");
}
function BadgesMesaBlankEXPO (){
	$this->Blankbadge("testconx","Mesa2023", FALSE,"EXPO");
}

function BadgestinymlBlankProfessional (){
	$this->Blankbadge("tinyml","tinyml2023", FALSE,"Summit");
}
function BadgestinymlBlankExhibitor (){
	$this->Blankbadge("tinyml","tinyml2023", FALSE,"Symposium");
}
function BadgestinymlBlankEXPO (){
	$this->Blankbadge("tinyml","tinyml2023", FALSE,"EXPOtiny");
}

function BadgesEMEAAttendee (){
	$this->Testbadge("emea","emea2023", TRUE,"Attendee");
}

function BadgesEMEABlankAttendee (){
	$this->Blankbadge("emea","emea2023", FALSE,"Attendee");
}
	function ClearPrint ()
	{

	
	$this->db = $this->load->database('RegistrationDataBase', TRUE);

	$data = array (
		'ToPrint' => 'No');
	$this->db->where('ToPrint', 'Yes');
		
	$this->db->update('guests', $data);

	}
		
}

/* End of file Main.php */
/* Location: ./application/controllers/Main.php */
?>