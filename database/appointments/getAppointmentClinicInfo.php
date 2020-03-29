<?php
$conn = OpenCon();

$appointmentId = $_GET['appointmentId'];
$sql = "SELECT  DentalClinics.name as clinicName,
                DentalClinics.address as clinicAddress,
                DentalClinics.phoneNumber as clinicPhoneNumber,
                Appointments.date,
                Appointments.time
        FROM 	  Appointments, PerformedAt, DentalClinics
        WHERE 	Appointments.appointmentId = $appointmentId AND
                Appointments.appointmentId = PerformedAt.appointmentId AND
                PerformedAt.clinicId = DentalClinics.clinicId";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($appointmentDetails = $result->fetch_assoc()) {
    echo '<div class="col-sm-4 mb-5">' .
            '<div class="card h-100">' .
              '<div class="card-body">' .
                '<h5 class="card-title">' . $appointmentDetails['clinicName'] . '</h5>' .
                '<p class="card-text">' . 
                  $appointmentDetails['clinicAddress'] . 
                  '<br />' . 
                  $appointmentDetails['clinicPhoneNumber']  .                 
                '</p>' .
                '<hr />' .
                '<p class="card-text text-center font-weight-bold">' . 
                  'At ' . $appointmentDetails['time'] . ' on ' . $appointmentDetails['date'] .
                '</p>' .
              '</div>' .
            '</div>' .
          '</div>';
  }
} else {
  echo "Clinic details not found!";
}

CloseCon($conn);
?>
