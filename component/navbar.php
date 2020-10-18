<?php

require_once "model/model.notification.php";
require_once "view/view.search.php";
$search = new Search($BASE_DIR, 'bid');
if($isLoggedIn) {
    $notification = new Notification($__user_id);
    $unread = $notification->getUnread();
}


?>
<div class="navbar-fixed">
    <nav class="z-depth-0">
        <div class="wrapper nav-wrapper">
            <a href="<?= $BASE_DIR ?>" class="brand-logo left">
                <img src="<?= $BASE_DIR ?>static/asset/logo.png" alt="Site Logo" />
            </a>
            <ul class="right">
                <li><a href="<?= $BASE_DIR ?>blogs/" class="hide-on-med-and-down">Blog</a></li>
                <li><a href="<?= $BASE_DIR ?>home/" class="hide-on-med-and-down">Biddings</a></li>
                <li><a href="<?= $BASE_DIR ?>home/?sidebar=0" class="hide-on-med-and-down">Login</a></li>
                <li><a href="<?= $BASE_DIR ?>product/" class="hide-on-med-and-down">Products</a></li>
                <li><a href="#!" data-target="menu-nav" class="sidenav-trigger no-margin"><i class="material-icons">menu</i></a></li>
                <?php if($isLoggedIn) { ?>
                <li><a href="#!" data-target="notification-nav" class="sidenav-trigger show-on-large no-margin"><i class="material-icons">notifications_none</i></a> 
                    <?php if($unread) { ?>
                        <span class="unread"><?= $unread ?></span>
                    <?php } ?>
                </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
</div>

<ul id="menu-nav" class="sidenav darknav z-depth-0">
    <li class="navbar-fixed"></li>
    <li >
        <a href="#!"></a>
    </li>
    <li class="hide-on-med-and-up show-on-medium-and-down"><a href="<?= $BASE_DIR ?>blogs/">Blog</a></li>
    <li class="hide-on-med-and-up show-on-medium-and-down"><a href="<?= $BASE_DIR ?>home/">Biddings</a></li>
    <li class="hide-on-med-and-up show-on-medium-and-down"><a href="<?= $BASE_DIR ?>home/?sidebar=0">Login</a></li>
    <li class="hide-on-med-and-up show-on-medium-and-down"><a href="<?= $BASE_DIR ?>product/">Products</a></li>
                
</ul>

<ul class="bottom-bar white no-margin z-depth-0 hide-on-med-and-up show-on-medium-and-down row">
    <li class="col s3">
        <a href="#!" data-target="profile-nav" class="sidenav-trigger grey-text text-darken-1 block"><i class="material-icons">menu</i></a>
        <p class="no-margin grey-text text-darken-1"><b>Account</b></p>
    </li>
    <li class="col s3">
        <a href="<?= $BASE_DIR ?>home/" class="grey-text text-darken-1 block"><i class="material-icons">playlist_add</i></a>
        <p class="no-margin grey-text text-darken-1"><b>Biddings</b></p>
    </li>
    
    <li class="col s3">
        <a href="<?= $BASE_DIR ?>product/" class="grey-text text-darken-1 block"><i class="material-icons">shopping_bag</i></a>
        <p class="no-margin grey-text text-darken-1"><b>Products</b></p>
    </li>
    
    <li class="col s3">
        <a href="<?= $BASE_DIR ?>blogs/" class="grey-text text-darken-1 block"><i class="material-icons">inbox</i></a>
        <p class="no-margin grey-text text-darken-1"><b>Blog</b></p>
    </li>
</ul>
<?php if($isLoggedIn) { ?>
    <ul id="notification-nav" class="sidenav grey lighten-3">
        <li class="navbar-fixed"></li>
        <li class="white">
            <a class="waves-effect mark-as-read"><i class="material-icons left">notes</i><b>Mark All as read</b></a>
        </li>
        
        <li class="notif-panel">
        <?php 
        $unreadNotifs = $notification->getUnread(false);
        if(!empty($unreadNotifs)) {
            foreach($unreadNotifs as $key=>$value){ ?>
            <span class="mark-this-read" data-del="<?= $unreadNotifs[$key]['cs_notif_id'] ?>" ><?= $unreadNotifs[$key]['cs_notif'] ?><br>
                <time class="timeago" datetime="<?= $unreadNotifs[$key]['cs_added'] ?>" title="<?= $unreadNotifs[$key]['cs_added'] ?>"><?= $unreadNotifs[$key]['cs_added'] ?></time>
            </span>
        <?php }
        } ?>
        </li>
        <li class="notif-panel read">
        <?php 
        $readNotifs = $notification->getRead(false);
        if(!empty($readNotifs)) {
            foreach($readNotifs as $key=>$value){ ?>
            <span><?= $readNotifs[$key]['cs_notif'] ?><br>
                <time class="timeago" datetime="<?= $readNotifs[$key]['cs_added'] ?>" title="<?= $readNotifs[$key]['cs_added'] ?>"><?= $readNotifs[$key]['cs_added'] ?></time>
            </span>
        <?php }
        } ?>
        </li>
    </ul>
<?php } ?>
<ul id="profile-nav" class="sidenav sidenav-fixed z-depth-0">
    <li class="navbar-fixed"></li>
    <?php

        $sideChip = '<span class="chip chip white-text grey lighten-1">Free</span>';
        $sideChip .= ' <a href="#upgrade-to-pro" class="modal-trigger" ><span class="chip chip white-text orange darken-2">Upgrade to pro</span></a>';

        if($isLoggedIn){
            if(!empty($loggedInAccountType)){
                $sideChip = '<span class="chip orange white-text">Premium User</span>';
            }
        }

        $mode = (isset($_GET['sidebar'])) ? $_GET['sidebar'] : '0';
        require 'view/view.sidenav.php';
        $detailArray = array(
            $isLoggedIn,
            $isBidder, 
            $loggedInUserAvatar,
            $loggedInUserName,
            $loggedInUserEmail,
            $BASE_DIR,
            $mode,
            $sideChip
        );

        $sideNav = new sideNav($detailArray);
        $sideNav->loadSideNav();

    ?>
</ul>

<div id="load-wrap">
    <div id="onload">
        <div class="preloader-wrapper small active abs">
            <div class="spinner-layer">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
    </div>
</div>