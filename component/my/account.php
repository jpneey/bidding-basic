<?php 

defined('included') || die("Bad request"); 

$message = Sanitizer::filter('p', 'get');

$newUser = (empty($loggedInUserRole)) ? true : false;
$loggedInUserDetail = $user->getUser($__user_id, "cs_user_detail");

?>

<form action="<?= $BASE_DIR ?>controller/controller.user.php?action=update" class="user-form" method="POST" enctype="multipart/form-data" >
<div class="col s12 white page z-depth-1">
    <div class="row content">
        <div class="col s12">
            <div class="row">
                <div class="col s12">
                    <label><a class="grey-text" href="<?= $BASE_DIR ?>">Home</a> > My > Account</label>
                    <h1><b>My Account</b></h1>
                    <?php if($newUser){ ?>
                    <p>Please fill in the required fields inorder to finish the registration process.</p>
                    <?php } ?>
                </div>
            
                <div class="file-field input-field no-margin col s12">
                    <p><label>Logo / Display Picture </label></p>
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
                    <p><label>User Name *</label></p>
                    <input 
                        required 
                        type="text" 
                        name="cs_user_name" 
                        class="custom-input validate"
                        placeholder="<?= $loggedInUserName ?>"  
                        value="<?= $loggedInUserName ?>"
                    />
                </div>
                <div class="input-field no-margin col s12">
                    <p><label>Profile Intro *</label></p>
                    <textarea required name="cs_user_detail" class="custom-input materialize-textarea"><?= $loggedInUserDetail ?></textarea>
                </div>
                <div class="input-field no-margin col s12">
                    <p><label>Current Password *</label></p>
                    <input 
                        required 
                        type="text" 
                        name="cs_user_password" 
                        class="custom-input validate"
                        placeholder="my-secret"  
                    />
                </div>

                <?php if($newUser){ ?>
                       
                <div class="input-field no-margin col s12">
                    <p><label>New Password *</label></p>
                    <input 
                        required 
                        type="text" 
                        name="cs_new_password" 
                        class="custom-input validate"
                        min="5"
                        placeholder="* please fill this field to secure your account"
                    />
                </div>           
                <div class="input-field no-margin col s12">
                    <p><label>Account Type *</label></p>
                    <select required name="account-type" class="custom-input validate browser-default">
                        <option value="0" disabled selected>Choose your option</option>
                        <option value="2">I would like to participate on biddings and promote my services</option>
                        <option value="1">I would like to find suppliers and post biddings.</option>
                    </select>
                </div>

                <?php } ?>
                <div class="input-field no-margin col s12">
                <br>
                <br>
                    <input type="submit" class="btn z-depth-1 orange white-text" value="Update Profile" />
                </div>

                
            </div>
        </div>
    </div>
</div>
</form>
<script src="<?php echo $BASE_DIR ?>static/js/services/services.user.js" type="text/javascript"></script>
