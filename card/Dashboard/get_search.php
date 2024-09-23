<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the connection to the database
include('connection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>UR-HUYE - Search Results</title>
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
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <style>
    ul {
      list-style-type: none;
      padding-left: 0;
    }

    li {
      margin-bottom: 1px;
      font-weight: bold;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
  </style>

</head>

<body style="background-color:white">
  <?php
  include("./includes/header.php");
  include("./includes/menu.php");
  ?>

  <main id="main" class="main">
    
    <section class="section dashboard" style="background-color:white">
      <div class="row">



        <!-- Left side columns -->
        <div class="col-lg-12" id="studentCards">
          <div class="row">

            <div class="col-lg-12">
              <div class="row">
                <?php
                // Initialize variables
                $attribute = isset($_POST['attribute']) ? $_POST['attribute'] : null;
                $value = isset($_POST['value']) ? $_POST['value'] : null;

                // Validate attribute
                $valid_attributes = ['campus', 'college', 'school', 'program'];
                if ($attribute && in_array($attribute, $valid_attributes) && $value) {
                  // Use prepared statements to prevent SQL injection
                  $stmt = $connection->prepare("SELECT * FROM info WHERE `$attribute` = ? ORDER BY id DESC");
                  if ($stmt) {
                    $stmt->bind_param("s", $value);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Check if there are any records
                    if ($result->num_rows > 0) {
                      // Loop through each record
                      while ($row = $result->fetch_assoc()) {
                        // Output HTML card for each record
                        ?>

                        <div class="col-xxl-4 col-md-6">
                          <div class="card info-card"
                            style="background: url('./2.png') no-repeat center center/cover; background-size: cover; position: relative;border:1px solid gray">
                            <div class="card-body">
                              <div class="ps-1" style="color:black">
                                <div class="row">
                                  <div class="col-6"> 
                                    <img src="./logo.png" alt="Logo"
                                      style="height:auto;width:100%;margin-left:-0.7cm">
                                  </div>
                                  <div class="col-6">
                                    <h6
                                      style="padding-top:0.6cm;text-transform:uppercase;text-align:right;font-size:28px;color:black">
                                      <b>
                                        <?php echo htmlspecialchars($row['campus']); ?> Campus
                                    </h6>
                                    </b>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-12">
                                    <h3 style="text-align:center;text-transform:uppercase;font-weight:bold">
                                      <b>College of Business and Economics</b>
                                    </h3>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-8">
                                    <h5 style="text-align:right;padding-bottom:0.2cm"><b><u>STUDENT ID CARD</u></b></h5>
                                    <ul style="text-transform: uppercase;font-size:14px">
                                      <li><b>Names: <?php echo htmlspecialchars($row['names']); ?></b></li>
                                      <li><b>School: <?php echo htmlspecialchars($row['school']); ?></b></li>
                                      <li><b>Program: <?php echo htmlspecialchars($row['program']); ?></b></li>
                                      <li><b>Year of Study: <?php echo htmlspecialchars($row['yearofstudy']); ?></b></li>
                                    </ul>

                                    <p style="text-align:left;padding-top:0cm;font-size:16px">
                                      <b><i>Expiry Date: <?php echo htmlspecialchars($row['expireddate']); ?></i></b>
                                    </p>
                                  </div>
                                  <div class="col-4">
                                    <?php
                                    if (!empty($row['picture'])) {
                                      ?>
                                      <img src="../Students/<?php echo htmlspecialchars($row['picture']); ?>" alt="Student Picture"
                                        style="height:3cm;width:2.8cm;margin-top:0.3cm">
                                      <p style="margin-top:0cm">
                                        <b><i>Reg: <?php echo htmlspecialchars($row['regnumber']); ?></i></b>
                                      </p>
                                      <?php
                                    } else {
                                      ?>
                                      <div alt="No Image" style="height:3cm;width:2.8cm;margin-top:0.3cm;border:1px solid black"></div>
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
                      echo '<div class="col-12"><p>No records found for the selected criteria.</p></div>';
                    }

                    $stmt->close();
                  } else {
                    // If statement preparation failed
                    echo '<div class="col-12"><p>Failed to prepare the SQL statement.</p></div>';
                  }
                } else {
                  // If form data is missing or invalid, redirect back or show a message
                  echo '<div class="col-12"><p>Invalid search criteria. Please go back and try again.</p></div>';
                  echo"<script>window.location.href='./get_card_by.php'</script>";
                }
                ?>
              </div>
            </div>

          </div><!-- End Records Card -->
          <button class="download-btn btn btn-outline-primary" onclick="downloadPDF()">Download PDF</button>

        </div>
      </div><!-- End Left side columns -->
    </section>
  </main><!-- End #main -->

  <!-- Add jsPDF -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

  <!-- Add html2canvas -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

  <script>
    function downloadPDF() {
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();

      const studentCards = document.querySelectorAll('.info-card'); // Select all student cards
      const cardsPerPage = 6; // 6 cards per page
      let x = 10; // Initial X position (for card placement)
      let y = 10; // Initial Y position (for card placement)
      const cardWidth = 90; // Approximate width of each card in mm
      const cardHeight = 60; // Approximate height of each card in mm

      // Iterate over each student card and capture it
      Array.from(studentCards).forEach((card, index) => {
        html2canvas(card).then(canvas => {
          const imgData = canvas.toDataURL('image/jpeg', 1.0);

          // Add image of the card to the PDF at the current X, Y position
          doc.addImage(imgData, 'JPEG', x, y, cardWidth, cardHeight);

          // Adjust the position for the next card
          if ((index + 1) % 2 === 0) { // After two cards, move to the next row
            x = 10; // Reset X position to the left margin
            y += cardHeight + 10; // Move down for the next row
          } else {
            x += cardWidth + 10; // Move to the right for the second card in the row
          }

          // If 6 cards have been placed on the page, add a new page
          if ((index + 1) % cardsPerPage === 0) {
            doc.addPage();
            x = 10; // Reset X position for new page
            y = 10; // Reset Y position for new page
          }

          // When all cards are processed, save the PDF
          if (index === studentCards.length - 1) {
            doc.save('student-cards.pdf');
          }
        }).catch(error => {
          console.error('Error capturing card:', error);
        });
      });
    }
  </script>

  <!-- ======= Footer ======= -->
  <?php
  include("./includes/footer.php");
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
