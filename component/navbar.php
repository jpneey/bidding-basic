<div class="navbar-fixed">
    <nav>
        <div class="wrapper nav-wrapper">
            <a href="<?php echo $BASE_DIR ?>" class="brand-logo left">
                <img src="<?php echo $BASE_DIR ?>static/asset/logo.png" alt="Site Logo" />
            </a>
            <ul class="right hide-on-med-and-down">
                
            </ul>
            <ul class="right hide-on-med-and-up show-on-medium-and-down">
                <li>
                    <a href="#!" data-target="profile-nav" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                </li>
            </ul>
        </div>
    </nav>
</div>

<ul id="profile-nav" class="sidenav sidenav-fixed">
    <li class="navbar-fixed"></li>
    <?php

        require 'view/view.sidenav.php';
        $detailArray = array(
            $isLoggedIn,
            $isBidder, 
            $loggedInUserAvatar,
            $loggedInUserName,
            $loggedInUserEmail,
            $BASE_DIR
        );

        $sideNav = new sideNav($detailArray);
        $sideNav->loadSideNav();

    ?>
</ul>