<div class="row">
  <div class="col-lg-6">
    <?php $clinicId = $_GET['clinicId']; ?>

    <h3>Search by date</h3>
    <form method="get" action="<?php echo '/templates/clinics/clinic.php?clinicId=' . htmlspecialchars($_GET['clinicId']); ?>">
      <input style="background-color: gray; display: none;" type="text" name="clinicId" value="<?php echo htmlspecialchars($_GET['clinicId']); ?>">
      <input type="text" id="date" name="date">
      <br />
      <br />
      <button type="submit" class="btn btn-outline-info w-25">
        Submit
      </button>
    </form>

    <?php
    $conn = OpenCon();
    echo "<h4>All Appointments for the Clinic</h4>";

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

    echo "<br /><br />";

    if ($result->num_rows > 0) {
      // output data of each row
      echo '<div style="width:1000px;">';
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
        '</div>';
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
          $row['date'] . ' $' .
          '</div>' .
          '<div class="col-sm text-center">' .
          $row['time'] .
          '</div>' .
          '<div class="col-sm text-center">' .
          $row['treatmentName'] .
          '</div>' .
          '<div class="col-sm text-center">' .
          $row['isMissed'] .
          '</div>' .
          '</div>';
      }
    } else {
      echo "0 appointments";
    }
    CloseCon($conn);
    ?>
  </div>
</div>