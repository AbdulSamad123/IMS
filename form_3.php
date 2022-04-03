<?php
$conn = mysqli_connect('localhost', 'root', '', 'ipos');  
session_start();

isset( $_SESSION['name'] );
$customer_id = $_SESSION['name'];
$date_1 = $_SESSION['date_1'];
$date_2 = $_SESSION['date_2'];

$query = "Select name as cus from tbl_customer where customer_id= '$customer_id'";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result))
{
     $putin = $row['cus'];
}

$quer = "Select Sum(total) as sum from tbl_invoice where customer_id = '$customer_id'and order_date BETWEEN '$date_1' AND '$date_2'";
$result = mysqli_query($conn, $quer);
while ($row = mysqli_fetch_assoc($result))
{   
     $output = $row['sum'];
}

$putin;
$qu = "Select Sum(received) as sum from tbl_balance where Cus_name = '$putin' and date BETWEEN '$date_1' AND '$date_2'";
$result = mysqli_query($conn, $qu);
while ($row = mysqli_fetch_assoc($result))
{
     $out = $row['sum'];
}

$bal = "Select Sum(due) as sum from tbl_invoice where customer_id = '$customer_id' and order_date < '$date_1'";
$result = mysqli_query($conn, $bal);
while ($row = mysqli_fetch_assoc($result))
{
     $put = $row['sum'];
}

  $sub = $put - $out;
?>
<!DOCTYPE html>
<html>
<head>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<title></title>
<body>
    <div class="container" id="content">
        <h2 class="text-center">Seerat Traders & Medical Store</h2>
        <p class="text-center">Karachi Pakistan</p>
        <p class="text-center">Design by Abdul-Samad (0310-2536246), Samad182@gmail.com</p>
        <h3 class="text-center">Sales Report</h3>
                <div class="row">
                    <div class="col"> <strong>Customer's Name</strong></div>
                    <div class="col"><?php echo $putin ?></div>
                    <div class="col"></div>
                    <div class="col"></div>
                </div>
                <div class="row">
                    <div class="col"> <strong>Starting Date</strong></div>
                    <div class="col"><?php echo $date_1 ?></div>
                    <div class="col"></div>
                    <div class="col"></div>
                </div>
                <div class="row">
                    <div class="col"> <strong>Ending Date</strong></div>
                    <div class="col"><?php echo $date_2 ?></div>
                    <div class="col"></div>
                    <div class="col"></div>
                </div>
                <table class="table table-bordered table-striped mt-5">
                    <thead>
                        <tr> 
                            <th>Selling Date</th>
                            <th>Product Name</th>
                            <th>Product Quantity</th>
                            <th>Product Price</th>
                            <th>Amount</th>
                        </tr>
                    </thead>

                <?php
                $query = "SELECT tbl_customer.name, tbl_invoice.order_date, tbl_invoice_detail.price, tbl_invoice_detail.total, tbl_invoice_detail.product_name, tbl_invoice_detail.qty From tbl_customer join tbl_invoice on tbl_customer.customer_id=tbl_invoice.customer_id join tbl_invoice_detail ON tbl_invoice.invoice_id = tbl_invoice_detail.invoice_id WHERE tbl_invoice.customer_id = '$customer_id' and tbl_invoice.order_date BETWEEN '$date_1' and '$date_2'";
                $select = mysqli_query($conn, $query);
                
                
                    while($row = mysqli_fetch_assoc($select)) {
                ?>
                <tbody>
                    <tr>
                        <td><?php echo $row['order_date']?></td>
                        <td><?php echo $row['product_name']?></td>
                        <td><?php echo $row['qty']?></td>
                        <td><?php echo $row['price']?></td>
                        <td><?php echo $row['total']?></td>
                    </tr>
                    <?php 
                } ?>
                    <tr>
                        <td colspan="3"></td>
                        <td><b>Total Amount</b></td>
                        <td><?php echo number_format($output,2) ; ?></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td><b>Previous Balance</b></td>
                        <td><?php echo number_format($put,2) ; ?></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td><b>Paid</td>
                        <td><?php echo number_format($out,2) ; ?></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td><b>Sub Total</b></td>
                        <td><?php echo number_format($sub,2) ; ?></td>
                    </tr>

                </tbody>
        </table>
   </div>
   <!-- <button type="button" onclick="generatePDF();" class="btn btn-info"> Click here</button> -->
</body>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- jsPDF library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>


<script>
function generatePDF() {
    var doc = new jsPDF();
    var elementHTML = $('#content').html();
    var specialElementHandlers = {
        '#elementH': function (element, renderer) {
            return true;
        }
    };
    doc.fromHTML(elementHTML, 15, 15, {
        'width': 170,
        'elementHandlers': specialElementHandlers
    });
}
// Save the PDF
doc.save('sample-document.pdf');
</script>
</script>
</html>

