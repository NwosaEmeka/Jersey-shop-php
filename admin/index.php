<?php
session_start();
require_once "../config/pdo.php";

if (isset($_POST["login"])) {
  if (empty(trim($_POST['email'])) || empty(trim($_POST['password']))) {
    $_SESSION['admin_login_err'] = "Please complete the login info";
    header("Location: index.php");
    return;

  } else {
    //connect to database, pull the usename and check if it is in the database
    //unset the current user
    //set section to username and go to display product
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = :email AND password = :password");
    $stmt->execute(array(
      ':email'=> $_POST['email'],
      ':password' => $_POST['password']
    ));
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
    $currentAdmin = array(
      'admin_id' => $rows['admin_id'],
      'admin_name' => $rows['name']
    );
    if(empty($rows)){
      $_SESSION['admin_login_err'] = "Email or password is incorrect";
      header("Location: index.php");
      return;
    }
    else{
      unset($_SESSION['currentAdmin']); //log out previous admin
      $_SESSION['currentAdmin']= $currentAdmin;
      header("Location: products.php");
      return;
    }
  }
}

$admin = isset($_SESSION['currentAdmin']) ? $_SESSION['currentAdmin'] : "";
if (!empty($admin)) {
  header("Location: products.php");
  return;
} else { 
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Admin Panel</title>
</head>

<body>
  <div class="form__container">
    <h1 class="header__text">ADMIN LOGIN</h1>
    <div class="form__wrapper-login">

      <form method="POST" class="form__login">
        <?php
        $errmsg = isset($_SESSION['admin_login_err']) ? $_SESSION['admin_login_err'] : "";
        if (!empty($errmsg)) {
          echo ("<span class='errMsg'> $errmsg </span>");
          unset($_SESSION['admin_login_err']);
        }
        ?>
        <div class="form__element">
          <label for="email">Email: </label>
          <input type="email" name="email" id="email" class="form_input">
        </div>
        <div class="form__element">
          <label for="password">Password: </label>
          <input type="password" name="password" id="password" class="form_input">
        </div>
        <input type="submit" value="Login" name="login" class="btn btn__login">
      </form>
    </div>
  </div>
</body>

</html>

<?php }

?>