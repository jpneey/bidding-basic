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
                <div class="background">
                </div>
                <a href="#user">
                    <div class="circle img-wrap">
                        <img src="<?= $this->detailArray[5].'static/asset/user/'.$this->detailArray[2] ?>" alt="<?= $this->detailArray[3] ?>'s' avatar" />
                    </div>
                </a>
                <a href="<?= $this->detailArray[5].'user/'.$this->detailArray[3] ?>"><span class="grey-text name"><?= $this->detailArray[3] ?></span></a>
                <a href="#email"><span class="grey-text email" style="padding-bottom: 0"><?= $this->detailArray[4] ?></span></a>
                <?= $this->detailArray[7] ?>
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
        if($this->detailArray[0] && !$this->detailArray[1]) {
            ?>
            <li>
                <a class="waves-effect" href="<?= $this->detailArray[5] ?>my/business/"><i class="material-icons right">folder_open</i><b>My business</b></a>
            </li>  
            <?php
        }
        ?>
        <li>
            <a class="waves-effect" href="<?= $this->detailArray[5] ?>my/dashboard/">My Dashboard</a>
        </li>

        <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
                <li>
                    <a class="collapsible-header" style="padding: 0 32px;">My Account</a>
                    <div class="collapsible-body">
                        <ul>
                            <li>
                                <a class="waves-effect" href="<?= $this->detailArray[5] ?>my/account/">Account Details</a>
                            </li>
                            <li>
                                <a class="waves-effect" href="<?= $this->detailArray[5] ?>my/contact/">Contact Details</a>
                            </li>
                            
                            <li>
                                <a class="waves-effect" href="<?= $this->detailArray[5] ?>my/plan/">My Plan</a>
                            </li>

                        </ul>
                    </div>
                </li>
            </ul>
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
                $p = '';
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
                    <label class="col s8 padding-0"><a href="<?= $this->detailArray[5] ?>home/?sidebar=1" class="grey-text">Forgot password</a></label>
                    <label class="col s4 padding-0 right-align"><a href="<?= $this->detailArray[5] ?>home/?sidebar=2" class="grey-text">Register</a></label>
                </li>
                <?php } else { ?>
                <li class="row">
                    <label class="col s8 padding-0"><a href="<?= $this->detailArray[5] ?>home/?sidebar=0" class="grey-text">&#8592; Back to login</a></label>
                </li>
                <?php } ?>
                </form>
            </ul>
        </li>
        <?php
    }


}

// EOF
