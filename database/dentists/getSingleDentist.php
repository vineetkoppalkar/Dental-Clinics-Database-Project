<div class="row">
    <div class="col-lg-6">
        <?php $date = ""; ?>
        <?php $professionalId = $_GET['professionalId']; ?>

        <h3>Search by week</h3>
        <form method="get" action="<?php echo '/templates/dentists/dentist.php?professionalId=' . htmlspecialchars($_GET['professionalId']); ?>">
            <input style="background-color: gray; display: none;" type="text" name="professionalId" value="<?php echo htmlspecialchars($_GET['professionalId']); ?>">
            <textarea class="form-control" name="date" rows="2" cols="120"><?php echo $date; ?></textarea>
            <br />
            <button type="submit" class="btn btn-outline-info w-25">
                Submit
            </button>
        </form>

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
                        WEEK(date) = WEEK(\"$date\");";


        $result = $conn->query($sql);

        echo "<br /><br />";

        if ($result->num_rows > 0) {
            echo '<div style="width:1000px;">';
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
                '</div>';
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                echo '<li class="w-100 list-group-item container">' .
                    '<div class="row">' .
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