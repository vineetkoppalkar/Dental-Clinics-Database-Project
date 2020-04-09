
<div class="row">
    <h3 class="col-sm-10">Patients</h3>
    <a class="btn btn-primary col-sm-2" href="createPatient.php">New Patient</a>
</div>
<div class="row">
  
  <?php
  $conn = OpenCon();

  $sql = "SELECT * FROM Patients";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while ($patient = $result->fetch_assoc()) {
      echo
        '<div class="col-sm-4 my-3">' .
          '<div class="card h-100">' .
            '<div class="card-body">' .
              '<a href="updatePatient.php?patientId='.$patient['patientId'] .'&patientName='. $patient['name'] .'&address='. $patient['address'] .'&phoneNumber='.$patient['phoneNumber'].'" class="col-sm-40 float-right btn btn-outline-warning">Update</a>' .
              '<h5 class="card-title">' . $patient['name'] . '</h5>' .
              '<p class="card-text">' . $patient['address'] . '<br />' . $patient['phoneNumber']  . '</p>' .
              '<a href="patient.php?patientId=' . $patient['patientId'] . '&patientName=' . $patient['name'] . '"'.
              'class="btn btn-outline-primary align-items-end">View Appointments</a>' .
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
