<?php
// Include database connection file
include("connection.php");

// Start the session
session_start();

// Check if the token is provided
if (isset($_GET['token'])) {
  $encodedToken = $_GET['token'];
  $decodedToken = base64_decode($encodedToken);

  // Check if the decoded token contains the delimiter
  if (strpos($decodedToken, '|') !== false) {
    list($token, $regnumber) = explode('|', $decodedToken);

    // Fetch token from database based on encoded token and registration number
    $sql = "SELECT email FROM info WHERE token='$encodedToken' AND regnumber='$regnumber'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);

    // Validate the token
    if ($row) {
      // Store the registration number in the session
      $_SESSION['regnumber'] = $regnumber;
    } else {
      echo "Invalid token or registration number.";
      echo "<script>window.location.href='../tokenrequest.php'</script>";
    }
  } else {
    echo "Invalid token format.";
    echo "<script>window.location.href='../tokenrequest.php'</script>";
  }
} else {
  echo "Token not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>UR-HUYE</title>
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

  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" />
</head>

<body>

  <?php
  include("./includes/studentHeader.php");
  include("./includes/studentMenu.php");
  ?>

  <main id="main" class="main">
    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <?php
            $id = $regnumber;

            // Initialize the query string
            $query = "SELECT * FROM info";

            // Append WHERE clause if ID is provided
            if ($id !== null) {
              $query .= " WHERE regnumber = '$id'";
            }

            $result = mysqli_query($connection, $query);

            // Check if there are any records
            if (mysqli_num_rows($result) > 0) {
              // Loop through each record
              while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="col-xxl-4 col-md-6">
                  <div class="card info-card"
                    style="background: url('./2.png') no-repeat center center/cover; background-size: cover; position: relative;border:1px solid gray">
                    <div class="card-body">
                      <div class="ps-1" style="color:black">
                        <div class="row">
                          <div class="col-6">
                            <img src="./logo.png" alt="" style="height:auto;width:100%;margin-left:-0.7cm">
                          </div>
                          <div class="col-6">
                            <h6
                              style="padding-Top:0.6cm;text-transform:uppercase;text-align:right;font-size:28px;color:black">
                              <b><?php echo htmlspecialchars($row['campus']); ?> Campus</b>
                            </h6>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <h3 style="text-align:center;text-transform:uppercase;text-style:bold">
                              <b>College of Business and Economics</b>
                            </h3>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-8">
                            <h5 style="text-align:right;padding-bottom:0.2cm">
                              <b><u>STUDENT ID CARD</u></b>
                            </h5>
                            <ul style="text-transform: uppercase;font-size:14px;list-style:none;margin-left:-0,5cm">
                              <li><b>Names: <?php echo htmlspecialchars($row['names']); ?></b></li>
                              <li><b>School: <?php echo htmlspecialchars($row['school']); ?></b></li>
                              <li><b>Program: <?php echo htmlspecialchars($row['program']); ?></b></li>
                              <li><b>Year of Study: <?php echo htmlspecialchars($row['yearofstudy']); ?></b></li>
                            </ul>
                            <p style="text-align:left;padding-top:0cm;font-size:16px">
                              <b><i> Expiry Date: <?php echo htmlspecialchars($row['expireddate']); ?></i></b>
                            </p>
                          </div>
                          <div class="col-4">
                            <?php
                            if (!$row['picture'] == null) {
                              ?>
                              <img src="../Students/<?php echo $row['picture']; ?>" alt=""
                                style="height:3cm;width:2.7cm;margin-top:0.3cm">
                              <p style="margin-top:0cm">
                                <b><i>Reg: <?php echo htmlspecialchars($row['regnumber']); ?></i></b>
                              </p>

                              <?php

                            } else {
                              ?>
                              <div alt="" style="height:3cm;width:3cm;margin-top:0.3cm;border:1px solid black"></div>
                              <p style="margin-top:0cm">
                                <b><i>Reg: <?php echo htmlspecialchars($row['regnumber']); ?></i></b>
                              </p>


                              <?php
                            }

                            ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div><!-- End Info Card -->
                <?php
              }
            } else {
              // If no records found
              echo '<p>No record found</p>';
            }
            ?>



            <div class="col-lg-6">
              <div class="row">
                <div class="card">
                  <div class="card-body">
                    <br>
                    <h5 class="card-title">UPLOAD CARD IMAGE</h5>
                    <div class="row">
  <div class="col-2">
    <i class="bi bi-exclamation-triangle-fill" style="font-size: 1.5cm; color: red;"></i>
  </div>
  <div class="col-10">
    <p style="padding:0px; color:red;"> 
      Make sure your picture is a passport picture with a white background, otherwise your card will be moved to the recycle bin.
    </p>
    <br>
  </div>
</div>

                 
                    

                    <!-- Floating Labels Form -->
                    <form class="row g-3" action='' method="post" enctype="multipart/form-data">
                      <div class="panel panel-default">
                        <div class="panel-heading">Select passport image (Max: 1 MB)</div>
                        <div class="panel-body text-center">
                          <input type="hidden" name="regnumber" value="<?php echo htmlspecialchars($regnumber); ?>">
                          <label for="upload_image" class="btn btn-primary">Choose Image</label>
                          <input type="file" name="upload_image" id="upload_image" accept="image/*"
                            style="display: none;" />
                          <div class="mt-2" id="file_info"></div>
                          <br />
                        </div>
                      </div>

                      <div class="text-center">
                        <button type="submit" name="saveproduct" class="btn btn-primary">Save</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                      </div>
                    </form><!-- End floating Labels Form -->

                  </div>
                </div>
              </div>
            </div><!-- End Left side columns -->
          </div>
        </div>



        <div id="uploadimageModal" class="modal" role="dialog" tabindex="-1">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Upload & Crop Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-8 text-center">
                    <div id="image_demo" style="width: 100%; max-width: 350px; margin: auto;"></div>
                    <img id="cropped_image" style="display: none; width: 200px; height: 200px;" />
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary crop_image">Crop & Upload Image</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main><!-- End #main -->

  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; <strong><span>UR-HUYE</span></strong>
    </div>
  </footer><!-- End Footer -->

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <script>
    $(document).ready(function () {
      var $uploadCrop;

      $('#upload_image').on('change', function () {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#uploadimageModal').modal('show');
          $('#image_demo').croppie({
            enableExif: true,
            viewport: {
              width: 200,
              height: 200,
              type: 'square' //circle
            },
            boundary: {
              width: 300,
              height: 300
            }
          });
          $('#image_demo').croppie('bind', {
            url: e.target.result
          });
        }
        reader.readAsDataURL(this.files[0]);
      });

      $('.crop_image').click(function (event) {
        $('#image_demo').croppie('result', {
          type: 'canvas',
          size: 'viewport'
        }).then(function (response) {
          $('#cropped_image').attr('src', response);
          $('#uploadimageModal').modal('hide');
          $('#file_info').html('<img src="' + response + '" style="width: 200px; height: 200px;"/>');

          // Send the cropped image to the server
          $.ajax({
            url: 'imageupload.php', // Update this to your PHP upload script
            type: 'POST',
            data: {
              "image": response,
              "regnumber": '<?php echo htmlspecialchars($regnumber); ?>' // Send regnumber too
            },
            success: function (data) {
              // alert(data); 
            }
          });
        });
      });

    });
  </script>
</body>

</html>

<?php

include("connection.php");

if (isset($_POST['image']) && isset($_POST['regnumber'])) {
  $image = $_POST['image'];
  $regnumber = $_POST['regnumber'];

  // Decode the image data
  list($type, $image) = explode(';', $image);
  list(, $image) = explode(',', $image);
  $image = base64_decode($image);

  // Define the path where you want to save the image
  $timestamp = time(); // Get the current timestamp
  $target = "uploads/cropped_image_" . $regnumber . "_" . $timestamp . ".png"; // Include timestamp in the filename


  // Save the image
  if (file_put_contents($target, $image)) {
    // Update the database with the path of the uploaded image
    $sql = "UPDATE info SET picture='$target' WHERE regnumber='$regnumber'";
    if (mysqli_query($connection, $sql)) {
      echo "Cropped image uploaded successfully!";
      echo "<script> alert('image uploaded successfully')</script>";
    } else {
      echo "Error updating image: " . mysqli_error($connection);
    }
  } else {
    echo "Failed to upload image.";
  }
} else {
  // echo "No image or registration number provided.";
}
?>