<?php
include ('connection.php');
checkPrivilege('View Product');
$id1= intval($_GET['pid']);
// $id = 2;
if (!isset($id1)) {
  echo "<script>window.location.href='view_products.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>OGB GARAGE-stock</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/icon1.png" rel="icon">
  <link href="assets/img/icon1.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">


</head>

<body>

  <?php
  include ("./includes/header.php");
  include ("./includes/menu.php");
  ?>



  <main id="main" class="main">



    <section class="section dashboard">
      <div class="row">


        <!-- <div class="col-lg-4">
          <div class="col-xxl-12 col-md-12">
            <div class="card info-card">
              <div class="card-body">
                <br>
                <img src="assets/img/sp.png" class="card-img-top" alt="...">
                <div class="card-body">
                  <p class="card-title">Card with an image on top</p>
                  <p class="card-text">Some quick example text to build on .</p>
                  <div class="ps-1">
                    <h6>3,264</h6>
                    <span class="text-success small pt-1 fw-bold">8%</span> <span
                      class="text-muted small pt-2 ps-1">quantity</span>

                  </div>
                </div>
              </div>

            </div>
          </div>


        </div> -->

        <?php


        // Retrieve products with updated quantity from the database
        $query = "SELECT p.pid, p.*, s.quantity AS product_quantity,s.unit_cost AS unit_cost ,s.total_cost AS total_cost  FROM `product` AS p LEFT JOIN `stock` AS s ON p.pid = s.pid where p.pid=$id1";

        $result = mysqli_query($connection, $query);

        // Check if there are any products
        if (mysqli_num_rows($result) > 0) {
          // Loop through each product
          while ($row = mysqli_fetch_assoc($result)) {
            // Initialize quantity to 0 if not found in stock table
            $quantity = isset($row['product_quantity']) ? $row['product_quantity'] : 0;

            // Output HTML card for each product
            ?>

            <div class="col-xxl-3 col-md-4">
              <a href="stock.php?pid=<?php echo $row['pid']; ?>">
                <div class="card info-card">
                  <div class="card-body">
                    <br>

                    <?php
              if($row['image']==''){

              }else{
                ?>
                  <img src="<?php echo "../Dashboard/".$row['image']?>" class="card-img-top" alt="<?php echo $row['pname']; ?>">
                <?php
              }

              ?>
                   
                    <!--<img src="<?php //echo $row['image']; ?>" class="card-img-top" alt="<?php //echo $row['pname']; ?>">-->
                    <div class="card-body">
                      <p class="card-title"><?php echo $row['pname']; ?></p>
                      <p class="card-text"><?php //echo $row['decription']; ?></p>
                      <div class="ps-1">
                        <h6><?php echo $quantity; ?> quantities</h6>
                        <span class="text-success small pt-1 fw-bold"><?php echo $row['unit_cost']; ?>&nbsp;Rwf</span> <span
                              class="text-muted small pt-2 ps-1">unity cost</span><br>

                              <span class="text-success small pt-1 fw-bold"><?php echo $row['total_cost']; ?>&nbsp;Rwf</span> <span
                              class="text-muted small pt-2 ps-1">total cost</span>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div><!-- End Sales Card -->

            <?php
          }
        } else {
          // If no products found
          echo '<p>No products found</p>';
        }
        ?>


        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

          <div class="card">
  <div class="card-body">
    <br>
    <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
      <li class="nav-item flex-fill" role="presentation">
        <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-justified" type="button" role="tab" aria-controls="home" aria-selected="true">Record Stock In</button>
      </li>
      <li class="nav-item flex-fill" role="presentation">
        <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-justified" type="button" role="tab" aria-controls="profile" aria-selected="false">Record Stock Out</button>
      </li>
    </ul>

    <div class="tab-content pt-2" id="myTabjustifiedContent">
      <div class="tab-pane fade show active" id="home-justified" role="tabpanel" aria-labelledby="home-tab">
        <div class="row">
          <div class="col-md-6">
            <form class="mt-3" action="stock.php" method="POST">
            <input type="text" name='pid' value='<?php echo $id ?>' hidden>
              <div class="mb-3 form-floating">
                <input type="number" class="form-control" id="quantity" placeholder="Product Quantity" name='quantity' required>
                <label for="quantity">Quantity</label>
              </div>
              <div class="mb-3 form-floating">
                <input type="number" class="form-control" id="unit_cost" name='unit_cost' required>
                <label for="unit_cost">Unit Cost (Rwf)</label>
              </div>

              <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustifiedHome" role="tablist">
                <li class="nav-item flex-fill" role="presentation">
                  <button class="nav-link w-100 active" id="no-date-tab" data-bs-toggle="tab" data-bs-target="#no-date" type="button" role="tab" aria-controls="no-date" aria-selected="true">Without Date</button>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                  <button class="nav-link w-100" id="date-tab" data-bs-toggle="tab" data-bs-target="#date" type="button" role="tab" aria-controls="date" aria-selected="false">With Date</button>
                </li>
              </ul>
              
              <div class="tab-content pt-2" id="borderedTabJustifiedContentHome">
                <div class="tab-pane fade show active" id="no-date" role="tabpanel" aria-labelledby="no-date-tab">
                  <p style='text-align:justify'>You can proceed without specifying a date. The system will automatically use the current date. However, if the action occurred on a different date, please enter the appropriate date.</p>
                </div>
                <div class="tab-pane fade" id="date" role="tabpanel" aria-labelledby="date-tab">
                  <div class="mb-3 form-floating">
                    <input type="date" class="form-control" id="record_date" name='record_date' disabled>
                    <label for="record_date">Record Date</label>
                  </div>
                </div>
              </div>

              <button type="submit" name='stockin' class="btn btn-primary col-12">RECORD STOCK IN</button>
            </form>
          </div>
        </div>
      </div>

      <!-- stockout -->

      <div class="tab-pane fade" id="profile-justified" role="tabpanel" aria-labelledby="profile-tab">
        <div class="row">
          <div class="col-md-6"></div>
          <div class="col-md-6">
            <form class="mt-3" action="stock.php" method="POST">
              <input type="text" name='pid' value='<?php echo $id ?>' hidden>
                <!-- <input type="text" name='pid' value='<?php //echo $id ?>'> -->
              <div class="mb-3 form-floating">
                <input type="number" class="form-control" id="quantity" placeholder="Product Quantity" name='quantity' required>
                <label for="quantity">Quantity</label>
              </div>
              <div class="mb-3 form-floating">
                <input type="number" class="form-control" id="unit_cost" name='unit_cost' required>
                <label for="unit_cost">Unit Price (Rwf)</label>
              </div>

              <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustifiedProfile" role="tablist">
                <li class="nav-item flex-fill" role="presentation">
                  <button class="nav-link w-100 active" id="no-date-tab" data-bs-toggle="tab" data-bs-target="#no-date-profile" type="button" role="tab" aria-controls="no-date-profile" aria-selected="true">Without Date</button>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                  <button class="nav-link w-100" id="date-tab" data-bs-toggle="tab" data-bs-target="#date-profile" type="button" role="tab" aria-controls="date-profile" aria-selected="false">With Date</button>
                </li>
              </ul>

              <div class="tab-content pt-2" id="borderedTabJustifiedContentProfile">
                <div class="tab-pane fade show active" id="no-date-profile" role="tabpanel" aria-labelledby="no-date-tab">
                  <p style='text-align:justify'>You can proceed without specifying a date. The system will automatically use the current date. However, if the action occurred on a different date, please enter the appropriate date.</p>
                </div>
                <div class="tab-pane fade" id="date-profile" role="tabpanel" aria-labelledby="date-tab">
                  <div class="mb-3 form-floating">
                    <input type="date" class="form-control" id="record_date" name='record_date' disabled>
                    <label for="record_date">Record Date</label>
                  </div>
                </div>
              </div>

              <button type="submit" name='stockout' class="btn btn-danger col-12">RECORD STOCK OUT</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>




          </div>
        </div><!-- End Left side columns -->


      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->

  <?php
  include ("./includes/footer.php");
  ?>

  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>

<?php

$time = date("h:i:s A");

if (isset($_POST['stockin'])) {

  $pid = $_POST['pid'];
  $quantity = intval($_POST['quantity']);
  $unit_cost = floatval($_POST['unit_cost']);
  $total = $quantity * $unit_cost;
  $total_price = $quantity * $unit_cost;


              if ($_POST['record_date'] != '') {
                $record_date = $_POST['record_date'];
                if (preg_match("/^\d{4}-\d{2}-\d{2}$/", $record_date)) {
                  list($year, $month, $day) = explode('-', $record_date);
                }
              } else {
                $year = date("Y");
                $month = date("m");
                $day = date("d");
                //  echo $year . $month . $day;
              }
                 $ok1 = mysqli_query($connection, "select * from stock where pid=$pid");
                  while ($row = mysqli_fetch_array($ok1)) {
                    $existingquantity = $row["quantity"];
                    $existingunit_cost = $row["unit_cost"];
                    $existingtotal_cost = $row["total_cost"];
                }
                 $updatedquantity= $quantity + $existingquantity;
                $updatedTotal=$existingtotal_cost +   $total_price;
                if( $existingunit_cost==0){

                  $updatedunit_cost=$unit_cost;

                }else{
                   $updatedunit_cost=($existingunit_cost + $unit_cost)/2;


                }
               

              $ok = mysqli_query($connection, "update stock set quantity=quantity + '$quantity' ,total_cost=$updatedTotal,unit_cost=$updatedunit_cost where pid='$pid' ");
              if ($ok) {

                echo "<script>alert('stock added successfully')</script>";

                $stock_ok = mysqli_query($connection, "INSERT INTO `historic`(`id`, `pid`, `quantity`, `cost`, `total`, `profit`, `year`, `month`, `day`,`time`,`status`) 
                  VALUES (null,'$pid','$quantity','$unit_cost','$total','0','$year','$month','$day','$time','stockin')");
                if ($stock_ok) {
                  echo "<script>window.location.href='view_products.php'</script>";
                }

              } else {
                echo "not" . mysqli_error($connection) . "";
              }





}
 if (isset($_POST['stockout'])){




  $pid = $_POST['pid'];
  $quantity = intval($_POST['quantity']);
  $unit_cost = floatval($_POST['unit_cost']);
  $total = $quantity * $unit_cost;
  $total_price = $quantity * $unit_cost;


  if ($_POST['record_date'] != '') {
    $record_date = $_POST['record_date'];
    if (preg_match("/^\d{4}-\d{2}-\d{2}$/", $record_date)) {
      list($year, $month, $day) = explode('-', $record_date);
    }
  } else {
    $year = date("Y");
    $month = date("m");
    $day = date("d");
    //  echo $year . $month . $day;
  }

  
  $ok1 = mysqli_query($connection, "select * from stock where pid=$pid");
  while ($row = mysqli_fetch_array($ok1)) {
    $existingquantity = $row["quantity"];
    $existingunit_cost = $row["unit_cost"];
    $existingtotal_cost = $row["total_cost"];
}
$updatedquantity= $existingquantity - $quantity;
$updatedTotal=$existingtotal_cost -   $total_price;
// $updatedunit_cost=$updatedTotal / $updatedquantity;

$cost_for_quantity=$quantity * $existingunit_cost;
$profit=$total_price-$cost_for_quantity;
$put_price=$updatedTotal+$profit;


      if($existingquantity>=$quantity){
if($updatedquantity!=0){
  

          $ok = mysqli_query($connection, "update stock set quantity=quantity - '$quantity' ,total_cost=$put_price where pid=$pid ");
              if($ok){
                echo "<script>alert('stock out  added successfully')</script>";

                $stock_ok = mysqli_query($connection, "INSERT INTO `historic`(`id`, `pid`, `quantity`, `price`,`cost`, `total`, `profit`, `year`, `month`, `day`, `time`, `status`) 
                  VALUES (null,'$pid','$quantity','$unit_cost','$existingunit_cost','$total','$profit','$year','$month','$day','$time','stockout')");
                if ($stock_ok) {
                  echo "<script>window.location.href='view_products.php'</script>";
                }
              }else{
                echo "<script>alert('not')</script>";
                  // echo "not".mysqli_error( $connection )."";
              }
}else{
  $ok = mysqli_query($connection, "update stock set quantity=quantity - '$quantity',unit_cost='0' ,total_cost=$put_price where pid=$pid ");
  if($ok){
    echo "<script>alert('stock out  added successfully')</script>";

    $stock_ok = mysqli_query($connection, "INSERT INTO `historic`(`id`, `pid`, `quantity`, `price`,`cost`, `total`, `profit`, `year`, `month`, `day`, `time`, `status`) 
      VALUES (null,'$pid','$quantity','$unit_cost','$existingunit_cost','$total','$profit','$year','$month','$day','$time','stockout')");
    if ($stock_ok) {
      echo "<script>window.location.href='view_products.php'</script>";
    }
  }else{
    echo "<script>alert('not')</script>";
      // echo "not".mysqli_error( $connection )."";
  }
}

      }else{
          echo "<script>alert('quantity you are tring to stock out we dont have')</script>";
          echo "<script>window.location.href='view_products.php'</script>";
      }




     





}



?>