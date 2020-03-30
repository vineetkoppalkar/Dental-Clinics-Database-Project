<div class="row">
  <?php
  $conn = OpenCon();

  $sql = "SELECT * FROM Patients";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while ($patient = $result->fetch_assoc()) {
      echo '<div class="col-sm-4 my-3">' .
        '<div class="card">' .
        '<div class="card-body">' .
        '<a class="col-sm-20 float-right btn btn-outline-secondary">Update</a>' .
        '<a class="col-sm-20 float-right btn btn-outline-secondary">Delete</a>' .
        '<h5 class="card-title">' . $patient['name'] . '</h5>' .
        '<p class="card-text">' . $patient['address'] . '<br />' . $patient['phoneNumber']  . '</p>' .
        '<a href="/templates/patients/patient.php?patientId=' . $patient['patientId'] . '&patientName=' . $patient['name'] . '"'.
        '<a class="btn btn-outline-primary">View Appointments</a>' .
        '</div>' .
        '</div>' .
        '</div>';
    }
  } else {
    echo "0 patients found";
  }

  CloseCon($conn);
  ?>

</div>