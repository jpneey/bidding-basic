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

<ul id="slide-out" class="sidenav sidenav-fixed">
    <li class="navbar-fixed"></li>
    <?php

        if(!$isLoggedIn){
            require 'view/view.login.php';
        } else {
            require 'view/view.profile.php';
        }

    ?>
</ul>