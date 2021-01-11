<?php
session_start();
require_once "./config/pdo.php";

if (isset($_POST['register'])) {
  if ($_POST['pswd'] !== $_POST['cpswd']) {
    $_SESSION["register_err"] = "Password does not match";
    header("Location: register.php");
    return;
  } else {
    $credentials = array('fname', 'lname', 'email', 'pswd');
    foreach ($credentials as $credential) {
      if (empty($_POST[$credential])) {
        $_SESSION["register_err"] = "Please fill all fields";
        header("Location: register.php");
        return;
      }
    }

    //connect to database
    $sql = "INSERT INTO customers(fname, lname, email, pswd) VALUES (:fname, :lname, :email,:pswd)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':fname' => $_POST['fname'],
      ':lname' => $_POST['lname'],
      ':email' => $_POST['email'],
      ':pswd' => $_POST['pswd']
    ));
    $id = $pdo->lastInsertId(); //get the customer id of the inserted customer

    $currentUser = array(
      'user_fname' => $_POST['fname'],
      'user_lname' => $_POST['lname'],
      'user_email' => $_POST['email'],
      'userId' => $id
    );

    // unset the current user and set the user as logged in
    unset($_SESSION['currentUser']);
    $_SESSION['currentUser'] = $currentUser;
    header("Location: index.php");

    $stmt = null;
    //redirect
    header("Location: index.php");
  }
}
?>
<?php
$user = isset($_SESSION['currentUser']) ? $_SESSION['currentUser'] : "";
if (!empty($user)) {
  // the admin is not logged in so cannot access this page
  header("Location: index.php");
  return;
} else { ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EMS JERSEY | Register</title>

  <?php
    include_once "header.php"
    ?>

  <div class="form__container">
    <h3 class="section__header">Create your Account</h3>
    <div class="form__wrapper-login">

      <form method="POST" class="form__login">
        <?php
          $errmsg = isset($_SESSION['register_err']) ? $_SESSION['register_err'] : "";
          if (!empty($errmsg)) {
            echo ("<span class='errMsg'> $errmsg </span>");
            unset($_SESSION['register_err']);
          }
          ?>
        <div class="form__element">
          <label for="fname">First Name: </label>
          <input type="text" name="fname" id="fname" class="form_input">
        </div>
        <div class="form__element">
          <label for="lname">Last Name: </label>
          <input type="text" name="lname" id="lname" class="form_input">
        </div>
        <div class="form__element">
          <label for="email">Email: </label>
          <input type="email" name="email" id="email" class="form_input">
        </div>
        <div class="form__element">
          <label for="password">Password: </label>
          <input type="password" name="pswd" id="password" class="form_input">
        </div>
        <div class="form__element">
          <span class="passErr">Password does not match</span>
          <label for="cpassword">Confirm Password: </label>
          <input type="password" name="cpswd" id="cpassword" class="form_input">
        </div>
        <input type="submit" value="Sign Up" name="register" class="btn btn__login">

      </form>
      <p class="form_text">Already a member? <a href="login.php" class="btn_link">Login</a></p>
    </div>
  </div>


  <!-- JS -->
  <script src="app.js"></script>
  </body>

</html>

<?php } ?>