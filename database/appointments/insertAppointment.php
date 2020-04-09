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

    $totalAppointmentCost = 0;
    foreach ($treatmentIds as $treatmentId) {
      $sql = "SELECT cost FROM Treatments WHERE treatmentId = $treatmentId";
      $result = $conn->query($sql);
      $treatmentCost = $result->fetch_assoc()['cost'];
      $totalAppointmentCost += $treatmentCost;
      
      $sql = "INSERT INTO TreatmentPerformed (appointmentId, treatmentId) VALUES ($newAppointmentId, $treatmentId);";
      $result = $conn->query($sql);
    }

    $sql = "INSERT INTO Bills (amount) VALUES ($totalAppointmentCost);";
    $result = $conn->query($sql);
    $newBillId = $conn->insert_id;

    foreach ($treatmentIds as $treatmentId) {
      $sql = "UPDATE  TreatmentPerformed
              SET     billId = $newBillId 
              WHERE   appointmentId = $newAppointmentId AND
                      treatmentId = $treatmentId;";
      $result = $conn->query($sql);
    }

    $sql = "SELECT 	COUNT(Receptionists.receptionistId) as numOfReceptionists
            FROM   	Receptionists, ReceptionistAt, DentalClinics
            WHERE 	DentalClinics.clinicId = $clinicId AND
                    Receptionists.receptionistId = ReceptionistAt.receptionistId  AND
                    ReceptionistAt.clinicId = DentalClinics.clinicId;";
    $result = $conn->query($sql);
    $numOfReceptionists = $result->fetch_assoc()['numOfReceptionists'];

    $randomReceptionistId = rand(1, $numOfReceptionists);
    
    $sql = "INSERT INTO PreparedBy (patientId, billId, receptionistId) VALUES ($patientId, $newBillId, $randomReceptionistId);";
    $result = $conn->query($sql);
       
  }
  
  CloseCon($conn);
?>