<body>
  <div id="outer-wrapper">
    <div id="wrapper">
      <div class="twoCols-66 nav-bar">
        <div class="col-1">
          <p>Logo header</p>
        </div>
        <div class="col-2">
          <div class="right">
            <?php if (isset($_COOKIE['user']) && basename($_SERVER['PHP_SELF']) != 'logout.inc.php') {
              echo '<div><a href="index.php?pagelet=cus-home" class="action">Home</a></div> | <div>
                    <a href="index.php?pagelet=logout" class="non-action">Logout</a>';
            }else{
                echo '<div><a href="index.php?pagelet=cus-info" class="action">Sign Up</a></div> | <div>
                      <a href="index.php?pagelet=login" class="non-action">Login</a>';
              } 
              ?>
              </div>
          </div>
          <div id="nav-container">
            <ul id="navlist">
              <li><a href="index.php?pagelet=index">Home</a></li>
              <li><a href="index.php?pagelet=about">About</a></li>
              <li><a href="index.php?pagelet=services">Services</a></li>
              <li><a href="index.php?pagelet=contact">Contact</a></li>
              <li><a href="index.php?pagelet=ServiceArea">Service Area</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div id="header">
        <div>
          <p id="header-text">Front Yard Fairways</p>
        </div>
      </div>
      <div id="content">