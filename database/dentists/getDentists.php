<div class="row">
    <?php
    $conn = OpenCon();

    $sql =  "SELECT Professionals.professionalId, Professionals.isDentist,  Professionals.name,  Professionals.phoneNumber
            FROM Professionals, ProfessionalAt, DentalClinics 
            WHERE isDentist = True AND
            Professionals.professionalId = ProfessionalAt.dentistId AND
            ProfessionalAt.clinicId = DentalClinics.clinicId";

    $result = $conn->query($sql);

    $todayDate = date("Y-m-d");

    if ($result->num_rows > 0) {
        while ($dentists = $result->fetch_assoc()) {
            echo '<div class="col-sm-4 my-3">' .
                '<div class="card">' .
                '<div class="card-body">' .
                '<h5 class="card-title">' . $dentists['name'] . '</h5>' .
                '<p class="card-text">' . $dentists['phoneNumber']  . '</p>' .
                '<a href="/templates/dentists/dentist.php?professionalId=' . $dentists['professionalId'] . '&date=' . $todayDate .
                '" class="btn btn-outline-primary">Details</a>' .
                '</div>' .
                '</div>' .
                '</div>';
        }
    } else {
        echo "0 dentists found";
    }

    CloseCon($conn);
    ?>

</div>