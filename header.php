<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
  integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
<!-- end of font awsome cdn -->
<link rel="stylesheet" href="style.css">

</head>

<body>
  <div class="header">
    <nav class="nav__bar">
      <a href="index.php" class="logo">EMS</a>
      <ul class="nav__items">
        <?php
        $cart_count = isset($_SESSION['cart']) ? count(array_keys($_SESSION['cart'])) : 0;
        $user = isset($_SESSION['currentUser']) ? $_SESSION['currentUser'] : "";
        if (empty($user)) { ?>

        <li><a href="login.php" class="gray-text">Login</a></li>
        <li><a href="register.php" class="gray-text">SignUp</a></li>
        <?php } else { ?>
        <li><span class="blue-text">Hi!, <?php echo $user['user_fname']; ?></span></li>
        <li><a href="logout.php" class="gray-text">Logout</a></li>
        <li><a href="orders.php" class="gray-text">Orders</a></li>
        <?php
        }
        ?>
        <li class="cart-list">
          <a href="cart.php" class="cart">
            <i class="fas fa-shopping-cart"></i>
          </a>
          <!-- will hold the number of items in the session -->
          <span><?php echo $cart_count; ?></span>
        </li>
      </ul>
    </nav>
  </div>