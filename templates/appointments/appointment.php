<?php session_start(); ?>
<?php include '../../db_connection.php'; ?>
<!doctype html>
<html lang="en">

<head></head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<!-- Custom CSS -->

<title>Appointment</title>
</head>

<body>
  <div class="container">
    <?php include '../header.php'; ?>
    <h4>Appointment</h4>
    <div class="row">
      <?php include '../../database/appointments/getAppointmentClinicInfo.php'; ?>
      <?php include '../../database/appointments/getAppointmentPatientInfo.php'; ?>
      <?php include '../../database/appointments/getAppointmentProfessionalInfo.php'; ?>
    </div>
    <div class="row">
      <div class="col-sm-10">
        <?php include '../../database/appointments/getTreatmentsPerformed.php'; ?>
      </div>
        <?php include '../../database/appointments/getMissedPaid.php'; ?>
      <div class="col-sm-2">
      </div>
    </div>
    <?php include '../footer.php' ?>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </div>
</body>

</html>