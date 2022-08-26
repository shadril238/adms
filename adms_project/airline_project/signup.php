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
    <div class="center">
      <h1>User Registration</h1>

      <form method="post">
        <div class="txt_field">
          <input type="text" name="name" required>
          <span></span>
          <label>Name</label>
        </div>


        <div class="txt_field">
          <input type="text" name="email" required>
          <span></span>
          <label>Email</label>
        </div>
        <div class="txt_field">
          <input type="password" name="password" required>
          <span></span>
          <label>Password</label>
        </div>

        <div class="txt_field">
          <input type="password" name="cpassword" required>
          <span></span>
          <label>Confirm Password</label>
        </div>

        <div class="txt_field">
          <input type="text" name="phn_no" required>
          <span></span>
          <label>Phon Number</label>
        </div>
        
        <input type="submit" value="Signup" name="submit">
        <div class="signup_link">          
        </div>
      </form>
    </div>

  </body>
</html>

<?php
  if (isset($_POST['submit'])) {
    $name=$_POST["name"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $email = $_POST["email"];
    $phn_no = $_POST["phn_no"];
    
    if($password<>$cpassword){
      echo '<script>alert("Passwords did not matched")</script>';
      header("refresh: 0");
    }
    if(len($password)<4){
      echo '<script>alert("Password too short")</script>';
      header("refresh: 0");
    }
    $conn = oci_connect('ADMS', 'tiger', '//localhost/XE');   
    if (!$conn) {
      $e = oci_error();
      trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    
    $query="insert into CUSTOMER(customer_id, customer_name, customer_pass, customer_email, customer_phn, mgr_id) VALUES (seq_customer_id.NEXTVAL, '$name', '$password', '$email','$phn_no',2)";
    $stid = oci_parse($conn, $query);

    if (!$stid) {
      $m = oci_error($conn);
      trigger_error('Could not parse statement: '. $m['message'], E_USER_ERROR);
    }
    echo '<br>';

    $r = oci_execute($stid);
    if ($r) {
      echo '<script>alert("Sign up done successfully")</script>';
      header("refresh: 0");    
    }
    else{
        $m = oci_error($stid);
        trigger_error('Could not execute statement: '. $m['message'], E_USER_ERROR);
    }
    

    header("refresh: 5; url=signin.php");
    oci_close($conn);
  }
 

?>