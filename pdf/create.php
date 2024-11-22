<?php

require_once('tcpdf/tcpdf.php');

$p_nev = $_POST["nev"];
$p_talnev = $_POST["talnev"];
$p_szuletes = $_POST["szuletes"];

class MYPDF extends TCPDF {

	public function LoadData($nev, $talnev, $szuletes) {
		$rows = array();

		try {
			
			$dbh = new PDO('mysql:host=localhost;dbname=feltalalokdb', 'feltalalokdb', 'UvegPohar111',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
			$dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');

			$sql = "select k.*,t.* from kutato k join kapcsol ka on k.fkod=ka.fkod join talalmany t on t.tkod=ka.tkod where t.talnev like :talnev and k.nev like :nev and k.szul > :szuletes"; 
			$sth = $dbh->prepare($sql);
			$sth->bindValue(':nev', '%'.$nev.'%');
			$sth->bindValue(':talnev', '%'.$talnev.'%');
			$sth->bindValue(':szuletes', $szuletes);
			
			$sth->execute();
			$rows = $sth->fetchAll(PDO::FETCH_NUM);
			}
			catch (PDOException $e) {
				
			}
		return $rows;
	}

	public function Table($caption, $header,$rows) {
		$this->SetFont('courier', 'B', 16);
		$this->SetTextColor(0, 0, 0);

		$this->cell(180, 18, $caption, 0, 0, 'C', 0);
		$this->Ln();
		
		$this->SetLineWidth(0.2);

		$this->SetFont('courier', 'B', 10);
		$this->SetFillColor(200, 0, 0);
		$this->SetTextColor(255,255,255);
		$this->SetDrawColor(0,0,0);

		$w = array(15, 50, 20, 18, 14,60);
		$num_headers = count($header);
		for($i = 0; $i < $num_headers; ++$i) {
			$this->Cell($w[$i], 12, $header[$i], 1, 0, 'C', 1);
		}
		$this->Ln();

		$this->SetFont('courier', '', 10);
		$this->SetDrawColor(0,0,0);

		$i = 1;
		foreach($rows as $row) {
			if($i) {
				$this->SetFillColor(255,255,255);
				$this->SetTextColor(0,0,0);
			}
			else {
				$this->SetFillColor(240,240,240);
				$this->SetTextColor(0,0,0);
			}
			$this->Cell($w[0], 14, $row[0], 'LRB', 0, 'R', 1, '', 0, false, 'T', 'T');
			$this->Cell($w[1], 14, $row[1], 'LRB', 0, 'L', 1, '', 0, false, 'T', 'T');
			$this->Cell($w[2], 14, $row[2], 'LRB', 0, 'L', 1, '', 0, false, 'T', 'T');
			$this->Cell($w[3], 14, $row[3], 'LRB', 0, 'L', 1, '', 0, false, 'T', 'T');
			$this->Cell($w[4], 14, $row[4], 'LRB', 0, 'L', 1, '', 0, false, 'T', 'T');
			$this->Cell($w[5], 14, $row[5], 'LRB', 0, 'L', 1, '', 0, false, 'T', 'T');
			$this->Ln();
			$i = !$i;
		}
	}
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Takács Dániel');
$pdf->SetTitle('Találmányok');
$pdf->SetSubject('Találmányok');

$pdf->SetHeaderData("ENIAC_Penn1.png", 15, "Találmányok", "Találmányok\n".date('Y.m.d',time()));

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

if (@file_exists(dirname(__FILE__).'/lang/hun.php')) {
	require_once(dirname(__FILE__).'/lang/hun.php');
	$pdf->setLanguageArray($l);
}

$pdf->SetFont('courier', '', 14, '', true);

$pdf->AddPage();

$caption = 'Találmányok PDF';
$header = array('Fkod', 'Kutató neve', 'Született', 'Meghalt', 'Tkod', 'Találmány');
$rows = $pdf->LoadData($p_nev,$p_talnev,$p_szuletes);

$pdf->Table($caption, $header, $rows);

$pdf->Output('talalmanyok.pdf', 'I');