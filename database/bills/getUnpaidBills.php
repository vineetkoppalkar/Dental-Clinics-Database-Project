<div class="row">
    <?php
    $conn = OpenCon();

    $sql = "SELECT Bills.billId, Patients.name as patientName, Bills.amount, Receptionists.name as receptionistName
            FROM Bills, PreparedBy, Patients, Receptionists
            WHERE Bills.isPaid = False AND
                  PreparedBy.billId = Bills.billId AND
                  Patients.patientId = PreparedBy.patientId AND
                  Receptionists.receptionistId = PreparedBy.receptionistId;";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<h3>' . 'Unpaid Bills' . '</h3>';
        echo '<div class="col-sm-11 my-5">';
        echo '<li class="w-100 list-group-item container">' .
                '<div class="row">' .
                '<div class="col-sm text-center font-weight-bold">' .
                'Bill Number' .
                '</div>' .
                '<div class="col-sm text-center font-weight-bold">' .
                'Patient Name' .
                '</div>' .
                '<div class="col-sm text-center font-weight-bold">' .
                'Amount Due' .
                '</div>' .
                '<div class="col-sm text-center font-weight-bold">' .
                'Receptionist Name' .
                '</div>' .
                '</div>';
        while ($unpaidBills = $result->fetch_assoc()) {

            echo '<li class="w-100 list-group-item container">' .
                '<div class="row">' .
                '<div class="col-sm text-center font-weight-bold">' .
                $unpaidBills['billId'] .
                '</div>' .
                '<div class="col-sm text-center">' .
                $unpaidBills['patientName'] .
                '</div>' .
                '<div class="col-sm text-center">' .
                $unpaidBills['amount'] . ' $' .
                '</div>' .
                '<div class="col-sm text-center">' .
                $unpaidBills['receptionistName'] .
                '</div>' .
                '</div>';
        }
        echo
            '</li>';
    } else {
        echo "0 unpaid bills found";
    }

    CloseCon($conn);
    ?>

</div>