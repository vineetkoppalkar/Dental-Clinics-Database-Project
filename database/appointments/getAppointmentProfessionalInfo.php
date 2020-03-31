<?php
$conn = OpenCon();

$appointmentId = $_GET['appointmentId'];
$sql = "SELECT  name,
                phoneNumber,
                isDentist
        FROM 	  Appointments, PerformedBy, Professionals
        WHERE 	Appointments.appointmentId = $appointmentId AND
                Appointments.appointmentId = PerformedBy.appointmentId AND
                PerformedBy.professionalId = Professionals.professionalId;";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($professionalDetails = $result->fetch_assoc()) {
    $professionalType = $professionalDetails['isDentist'] ? 'Dentist' : 'Dental Assistant';
    echo '<div class="col-sm-4 mb-5">' .
            '<div class="card  h-100">' .
              '<div class="card-body">' .
                '<h5 class="card-title">Professional Details</h5>' .
                '<p class="card-text ml-4">' . 
                  $professionalDetails['name'] . 
                  '<br />' . 
                  $professionalType .
                  '<br />' . 
                  $professionalDetails['phoneNumber']  .         
                '</p>' .
              '</div>' .
            '</div>' .
          '</div>';
  }
} else {
  echo "Professional details not found!";
}

CloseCon($conn);
?>
