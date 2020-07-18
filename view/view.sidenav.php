<?php defined('included') || die("Bad request"); 

class sideNav {

    /**
     * @param $detailArray
     * 0 isLoggedIn
     * 1 isBidder
     * 2 loggedInUserAvatar
     * 3 loggedInUserName
     * 4 loggedInUserEmail
     * 5 BASE_DIR
     */

    private $detailArray;

    public function __construct($detailArray = array()){
        return $this->detailArray = $detailArray;
    }

    public function loadSideNav() {
        if($this->detailArray[0]) {
            return $this->loadProfile();
        }
        return $this->loadLoginForm();
    }

    public function loadProfile(){
        ?>
        <li>
            <div class="user-view ">
                <div class="background grey lighten-5">
                </div>
                <a href="#user">
                    <img class="circle" src="<?= $this->detailArray[5].'static/asset/user/'.$this->detailArray[2] ?>" alt="<?= $this->detailArray[3] ?>'s' avatar" />
                </a>
                <a href="#name"><span class="grey-text name"><?= $this->detailArray[3] ?></span></a>
                <a href="#email"><span class="grey-text email"><?= $this->detailArray[4] ?></span></a>
            </div>
        </li>
        <?php
        if($this->detailArray[0] && $this->detailArray[1]) {
            ?>
            <li>
                <a class="waves-effect" href="<?= $this->detailArray[5] ?>my/dashboard/?action=add"><i class="material-icons right">add_circle_outline</i><b>Post new bid</b></a>
            </li>  
            <li>
                <a class="waves-effect" href="<?= $this->detailArray[5] ?>my/dashboard/">Dashboard</a>
            </li>
            <?php
        }
        ?>
        <li><div class="divider"></div></li>
        <li>
            <a class="waves-effect" href="<?= $this->detailArray[5] ?>logout/">My Account</a>
        </li>

        <li>
            <a class="waves-effect" href="<?= $this->detailArray[5] ?>logout/"><i class="material-icons right">exit_to_app</i><b>Sign out</b></a>
        </li>
        <?php

    }

    public function loadLoginForm(){
        ?>
        <li class="login valign">
            <ul>
                <form action="<?= $this->detailArray[5] ?>controller/controller.login.php?mode=login" class="login-form" method="POST" enctype="multipart/form-data" >
                <li class="text">
                    <h3><b>Login</b></h3><p>and maximize<br>your experience.</p>
                </li>
                <li>
                    <input required name="cs_ems" placeholder="email-address" type="email" class="custom-input browser-default no-border grey lighten-4">
                </li>
                <li>
                    <input required name="cs_pas" placeholder="password" type="password" class="custom-input browser-default no-border grey lighten-4">
                </li>
                <li>
                    <input name="submit" type="submit" value="Login" class="browser-default submit no-border orange white-text">
                </li>
                </form>
            </ul>
        </li>
        <?php
    }


}

// EOF
