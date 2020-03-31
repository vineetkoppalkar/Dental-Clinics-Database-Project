<?php include '../../db_connection.php'; ?>

<?php

  $patientId = $_POST['patientId'];
  $clinicId = $_POST['clinicId']; 
  $date = $_POST['date']; 
  $time = $_POST['time']; 
  $professionalId = $_POST['professionalId']; 
  $treatmentIds = explode(",", $_POST['treatmentIds']);

  // $log = $_POST['date'] . ' | ' . $_POST['time'];
  // file_put_contents('your_log_file.txt', PHP_EOL . $log );

  // $log = $_POST['patientId'] . ' | ' .
  //       $_POST['clinicId'] . ' | ' . 
  //       (string) $_POST['date'] . ' | ' . 
  //       $_POST['time'] . ' | ' . 
  //       $_POST['professionalId'] . ' | ' . 
  //       $_POST['treatmentIds'];
  // file_put_contents('your_log_file.txt', PHP_EOL . $log );
  
  // file_put_contents('your_log_file.txt', PHP_EOL . $sql );

  $conn = OpenCon();

  $newAppointmentId = null;
  $sql = "INSERT INTO Appointments (date, time) VALUES ('$date', '$time');";
  //file_put_contents('your_log_file.txt', PHP_EOL . $sql, FILE_APPEND);
  $result = $conn->query($sql);

  if ($result) {
    $newAppointmentId = $conn->insert_id;
    //file_put_contents('your_log_file.txt', PHP_EOL . "Successfully inserted appointment", FILE_APPEND);
    //file_put_contents('your_log_file.txt', PHP_EOL . $newAppointmentId . '', FILE_APPEND);
  } else {
    //file_put_contents('your_log_file.txt', PHP_EOL . "Failed to insert appointment", FILE_APPEND);
  }

  if (!is_null($newAppointmentId)) {
    $sql = "INSERT INTO PerformedAt (appointmentId, clinicId) VALUES ($newAppointmentId, $clinicId);";
    //file_put_contents('your_log_file.txt', PHP_EOL . $sql, FILE_APPEND);
    $result = $conn->query($sql);
    
    // if ($result) {
    //   //file_put_contents('your_log_file.txt', PHP_EOL . "Successfully inserted into performedAt", FILE_APPEND);
    // } else {
    //   //file_put_contents('your_log_file.txt', PHP_EOL . "Failed insert into performedAt", FILE_APPEND);
    // }

    $sql = "INSERT INTO ReceivedBy (appointmentId, patientId) VALUES ($newAppointmentId, $patientId);";
    //file_put_contents('your_log_file.txt', PHP_EOL . $sql, FILE_APPEND);
    $result = $conn->query($sql);
    
    // if ($result) {
    //   //file_put_contents('your_log_file.txt', PHP_EOL . "Successfully inserted into receivedBy", FILE_APPEND);
    // } else {
    //   //file_put_contents('your_log_file.txt', PHP_EOL . "Failed insert into receivedBy", FILE_APPEND);
    // }

    $sql = "INSERT INTO PerformedBy (appointmentId, professionalId) VALUES ($newAppointmentId, $professionalId);";
    // file_put_contents('your_log_file.txt', PHP_EOL . $sql, FILE_APPEND);
    $result = $conn->query($sql);
    
    // if ($result) {
    //   file_put_contents('your_log_file.txt', PHP_EOL . "Successfully inserted into PerformedBy", FILE_APPEND);
    // } else {
    //   file_put_contents('your_log_file.txt', PHP_EOL . "Failed insert into PerformedBy", FILE_APPEND);
    // }

    foreach ($treatmentIds as $treatmentId) {
      $sql = "INSERT INTO TreatmentPerformed (appointmentId, treatmentId) VALUES ($newAppointmentId, $treatmentId);";
      // file_put_contents('your_log_file.txt', PHP_EOL . $sql, FILE_APPEND);
      $result = $conn->query($sql);

      // if ($result) {
      //   file_put_contents('your_log_file.txt', PHP_EOL . "Successfully inserted into TreatmentPerformed", FILE_APPEND);
      // } else {
      //   file_put_contents('your_log_file.txt', PHP_EOL . "Failed insert into TreatmentPerformed", FILE_APPEND);
      // }
    }


  }


  CloseCon($conn);




  // $log = '';

  // if ($result->num_rows > 0) {
  //   while ($row = $result->fetch_assoc()) {
  //     $log = $log . ' | ' .  $row['name'];
  //   }
  // } else {
  //   $log = "No clinics found";
  // }

  // file_put_contents('your_log_file.txt', PHP_EOL . $log);


  // $log = $_POST['patientId'] . ' | ' .
  //       $_POST['clinicId'] . ' | ' . 
  //       $_POST['date'] . ' | ' . 
  //       $_POST['time'] . ' | ' . 
  //       $_POST['professionalId'] . ' | ' . 
  //       $_POST['treatmentIds'];


  // file_put_contents('your_log_file.txt', PHP_EOL . $log );
  // return "Test response";

?>