<div class="newClass">

<?php
  $sqlQuery = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["sqlQuery"])) {
      $sqlQuery = "";
    } else {
      $sqlQuery = $_POST["sqlQuery"];
     
      $conn = OpenCon();

      echo "<h4>Your Input:</h4>";
      echo $sqlQuery;
      echo "</br></br>";

      $result = $conn->query($sqlQuery);

      echo "<h4>Query Result: </h4>";

      if ($result->num_rows > 0) {
        
        while($result_row = $result->fetch_assoc()){
          echo '<li class="w-100 list-group-item container">' .
          '<div class="row">';
          foreach($result_row as $attribute=>$attribute_value) {
            echo '<div class="col-sm text-center">' .
            $attribute_value .
            '</div>'; 
          }
          echo '</div>';
        }
      }else{
        echo "0 Results Found.";
      }

      CloseCon($conn);
    }
  }
?>

<h3>Advanced Search</h3>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  SQL Query: <textarea name="sqlQuery" rows="5" cols="40"><?php echo $sqlQuery;?></textarea>
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>

</div>