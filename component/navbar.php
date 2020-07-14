<div class="navbar-fixed">
    <nav>
        <div class="wrapper">
            
            <a href="<?php echo $BASE_DIR ?>" class="brand-logo left">
                <img src="<?php echo $BASE_DIR ?>static/asset/logo.png" alt="Site Logo" />
            </a>
            <ul class="right">
                <li>
                    <a href="#!">Home</a>
                </li>
                <li>
                    <a href="#!">Feed</a>
                </li>
                <li>
                    <a href="#!">My Account</a>
                </li>
            </ul>

        </div>
        
    </nav>
</div>

<ul id="profile-nav" class="sidenav sidenav-fixed">
    <li class="navbar-fixed"></li>
    <?php

        if(!$isLoggedIn){
            require 'view/view.login.php';
        } else {
            require 'view/view.profile.php';
        }
    ?>
</ul>
<ul id="category-nav" class="sidenav sidenav-fixed">
    <li class="navbar-fixed"></li>
    
      <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Dropdown<i class="material-icons">arrow_drop_down</i></a>
            <div class="collapsible-body">
              <ul>
                <li><a href="#!">First</a></li>
                <li><a href="#!">Second</a></li>
                <li><a href="#!">Third</a></li>
                <li><a href="#!">Fourth</a></li>
              </ul>
            </div>
          </li>
        </ul>
    </li>
</ul>