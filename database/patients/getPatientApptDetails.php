<div class="row">

        <?php
        $conn = OpenCon();
        echo "<h4>All Appointments for ". $_GET['patientName'] . "</h4>";

        $patientId = $_GET['patientId'];
        $sql = "SELECT Appointments.appointmentId as appointmentId, Professionals.name as professionalName, 
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
echo '</div>';


        $result = $conn->query($sql);


        $apptIdMap = array();
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $apptId = $row['appointmentId'];
            if (!array_key_exists($apptId, $apptIdMap)) {
              $apptTreatments = array($row['treatmentName']);
              $apptIdMap[$apptId] = array(
                "professionalName"=>$row['professionalName'],
                "dentalClinic"=>$row['dentalClinic'],
                "dentalClinicAddress"=>$row['dentalClinicAddress'],
                "dentalClinicPhoneNumber"=>$row['dentalClinicPhoneNumber'],
                "date"=>$row['date'],
                "time"=>$row['time'],
                "treatmentName"=>$apptTreatments,
                "isMissed"=>$row['isMissed']
              );
            } else {
              array_push($apptIdMap[$apptId]['treatmentName'], $row['treatmentName']);
            }
          }
        }
        $missedCount = 0;
        if (sizeof($apptIdMap) > 0) {
          // output data of each row
          echo '<div class="row">';
          echo '<div class="col-lg-8 my-3">';
          
          foreach ($apptIdMap as $key => $val ) {
            echo '<div class="card">' .
          '<div class="card-body">';
            echo "<h5>Appointment Id: ". $key ."</h5>";
            foreach ($val as $cat => $info) {
     
              if ($cat == 'professionalName') {
                echo "<p>Performed By: " . $info . "</p>" ;
              }
              if ($cat == 'dentalClinic') {
                echo "<p>Clinic Name: " . $info . "</p>";
              }
              if ($cat == 'dentalClinicAddress') {
                echo "<p>Clinic Address: " . $info . "</p>";
              }
              if ($cat == 'dentalClinicPhoneNumber') {
                echo "<p>Clinic Phone: " . $info . "</p>";
              }
              if ($cat == 'date') {
                echo "<p>Date: " . $info . "</p>";
              }
              if ($cat == 'time') {
                echo "<p>Time: " . $info . "</p>";
              }
              if ($cat == 'treatmentName') {
                echo "<p>Treatments: " ;
              
                foreach ($info as $treat) {
                  echo $treat . ". ";
                }
                echo "</p>";
              }
              if ($cat == 'isMissed') {
                $apptMissed = ($info == 1) ? ("Yes") : ("No");
                if($info == 1) {
                  $missedCount = $missedCount + 1;
                } 
                echo "<p>Missed: " . $apptMissed . "</p>";
              }  
            }
            echo '</div></div>';
          }
          echo '</div>';
          echo '</div>';
          echo "</br></br><h6>TOTAL Missed: ".$missedCount . "</h6> ". "</br></br></br>";
        } else {
          echo "No appointments";
        }
        CloseCon($conn);
        ?>
