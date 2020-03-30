<div class="row">
    <?php
    $conn = OpenCon();

    $sql = "SELECT * FROM Treatments";
    $result = $conn->query($sql);

    $todayDate = date("Y-m-d");

    if ($result->num_rows > 0) {
        echo '<h3>' . 'Treatments' . '</h3>';
        echo '<div class="col-sm-11 my-5">';
        while ($appointments = $result->fetch_assoc()) {

            echo '<li class="w-100 list-group-item container">' .
                '<div class="row">' .
                '<div class="col-sm text-center font-weight-bold">' .
                $appointments['name'] .
                '</div>' .
                '<div class="col-sm text-center">' .
                $appointments['cost'] . ' $' .
                '</div>' .
                '</div>';
        }
        echo
            '</li>';
    } else {
        echo "0 clinics found";
    }

    CloseCon($conn);
    ?>

</div>