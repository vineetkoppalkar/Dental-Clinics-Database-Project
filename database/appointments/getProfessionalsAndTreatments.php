<div class="row w-100">
  <?php

  function getProfessionalNames() {
    $conn = OpenCon();

    $clinicId = $_GET['clinicId'];
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

  $professionalNameMap = getProfessionalNames();
  $treatmentNameMap = getTreatmentNames();

  echo '<form class="w-50 mb-5 mx-auto">
          <h3 class="mb-4 mx-auto">Professional and Treatment Details</h3>
          <div class="form-group row">
            <label for="professionalId" class="col-sm-3 col-form-label">Dentist</label>
            <div class="col-sm-9">
              <select class="custom-select my-1 mr-sm-2" name="professionalId">
                <option selected>Select a dentist ...</option>';

                foreach ($professionalNameMap as $professionalId => $professionalName) {
                  echo '<option value="' . $professionalId . '">' . $professionalName . '</option>';
                }

  echo       '</select>
            </div>
          </div>
          <div class="form-group row">
            <label for="treatment" class="col-sm-3 col-form-label">Treatment(s)</label>
            <div class="col-sm-9">
              <select class="custom-select my-1 mr-sm-2 pb-5" name="treatment" multiple data-live-search="true">';

                foreach ($treatmentNameMap as $treatmentId => $treatmentName) {
                  echo '<option value="' . $treatmentId . '">' . $treatmentName . '</option>';
                }

  echo        '</select>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-8">
              <button
                type="submit"
                class="btn btn-outline-success w-25"
              >
                Submit
              </button>
            </div>
          </div>
        </form>';
    
  ?>
  
  <script>
    const insertNewAppointment = (patientId, clinicId, date, time, professionalId, treatmentIds) => {

      const formData = new FormData();
      formData.append("patientId", patientId);
      formData.append("clinicId", clinicId);
      formData.append("date", date);
      formData.append("time", time);
      formData.append("professionalId", professionalId);
      formData.append("treatmentIds", treatmentIds);

      fetch('../../database/appointments/insertAppointment.php', {
        method: 'POST',
        body: formData
      }).then(response => {
        window.location.href = "/templates/appointments/appointments.php"; 
      }).catch(error => {
        console.log("Fetch error while inserting new appointment");
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
      const patientId = urlParams.get('patientId');
      const clinicId = urlParams.get('clinicId');
      const date = urlParams.get('date');
      const time = urlParams.get('time');

      insertNewAppointment(patientId, clinicId, date, time, professionalId, selectedTreatmentIds);
    };

    const form = document.getElementsByTagName('form')[0];
    form.addEventListener('submit', handleOnSubmit);
  </script>

</div>