<?php 

defined('included') || die("Bad request"); 
$loggedInUserName = $user->getUser($__user_id, "cs_user_name");
$loggedInEmailAddress = $user->getUser($__user_id, "cs_user_email");

?>

<form action="<?= $BASE_DIR ?>controller/controller.user.php?action=update" class="user-form" method="POST" enctype="multipart/form-data" >
<div class="col s12 white page z-depth-1">
    <div class="row content">
        <div class="col s12">
            <div class="row">
                <div class="col s12">
                    <label>Home > My > Account</label>
                    <h1><b>My Account</b></h1>
                </div>
            
                <div class="input-field no-margin col s12 m6">
                    <p><label>User Name</label></p>
                    <input 
                        required 
                        type="text" 
                        name="cs_user_name" 
                        class="custom-input validate"
                        placeholder="<?= $loggedInUserName ?>"  
                        value="<?= $loggedInUserName ?>"
                    />
                </div>
                <div class="input-field no-margin col s12 m6">
                    <p><label>Email Address</label></p>
                    <input 
                        required 
                        type="email" 
                        name="cs_email_address" 
                        class="custom-input validate"
                        placeholder="<?= $loggedInEmailAddress ?>"  
                        value="<?= $loggedInEmailAddress ?>"  
                    />
                </div>

                <div class="file-field input-field no-margin col s12 m8">
                    <p><label>Logo / Display Picture (optional)</label></p>
                    <div class="btn">
                        <span>Image</span>
                        <input  
                            name ="cs_user_avatar"
                            type="file" 
                            accept="image/*">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate custom-input" type="text" placeholder="*.png, *.jpg and less then 1mb.">
                    </div>
                </div>

                <div class="input-field no-margin col s12">
                    <input type="submit" class="btn z-depth-1 orange white-text" value="Update Profile" />
                </div>

                
            </div>
        </div>
    </div>
</div>
</form>
<script src="<?php echo $BASE_DIR ?>static/js/services/services.user.js" type="text/javascript"></script>
