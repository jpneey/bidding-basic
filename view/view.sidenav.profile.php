<?php defined('included') || die("Bad request"); ?>
<li>
    <div class="user-view ">
        <div class="background grey lighten-5">
        </div>
        <a href="#user">
            <img class="circle" src="<?php echo $BASE_DIR.'static/asset/user/'.$loggedInUserAvatar; ?>" alt="<?php echo $loggedInUserName.'\'s'; ?> avatar" />
        </a>
        <a href="#name"><span class="grey-text name"><?php echo $loggedInUserName; ?></span></a>
        <a href="#email"><span class="grey-text email"><?php echo $loggedInUserEmail; ?></span></a>
    </div>
</li>


<?php if($isLoggedIn && $isBidder) { ?>
<li>
    <a class="waves-effect" href="<?php echo $BASE_DIR ?>home/#!"><i class="material-icons right">add_circle_outline</i><b>Post new bid</b></a>
</li>  
<li>
    <a class="waves-effect" href="<?php echo $BASE_DIR ?>my/dashboard/">Dashboard</a>
</li>
<?php } ?>
<li><div class="divider"></div></li>
<li>
    <a class="waves-effect" href="<?php echo $BASE_DIR ?>logout/">My Account</a>
</li>

<li>
    <a class="waves-effect" href="<?php echo $BASE_DIR ?>logout/"><i class="material-icons right">exit_to_app</i><b>Sign out</b></a>
</li>
