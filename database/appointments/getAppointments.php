<div class="row">
  <?php
  $conn = OpenCon();

  $sql = "SELECT	  DentalClinics.clinicId,
                    DentalClinics.name as clinicName,
                    Appointments.appointmentId,
                    Appointments.date,
                    Appointments.time
          FROM 	    Appointments, PerformedAt, DentalClinics
          WHERE 	  Appointments.appointmentId = PerformedAt.appointmentId AND
                    PerformedAt.clinicId = DentalClinics.clinicId";

  $result = $conn->query($sql);

  $clinicNameMap = array();
  $appointmentsInClinicMap = array();
  $todayDate = date("Y-m-d");

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

      $clinicId = $row['clinicId'];
      if (!array_key_exists($clinicId, $clinicNameMap)) {
        $clinicNameMap[$clinicId] = $row['clinicName'];
        $appointmentsInClinicMap[$clinicId] = array();
      }

      $appointmentsAtClinic = $appointmentsInClinicMap[$clinicId];
      $appointment = array(
        'appointmentId' => $row['appointmentId'],
        'date' => $row['date'],
        'time' => $row['time']
      );
      array_push($appointmentsAtClinic, $appointment);
      $appointmentsInClinicMap[$clinicId] = $appointmentsAtClinic;
    }
  } else {
    echo "0 appointments found";
    return;
  }

  foreach ($appointmentsInClinicMap as $clinicId => $appointments) {
    $clinicName = $clinicNameMap[$clinicId];
    echo '<h5 class="w-75 mx-auto">' . $clinicName . '</h5>';
    echo '<ul class="w-75 mx-auto mb-5 list-group">';
    foreach ($appointments as $appointment) {
      echo '<li class="w-100 list-group-item container">' .
              '<div class="row">' .
                '<div class="col-sm text-center font-weight-bold">' .
                  $appointment['date'] .
                '</div>' .
                '<div class="col-sm text-center">' .
                  $appointment['time'] .
                '</div>' .
                '<div class="col-sm text-center">' .
                  '<a class="btn btn-outline-primary btn-sm" href="#" role="button">Details</a>' .
                '</div>' .
              '</div>' .
            '</li>';
    }
    echo '</ul>';
  }

  CloseCon($conn);
  ?>

</div>