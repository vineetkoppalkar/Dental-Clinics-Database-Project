<?php include '../../db_connection.php'; ?>

<?php
  $appointmentId = $_POST['appointmentId'];
  $clinicId = $_POST['clinicId']; 
  $date = $_POST['date']; 
  $time = $_POST['time']; 
  $professionalId = $_POST['professionalId']; 
  $treatmentIds = explode(",", $_POST['treatmentIds']);

  $conn = OpenCon();

  $sql = "UPDATE Appointments SET date = $date, time = $time WHERE appointmentId = $appointmentId;";
  $result = $conn->query($sql);

  $sql = "UPDATE PerformedAt SET clinicId = $clinicId WHERE appointmentId = $appointmentId;";
  $result = $conn->query($sql);

  $sql = "UPDATE PerformedBy set professionalId = $professionalId WHERE appointmentId = $appointmentId;";
  $result = $conn->query($sql);

  $sql = "DELETE FROM TreatmentPerformed WHERE appointmentId = $appointmentId;";
  $result = $conn->query($sql);

  foreach ($treatmentIds as $treatmentId) {
    $sql = "INSERT INTO TreatmentPerformed (appointmentId, treatmentId) VALUES ($appointmentId, $treatmentId);";
    $result = $conn->query($sql);
  }
  
  CloseCon($conn);
?>