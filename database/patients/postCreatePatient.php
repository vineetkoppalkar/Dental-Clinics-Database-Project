<?php header("Location: /templates/patients/patients.php"); ?>
<?php include '../../db_connection.php'; ?>

<?php
    
    $name = $_POST['createName'];
    $address = $_POST['createAddress'];
    $phoneNumber = $_POST['createPhoneNumber'];

    $sql = "INSERT INTO Patients (name, address, phoneNumber) VALUES ('$name', '$address', '$phoneNumber');";
    $result = $conn->query($sql);
    
    CloseCon($conn);
    
?>