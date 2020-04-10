<div class="row">
    <?php
    $conn = OpenCon();

    $sql = "SELECT * FROM Receptionists";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($receptionist = $result->fetch_assoc()) {
            echo  '<div class="col-sm-4 my-3">' .
                    '<div class="card">' .
                      '<div class="card-body">' .
                        '<h5 class="card-title">' . $receptionist['name'] . '</h5>' .
                        '<p class="card-text">' .
                          'Receptionist' .
                          '<br />' . 
                          $receptionist['phoneNumber']  .
                        '</p>' .

                      '</div>' .
                    '</div>' .
                  '</div>';
        }
    } else {
      echo "<p class='ml-5 my-5'>0 receptionists found</p>";
    }

    CloseCon($conn);
    ?>

</div>