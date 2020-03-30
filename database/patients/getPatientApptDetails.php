<div class="row">
  <div class="col-lg-6">
    <?php
    $conn = OpenCon();
    echo "<h4>All Appointments for ". $_GET['patientName'] . "</h4>";

    $patientId = $_GET['patientId'];
    $sql = "SELECT Professionals.name as professionalName, 
            DentalClinics.name as dentalClinic,
            DentalClinics.address as dentalClinicAddress,
            DentalClinics.phoneNumber as dentalClinicPhoneNumber,
            date, 
            time,
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
            WHERE	Patients.patientId = $patientId AND
            ReceivedBy.patientId = Patients.patientId AND
            ReceivedBy.appointmentId = Appointments.appointmentId AND
            PerformedBy.appointmentId = Appointments.appointmentId AND
            PerformedBy.professionalId = Professionals.professionalId AND
            TreatmentPerformed.appointmentId = Appointments.appointmentId AND
            TreatmentPerformed.treatmentId = Treatments.treatmentId AND
            PerformedAt.appointmentId = Appointments.appointmentId AND
            PerformedAt.clinicId = DentalClinics.clinicId;
";


    $result = $conn->query($sql);

    echo "<br /><br />";

    if ($result->num_rows > 0) {
      // output data of each row
      while ($row = $result->fetch_assoc()) {
        $apptMissed = ($row["isMissed"] == 1) ? ("Yes") : ("No");

        echo "<p>Performed by: " . $row["professionalName"] . "</p> " . 
              "<p>Clinic Name: " . $row["dentalClinic"] . "</p> " . 
              "<p>Clinic Address: " .$row["dentalClinicAddress"] . "</p> " .
              "<p>Clinic Phone: " . $row["dentalClinicPhoneNumber"] . "</p> " .
              "<p>Apointment Date: " . $row["date"] . "</p> " .
              "<p>Appointment Time: " . $row["time"] . "</p> " .
              "<p>Treatment: " . $row["treatmentName"] . "</p> " .
              "<p>Missed: " . $apptMissed . "</p>";
      }
    } else {
      echo "0 appointments";
    }
    CloseCon($conn);
    ?>
  </div>
</div>