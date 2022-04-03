<?php
require('../fpdf/fpdf.php');
include_once'../db/connect_db.php';

$id = $_GET['id'];
$select = $pdo->prepare("SELECT tbl_supplier.name ,tbl_purchase.purchase_id,tbl_purchase.cashier_name, tbl_purchase.order_date, tbl_purchase.time_order, tbl_purchase.total,tbl_purchase.discount,tbl_purchase.paid,tbl_purchase.due from tbl_purchase join tbl_supplier on tbl_supplier.supplier_id=tbl_purchase.supplier_id WHERE tbl_purchase.purchase_id=$id");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

$pdf = new FPDF('P','mm', array(80,200));

$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
$pdf->Cell(60,10,'Medicine | POS',0,1,'C');

$pdf->Line(10,18,72,18);
$pdf->Line(10,19,72,19);

$pdf->SetFont('Arial','',10);
$pdf->Cell(60,3,'Karachi Pakistan',0,1,'C');

// $pdf->SetFont('Arial','',8);
// $pdf->Cell(63,4,'Landline # 021-32546251',0,1,'C');

$pdf->Line(10,30,72,30);
$pdf->Line(10,31,72,31);

$pdf->SetY(31);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(60,6 ,'Purchase Receipt',0,1,'C');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(20,4 ,'Invoice No   :',0,0,'C');

$pdf->SetFont('Courier','BI',8);
$pdf->Cell(10,4 ,$row->purchase_id,0,1,'C');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(22,4 ,'Supplier Name :',0,0,'C');

$pdf->SetFont('Courier','BI',8);
$pdf->Cell(14,4 ,$row->name,0,1,'C');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(20,4 ,'Cashier Name :',0,0,'C');

$pdf->SetFont('Courier','BI',8);
$pdf->Cell(10,4 ,$row->cashier_name,0,1,'C');

$pdf->SetFont('Courier','B',8);
$pdf->Cell(20,4 ,'Date & Time  :',0,0,'C');

$pdf->SetFont('Courier','BI',8);
$pdf->Cell(21,4 ,$row->order_date,0,0,'C');

$pdf->SetFont('Courier','BI',8);
$pdf->Cell(10,4 ,$row->time_order,0,1,'C');
//////////////////////////////////////////////
$pdf->SetY(55);

$pdf->SetX(6);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(27,8 ,'Product',1,0,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(7,8 ,'Qty',1,0,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(18,8 ,'Rate',1,0,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(18,8 ,'Total',1,1,'C');

$select = $pdo->prepare("SELECT * FROM tbl_purchase_detail WHERE purchase_id=$id");
$select->execute();
while($item = $select->fetch(PDO::FETCH_OBJ)){
    $pdf->SetX(6);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(27,5,$item->product_name,1,0,'L');
    $pdf->Cell(7,5,$item->qty,1,0,'C');
    $pdf->SetFont('Arial','B',7);
    $pdf->Cell(18,5,'Rp '.$item->price,1,0,'R');
    $pdf->Cell(18,5,'Rp '.$item->total,1,1,'R');
}

//////////////////////////////////////////////
$pdf->SetX(43);
$pdf->SetFont('Arial','Bi',8);
$pdf->Cell(25,8 ,'Total  :',0,0,'C');

$pdf->SetFont('Arial','BI',7);
$pdf->Cell(1,8 ,'Rp ' .$row->total,0,1,'C');

$pdf->SetX(43);
$pdf->SetFont('Arial','Bi',8);
$pdf->Cell(25,8 ,'Discount  :',0,0,'C');

$pdf->SetFont('Arial','BI',7);
$pdf->Cell(2,8 ,'Rp ' .$row->discount,0,1,'C');

$pdf->SetX(43);
$pdf->SetFont('Arial','BI',7);
$pdf->Cell(25,4 ,'Paid   :',0,0,'C');

$pdf->SetFont('Arial','BI',7);
$pdf->Cell(1,4 ,'Rp '.$row->paid,0,1,'C');

$pdf->SetX(43);
$pdf->SetFont('Arial','BI',8);
$pdf->Cell(25,8 ,'Balance   :',0,0,'C');

$pdf->SetFont('Arial','BI',7);
$pdf->Cell(1,8 ,'Rp '.$row->due,0,1,'C');

//////////////////////////////////////////////
$pdf->SetY(175);
$pdf->SetX(5);
// $pdf->SetFont('Arial','B',10);
// $pdf->Cell(45,4 ,'Thank you come again',0,1,'L');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(65,4,'Software by Abdul-Samad | 03102536246',0,1,'L'); 

$pdf->Output();

