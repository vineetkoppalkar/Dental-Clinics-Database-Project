<?php header("Location: patients.php"); ?>
<?php include '../../db_connection.php'; ?>

<?php

    $patientId = $_POST['patientId'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phoneNumber = $_POST['phoneNumber'];
    
    $conn = OpenCon();

    $sql = "UPDATE Patients SET name = '$name', address = '$address', phoneNumber = '$phoneNumber' WHERE patientId = $patientId;";
    $result = $conn->query($sql);

    CloseCon($conn);

    
?>