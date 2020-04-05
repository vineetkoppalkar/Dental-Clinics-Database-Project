<div class="row">

  <?php
  $conn = OpenCon();

  $sql = "SELECT * FROM Patients";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while ($patient = $result->fetch_assoc()) {
      echo
        '<div class="col-sm-4 my-3">' .
          '<div class="card">' .
            '<div class="card-body">' .
              '<a href="/templates/patients/updatePatient.php?patientId='.$patient['patientId'] .'&patientName='. $patient['name'] .'&address='. $patient['address'] .'&phoneNumber='.$patient['phoneNumber'].'" class="col-sm-40 float-right btn btn-outline-warning">Update</a>' .
              '<button onclick="handleOnPatientDelete('. $patient['patientId'] .')" class="col-sm-40 float-right btn btn-outline-danger">Delete</button>' .
              '<h5 class="card-title">' . $patient['name'] . '</h5>' .
              '<p class="card-text">' . $patient['address'] . '<br />' . $patient['phoneNumber']  . '</p>' .
              '<a href="/templates/patients/patient.php?patientId=' . $patient['patientId'] . '&patientName=' . $patient['name'] . '"'.
              'class="btn btn-outline-primary">View Appointments</a>' .
            '</div>' .
          '</div>' .
        '</div>';
    }
  } else {
    echo "0 patients found";
  }

  CloseCon($conn);
  ?>
  <div class="col-sm-4 my-3">
    <a class="btn btn-primary" href="/templates/patients/createPatient.php">New Patient</a>
  </div>

  <script>
    function handleOnPatientDelete(patientId) {
      console.log(patientId);
      const formData = new FormData();
      formData.append("patientId", patientId);

      fetch('../../database/patients/deletePatient.php', {
        method: 'POST',
        body: formData
      }).then(response => {
        console.log(response.json());
        window.location.href = "/templates/patients/patients.php"; 
      }).catch(error => {
        console.log("Fetch error while deleting patient");
        console.log(error);
      });
    }
  </script>
</div>
