<?php
$admin = isset($_SESSION['currentAdmin']) ? $_SESSION['currentAdmin'] : "";
if (empty($admin)) {
  // the admin is not logged in so cannot access this page
  header("Location: index.php");
  return;
} else { 
?>

<nav style="height:4rem; width:100%; background-color:#333; position:sticky; top:0; padding: 0 2.5rem">
  <ul style="display:flex; align-items:center; justify-content:flex-end; height:100%; width:100%; color: #fff">
    <li>
      <p style="font-weight:600; margin-right:1rem">Welcome: <?php echo $admin['admin_name']; ?></p>
    </li>
    <li>
      <a href="logout.php"
        style="padding:0.3rem 0.5rem; border: 1px solid #ccc; color:#b23b3b; font-weight:600">Logout</a>
    </li>
  </ul>
</nav>
<?php

}
?>