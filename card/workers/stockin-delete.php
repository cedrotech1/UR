<?php
include('connection.php');
checkPrivilege('Stock Recorded');
echo $id=$_GET['hid'];
$ok1 = mysqli_query($connection, "select * from historic where id=$id");
while ($row = mysqli_fetch_array($ok1)) {
  $hhid = $row["id"];
  $pid = $row["pid"];
  $existingquantity = $row["quantity"];
  $existinprice = $row["price"];
  $existcost = $row["cost"];
  $existtotal = $row["total"];
  $existprofit = $row["profit"];
}

$qp = mysqli_query($connection, "select * from stock where pid=$pid");
while ($row = mysqli_fetch_array($qp)) {
  $stockquantity = $row["quantity"];
  $stockunit_cost = $row["unit_cost"];
  $stocktotal_cost = $row["total_cost"];
}
$updatedquantity=$stockquantity-$existingquantity;
// $updatedtotal=
if($updatedquantity==0){
    $updated_unit_cost=0;
    $updated_total= 0;
}else{
    $updated_unit_cost=($stockunit_cost*2)-$existcost;
    $updated_total=$stocktotal_cost-$existtotal;
}

$ok = mysqli_query($connection, "update stock set quantity='$updatedquantity',unit_cost='$updated_unit_cost' ,total_cost=$updated_total where pid=$pid");


$okx=mysqli_query($connection,"delete from historic where id='$hhid'");
            if($okx){
                echo "<script>alert('deleted')</script>";
                // echo $hid;
                echo "<script>window.location.href='recorded.php'</script>";
            }

?>