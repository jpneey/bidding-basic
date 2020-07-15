<li>
    <div class="user-view ">
        <div class="background grey lighten-5">
        </div>
        <a href="#user">
            <img class="circle" src="<?php echo $BASE_DIR.'static/asset/user/'.$loggedInUserAvatar; ?>" alt="<?php echo $loggedInUserName.'\'s'; ?> avatar" />
        </a>
        <a href="#name"><span class="grey-text name"><?php echo $loggedInUserName; ?></span></a>
        <a href="#email"><span class="grey-text email">jdandturk@gmail.com</span></a>
    </div>
</li>

<li><a href="#!">Second Link</a></li>
<li><div class="divider"></div></li>
<li><a class="subheader">Subheader</a></li>
<li><a class="waves-effect" href="#!">Third Link With Waves</a></li>

<li>
    <a class="waves-effect" href="<?php echo $BASE_DIR ?>logout/"><i class="material-icons right">exit_to_app</i><b>Sign out</b></a>
</li>
