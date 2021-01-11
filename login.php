<?php
// if already signed in redirect to the homepage
//else login and direct to homepage
session_start();
include_once "./config/pdo.php";

if (isset($_POST['login'])) {
  if (empty(trim($_POST['email'])) || empty(trim($_POST['pswd']))) {
    $_SESSION["login_err"] = "Email or password cannot be blank";
    header("Location: login.php");
    return;
  } else {
    // fetch data from database
    $sql = "SELECT * FROM customers WHERE email = :email AND pswd = :pswd";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':email' => $_POST['email'],
      ':pswd' => $_POST['pswd']
    ));

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($user)) {
      $_SESSION["login_err"] = "Invalid login, check email and password";
      header("Location: login.php");
      return;
    } else {
      // unset the current user and set the user as logged in
      // set user id, firstname, last name and email
      $currentUser = array(
        'user_fname' => $user['fname'],
        'user_lname' => $user['lname'],
        'user_email' => $user['email'],
        'userId' => $user['customer_id']
      );

      unset($_SESSION['currentUser']);
      $_SESSION['currentUser'] = $currentUser;
      header("Location: index.php");
    }
    $stmt = null;
    //header location
  }
}
?>

<!-- Prevent logged in user from accessing the login page -->
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
  <title>EMS JERSEY | Login</title>

  <?php
    include_once "header.php"
    ?>
  <div class="form__container">
    <h3 class="section__header">Welcome, Please Login</h3>
    <div class="form__wrapper-login">

      <form method="POST" class="form__login">
        <?php
          $errmsg = isset($_SESSION['login_err']) ? $_SESSION['login_err'] : "";
          if (!empty($errmsg)) {
            echo ("<span class='errMsg'> $errmsg </span>");
            unset($_SESSION['login_err']);
          }
          ?>
        <div class="form__element">
          <label for="email">Email: </label>
          <input type="email" name="email" id="email" class="form_input">
        </div>
        <div class="form__element">
          <label for="password">Password: </label>
          <input type="password" name="pswd" id="password" class="form_input">
        </div>
        <input type="submit" value="Login" name="login" class="btn btn__login">
      </form>
      <p class="form_text">Not A member? <a href="register.php" class="btn_link">Register</a></p>
    </div>
  </div>
  </body>

</html>

<?php } ?>