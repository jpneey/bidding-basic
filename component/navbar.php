<div class="navbar-fixed">
    <nav>
        <div class="wrapper nav-wrapper">
            <a href="<?= $BASE_DIR ?>" class="brand-logo left">
                <img src="<?= $BASE_DIR ?>static/asset/logo.png" alt="Site Logo" />
            </a>
            <ul class="right hide-on-med-and-down">
                <?php
                    require_once "view/view.search.php";
                    $search = new Search($BASE_DIR, 'bid');
                ?>
            </ul>
            <ul class="right hide-on-med-and-down">
                <li><a href="<?= $BASE_DIR ?>home/">Biddings</a></li>
                <li><a href="<?= $BASE_DIR ?>about/faqs">Faqs</a></li>
                <li><a href="<?= $BASE_DIR ?>supplier/">Suppliers</a></li>
            </ul>
        </div>
    </nav>
</div>


<ul class="bottom-bar white no-margin z-depth-4 hide-on-med-and-up show-on-medium-and-down row">
    <li class="col s3">
        <a href="#!" data-target="profile-nav" class="sidenav-trigger grey-text text-darken-1 block"><i class="material-icons">perm_identity</i></a>
        <p class="no-margin grey-text text-darken-1"><b>Account</b></p>
    </li>
    <li class="col s3">
        <a href="<?= $BASE_DIR ?>home/" class="grey-text text-darken-1 block"><i class="material-icons">playlist_add</i></a>
        <p class="no-margin grey-text text-darken-1"><b>Biddings</b></p>
    </li>
    
    <li class="col s3">
        <a href="<?= $BASE_DIR ?>supplier/" class="grey-text text-darken-1 block"><i class="material-icons">people_outline</i></a>
        <p class="no-margin grey-text text-darken-1"><b>Suppliers</b></p>
    </li>
    
    <li class="col s3">
        <a href="#search-bottomsheet" class="grey-text text-darken-1 block modal-trigger"><i class="material-icons">search</i></a>
        <p class="no-margin grey-text text-darken-1"><b>Search</b></p>
    </li>

</ul>

<ul id="profile-nav" class="sidenav sidenav-fixed">
    <li class="navbar-fixed"></li>
    <?php

        $sideChip = '<span class="chip chip white-text grey lighten-1">Free</span>';
        $sideChip .= ' <a href="'.$BASE_DIR.'about/faqs/#upgrade-to-pro"><span class="chip chip white-text grey lighten-2">Upgrade to pro</span></a>';

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
<ul id="category-nav" class="sidenav">
    <li class="navbar-fixed"></li>

</ul>
<div id="search-bottomsheet" class="modal bottom-sheet">
    <?= $search->searchForm() ?>
</div>
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