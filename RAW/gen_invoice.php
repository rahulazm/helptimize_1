<?php
require('./fpdf181/fpdf.php');
require_once("common.inc.php");
require_once "check_session.php";
require_once("mysql_lib.php");

class PDF extends FPDF
{
// Page header
function Header()
{
	// Logo
	$this->Image('./img/helptimize_text_small.png',10,6,30);
	// Arial bold 15
	$this->SetFont('Arial','B',15);
	// Move to the right
	$this->Cell(80);
	// Title
	$this->Cell(50,10,'Helptimize Invoice',1,0,'C');
	// Line break
	$this->Ln(20);
}

// Page footer
function Footer()
{
	// Position at 1.5 cm from bottom
	$this->SetY(-15);
	// Arial italic 8
	$this->SetFont('Arial','I',8);
	// Page number
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

//sql 
$sqlServ="select * from view_serviceRequests where id='$_POST[sr_id]' AND ownerid='$_POST[owner_id]'";
$res=$_sqlObj->query($sqlServ);
$sqlFee="select * from platform_fee where platformfee_status='0'";
$resFee=$_sqlObj->query($sqlFee);
//$slsCommFee = ($resFee[0]['platformfee_name']=='')?:;
//print_r($res);


// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->Cell(0,10,'Invoice Id ---- '.$res[0]['id'],0,1);
$pdf->Cell(0,10,'Invoice date/time ---- '.date("Y-m-d H:i:s", strtotime($res[0]['create_dateTime'])),0,1);
//$pdf->Cell(0,10,'Invoice Paytype ----',0,1);
$pdf->Cell(0,10,'Invoice Pay Amount ---- '.$res[0]['payAmt'],0,1);
$Fees=$res[0]['payAmt'];
for($i=0;$i<count($resFee);$i++){
	$pdf->Cell(0,10,$resFee[$i]['platformfee_name'].' ---- '.$resFee[$i]['platformfee_value'].' %',0,1);
	$Fees+= $resFee[$i]['platformfee_value']*$res[0]['payAmt']/100;
}

$pdf->Cell(0,10,'Invoice Total amount ---- '.$Fees,0,1);
$filename="./invoice/invoice_".$_POST['sr_id'].".pdf";
$pdf->Output($filename,'F');
echo $filename;
//$pdf->Output();
?>
