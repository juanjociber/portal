<?php

//http://www.fpdf.org/en/download.php
// include class
require($_SERVER['DOCUMENT_ROOT'].'/mycloud/library/fpdf-1.84/fpdf.php');

class PDF extends FPDF
{
    //Cabecera de página
    function Header(){
        //Logo
        $this->Image($_SERVER['DOCUMENT_ROOT'].'/mycloud/logos/logo-gpem.png',10,13,50,15, "PNG" ,"https://gpemsac.com");
        //Arial bold 15
        $this->SetFont('Arial','B',15);
        //Movernos a la derecha
        $this->Cell(140);
        //$this->Multicell(50, 10, 'COTIZACION'. "\n"."123123", 1, 'C', 0);
        $this->Cell(50,10,'COTIZACION','LTR',0,'C');
        $this->Ln();
        $this->Cell(140);
        $this->Cell(50,10,'2022-03404040','LRB',0,'C');
        //Salto de línea
        $this->Ln(15);
    }
   //Pie de página
    function Footer()
    {
        $this->SetY(-10);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

    function BasicTable($header)
    {
        // Header
        foreach($header as $col)
            $this->Cell(40,7,$col,1);
        $this->Ln();
    }
}

// create document
$pdf = new PDF();
//$pdf = new FPDF();

$pdf->AliasNbPages();
$pdf->AddPage();

// config document
$pdf->SetTitle('Generar archivos PDF con PHP');
$pdf->SetAuthor('Kodetop');
$pdf->SetCreator('FPDF Maker');

//$pdf->SetY(20);

// add title
//$pdf->SetFont('Arial', 'B', 24);
//$pdf->Cell(0, 10, 'Generar archivos PDF con PHP', 0, 1);
//$pdf->Ln();

// add text
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 6, 'Lima, 23 de Agosto del 2021', 0, 1);
$pdf->Ln();
$pdf->Cell(0, 6, utf8_decode('Señores:'), 0, 1);
$pdf->Cell(0, 6, utf8_decode('NOMBRE DEL CLIENTE'), 0, 1);
$pdf->Cell(0, 6, 'RUC: 2123123123', 0, 1);
$pdf->Cell(0, 6, utf8_decode('Dirección: Av. Los Incas S/N.'), 0, 1);
$pdf->Ln();
//$pdf->Multicell(160, 6, 'ALUMNO: ' . 'HOLA A TODOS' . "\n"."DSFDSDFSDF", 1, 'C', 0);
$pdf->Multicell(0, 6, utf8_decode('              De nuestra especial consideración, es grato dirigirnos a Uds. para remitir la siguiente cotización.'), 0,'J',0);
//$pdf->Cell(0, 6, '               ', 0, 1);
$pdf->Ln(2);

// Colors, line width and bold font
$pdf->SetFillColor(0,10,110);
$pdf->SetTextColor(255);
$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(.3);
$pdf->SetFont('Arial','',9);

//$x=$pdf->GetX();
$y=$pdf->GetY();
$y+=6;

$x=10;
$pdf->SetXY($x,$y);
$pdf->Cell(10, 6, 'Item',"B",0,'C',true);

$x+=10;
$pdf->SetXY($x,$y);
$pdf->Cell(30, 6, utf8_decode('Código'), "B", 0, 'L', true);

$x+=30;
$pdf->SetXY($x,$y);
$pdf->Cell(60, 6, utf8_decode('Descripción'), "B", 0, 'L', true);

$x+=60;
$pdf->SetXY($x,$y);
$pdf->Cell(30, 6, 'Cant.', "B", 0, 'R', true);

$x+=30;
$pdf->SetXY($x,$y);
$pdf->Cell(30, 6, 'V.Vventa', "B", 0, 'R', true);

$x+=30;
$pdf->SetXY($x,$y);
$pdf->Cell(30, 6, 'P.Venta', "B", 0, 'R', true);

$producto="Los archivos PDF 123456789123 dnsdfd sdf sf s FJSDFSJDF SJ FJS FDJS FDJ SDFSDFSDFF788SD FSDFKSKDF SDJ/// DSDFKS DFJSDJF SDJF SDJF S FDJSD FJSD FJS DF SDFSDFS DSFL..S,DF,SDF";
//$h= 6 * (ceil($pdf->GetStringWidth($producto)/48));

$pdf->SetFillColor(224,235,255);
$pdf->SetDrawColor(180,180,180);
$pdf->SetTextColor(0);
$pdf->SetFont('');

$y+=6;

$altura=6;

$x=50; //Ubicación x de la columna producto (para hallar su altura).
$pdf->SetXY($x,$y); //Establecemos la ubicacion x,y de la columna producto
$pdf->Multicell(60, $altura, utf8_decode($producto), "B", 'L', 0);

$altura=$pdf->GetY()-$y; //Obtenemos la ubicacion y de la actual posicion y le restamos la anterior ubicacion y para hallar la altura de la columna dinámica

$x=10; //Ubicación x de la 1ra columna
$pdf->SetXY($x,$y);
$pdf->Cell(10, $altura, 1, "B", 0, 'R');

$x+=10; //Ubicacion x de la 2da columna
$pdf->SetXY($x,$y);
$pdf->Cell(30, $altura, "A-CR001", "B", 0, 'L', 0);

$x=110; //Ubicación x de la 4ta columna.
$pdf->SetXY($x,$y);
$pdf->Cell(30, $altura, 12.00, "B", 0, 'R', 0);

$x+=30; //Ubicación x de la 5ta columna.
$pdf->SetXY($x,$y);
$pdf->Cell(30, $altura, '16.56', "B", 0, 'R', 0);

$x+=30; //Ubicación x de la 6ta columna.
$pdf->SetXY($x,$y);
$pdf->Cell(30, $altura, '20.45', "B", 0, 'R', 0);

//$y+=$h;



$pdf->Ln();


$header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');
// Simple table

$pdf->BasicTable($header);


//$pdf->SetFont('Times','',12);
//for($i=1;$i<=40;$i++)
//    $pdf->Cell(0,10,'Imprimiendo línea número '.$i,0,1);

// add image
$pdf->Image($_SERVER['DOCUMENT_ROOT'].'/mycloud/logos/logo-gpem.png', null, null, 180);

// output file
$pdf->Output('', 'fpdf-complete.pdf');

?>