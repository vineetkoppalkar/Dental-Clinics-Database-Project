<div class="row w-100">
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

  function getPatientNames() {
    $conn = OpenCon();

    $patientNameMap = array();
    $sql = "SELECT * FROM Patients";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($patient = $result->fetch_assoc()) {
        $patientId = $patient['patientId'];
        $patientName = $patient['name'];
        $patientNameMap[$patientId] = $patientName;
      }
    } else {
      echo "0 patients found";
      return;
    }

    CloseCon($conn);
    return $patientNameMap;
  }

  $clinicNameMap = getClinicNames();
  $patientNameMap = getPatientNames();

  echo '<form
          class="w-50 mb-5 mx-auto"
          method="GET"
          action="appointmentProfessional.php"
        >
          <h3 class="mb-4 mx-auto">New Appointment Details</h3>
          <div class="form-group row">
            <label for="patientId" class="col-sm-2 col-form-label">Patient</label>
            <div class="col-sm-10">
              <select class="custom-select my-1 mr-sm-2" name="patientId">
                <option selected>Select a patient ...</option>';

                foreach ($patientNameMap as $patientId => $patientName) {
                  echo '<option value="' . $patientId . '">' . $patientName . '</option>';
                }

  echo       '</select>
            </div>
          </div>
          <div class="form-group row">
            <label for="clinicId" class="col-sm-2 col-form-label">Clinic</label>
            <div class="col-sm-10">
              <select class="custom-select my-1 mr-sm-2" name="clinicId">
                <option selected>Select a clinic ...</option>';

                foreach ($clinicNameMap as $clinicId => $clinicName) {
                  echo '<option value="' . $clinicId . '">' . $clinicName . '</option>';
                }

  echo        '</select>
            </div>
          </div>
          <div class="form-group row">
            <label for="date" class="col-sm-2 col-form-label">Date</label>
            <div class=" col-sm-10">
              <input name="date" type="text" class="form-control w-50" placeholder="2020-01-01">
            </div>
          </div>
          <div class="form-group row">
            <label for="time" class="col-sm-2 col-form-label">Time</label>
            <div class=" col-sm-10">
              <input name="time" type="text" class="form-control w-50" placeholder="00:00:00">
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