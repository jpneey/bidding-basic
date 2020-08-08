<div class="navbar-fixed">
    <nav>
        <div class="wrapper nav-wrapper">
            <a href="<?php echo $BASE_DIR ?>" class="brand-logo left">
                <img src="<?php echo $BASE_DIR ?>static/asset/logo.png" alt="Site Logo" />
            </a>
            
            <ul class="right">
                <li><a href="#!"><i class="material-icons">menu</i></a></li>
            </ul>
            <ul class="right hide-on-med-and-down">
            <?php
                require_once "view/view.search.php";
                $search = new Search($BASE_DIR, 'bid');
                $search->load($search->searchForm());
            ?>
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
        <a href="<?php echo $BASE_DIR ?>home/" class="grey-text text-darken-1 block"><i class="material-icons">playlist_add</i></a>
        <p class="no-margin grey-text text-darken-1"><b>Biddings</b></p>
    </li>
    
    <li class="col s3">
        <a href="<?php echo $BASE_DIR ?>supplier/" class="grey-text text-darken-1 block"><i class="material-icons">people_outline</i></a>
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

        $mode = (isset($_GET['sidebar'])) ? $_GET['sidebar'] : '0';
        require 'view/view.sidenav.php';
        $detailArray = array(
            $isLoggedIn,
            $isBidder, 
            $loggedInUserAvatar,
            $loggedInUserName,
            $loggedInUserEmail,
            $BASE_DIR,
            $mode
        );

        $sideNav = new sideNav($detailArray);
        $sideNav->loadSideNav();

    ?>
</ul>
<div id="search-bottomsheet" class="modal bottom-sheet">
    <?= $search->load($search->searchForm()) ?>
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