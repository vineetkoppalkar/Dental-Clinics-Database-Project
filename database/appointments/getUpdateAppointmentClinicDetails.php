<div class="row">
  <?php
    function getClinicNames() {
      $conn = OpenCon();

      $clinicNameMap = array();
      $sql = "SELECT clinicId, name FROM DentalClinics";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while ($clinic = $result->fetch_assoc()) {
          $clinicId = $clinic['clinicId'];
          $clinicName = $clinic['name'];
          $clinicNameMap[$clinicId] = $clinicName;
        }
      } else {
        echo "0 clinics found";
        return;
      }

      CloseCon($conn);
      return $clinicNameMap;
    }

    function getPatientName($appointmentId) {
      $conn = OpenCon();

      $patientName = "";
      $sql = "SELECT   Patients.name as name
              FROM     Appointments, ReceivedBy, Patients
              WHERE    Appointments.appointmentId = $appointmentId AND
                       Appointments.appointmentId = ReceivedBy.appointmentId AND
                       ReceivedBy.patientId = Patients.patientId"; 
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while ($patient = $result->fetch_assoc()) {
          $patientName = $patient['name'];
        }
      } else {
        $patientName = "Patient not found";
        return;
      }

      CloseCon($conn);
      return $patientName;
    }

    $appointmentId = $_GET['appointmentId'];
    $clinicNameMap = getClinicNames();
    $patientName = getPatientName($appointmentId);
    $prevClinicId = $_GET['clinicId'];
    $prevDate = $_GET['date'];
    $prevTime = $_GET['time'];

    echo '<form
          class="w-50 mb-5 mx-auto"
          method="GET"
          action="updateAppointmentProfessional.php"
        >
          <input type="hidden" name="appointmentId" value="' .  $appointmentId . '">
          <h3 class="mb-4 mx-auto">Update Appointment Details</h3>
          <div class="form-group row">
            <label for="patient" class="col-sm-2 col-form-label">Patient</label>
            <div class=" col-sm-10">
              <input name="patient" type="text" class="form-control w-50" value="' . $patientName . '" disabled>
            </div>
          </div>
          <div class="form-group row">
            <label for="clinicId" class="col-sm-2 col-form-label">Clinic</label>
            <div class="col-sm-10">
              <select class="custom-select my-1 mr-sm-2" name="clinicId">
                <option selected>Select a clinic ...</option>';

                foreach ($clinicNameMap as $clinicId => $clinicName) {
                  if ($clinicId == $prevClinicId) {
                    echo '<option value="' . $clinicId . '" selected>' . $clinicName . '</option>';
                  } else {
                    echo '<option value="' . $clinicId . '">' . $clinicName . '</option>';
                  }
                }

    echo     '</select>
            </div>
          </div>
          <div class="form-group row">
            <label for="date" class="col-sm-2 col-form-label">Date</label>
            <div class=" col-sm-10">
              <input name="date" type="text" class="form-control w-50" value="'. $prevDate .'">
            </div>
          </div>
          <div class="form-group row">
            <label for="time" class="col-sm-2 col-form-label">Time</label>
            <div class=" col-sm-10">
              <input name="time" type="text" class="form-control w-50" value="' . $prevTime . '">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-8">
              <button
                type="submit"
                class="btn btn-outline-info w-25"
              >
                Next
              </button>
            </div>
          </div>
        </form>';
  ?>
</div>
