<?php
$conn = OpenCon();

$appointmentId = $_GET['appointmentId'];
$sql = "SELECT  name,
                address,
                phoneNumber
        FROM 	  Appointments, ReceivedBy, Patients
        WHERE 	Appointments.appointmentId = $appointmentId AND
                Appointments.appointmentId = ReceivedBy.appointmentId AND
                ReceivedBy.patientId = Patients.patientId;";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($patientDetails = $result->fetch_assoc()) {
    echo '<div class="col-sm-4 mb-5">' .
            '<div class="card  h-100">' .
              '<div class="card-body">' .
                '<h5 class="card-title">Patient Detials</h5>' .
                '<p class="card-text ml-4">' . 
                  $patientDetails['name'] . 
                  '<br />' . 
                  $patientDetails['address']  .
                  '<br />' . 
                  $patientDetails['phoneNumber']  .         
                '</p>' .
              '</div>' .
            '</div>' .
          '</div>';
  }
} else {
  echo "Patient details not found!";
}

CloseCon($conn);
?>
