<div class="">
  <?php

  function getMissedStatus($appointmentId) {
    $conn = OpenCon();

    $sql = "SELECT  ReceivedBy.isMissed
            FROM    ReceivedBy
            WHERE   ReceivedBy.appointmentId = $appointmentId";
    $result = $conn->query($sql);
    $isMissed = $result->fetch_assoc()['isMissed'];

    CloseCon($conn);
    return $isMissed;
  }

  function getPaidStatus($appointmentId) {
    $conn = OpenCon();

    $sql = "SELECT  billId
            FROM    TreatmentPerformed
            WHERE   appointmentId = $appointmentId
            GROUP BY appointmentId;";
    $result = $conn->query($sql);
    $billId = intval($result->fetch_assoc()['billId']);

    $sql = "SELECT  Bills.isPaid
            FROM    Bills
            WHERE   Bills.billId = $billId";
    $result = $conn->query($sql);
    $isPaid = $result->fetch_assoc()['isPaid'];

    CloseCon($conn);
    return $isPaid;
  }

  $appointmentId = $_GET['appointmentId'];
  $isMissed = getMissedStatus($appointmentId);
  $isPaid = getPaidStatus($appointmentId);

  echo '<form class="m-5">
          <div class="form-check my-2">';

          if ($isMissed) {
            echo '<input name="missed" type="checkbox" value="missed-true" class="form-check-input" checked>';
          } else {
            echo '<input name="missed" type="checkbox" value="missed-true" class="form-check-input">';
          }

  echo      '<label class="form-check-label" for="missed">Missed</label>
          </div>
          <div class="form-check my-2">';

          if ($isPaid) {
            echo '<input name="paid" type="checkbox" value="paid-true" class="form-check-input" checked>';
          } else {
            echo '<input name="paid" type="checkbox" value="paid-true" class="form-check-input">';
          }

  echo      '<label class="form-check-label" for="paid">Paid</label>
          </div>
          <button type="submit" class="btn btn-outline-info">Save</button>
        </form>';

  ?>

<script>
    const updateMissedPaid = (isMissed, isPaid, appointmentId) => {
      const formData = new FormData();
      formData.append("isMissed", isMissed);
      formData.append("isPaid", isPaid);
      formData.append("appointmentId", appointmentId);

      fetch('../../database/appointments/updateMissedPaid.php', {
        method: 'POST',
        body: formData
      }).then(response => {
       window.location.href = `appointment.php?appointmentId=${appointmentId}`;
      }).catch(error => {
        console.log("Fetch error while updating missed and paid appointment status");
        console.log(error);
      });
    };

    const handleOnSubmit = (event) => {
      event.preventDefault();

      const isMissed = event.target[0].checked;
      const isPaid = event.target[1].checked;

      const urlParams = new URLSearchParams(window.location.search);
      const appointmentId = urlParams.get('appointmentId');
      
      updateMissedPaid(isMissed, isPaid, appointmentId);
    };

    const form = document.getElementsByTagName('form')[0];
    form.addEventListener('submit', handleOnSubmit);
  </script>

</div>