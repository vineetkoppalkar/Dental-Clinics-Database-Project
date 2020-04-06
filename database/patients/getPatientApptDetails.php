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
          PerformedAt.clinicId = DentalClinics.clinicId;";
  echo '</div>';


  $result = $conn->query($sql);


  $apptIdMap = array();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $apptId = $row['appointmentId'];
      if (!array_key_exists($apptId, $apptIdMap)) {
        $apptTreatments = array($row['treatmentName']);
        $apptIdMap[$apptId] = array(
          "date"=>$row['date'],
          "time"=>$row['time'],
          "professionalName"=>$row['professionalName'],
          "dentalClinic"=>$row['dentalClinic'],
          "dentalClinicAddress"=>$row['dentalClinicAddress'],
          "dentalClinicPhoneNumber"=>$row['dentalClinicPhoneNumber'],
          "treatmentName"=>$apptTreatments,
          "isMissed"=>$row['isMissed']
        );
      } else {
        array_push($apptIdMap[$apptId]['treatmentName'], $row['treatmentName']);
      }
    }
  }

  $sqlMissed = "SELECT patientId, COUNT(isMissed) as missed
                FROM ReceivedBy
                WHERE isMissed = TRUE
                GROUP BY patientId;";
  $resultMissed = $conn->query($sqlMissed);

  $missedCount = 0;

  $missedMap = array();
  if ($resultMissed->num_rows > 0) {
    while ($row = $resultMissed->fetch_assoc()) {
      $missedMap[$row['patientId']] = $row['missed'];
    }
  }
  if (array_key_exists($patientId, $missedMap)) {
    $missedCount = $missedMap[$patientId];
  }

  echo '<div class="row"><div class="col my-2">Number of Appointments Missed: '.$missedCount.'</div></div>';
  
  if (sizeof($apptIdMap) > 0) {
    // output data of each row
    echo '<div class="row">';
    echo '<div class="col-lg-8 my-3">';
    
    foreach ($apptIdMap as $key => $val ) {
      echo '<div class="card my-3">' .
              '<div class="card-body">';
      foreach ($val as $cat => $info) {

        if ($cat == 'date') {
          echo '<div class="row text-right"><div class="col">Date: ' . $info . '</div></div>';
        }
        if ($cat == 'time') {
          echo '<div class="row text-right"><div class="col">Time: ' . $info . '</div></div>';
        }
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
    
  } else {
    echo "No appointments";
  }
CloseCon($conn);
?>
