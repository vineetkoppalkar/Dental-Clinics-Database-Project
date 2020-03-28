<div class="row">
  <div class="col-lg-6">
    <?php
    $conn = OpenCon();
    echo "<h4>All Appointments for a Single Clinic</h4>";

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
      while ($row = $result->fetch_assoc()) {
        echo $row["professionalName"] . " " . $row["patientName"] . " " . $row["date"] . " " . $row["time"] . " " . $row["treatmentName"] . " " . $row["isMissed"] . "<br />";
      }
    } else {
      echo "0 appointments";
    }
    CloseCon($conn);
    ?>
  </div>
</div>