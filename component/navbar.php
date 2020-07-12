<div class="navbar-fixed">
    <nav>
        <div class="container">
            
            <a href="<?php echo $BASE_DIR ?>" class="brand-logo left">
                <img src="<?php echo $BASE_DIR ?>static/asset/logo.png" alt="Site Logo" />
            </a>
            <ul id="nav-mobile" class="right">
                <li><a href="<?php echo $BASE_DIR ?>account/"></a></li>
                <li><a class="dropdown-trigger" href="#!" data-target="my-account">My account<i class="material-icons right">arrow_drop_down</i></a></li>
            </ul>

        </div>
        
    </nav>
</div>

<ul id='my-account' class='dropdown-content'>
    <?php
        if($isLoggedIn){
            echo '<li><a href="'.$BASE_DIR.'my-account" class="normal-text">My Account</a></li>';
            echo '<li><a href="'.$BASE_DIR.'logout" class="normal-text">Logout</a></li>';
        } else {
            echo '<li><a href="'.$BASE_DIR.'#!" class="grey-text lighten-3 normal-text">Register</a></li>';
            echo '<li><a href="#login" class="black-text normal-text modal-trigger">Login</a></li>';
        }
    ?>
</ul>

<div id="login" class="modal">
    <form action="<?php echo $BASE_DIR ?>controller/controller.login.php?mode=login" class="login-form" method="POST" enctype="multipart/form-data" >
        <div class="modal-content row">
            <div class="input-field col s12 m5">
                <h3><b>Welcome Back.</b></h3>
                <p>We've missed you. We'll love to have you back.</p>
            </div>
            <div class="col s12 m7">
                <div class="input-field col s12">
                    <input placeholder="your@email.address" id="email" name="cs_ems" type="email" class="validate prefilled" required />
                    <label for="email">Email Address</label>
                </div>
                <div class="input-field col s12">
                    <input placeholder="******" id="password" name="cs_pas" type="password" class="validate prefilled" required />
                    <label for="password">Password</label>
                </div>
                <div class="input-field col s12">
                    <button type="submit" value="submit" class="btn normal-text waves-effect waves-light orange darken-1 white-text">&emsp14;Login&emsp14;</button>
                </div>
            </div>
        </div>
    </form>
</div>