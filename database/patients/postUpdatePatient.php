<?php include '../../db_connection.php'; ?>

<?php

    $patientId = $_POST['patientId'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phoneNumber = $_POST['phoneNumber'];
    file_put_contents('your_log_file.txt', PHP_EOL . $name . $address . $phoneNumber, FILE_APPEND);
    $conn = OpenCon();

    $sql = "UPDATE Patients SET name = '$name', address = '$address', phoneNumber = '$phoneNumber' WHERE patientId = $patientId;";
    $result = $conn->query($sql);

    CloseCon($conn);
?>