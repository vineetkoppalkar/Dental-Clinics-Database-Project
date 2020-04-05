<?php include '../../db_connection.php'; ?>

<?php

  $appointmentId = $_POST['appointmentId']; 

  $conn = OpenCon();

  $sql = "SELECT  billId
          FROM    TreatmentPerformed
          WHERE   appointmentId = $appointmentId
          GROUP BY appointmentId;";
  $result = $conn->query($sql);
  $appointmentBillId = intval($result->fetch_assoc()['billId']);

  $sql = "DELETE FROM Appointments WHERE appointmentId = $appointmentId;";
  $result = $conn->query($sql);

  $sql = "DELETE FROM Bills WHERE billId = $appointmentBillId;";
  $result = $conn->query($sql);

  CloseCon($conn);
?>