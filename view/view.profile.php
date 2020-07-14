<li class="banner grey lighten-5">
    <span class="z-depth-1 white ">
        <img src="<?php echo $BASE_DIR.'static/asset/user/'.$loggedInUserAvatar; ?>" alt="<?php echo $loggedInUserName.'\'s'; ?> avatar" />
    </span>
</li>
<li class="banner-user-name center-align">
    <span><?php echo $loggedInUserName ?></span>
</li>
<li class="logout">
    <a class="margin-auto waves-effect waves-light btn normal-text"><?php echo $loggedInUserName ?></a>
</li>

<li class="logout">
    <a href="<?php echo $BASE_DIR ?>logout/" class="margin-auto waves-effect waves-light btn normal-text">Logout</a>
</li>