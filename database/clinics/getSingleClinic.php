<div class="row">
  <?php $clinicId = $_GET['clinicId']; ?>

  <div class="col-sm-12 mb-5">
    <h3>Search appointments by date</h3>
    <form method="get" action="<?php echo 'clinic.php?clinicId=' . htmlspecialchars($_GET['clinicId']); ?>">
      <input style="background-color: gray; display: none;" type="text" name="clinicId" value="<?php echo htmlspecialchars($_GET['clinicId']); ?>">
      <input type="text" id="date" name="date" placeholder="2020-01-01">
      <br />
      <br />
      <button type="submit" class="btn btn-outline-info w-25">
        Search
      </button>
    </form>
  </div>


  <?php
  $conn = OpenCon();

  echo "<div class='col-sm-12'>";
  echo "<h4 class='ml-5 mb-3'>Appointments at this Clinic</h4>";

  $clinicId = $_GET['clinicId'];
  $date = $_GET['date'];
  $sql = "SELECT Professionals.name as professionalName, 
              Patients.name as patientName,
              date, time,
              Treatments.name as treatmentName,
              isMissed
          FROM 	Appointments,
              PerformedBy,
              Patients,
              ReceivedBy,
              TreatmentPerformed,
              Treatments,
              Professionals,
              DentalClinics,
              PerformedAt

          WHERE	DentalClinics.clinicId = $clinicId AND
              PerformedAt.clinicId = DentalClinics.clinicId AND
              PerformedAt.appointmentId = Appointments.appointmentId AND
              PerformedBy.appointmentId = Appointments.appointmentId AND
              PerformedBy.professionalId = Professionals.professionalId AND
              ReceivedBy.appointmentId = Appointments.appointmentId AND
              ReceivedBy.patientId = Patients.patientId AND
              Appointments.date = '$date' AND
              TreatmentPerformed.appointmentId = Appointments.appointmentId AND
              TreatmentPerformed.treatmentId = Treatments.treatmentId;";


  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    echo '<ul class="w-100">';
    echo '<li class="w-100 list-group-item container">' .
            '<div class="row">' .
              '<div class="col-sm text-center font-weight-bold">' .
                'Professional Name' .
              '</div>' .
              '<div class="col-sm text-center font-weight-bold">' .
                'Patient Name' .
              '</div>' .
              '<div class="col-sm text-center font-weight-bold">' .
                'Date' .
              '</div>' .
              '<div class="col-sm text-center font-weight-bold">' .
                'Time' .
              '</div>' .
              '<div class="col-sm text-center font-weight-bold">' .
                'Treatment Name' .
              '</div>' .
              '<div class="col-sm text-center font-weight-bold">' .
                'Missed' .
              '</div>' .
            '</div>' .
          '</li>';
    while ($row = $result->fetch_assoc()) {
      echo '<li class="w-100 list-group-item container">' .
              '<div class="row">' .
                '<div class="col-sm text-center">' .
                  $row['professionalName'] .
                '</div>' .
                '<div class="col-sm text-center">' .
                  $row['patientName'] .
                '</div>' .
                '<div class="col-sm text-center">' .
                  $row['date'] .
                '</div>' .
                '<div class="col-sm text-center">' .
                  $row['time'] .
                '</div>' .
                '<div class="col-sm text-center">' .
                  $row['treatmentName'] .
                '</div>' .
                '<div class="col-sm text-center">';
            echo  ($row['isMissed'] == 1) ? "Yes" : "No";
            echo '</div>' .
              '</div>' .
            '</li>';
    }
    echo "</ul>";
  } else {
    echo "<p class='ml-5 mb-5'>0 appointments for this date</p>";
  }

  echo '<footer class="footer">' .
        ' <p>&copy; DENTisTO inc. 2020</p>' .
        '</footer>';
  CloseCon($conn);
  ?>
</div>