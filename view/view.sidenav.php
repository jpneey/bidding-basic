<?php 

defined('included') || die("Bad request"); 

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
        return $this->loadLoginForm($this->detailArray[6]);
    }

    public function loadProfile(){
        ?>
        <li>
            <div class="user-view ">
                <div class="background grey lighten-3">
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
            <?php
        }
        ?>
        <li>
            <a class="waves-effect" href="<?= $this->detailArray[5] ?>my/dashboard/">Dashboard</a>
        </li>
        <li><div class="divider"></div></li>
        <li>
            <a class="waves-effect" href="<?= $this->detailArray[5] ?>my/">My Account</a>
        </li>

        <li>
            <a class="waves-effect" href="<?= $this->detailArray[5] ?>logout/"><i class="material-icons right">exit_to_app</i><b>Sign out</b></a>
        </li>
        <?php

    }

    public function loadLoginForm($mode){

        switch($mode){
            case '1':
                $action = 'forgot';
                $h3 = 'Oh No!';
                $p = 'Lost password?<br>Let\'s send you a password reset link!';
                $buttonText = 'Send Reset link';
                break;
            case '2':
                $action = 'register';
                $h3 = 'Register';
                $p = 'Enter a reachable<br>Email Address';
                $buttonText = 'Confirm my Email';
                break;
                
            default:
                $action = 'login';
                $h3 = 'Login';
                $p = 'and maximize<br>your experience.';
                $buttonText = 'Login';
        }

        ?>
        <li class="login valign">
            <ul>
                <form action="<?= $this->detailArray[5] ?>controller/controller.login.php?mode=<?= $action ?>" class="login-form" method="POST" enctype="multipart/form-data" >
                <li class="text">
                    <h3><b><?= $h3 ?></b></h3><p><?= $p ?></p>
                </li>
                <li>
                    <input required name="cs_ems" placeholder="email-address" type="email" class="custom-input browser-default no-border grey lighten-4">
                </li>
                <?php if(empty($mode)){ ?>
                <li>
                    <input required name="cs_pas" placeholder="password" type="password" class="custom-input browser-default no-border grey lighten-4">
                </li>
                <?php } ?>
                <li>
                    <input name="submit" type="submit" value="<?= $buttonText ?>" class="browser-default submit no-border orange white-text">
                </li>
                <?php if(empty($mode)){ ?>
                <li class="row">
                    <label class="col s8 padding-0"><a href="<?= $this->detailArray[5] ?>/home/?sidebar=1" class="grey-text">Forgot password</a></label>
                    <label class="col s4 padding-0 right-align"><a href="<?= $this->detailArray[5] ?>/home/?sidebar=2" class="grey-text">Register</a></label>
                </li>
                <?php } else { ?>
                <li class="row">
                    <label class="col s8 padding-0"><a href="<?= $this->detailArray[5] ?>/home/?sidebar=0" class="grey-text">&#8592; Back to login</a></label>
                </li>
                <?php } ?>
                </form>
            </ul>
        </li>
        <?php
    }


}

// EOF
