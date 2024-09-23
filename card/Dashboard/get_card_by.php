<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the connection to the database
include('connection.php');

// Define a function to fetch distinct values based on the report type
function fetchReportData($connection, $reportType) {
    $results = [];

    // Construct the query based on the selected report type
    if ($reportType == 'campus') {
        $query = "SELECT DISTINCT campus FROM info";
    } elseif ($reportType == 'college') {
        $query = "SELECT DISTINCT college FROM info";
    } elseif ($reportType == 'school') {
        $query = "SELECT DISTINCT school FROM info";
    } elseif ($reportType == 'program') {
        $query = "SELECT DISTINCT program FROM info";
    } else {
        return ["error" => "Invalid report type"];
    }

    // Debug: Output the query for testing
    // echo $query;

    // Execute the query
    $result = mysqli_query($connection, $query);

    if (!$result) {
        // If there's an SQL error, return the error message
        return ["error" => mysqli_error($connection)];
    }

    // Fetch the results and store them in the array
    while ($row = mysqli_fetch_assoc($result)) {
        $results[] = $row[$reportType];
    }

    return $results;
}

// Check if an AJAX request was made to fetch data based on the selected report
if (isset($_POST['reportType'])) {
    $reportType = $_POST['reportType'];

    // Call the function to get the report data
    $results = fetchReportData($connection, $reportType);

    // Return the results as a JSON response and terminate the script
    echo json_encode($results);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>UR-HUYE-CARDS</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="./icon1.png" rel="icon">
  <link href="./icon1.png" rel="apple-touch-icon">

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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

  <!-- Add jQuery for dynamic dropdown -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    $(document).ready(function () {
      // When the "attribute" dropdown changes
      $('select[name="attribute"]').on('change', function () {
        var selectedReport = $(this).val();
        
        // Debug: Output the selected report type
        console.log("Selected report type: " + selectedReport);
        
        // Make AJAX call to the same PHP page to fetch the relevant data from the database
        $.ajax({
          url: '<?php echo $_SERVER['PHP_SELF']; ?>', // Explicitly posting to the same file
          type: 'POST',
          data: { reportType: selectedReport }, // Send the selected report type
          success: function (response) {
            console.log("Response: " + response); // Debug: Output the response

            // Parse the JSON response
            try {
              var data = JSON.parse(response);

              // Debug: Check if there's an error
              if (data.error) {
                alert("Error: " + data.error);
                return;
              }

              // Empty the "value" dropdown
              $('select[name="value"]').empty();

              // Populate "value" dropdown with new options
              $.each(data, function (key, value) {
                $('select[name="value"]').append('<option value="' + value + '">' + value + '</option>');
              });
            } catch (e) {
              alert("Failed to parse response: " + e.message);
            }
          },
          error: function (xhr, status, error) {
            // Handle AJAX errors
            console.error("AJAX Error: " + status + " - " + error);
          }
        });
      });

      // Trigger the change event to load initial values if needed
      $('select[name="attribute"]').trigger('change');
    });
  </script>

</head>

<body>

  <?php
  include("./includes/header.php");
  include("./includes/menu.php");
  ?>
  <main id="main" class="main">
    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
          <div class="row">
            <div class="card">
              <form class="mt-3" action="get_search.php" method="POST">
                <div class="mb-3">
                  <label for="attribute" class="form-label">GET CARDS BY</label>
                  <select class="form-select" name="attribute">
                    <option value="campus">Campus</option>
                    <option value="college">College</option>
                    <option value="school">School</option>
                    <option value="program">Program</option>
                  </select>
                </div>
                <div class="col-sm-12">
                  <label for="value" class="form-label">Select Type</label>
                  <select class="form-select" name="value">
                    <!-- Options will be populated dynamically by JavaScript -->
                  </select>
                </div>
                <br> 

                <div class="row">
                  <div class="col-6">
                    <button type="submit" name='day' class="btn btn-outline-primary my-3 btn-md col-12">Get card</button>
                  </div>

                  <div class="col-6">
                    <button type="reset" name='day' class="btn btn-outline-primary my-3 btn-md col-12">Reset</button>
                  </div>
                </div>

                <br>
              </form>
            </div>
          </div>
        </div><!-- End Left side columns -->
      </div>
    </section>
  </main><!-- End #main -->
  <?php
  include("./includes/footer.php");
  ?>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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
