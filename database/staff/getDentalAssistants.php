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
            WHERE   isDentist = False AND
                    Professionals.professionalId = ProfessionalAt.dentistId AND
                    ProfessionalAt.clinicId = DentalClinics.clinicId";

    $result = $conn->query($sql);

    $todayDate = date("Y-m-d");

    if ($result->num_rows > 0) {
        while ($dentalAssistant = $result->fetch_assoc()) {
            echo  '<div class="col-sm-4 my-3">' .
                    '<div class="card">' .
                      '<div class="card-body">' .
                        '<h5 class="card-title">' . $dentalAssistant['name'] . '</h5>' .
                        '<p class="card-text">' .
                          'Dental Assistant' .
                          '<br />' . 
                          $dentalAssistant['phoneNumber']  .
                        '</p>' .
                        '<a href="dentalAssistant.php?professionalId=' . $dentalAssistant['professionalId'] . '&date=' . $todayDate .
                        '" class="btn btn-outline-primary">Details</a>' .
                      '</div>' .
                    '</div>' .
                  '</div>';
        }
    } else {
      echo "<p class='ml-5 my-5'>0 dental assistants found</p>";
    }

    CloseCon($conn);
    ?>

</div>