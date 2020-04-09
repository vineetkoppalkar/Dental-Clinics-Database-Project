<div class="row">
  <?php
  $conn = OpenCon();

  $appointmentId = $_GET['appointmentId'];
  $sql = "SELECT  Treatments.treatmentId, name, cost
          FROM    Treatments, TreatmentPerformed
          WHERE   TreatmentPerformed.appointmentId = $appointmentId AND
                  Treatments.treatmentId = TreatmentPerformed.treatmentId;";

  $result = $conn->query($sql);

  echo '<h6 class="w-100">Treatments performed</h6>';
  if ($result->num_rows > 0) {
    echo '<ul class="w-100 mb-5 list-group">';
    while ($treatment = $result->fetch_assoc()) {
      echo '<li class="w-100 list-group-item container">' .
              '<div class="row">' .
                '<div class="col-sm text-center font-weight-bold">' .
                  $treatment['name'] .
                '</div>' .
                '<div class="col-sm text-center">' .
                  "$". $treatment['cost'] .
                '</div>' .
              '</div>' .
            '</li>';
    }
    echo '</ul>';
  } else {
    echo '<p class="w-75 mx-auto">0 treatments performed</p>';
  }

  CloseCon($conn);
  ?>
</div>