<div class="row">
    <?php
    $conn = OpenCon();

    $sql = "SELECT  Professionals.professionalId,
                    Professionals.isDentist,
                    Professionals.name,
                    Professionals.phoneNumber
            FROM    Professionals,
                    ProfessionalAt,
                    DentalClinics 
            WHERE   isDentist = True AND
                    Professionals.professionalId = ProfessionalAt.dentistId AND
                    ProfessionalAt.clinicId = DentalClinics.clinicId";

    $result = $conn->query($sql);

    $todayDate = date("Y-m-d");

    if ($result->num_rows > 0) {
        while ($dentist = $result->fetch_assoc()) {
            echo  '<div class="col-sm-4 my-3">' .
                    '<div class="card">' .
                      '<div class="card-body">' .
                        '<h5 class="card-title">' . $dentist['name'] . '</h5>' .
                        '<p class="card-text">' .
                          'Dentist' .
                          '<br />' . 
                          $dentist['phoneNumber']  .
                        '</p>' .
                        '<a href="dentist.php?professionalId=' . $dentist['professionalId'] . '&date=' . $todayDate .
                        '" class="btn btn-outline-primary">Details</a>' .
                      '</div>' .
                    '</div>' .
                  '</div>';
        }
    } else {
      echo "<p class='ml-5 my-5'>0 dentists found</p>";
    }

    CloseCon($conn);
    ?>

</div>