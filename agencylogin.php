<?php

include_once('db.php');
// define variables and set to empty values
$emailErr = $passwordErr = $matchpasswordErr = "";
$email = $password = "" ;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["password"])) {
    $passwordErr = "password is required";
  } else {
    $password = test_input($_POST["password"]);
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
  }

  if($email != "" && $password !=""){

    $enpassword = md5($password);
    ##$enpassword = $password;

    $login_query = "SELECT * FROM agency WHERE ( email = '$email' OR phone = '$email' ) AND password='$enpassword' ";

    $resultCheck = $connection->query($login_query);
    
    $rowCount = $resultCheck->num_rows;
    
    if($rowCount>0){
      $matchpasswordErr = " Login Successful";

      session_start();

      while($rows = mysqli_fetch_assoc($resultCheck)){
        $_SESSION['agency_id'] = $rows['id'];
        $_SESSION['agency_name'] = $rows['branch'];
        $_SESSION['agency_email'] = $rows['email'];
        $_SESSION['agency_phone'] = $rows['phone'];
      }
      
    //   echo $_SESSION['user_id'];
    //   echo $_SESSION['user_name'];
    //   echo $_SESSION['user_email'];
    //   echo $_SESSION['user_phone'];
    //   echo $_SESSION['user_gender'];


      if($_SESSION['agency_name']) {
        header('location: agencydashboard.php');
      }
    }
    else{
        $matchpasswordErr = "Login Unsuccessful";
    }
  }
  

}

function test_input($data) {
    return $data;
  }
?>

<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Agency Login Page</title>
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="css/login.css">
  <link rel="stylesheet" href="css-design/style.css">
  <link rel="stylesheet" href="css/nav.css">
  <link rel="stylesheet" href="css/inputbox.css">
  <style>
.error {color: #FF0000;}



.card {
background-color: #FFFFFF;
width: 450px;
height: 380px;
margin: 7em auto;
border-radius: 1.5em;
box-shadow: 0px 11px 35px 2px rgba(0, 0, 0, 0.14);
}
</style>

</head>

<body>

<header style="background-color:grey;">
  <div class="container">
    <div class="logo">
      <a class="comname" href="index.php">
      <div style="margin-top:30px;margin-left:10px;">Ship<span style="color:FFD500;">It</span>Up </div>
      </a>
      </div>
    <nav>
      <ul>
      <!-- <a href="index.php">Home</a>
      <a href="about.php">About</a>
      <a href="Setting.php">Settings</a> -->
      </ul>
      </nav>
    </div>
  </header> 
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

  <div class="card">
      <p class="sign" align="center">Agency Sign-in</p>
        <p><span class="error"></span></p>

      <div class="form__group" >
        <input type="email" class="form__input" id="email" name="email" placeholder="Email" style="width:260px;" />
        <label for="email" class="form__label">Email</label>
        <span class="error"> <?php echo $emailErr;?></span>
      </div>

      <div class="form__group">
        <input type="password" class="form__input" id="password" name="password" placeholder="Password"  style="width:260px;" />
        <label for="password" class="form__label">Password</label>
        <span class="error"> <?php echo $passwordErr;?></span>
        
        <span class="error"> <?php echo $matchpasswordErr;?></span>
        
      </div>
      <input type="submit" class="submit" name="submit" value="Submit">

      </div>

<!--
  E-mail: <input type="text" name="email">
  <span class="error">* <?php echo $emailErr;?></span>
  <br><br>

  Password: <input type="text" name="password">
  <span class="error">* <?php echo $passwordErr;?></span>
  <br><br>
  <span class="error"> <?php echo $matchpasswordErr;?></span>
  <br><br>-->

  
  <!-- <a href="signup.php">Not a user? Sign up In</a>  -->
  <div class="main1">
        <p class="fontst" align="center"><a href="forgot.php">Forgot Password?</a></p>
        <!-- <p class="fontst" align="center"><a href="signup.php">Sign Up</a></p> -->
        <!-- <p class="fontst" align="center"><a href="adminlogin.php">Login as Previlege user</a></p> -->
      </div>
  </form>

<?php
// echo "<h2>Your Input:</h2>";
// echo $email;
// echo "<br>";
// echo $password;
?>
<footer>
    <div class="container_12">
      <div class="grid_12">
        <div class="f_phone"><span>Call Us:</span> +91 79 23214000</div>
        <div class="socials">
        </div>
        <div class="copy">
          <div class="st1">
          <div class="brand">Ship<span class="color1">It</span>Up </div>
          &copy; 2021	| <a href="https://kalpatarupower.com/5509-2/">Privacy Policy</a> </div> Website designed by <a href="https://kalpatarupower.com/" rel="nofollow">Kalpatarupower.com</a>
        </div>
      </div>
      <div class="clear"></div>
    </div>
    </footer>
</body>
</html>