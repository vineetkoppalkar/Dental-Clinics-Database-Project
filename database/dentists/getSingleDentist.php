<div class="row">
    <div class="col-lg-6">
        <?php
        $conn = OpenCon();
        echo "<h4>All Appointments for a Dentist</h4>";

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
                        Professionals.isDentist = TRUE AND
                        PerformedBy.professionalId = Professionals.professionalId AND
                        PerformedBy.appointmentId = Appointments.appointmentId AND 
                        TreatmentPerformed.appointmentId = Appointments.appointmentId AND
                        TreatmentPerformed.treatmentId = Treatments.treatmentId AND
                        Appointments.appointmentId = ReceivedBy.appointmentId AND
                        ReceivedBy.patientId = Patients.patientId AND
                        WEEK(date) = WEEK($date);";


        $result = $conn->query($sql);

        echo "<br /><br />";

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                echo $row["patientName"] . " " . $row["date"] . " " . $row["time"] . " " . $row["treatmentName"] . " " . $row["isMissed"] . "<br />";
            }
        } else {
            echo "0 appointments";
        }
        CloseCon($conn);
        ?>
    </div>
</div>