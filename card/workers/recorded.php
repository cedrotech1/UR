<?php
include ('connection.php');
checkPrivilege('Stock Recorded');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>OGB GARAGE- recorded</title>
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
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">



</head>

<body>

  <?php
  include ("./includes/header.php");
  include ("./includes/menu.php");
  ?>



  <main id="main" class="main">



    <section class="section dashboard">
      <div class="row">
        <!-- <div class="col-lg-1"></div> -->
        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">DIFFERENT REPORT</h5>

                <!-- Default Tabs -->
                <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
                  <li class="nav-item flex-fill" role="presentation">
                    <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab"
                      data-bs-target="#home-justified" type="button" role="tab" aria-controls="home"
                      aria-selected="true">stockin recorded</button>
                  </li>
                  <li class="nav-item flex-fill" role="presentation">
                    <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab"
                      data-bs-target="#profile-justified" type="button" role="tab" aria-controls="profile"
                      aria-selected="false">stockout recorded</button>
                  </li>

                </ul>
                <div class="tab-content pt-2" id="myTabjustifiedContent">
                  <div class="tab-pane fade show active" id="home-justified" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                      <div class="col-md-12 table-responsive">
                        <table class="table datatable">
                          <thead>
                            <tr>
                              <th>
                                <b>N</b>ame
                              </th>
                              <th>quantity.</th>
                              <th>unit cost</th>
                              <th>total cost</th>
                              <th data-type="date" data-format="YYYY/DD/MM">Start Date</th>
                              <th>time</th>
                              <th>modify</th>

                            </tr>
                          </thead>
                          <tbody>



                            <?php
                            $ok = mysqli_query($connection, "SELECT product.pid,product.pname,historic.quantity,historic.cost,historic.total,historic.year,historic.month,historic.day,historic.time,historic.id
                            FROM product,historic WHERE product.pid=historic.pid  and status='stockin' order by id desc");
                            while ($row = mysqli_fetch_array($ok)) {
                              ?>
                              <tr>

                                <td><?php echo $row['1'] ?></td>
                                <td><?php echo $row['2'] ?></td>
                                <td><?php echo formatMoney($row['3']); ?></td>
                                <td><?php echo formatMoney($row['4']); ?></td>
                                <td><?php echo $row['5'] ?>/<?php echo $row['6'] ?>/<?php echo $row['7'] ?></td>
                                <td><?php echo $row['8'] ?></td>
                                <td>

                                  <div class="row">
                                    <div class="col-3">
                                      <a href="#"
                                        onclick="confirmDelete(<?php echo $row['9']; ?>, '<?php echo $row['pname']; ?>')">
                                        <button class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                          title="Delete">
                                          <i class="fas fa-trash text-danger"></i>
                                        </button>
                                      </a>

                                      <script>
                                        function confirmDelete(hid, pname) {
                                          if (confirm('Are you sure you want to delete the this record on product ' + pname + '?')) {
                                            window.location.href = 'stockin-delete.php?hid=' + hid;
                                          } else {
                                            // Do nothing or handle cancellation
                                          }
                                        }
                                      </script>

                                    </div>

                                  </div>

                                </td>



                              </tr>
                              <?php
                            }

                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="profile-justified" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="row">
                      <div class="col-md-12 table-responsive">
                        <table class="table datatable">
                          <thead>
                            <tr>
                              <th>
                                <b>N</b>ame
                              </th>
                              <th>quantity.</th>
                              <th>unit cost</th>
                              <th>total sold</th>
                              <th>profit</th>
                              <th data-type="date" data-format="YYYY/DD/MM">Start Date</th>
                              <th>time</th>
                              <th>modify</th>

                            </tr>
                          </thead>
                          <tbody>



                            <?php
                            $ok = mysqli_query($connection, "SELECT product.pid,product.pname,historic.quantity,historic.cost,historic.total,historic.year,historic.month,historic.day,historic.time,historic.id,historic.profit
                            FROM product,historic WHERE product.pid=historic.pid  and status='stockout' order by id desc");
                            while ($row = mysqli_fetch_array($ok)) {
                              ?>
                              <tr>

                                <td><?php echo $row['1'] ?></td>
                                <td><?php echo $row['2'] ?></td>
                                <td><?php echo formatMoney($row['3']); ?></td>
                                <td><?php echo formatMoney($row['4']); ?></td>
                                <td><?php echo formatMoney($row['10']); ?></td>
                                <td><?php echo $row['5'] ?>/<?php echo $row['6'] ?>/<?php echo $row['7'] ?></td>
                                <td><?php echo $row['8'] ?></td>
                                <td>

                                  <div class="row">
                                    <div class="col-3">
                                      <a href="stockout-delete.php?hid=<?php echo $row['9']; ?>">

                                        <button class="btn" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                          title="Delete">
                                          <i class="fas fa-trash text-danger"></i>
                                        </button>
                                      </a>



                                    </div>

                                  </div>

                                </td>



                              </tr>
                              <?php
                            }

                            ?>
                          </tbody>
                        </table>
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