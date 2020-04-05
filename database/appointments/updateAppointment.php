<?php include '../../db_connection.php'; ?>

<?php
  $appointmentId = $_POST['appointmentId'];
  $clinicId = $_POST['clinicId']; 
  $date = $_POST['date']; 
  $time = $_POST['time']; 
  $professionalId = $_POST['professionalId']; 
  $treatmentIds = explode(",", $_POST['treatmentIds']);

  $conn = OpenCon();

  $sql = "UPDATE Appointments SET date = '$date', time = '$time' WHERE appointmentId = $appointmentId;";
  $result = $conn->query($sql);

  $sql = "UPDATE PerformedAt SET clinicId = $clinicId WHERE appointmentId = $appointmentId;";
  $result = $conn->query($sql);

  $sql = "UPDATE PerformedBy set professionalId = $professionalId WHERE appointmentId = $appointmentId;";
  $result = $conn->query($sql);

  $sql = "SELECT  billId
          FROM    TreatmentPerformed
          WHERE   appointmentId = $appointmentId
          GROUP BY appointmentId;";
  $result = $conn->query($sql);
  $billId = intval($result->fetch_assoc()['billId']);

  $sql = "DELETE FROM TreatmentPerformed WHERE appointmentId = $appointmentId;";
  $result = $conn->query($sql);

  $totalAppointmentCost = 0;
  foreach ($treatmentIds as $treatmentId) {
    $sql = "SELECT cost FROM Treatments WHERE treatmentId = $treatmentId";
    $result = $conn->query($sql);
    $treatmentCost = $result->fetch_assoc()['cost'];
    $totalAppointmentCost += $treatmentCost;
    
    $sql = "INSERT INTO TreatmentPerformed (appointmentId, billId, treatmentId) VALUES ($appointmentId, $billId, $treatmentId);";
    $result = $conn->query($sql);
  }

  $sql = "UPDATE Bills set amount = $totalAppointmentCost WHERE billId = $billId;";
  $result = $conn->query($sql);
    
  CloseCon($conn);
?>