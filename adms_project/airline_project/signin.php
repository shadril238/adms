<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>AMS</title>
    <link rel="stylesheet" href="style.css">
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
  <a href="index.php" >HOME</a>
  <a href="signup.php">Signup</a><br>
    <div class="center">
      <h1>User Login</h1>
      <form method="post">
        <div class="txt_field">
          <input type="number" name="username" required>
          <span></span>
          <label>ID</label>
        </div>
        <div class="txt_field">
          <input type="password" name="password" required>
          <span></span>
          <label>Password</label>
        </div>
        
        <input type="submit" value="Login" name="submit">
        <div class="signup_link">
          <a href="admin_signin.php">Manager Login</a>
        </div>
      </form>
    </div>


<?php
  if (isset($_POST['submit'])) {
    $password = $_POST["password"];
    $user_id = $_POST["username"];

    $conn = oci_connect('ADMS', 'tiger', '//localhost/XE');   
    if (!$conn) {
      $e = oci_error();
      trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    $query = "SELECT CUSTOMER_PASS FROM CUSTOMER WHERE CUSTOMER_ID = '$user_id'";
    $stid = oci_parse($conn, $query);

    if (!$stid) {
      $m = oci_error($conn);
      trigger_error('Could not parse statement: '. $m['message'], E_USER_ERROR);
    }
    echo '<br>';

    $r = oci_execute($stid);
    if (!$r) {
        $m = oci_error($stid);
        trigger_error('Could not execute statement: '. $m['message'], E_USER_ERROR);
    }
    echo '<br>';

    $row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC);

    $check_password= $row['CUSTOMER_PASS'];

    if ($password == $check_password && $password != null) {
      echo '<script>alert("LOGIN SUCCESSFULL")</script>';
      header("refresh: 0; url=customer_dashbord_plsql.php");
    }
    else{
      echo '<script>alert("LOGIN UNSUCCESSFULL. TRY AGAIN.")</script>';
      header("refresh: 0;");
    }

  }
 

?>


</body>
</html>