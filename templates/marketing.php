<div class="row marketing">
  <div class="col-lg-6">
    <?php
    $conn = OpenCon();
    echo "<h4>Patients</h4>";

    $sql = "SELECT * FROM Patients";
    $result = $conn->query($sql);

    echo "<br /><br />";

    if ($result->num_rows > 0) {
      // output data of each row
      while ($row = $result->fetch_assoc()) {
        echo $row["patientId"] . " " . $row["name"] . " " . $row["address"] . " " . $row["phoneNumber"] . "<br />";
      }
    } else {
      echo "0 results";
    }
    CloseCon($conn);
    ?>
  </div>

  <div class="col-lg-6">
    <h4>Subheading</h4>
    <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>

    <h4>Subheading</h4>
    <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>

    <h4>Subheading</h4>
    <p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
  </div>
</div>