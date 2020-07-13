<li class="login valign">
    <ul>
        <form action="<?php echo $BASE_DIR ?>controller/controller.login.php?mode=login" class="login-form" method="POST" enctype="multipart/form-data" >
        <li class="text">
            <h3><b>Login</b></h3><p>and maximize<br>your experience.</p>
        </li>
        <li>
            <input required name="cs_ems" placeholder="email-address" type="email" class="browser-default no-border grey lighten-4">
        </li>
        <li>
            <input required name="cs_pas" placeholder="password" type="password" class="browser-default no-border grey lighten-4">
        </li>
        <li>
            <input name="submit" type="submit" value="Login" class="browser-default submit no-border orange white-text">
        </li>
        </form>
    </ul>
</li>