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

<title>clinics</title>
</head>

<body class="clinic">
  <div class="container">
    <?php include '../header.php'; ?>
    <h1>Clinic</h1>

    <form method="get" class="form-inline" action="<?php echo '/templates/clinics/clinic.php?clinicId=' . htmlspecialchars($_GET['clinicId']); ?>">
      <label for="date">Date:</label>
      <input type="text" id="date" name="date" value="<?php echo date('Y-m-d'); ?>">
      <input type="submit" value="Submit">
    </form>

    <?php include '../../database/clinics/singleClinic.php'; ?>
    <?php include '../footer.php' ?>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </div>
</body>

</html>