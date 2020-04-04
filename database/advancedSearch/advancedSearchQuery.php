<div class="newClass">

<?php $sqlQuery = ""; ?>

<h3>Advanced Search</h3>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  <!-- <h5>Enter Query: </h5> -->
  <div class="input-group">
    <div class="input-group-prepend">
      <span class="input-group-text">Query: </span>
    </div>
    <textarea class="form-control" name="sqlQuery" rows="5" cols="120"><?php echo $sqlQuery;?></textarea>
  </div>
  </br>
  <button class="btn btn-primary" type="submit" name="submit">Submit</button> 
  </br></br>
</form>

<?php

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["sqlQuery"])) {
      $sqlQuery = "";
    } else {
      $sqlQuery = $_POST["sqlQuery"];
     
      $conn = OpenCon();

      echo "</br></br><h4>Query: </h4>" . $sqlQuery . "</br></br>";

      $result = $conn->query($sqlQuery);

      echo "<h4>Query Result: </h4>";
     
      //Add check to see if the table selected is valid
      $validTables = array("Appointments", "Bills", "DentalClinics", "Patients", "PerformedAt", "PerformedBy", "PreparedBy", "ProfessionalAt", "Professionals", "ReceivedBy", "ReceptionistAt", "Receptionists", "TreatmentPerformed", "Treatments");
      $validTableName = false;
      
      foreach($validTables as $tableName){
        if(strpos($sqlQuery, $tableName) !== false){
          $validTableName = true;
          break;
        }
      }
    
      if($validTableName == false){
        echo 'The entered table name does not exist. </br></br>' .
          '<div class="card">
            <div class="card-header">
              Tables
            </div>
            <div class="card-body">
            <p class="card-text">Appointments, Bills, DentalClinics, Patients, PerformedAt, PerformedBy, PreparedBy, ProfessionalAt, Professionals, ReceivedBy, ReceptionistAt, Receptionists, TreatmentPerformed, Treatments</p>
            </div
          </div>';
      }else if(is_object($result) && $result->num_rows > 0) {
        $firstRow = $result->fetch_assoc();
        echo '<li class="w-100 list-group-item container">' .
        '<div class="row">';
        foreach($firstRow as $column=>$value){
          echo '<div class="col-sm text-center font-weight-bold">' .
          $column .
          '</div>'; 
        }
        echo '</div>' .
        '<div class="row">';
        foreach($firstRow as $column=>$value){
          echo '<div class="col-sm text-center">' .
          $value .
          '</div>'; 
        }
        echo '</div>';
        while($result_row = $result->fetch_assoc()){
          echo '<li class="w-100 list-group-item container">' .
          '<div class="row">';
          foreach($result_row as $attribute=>$attribute_value) {
            echo '<div class="col-sm text-center">' .
            $attribute_value .
            '</div>'; 
          }
          echo '</div>';
        }
        echo '</div>';
      }else if(!$result){
        echo 'Error while running this query. </br></br>';
      } else if($result == 1){
        echo 'The query has executed successfully! </br></br>';
      } else if($result == 0){
        echo '0 results found. </br></br>';
      }

      CloseCon($conn);
    }
  }
?>

</div>