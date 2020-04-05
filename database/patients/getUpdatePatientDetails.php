<?php session_start(); ?>
<div class="row">
  <?php

    $patientId = $_GET['patientId'];
    $patientName = $_GET['patientName'];
    $address = $_GET['address'];
    $phoneNumber = $_GET['phoneNumber'];
    

    echo '<form
          class="w-50 mb-5 mx-auto"
          method="Post"
          action="/database/patients/postUpdatePatient.php"
          onsubmit="document.location.href = \'/templates/patients/patients.php\'; return false;"
        >
          <input type="hidden" name="patientId" id="patientId" value="' . $patientId . '">
          <h3 class="mb-4 mx-auto">Update Appointment Details</h3>
          <div class="form-group row">
            <label for="patient" class="col-sm-2 col-form-label">Patient</label>
            <div class=" col-sm-10">
              <input name="name" id="name" type="text" class="form-control w-50" value="' . $patientName . '">
            </div>
          </div>
          
          <div class="form-group row">
            <label for="address" class="col-sm-2 col-form-label">Address</label>
            <div class=" col-sm-10">
              <input name="address" id="address" type="text" class="form-control w-50" value="'. $address .'">
            </div>
          </div>
          <div class="form-group row">
            <label for="phoneNumber" class="col-sm-2 col-form-label">Phone</label>
            <div class=" col-sm-10">
              <input name="phoneNumber" id="phoneNumber" type="text" class="form-control w-50" value="' . $phoneNumber . '">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-8">
              <button
                type="submit"
                class="btn btn-outline-info w-25"
              >
                Update
              </button>
            </div>
          </div>
        </form>';
  ?>
</div>
