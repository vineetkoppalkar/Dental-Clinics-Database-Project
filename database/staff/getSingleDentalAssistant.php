<div class="row">
  <?php $professionalId = $_GET['professionalId']; ?>

    <div class="col-sm-12 mb-5">
      <h3>Search appointments by week</h3>
      <form method="get" action="<?php echo 'dentalAssistant.php?professionalId=' . htmlspecialchars($_GET['professionalId']); ?>">
        <input style="background-color: gray; display: none;" type="text" name="professionalId" value="<?php echo htmlspecialchars($_GET['professionalId']); ?>">
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
    echo "<h4 class='ml-5 mb-3'>All Appointments for Dental Assistant</h4>";

    $professionalId = $_GET['professionalId'];
    $date = $_GET['date'];
    $sql = "SELECT Patients.name as patientName,
                    date,time,
                    Treatments.name as treatmentName,
                    isMissed
            FROM 	Appointments,
                    PerformedBy,
                    Patients,
                    ReceivedBy,
                    TreatmentPerformed,
                    Treatments,
                    Professionals
            WHERE Professionals.professionalId = $professionalId AND
                    Professionals.isDentist = FALSE AND
                    PerformedBy.professionalId = Professionals.professionalId AND
                    PerformedBy.appointmentId = Appointments.appointmentId AND 
                    TreatmentPerformed.appointmentId = Appointments.appointmentId AND
                    TreatmentPerformed.treatmentId = Treatments.treatmentId AND
                    Appointments.appointmentId = ReceivedBy.appointmentId AND
                    ReceivedBy.patientId = Patients.patientId AND
                    WEEK(date) = WEEK(\"$date\");";


    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      echo '<ul class="w-100">';
      echo '<li class="w-100 list-group-item container">' .
              '<div class="row">' .
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
              '</div>
            </li>';

      while ($row = $result->fetch_assoc()) {
        echo '<li class="w-100 list-group-item container">' .
              '<div class="row">' .
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
    echo "</div>";


    echo '<footer class="footer">' .
        ' <p>&copy; DENTisTO inc. 2020</p>' .
        '</footer>';

    CloseCon($conn);
  ?>
</div>