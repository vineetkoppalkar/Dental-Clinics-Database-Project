<?php include '../../db_connection.php'; ?>

<?php

  $patientId = $_POST['patientId'];
  $clinicId = $_POST['clinicId']; 
  $date = $_POST['date']; 
  $time = $_POST['time']; 
  $professionalId = $_POST['professionalId']; 
  $treatmentIds = explode(",", $_POST['treatmentIds']);

  $conn = OpenCon();

  $newAppointmentId = null;
  $sql = "INSERT INTO Appointments (date, time) VALUES ('$date', '$time');";
  $result = $conn->query($sql);

  if ($result) {
    $newAppointmentId = $conn->insert_id;
  } 

  if (!is_null($newAppointmentId)) {
    $sql = "INSERT INTO PerformedAt (appointmentId, clinicId) VALUES ($newAppointmentId, $clinicId);";
    $result = $conn->query($sql);

    $sql = "INSERT INTO ReceivedBy (appointmentId, patientId) VALUES ($newAppointmentId, $patientId);";
    $result = $conn->query($sql);

    $sql = "INSERT INTO PerformedBy (appointmentId, professionalId) VALUES ($newAppointmentId, $professionalId);";
    $result = $conn->query($sql);

    foreach ($treatmentIds as $treatmentId) {
      $sql = "INSERT INTO TreatmentPerformed (appointmentId, treatmentId) VALUES ($newAppointmentId, $treatmentId);";
      $result = $conn->query($sql);
    }
  }
  
  CloseCon($conn);
?>