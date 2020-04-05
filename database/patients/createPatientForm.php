<?php session_start(); ?>
<div class="row">
  <?php

    echo '<form
          class="w-50 mb-5 mx-auto"
          method="Post"
          action="/database/patients/postCreatePatient.php"
        >
          <h3 class="mb-4 mx-auto">Create New Patient</h3>
          <div class="form-group row">
            <label for="patient" class="col-sm-2 col-form-label">Patient</label>
            <div class=" col-sm-10">
              <input name="createName" id="createName" type="text" class="form-control w-50" placeholder="Enter Patient\'s Name">
            </div>
          </div>
          
          <div class="form-group row">
            <label for="address" class="col-sm-2 col-form-label">Address</label>
            <div class=" col-sm-10">
              <input name="createAddress" id="createAddress" type="text" class="form-control w-50" placeholder="Enter Patient\'s Address">
            </div>
          </div>
          <div class="form-group row">
            <label for="phoneNumber" class="col-sm-2 col-form-label">Phone</label>
            <div class=" col-sm-10">
              <input name="createPhoneNumber" id="createPhoneNumber" type="text" class="form-control w-50" placeholder="Enter Patient\'s Phone">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-8">
              <button
                type="submit"
                class="btn btn-outline-info w-25"
              >
                Create
              </button>
            </div>
          </div>
        </form>';
  ?>
</div>