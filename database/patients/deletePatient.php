<?php include '../../db_connection.php'; ?>

<?php
    
    $patientId = $_POST['patientId']; 

    $conn = OpenCon();

    $sql = "DELETE FROM Patients WHERE patientId = $patientId";
    $result = $conn->query($sql);
    
    CloseCon($conn);
?>