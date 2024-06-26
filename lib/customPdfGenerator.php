<?php
// namespace Phppot;
  class CustomPdfGenerator extends TCPDF  {
    public function Header() 
    {
        //$image_file = '/web/logo.png';
        //$this->Image($image_file, 10, 3, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->SetFont('dejavusans', 'I', 8);
        $this->Cell(0, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln();
        $this->Cell(0, 2, 'Обслуговуючий  ', 0, false, 'R', 0, '', 0, false, 'M', 'M');
        $this->Ln();
        $this->Cell(0, 8, 'Кооператив     ', 0, false, 'R', 0, '', 0, false, 'M', 'M');
        $this->Ln();
        $this->SetFont('dejavusans', '6', 10);
        $this->Cell(0, 8, 'СТ "Ручейок"', 0, false, 'R', 0, '', 0, true, 'M', 'M');
        $this->Ln();
        $this->SetFont('dejavusans', 'L', 8);
        $this->Cell(0, 6, 'Голова правління:           ', 0, true, 'R', 0, '', 0, false, 'M', 'M');
        $image_file = '../img/rucheyok-signin.png';
        $this->Image($image_file, 150, 35, 40, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->Ln();
        $this->Ln();
        $this->Ln();
        $this->Ln();
        $this->Ln();
        $this->Cell(0, 12, '_______________/Заяц О.В./', 0, true, 'R', 0, '', 0, false, 'M', 'M');
    }
    public function Footer() 
    {
        $this->SetY(-15);
        $this->SetFont('dejavusans', 'I', 10);
        $this->Cell(0, 10, '"СТ Ручейок", +380 (96) 090 62 26, info@rucheyok.org.ua', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
    public function printTable($header, $data)
    {
        $this->SetFillColor(0, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', '5', 8);
        $w = array(6, 14, 80, 26, 20, 32);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration 
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // table data 
        $fill = 0;
        $total = 0;
        foreach($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'R', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'R', $fill);
            $this->Cell($w[2], 6, $row[2], 'LR', 0, 'L', $fill);
            $this->Cell($w[3], 6, $row[3], 'LR', 0, 'R', $fill);
            $this->Cell($w[4], 6, number_format($row[4], 2, ',', ' '), 'LR', 0, 'R', $fill);
            $this->Cell($w[5], 6, $row[5], 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill=!$fill;
            $total+=$row[4];
        }
        $this->Cell($w[0], 6, '', 'LR', 0, 'R', $fill);
        $this->Cell($w[1], 6, '', 'LR', 0, 'R', $fill);
        $this->Cell($w[2], 6, '', 'LR', 0, 'L', $fill);
        $this->Cell($w[3], 6, '', 'LR', 0, 'R', $fill);
        $this->Cell($w[4], 6, '', 'LR', 0, 'R', $fill);
        $this->Cell($w[5], 6, '', 'LR', 0, 'R', $fill);
        $this->Ln();
        $this->Cell($w[0], 6, '', 'LR', 0, 'R', $fill);
        $this->Cell($w[1], 6, '', 'LR', 0, 'R', $fill);
        $this->Cell($w[2], 6, '', 'LR', 0, 'L', $fill);
        $this->Cell($w[3], 6, 'ВСЬОГО:', 'LR', 0, 'R', $fill);
        $this->Cell($w[4], 6, number_format($total, 2, ',', ' '), 'LR', 0, 'R', $fill);
        $this->Cell($w[5], 6, '', 'LR', 0, 'R', $fill);
        $this->Ln();
        $this->Cell(array_sum($w), 0, '', 'T');
    }
  }
?>
