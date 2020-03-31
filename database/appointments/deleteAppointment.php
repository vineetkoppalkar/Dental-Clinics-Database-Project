<?php include '../../db_connection.php'; ?>

<?php

  $appointmentId = $_POST['appointmentId']; 

  $conn = OpenCon();

  $sql = "DELETE FROM Appointments WHERE appointmentId = $appointmentId";
  $result = $conn->query($sql);

  CloseCon($conn);
?>