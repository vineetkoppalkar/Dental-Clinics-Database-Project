<div class="row">
  <?php
    function getProfessionalNamesOfClinic($clinicId) {
      $conn = OpenCon();

      $sql = "SELECT  professionalId, Professionals.name
              FROM    Professionals, ProfessionalAt, DentalClinics
              WHERE   DentalClinics.clinicId = $clinicId AND
                      DentalClinics.clinicId = ProfessionalAt.clinicId AND
                      ProfessionalAt.dentistId = Professionals.professionalId";
      $result = $conn->query($sql);
      
      $professionalNameMap = array();
      if ($result->num_rows > 0) {
        while ($professional = $result->fetch_assoc()) {
          $professionalId = $professional['professionalId'];
          $professionalName = $professional['name'];
          $professionalNameMap[$professionalId] = $professionalName;
        }
      } else {
        echo "0 professionals found";
        return;
      }

      CloseCon($conn);
      return $professionalNameMap;
    }

    function getTreatmentNames() {
      $conn = OpenCon();
  
      $sql = "SELECT treatmentId, name FROM Treatments";
      $result = $conn->query($sql);
      
      $treatmentNameMap = array();
      if ($result->num_rows > 0) {
        while ($treatment = $result->fetch_assoc()) {
          $treatmentId = $treatment['treatmentId'];
          $treatmentName = $treatment['name'];
          $treatmentNameMap[$treatmentId] = $treatmentName;
        }
      } else {
        echo "0 treatments found";
        return;
      }
  
      CloseCon($conn);
      return $treatmentNameMap;
    }

    function getAppointmentProfessionalId($appointmentId) {
      $conn = OpenCon();

      $professionalId = "";
      $sql = "SELECT   Professionals.professionalId
              FROM     Appointments, PerformedBy, Professionals
              WHERE    Appointments.appointmentId = $appointmentId AND
                       Appointments.appointmentId = PerformedBy.appointmentId AND
                       PerformedBy.professionalId = Professionals.professionalId"; 
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while ($professional = $result->fetch_assoc()) {
          $professionalId = $professional['professionalId'];
        }
      } else {
        echo "0 professionals found";
        return;
      }

      CloseCon($conn);
      return $professionalId;
    }

    function getAppointmentTreatmentIds($appointmentId) {
      $conn = OpenCon();
  
      $sql = "SELECT  Treatments.treatmentId
              FROM    Appointments, TreatmentPerformed, Treatments
              WHERE   Appointments.appointmentId = $appointmentId AND
                      Appointments.appointmentId = TreatmentPerformed.appointmentId AND
                      TreatmentPerformed.treatmentId = Treatments.treatmentId";
      $result = $conn->query($sql);
      
      $treatmentIds = array();
      if ($result->num_rows > 0) {
        while ($treatment = $result->fetch_assoc()) {
          $treatmentId = $treatment['treatmentId'];
          array_push($treatmentIds, $treatmentId);
        }
      } else {
        echo "0 treatments found";
        return;
      }
  
      CloseCon($conn);
      return $treatmentIds;
    }

    $professionalNameMap = getProfessionalNamesOfClinic($_GET['clinicId']);
    $treatmentNameMap = getTreatmentNames();
    $prevProfessionalId = getAppointmentProfessionalId($_GET['appointmentId']);
    $prevTreatmentIds = getAppointmentTreatmentIds($_GET['appointmentId']);

    echo '<form
          class="w-50 mb-5 mx-auto"
          method="GET"
          action="/templates/appointments/updateAppointmentProfessional.php&appointmentId=' . $_GET['appointmentId'] . '"
        >
          <h3 class="mb-4 mx-auto">Update Appointment Professional & Treatments</h3>
          <div class="form-group row">
            <label for="professionalId" class="col-sm-3 col-form-label">Dentist</label>
            <div class="col-sm-9">
              <select class="custom-select my-1 mr-sm-2" name="professionalId">
                <option selected>Select a dentist ...</option>';

                foreach ($professionalNameMap as $professionalId => $professionalName) {
                  if ($professionalId == $prevProfessionalId) {
                    echo '<option value="' . $professionalId . '" selected>' . $professionalName . '</option>';
                  } else {
                    echo '<option value="' . $professionalId . '">' . $professionalName . '</option>';
                  }
                }

    echo     '</select>
            </div>
          </div>
          <div class="form-group row">
          <label for="treatment" class="col-sm-3 col-form-label">Treatment(s)</label>
          <div class="col-sm-9">
            <select class="custom-select my-1 mr-sm-2 pb-5" name="treatment" multiple data-live-search="true">';

              foreach ($treatmentNameMap as $treatmentId => $treatmentName) {
                if (in_array($treatmentId, $prevTreatmentIds)) {
                  echo '<option value="' . $treatmentId . '" selected>' . $treatmentName . '</option>';
                } else {
                  echo '<option value="' . $treatmentId . '">' . $treatmentName . '</option>';
                }
              }

    echo    '</select>
          </div>
        </div>
          <div class="form-group row">
            <div class="col-sm-8">
              <button
                type="submit"
                class="btn btn-outline-success w-25"
              >
                Update
              </button>
            </div>
          </div>
        </form>';
  ?>

  <script>
    const updateAppointment = (appointmentId, clinicId, date, time, professionalId, treatmentIds) => {

      const formData = new FormData();
      formData.append("appointmentId", appointmentId);
      formData.append("clinicId", clinicId);
      formData.append("date", date);
      formData.append("time", time);
      formData.append("professionalId", professionalId);
      formData.append("treatmentIds", treatmentIds);

      fetch('../../database/appointments/updateAppointment.php', {
        method: 'POST',
        body: formData
      }).then(response => {
        window.location.href = "/templates/appointments/appointments.php"; 
      }).catch(error => {
        console.log("Fetch error while updating an appointment");
        console.log(error);
      });
    };

    const handleOnSubmit = (event) => {
      event.preventDefault();
      const professionalId = event.target[0].value;

      const selectedTreatmentIds = [];
      const treatmentDropdownOptions = event.target[1];
      const nbOfTreatments = event.target[1].length;

      for (let i = 0; i < nbOfTreatments; i++) {
        const { selected, value } = treatmentDropdownOptions[i];
        if (selected) {
          selectedTreatmentIds.push(value);
        }
      }

      const urlParams = new URLSearchParams(window.location.search);
      const appointmentId = urlParams.get('appointmentId');
      const clinicId = urlParams.get('clinicId');
      const date = urlParams.get('date');
      const time = urlParams.get('time');

      updateAppointment(appointmentId, clinicId, date, time, professionalId, selectedTreatmentIds);
    };

    const form = document.getElementsByTagName('form')[0];
    form.addEventListener('submit', handleOnSubmit);
  </script>
</div>
