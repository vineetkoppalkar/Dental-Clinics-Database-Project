<?php
	include 'db_connection.php';
?>

<HTML>
<HEAD>
   <TITLE>Date/Time Functions Demo</TITLE>
</HEAD>
<BODY>
	<H1>Date/Time Functions Demo</H1>

	<?php
		$conn = OpenCon();
		echo "Connected Successfully";
		
		$sql = "SELECT * FROM Patients";
		$result = $conn->query($sql);		
		
		echo "<br /><br />";	   	
	
		if ($result->num_rows > 0) {
  		  // output data of each row
    		  while($row = $result->fetch_assoc()) {
        		echo $row["id"] . " " . $row["name"] . " " . $row["address"] . " " . $row["phoneNumber"] . "<br />";
    		  }
		} else {
    			echo "0 results";
		}
		CloseCon($conn);
	?>

	<P>The current date and time is
	<EM><?echo date("D M d, Y H:i:s", time())?></EM>
	<P>Current PHP version:
	<EM><?echo  phpversion()?></EM>
</BODY>
</HTML>