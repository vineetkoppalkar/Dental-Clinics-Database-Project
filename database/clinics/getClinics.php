<div class="row">
  <?php
  $conn = OpenCon();

  $sql = "SELECT * FROM DentalClinics";
  $result = $conn->query($sql);

  $todayDate = date("Y-m-d");

  if ($result->num_rows > 0) {
    while ($clinic = $result->fetch_assoc()) {
      echo '<div class="col-sm-4 my-3">' .
        '<div class="card">' .
        '<div class="card-body">' .
        '<h5 class="card-title">' . $clinic['name'] . '</h5>' .
        '<p class="card-text">' . $clinic['address'] . '<br />' . $clinic['phoneNumber']  . '</p>' .
        '<a href="/templates/clinics/clinic.php?clinicId=' . $clinic['clinicId'] . '&date=' . $todayDate .
        '" class="btn btn-outline-primary">Details</a>' .
        '</div>' .
        '</div>' .
        '</div>';
    }
  } else {
    echo "0 clinics found";
  }

  CloseCon($conn);
  ?>

</div>