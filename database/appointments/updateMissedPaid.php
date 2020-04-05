<?php include '../../db_connection.php'; ?>

<?php

  $appointmentId = $_POST['appointmentId']; 
  $isMissed = $_POST['isMissed']; 
  $isPaid = $_POST['isPaid']; 


  $conn = OpenCon();

  $sql = "SELECT  billId
          FROM    TreatmentPerformed
          WHERE   appointmentId = $appointmentId
          GROUP BY appointmentId;";
  $result = $conn->query($sql);
  $billId = intval($result->fetch_assoc()['billId']);

  $sql = "UPDATE Bills set isPaid = $isPaid WHERE billId = $billId;";
  $result = $conn->query($sql);

  $sql = "UPDATE ReceivedBy set isMissed = $isMissed WHERE appointmentId = $appointmentId;";
  $result = $conn->query($sql);

  CloseCon($conn);
?>