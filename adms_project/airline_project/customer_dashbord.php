<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8">
    <title>AMS</title>
    <link rel="stylesheet" href="style2.css">
    <style>
    a:link, a:visited {
    background-color: #2691d9;
    border-radius: 25px;
    color: white;
    padding: 14px 25px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    }

    a:hover, a:active {
    background-color: skyblue;
    }
  </style>
</head>
<body>
<a href="index.php">HOME</a>
 
<div class="container">
  <h1>FLIGHT DETAILS</h1>
</div>
<div id="mainHolder" style="overflow: auto; max-height: 600px;">
<?php
  $conn = oci_connect('ADMS', 'tiger', '//localhost/XE');   
  if (!$conn) {
    echo 'Failed to connect to oracle' . "<br>";
  }

  $stid = oci_parse($conn, 'SELECT * FROM FLIGHT ');
  oci_execute($stid);
  echo "<table border='1'>
  <tr>
      <th>FLIGHT_ID</th>
      <th>DEPARTURE</th>
      <th>DESTINATION</th>
      <th>DEPARTURE_TIME</th>
      <th>ARRIVAL_TIME</th>
      <th>FLIGHT_COST</th>
      <th>FLIGHT_CLASS</th>
  </tr>";

  while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
  echo "<tr>";
  echo "<td>" . $row['FLIGHT_ID'] . "</td>";
  echo "<td>" . $row['DEPARTURE'] . "</td>";
  echo "<td>" . $row['DESTINATION'] . "</td>";
  echo "<td>" . $row['DEPARTURE_TIME'] . "</td>";
  echo "<td>" . $row['ARRIVAL_TIME'] . "</td>";
  echo "<td>" . $row['FLIGHT_COST'] . "</td>";
  echo "<td>" . $row['FLIGHT_CLASS'] . "</td>";
  echo "</tr>";
  }
  echo "</table>\n";       
?>    
</div>  
<!--another -->
<div class="center">    
  <form method="post">
    <div class="txt_field">
      <input type="text" name="flight_id" required>
      <label>Flight Id</label>
    </div>

    <div class="txt_field">
      <input type="text" name="user_id" required>
        <label>User Id</label>
      </div>

      <div class="txt_field">
        <input type="text" name="no_ticket" required>
        <label>Number of tickets </label>
      </div>

      <input type="submit" value="BOOK FLIGHT" name="submit">
    </form>
</div>      

<?php
    if (isset($_POST['submit'])) {
      $flight_id=$_POST["flight_id"];
      $user_id = $_POST["user_id"];
      $no_ticket = $_POST["no_ticket"];
      
      $query="insert into TICKET values (seq_ticket_id.NEXTVAL, '$no_ticket', 'pending','$user_id')";
      $stid = oci_parse($conn, $query);
    
      $query1="insert into BOOKING values (seq_booking_id.NEXTVAL,'$user_id','$flight_id')";
      $stid1 = oci_parse($conn, $query1);
    
      if (!$stid or !$stid1) {
        $m = oci_error($conn);
        trigger_error('Could not parse statement: '. $m['message'], E_USER_ERROR);
        header("refresh: 0");
      }
      
      $r = oci_execute($stid );
      $r1 =oci_execute($stid1);
      if (!$r or !$r1) {
        $m = oci_error($stid);
        trigger_error('Could not execute statement: '. $m['message'], E_USER_ERROR);
        $m1 = oci_error($stid1);
        trigger_error('Could not execute statement: '. $m1['message'], E_USER_ERROR);
        header("refresh: 0");
      }
      else{
        echo '<script>alert("Booking status pending. Waiting for payment")</script>';
      }
    }      
    oci_free_statement($stid);
    oci_close($conn);
    ?>   
</body>
</html>