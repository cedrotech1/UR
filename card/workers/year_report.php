<?php
include ('connection.php');
if (isset($_POST['year'])) {
  // echo $date = $_POST['date'];
  echo $report = $_POST['report'];
  $currect = date("d/m/Y");

$year=$_POST['year'];


  $status = '';
  $title = '';
  $total_cost = 0;
  $total_profit = 0;
  $ts=0;
  if ($report == 'stockin') {
    $status = 'stockin';
    $title = 'Garage Report on stock in at year ' . $year;

    $ok = mysqli_query($connection, "SELECT product.pid,product.pname,historic.quantity,historic.price,historic.total,historic.year,historic.month,historic.day,historic.time
        FROM product,historic WHERE product.pid=historic.pid and status='$status'  and year='$year'  order by id desc");
    while ($row = mysqli_fetch_array($ok)) {
      $row["4"];
      $total_cost = $total_cost + $row["4"];
    }

  } elseif ($report == 'stockout') {
    $status = 'stockout';
    $title = 'Garage Report on stock out year ' . $year;

    $ok = mysqli_query($connection, "SELECT product.pid,product.pname,historic.quantity,historic.price,historic.total,historic.year,historic.month,historic.day,historic.time,historic.profit
          FROM product,historic WHERE product.pid=historic.pid and status='$status'  and year='$year'  order by id desc");
    while ($row = mysqli_fetch_array($ok)) {
      $total_cost = $total_cost + $row["4"];
      $total_profit = $total_profit + $row["9"];
    }

  } else {
    $status = 'general';
    $title = 'Garage Report in General at year ' . $year;

    $ok = mysqli_query($connection, "SELECT product.pid,product.pname,historic.quantity,historic.price,historic.total,historic.year,historic.month,historic.day,historic.time,historic.profit
          FROM product,historic WHERE  status='stockin'and product.pid=historic.pid and year='$year'  order by id desc");
    while ($row = mysqli_fetch_array($ok)) {
      $total_cost = $total_cost + $row["4"];
      $total_profit = $total_profit + $row["9"];
    }


    
    $ok = mysqli_query($connection, "SELECT product.pid,product.pname,historic.quantity,historic.price,historic.total,historic.year,historic.month,historic.day,historic.time,historic.profit
          FROM product,historic WHERE  status='stockout'and product.pid=historic.pid and year='$year'  order by id desc");
    while ($row = mysqli_fetch_array($ok)) {
      $ts = $ts + $row["4"];
      $total_profit = $total_profit + $row["9"];
    }
  }

}
if (!isset($_POST['day'])) {
  echo "<script>window.location.href='report.php'</script>";
}
// echo $year . '' . $month . '' . $day;
echo $status;
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>OGB GARAGE-report</title>
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
  <style>
    ul li {
      list-style: none;
    }
  </style>


</head>

<body>

  <?php
  include ("./includes/header.php");
  include ("./includes/menu.php");
  ?>



  <main id="main" class="main">



    <section class="section dashboard" style='margin-top:-2cm'>
      <div class="row">

        <div class="col-lg-12">
          <div class="row">

            <div class="card">
              <div class="card-body"><br>
                <h5 class="card-title">REPORT ON <?php echo $currect; ?></h5><br>
                <ul style='margin-left:-1cm'>
                  <li>Gatsata sector</li>
                  <li>Nyabugogo cell</li>
                  <li>Kigali city</li>
                  <li>tel: 0788308413</li>
                </ul>
                <br>
                <!-- <center> -->
                  <b>
                    <b><h5><?php echo $title; ?></h5></b><br>
                  </b>
                <!-- </center> -->


                <div class="tab-content pt-2" id="myTabjustifiedContent">
                  <div class="tab-pane fade show active" id="home-justified" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                      <div class="col-md-12 table-responsive">
                        <table class="table datatable">
                          <thead>
                            <?php
                            if ($status == 'stockin') {
                              ?>
                              <tr>
                                <th>
                                  <b>N</b>ame
                                </th>
                                <th>quantity.</th>
                                <th>unit cost</th>
                                <th>total cost</th>
                                <!-- <th data-type="date" data-format="YYYY/DD/MM">Start Date</th> -->
                                <th>time</th>


                              </tr>
                              <?php

                            } elseif ($status == 'stockout') {
                              ?>
                              <tr>
                                <th>
                                  <b>N</b>ame
                                </th>
                                <th>quantity.</th>
                                <th>U.cost price</th>
                                <th>U.sell price</th>
                                <th>total seling price</th>
                                <th>profit</th>
                                <!-- <th data-type="date" data-format="YYYY/DD/MM">Start Date</th> -->
                                <th>time</th>


                              </tr>
                              <?php

                            } else {
                              ?>
                              <tr>
                                <th>
                                  <b>N</b>ame
                                </th>
                                <th>quantity.</th>
                                <th>U.cost price</th>
                                <th>U.sell price</th>
                                <!-- <th>cost</th> -->
                                <th>total</th>
                                <th>profit</th>
                              
                                <th>time</th>


                              </tr>
                              <?php

                            }

                            ?>

                          </thead>
                          <tbody>



                            <?php
                            if ($status == 'stockin') {
                              // $status= 'stockin';
                              $ok = mysqli_query($connection, "SELECT product.pid,product.pname,historic.quantity,historic.cost,historic.total,historic.year,historic.month,historic.day,historic.time
                             FROM product,historic WHERE product.pid=historic.pid and status='$status' and year='$year' order by id desc");
                              while ($row = mysqli_fetch_array($ok)) {
                                ?>
                                <tr>
                                  <td><?php echo $row['1'] ?></td>
                                  <td><?php echo $row['2'] ?></td>
                                  <td><?php echo formatMoney($row['3']); ?></td>
                                  <td><?php echo formatMoney($row['4']); ?></td>
                                  <td><?php echo $row['8'] ?></td>
                                  <?php
                              }
                            } if ($status == 'stockout') {
                              // $status= 'stockout';
                              $ok = mysqli_query($connection, "SELECT product.pid,product.pname,historic.quantity,historic.price,historic.total,historic.year,historic.month,historic.day,historic.time,historic.profit,historic.cost
                              FROM product,historic WHERE product.pid=historic.pid and status='$status' and year='$year' order by id desc");
                              while ($row = mysqli_fetch_array($ok)) {
                                ?>
                                <tr>
                                  <td><?php echo $row['1'] ?></td>
                                  <td><?php echo $row['2'] ?></td>
                                  <td><?php echo formatMoney($row['10']); ?></td>
                                  <td><?php echo formatMoney($row['3']); ?></td>
                                  <td><?php echo formatMoney($row['4']); ?></td>
                                  <td><?php echo formatMoney($row['9']); ?></td>  
                                  <td><?php echo $row['8'] ?></td>

                                  </td>



                                </tr>
                                <?php
                              }
                            } if ($status == 'general') {
                              // $status= 'all';
                              $ok = mysqli_query($connection, "SELECT product.pid,product.pname,historic.quantity,historic.price,historic.total,historic.year,historic.month,historic.day,historic.time,historic.status,historic.profit,historic.cost
                               FROM product,historic WHERE product.pid=historic.pid  and year='$year' order by id desc");
                              while ($row = mysqli_fetch_array($ok)) {
                                $status1 = $row['9'];
                                if ($status1 == 'stockin') {
                                  ?>
                                  <tr>
                                    <td><?php echo $row['1'] ?></td>
                                    <td><?php echo $row['2'] ?></td>
                                    <td>-</td>
                                    <td><?php echo formatMoney($row['cost']); ?></td>
                                    <td><?php echo formatMoney($row['4']); ?></td>
                                    <td>-</td>
                                   
                                    <td><?php echo $row['8'] ?></td>

                                    </td>



                                  </tr>
                                  <?php
                                } else {
                                  ?>
                                  <tr>
                                    <td style='background-color:#fef0d5'><?php echo $row['1'] ?></td>
                                    <td style='background-color:#fef0d5'><?php echo $row['2'] ?></td>
                                    <td><?php echo formatMoney($row['cost']); ?></td>
                                    <td style='background-color:#fef0d5'><?php echo formatMoney($row['price']); ?></td>
                                    <!-- <td style='background-color:#fef0d5'>-</td> -->
                                    <td style='background-color:#fef0d5'><?php echo formatMoney($row['4']);?></td>
                                    <td style='background-color:#bcffd5'><?php echo formatMoney($row['10']); ?></td>
                                    <!-- <td style='background-color:#fef0d5'> -->
                                    
                                    <td style='background-color:#fef0d5'><?php echo $row['8'] ?></td>

                                    </td>



                                  </tr>
                                  <?php
                                }
                              }
                            }else{
                              // echo'system has same issues';
                            }





                            ?>
                          </tbody>
                        </table>
                        <br>

                        <?php
                        if ($status == 'stockin') {
                          ?>
                                <ul style='margin-left:-1cm'>
                                  <li>total cost : <b> <?php echo  formatMoney($total_cost); ?></b></li>
                               </ul>

                          <?php

                        } elseif ($status == 'stockout') {
                          ?>
                                 <ul style='margin-left:-1cm'>
                                  <li>total selling : <b> <?php echo formatMoney($total_cost); ?></b></li>
                                  <li>total cost :<b> <?php echo formatMoney($total_cost-$total_profit);?></b></li>
                                  <li>total profit:<b> <?php echo formatMoney($total_profit); ?></b></li>

                                </ul>

                          <?php

                        } else {
                          ?>
                                 <ul style='margin-left:-1cm'>
                                 <li>total selling : <b> <?php echo formatMoney($ts); ?></b></li>
                               <li>total cost :<b> <?php echo formatMoney($total_cost);?></b></li>
                               <li>total profit:<b> <?php echo formatMoney($total_profit); ?></b></li>

                              </ul>

                          <?php

                        }

                        ?>






                   
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="profile-justified" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="row">
                      <div class="col-md-6">
                        <form class="mt-3" action="/submit_weekly_report" method="POST">
                          <div class="mb-3">
                            <label for="from" class="form-label">From:</label>
                            <input type="date" class="form-control" id="from" name="from_date">
                          </div>
                          <div class="mb-3">
                            <label for="to" class="form-label">To:</label>
                            <input type="date" class="form-control" id="to" name="to_date">
                          </div>
                          <div class="col-sm-12">
                            <select class="form-select" name="action">
                              <option value="1">stock in</option>
                              <option value="2">stock out</option>
                            </select>
                          </div>
                          <br>
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                      </div>
                    </div>
                  </div>

                </div><!-- End Default Tabs -->
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