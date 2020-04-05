<?php include '../../db_connection.php'; ?>

<?php

    $name = $_POST['name'];
    $address = $_POST['address'];
    $phoneNumber = $_POST['phoneNumber'];
    file_put_contents('your_log_file.txt', PHP_EOL . $name . $address . $phoneNumber, FILE_APPEND);
    $conn = OpenCon();

    $sql = "INSERT INTO Patients VALUES ('$name', '$address', '$phoneNumber');";
    $result = $conn->query($sql);

    if ($result) {
        file_put_contents('your_log_file.txt', PHP_EOL . "Successfully inserted appointment", FILE_APPEND);
      } else {
        file_put_contents('your_log_file.txt', PHP_EOL . "Failed to insert appointment", FILE_APPEND);
      }
    CloseCon($conn);
?>