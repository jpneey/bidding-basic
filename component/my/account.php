<?php 

defined('included') || die("Bad request"); 

$message = Sanitizer::filter('p', 'get');

$newUser = (empty($loggedInUserRole)) ? true : false;
$loggedInUserDetail = $user->getUser($__user_id, "cs_user_detail");

?>

<form action="<?= $BASE_DIR ?>controller/controller.user.php?action=update<?php if($newUser) { echo "&redir=1"; } ?>" class="user-form" method="POST" enctype="multipart/form-data" >
<div class="col s12 white page z-depth-1">
    <div class="row content">
        <div class="col s12">
            <div class="row">
                <div class="col s12">
                    <label><a class="grey-text" href="<?= $BASE_DIR ?>">Home</a> > My > Account</label>
                    <h1><b>My Account</b></h1>
                    <?php if($newUser){ 
                        $pw = Sanitizer::filter('pw', 'get');
                    ?>
                    <p>Please fill in the required fields inorder to finish the registration process.</p>
                    <?php } ?>
                </div>
                
                <div class="file-field input-field no-margin col s12">
                    <img src="<?= $BASE_DIR . "static/asset/user/" .$loggedInUserAvatar ?>" alt="dp" id="profile_pic" />
                </div>
            
                <div class="file-field input-field no-margin col s12">
                    <p><label>Logo / Display Picture </label></p>
                    <div class="btn">
                        <span>Image</span>
                        <input  
                            name ="cs_user_avatar"
                            type="file" 
                            id="loglog"
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
                        type="password" 
                        name="cs_user_password" 
                        class="custom-input validate"
                        placeholder="my-secret"  
                        <?php if($newUser){ ?>
                        value="<?= $pw ?>"
                        readonly
                        <?php } ?>

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
                        <optgroup label="Product/Service Provider">
                            <option value="2">I would like to participate on biddings and promote my services</option>
                        </optgroup>
                        <optgroup label="Client/Purchaser">
                            <option value="1">I would like to find suppliers and post biddings.</option>
                        </optgroup>
                    </select>
                </div>

                <?php } ?>
                <div class="input-field no-margin col s12">
                <br>
                <br>
                    <input type="submit" class="btn z-depth-1 orange white-text" value="Update Profile" />
                </div>

                <div class="input-field no-margin col s12">
                <br>
                <div class="divider"></div>
                <br>
                <button type="button" data-target="delete-account" class="waves-effect btn modal-trigger red white-text z-depth-0">Delete My Account</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>



<div id="delete-account" class="modal modal-sm">
    <div class="modal-content">
        <form action="<?= $BASE_DIR ?>controller/controller.user.php?action=delete-user<?php if($newUser) { echo "&redir=1"; } ?>" class="user-form" method="POST" enctype="multipart/form-data" >
            <p><b>Account Deletion</b></p>
            <p>Deleting your account is instant. Please proceed with caution. Plans, transactions, bidding or offers will be deleted permanently.However, your ratings on other canvasspoint users will remain untouched.</p>
            <input 
            required 
            type="password" 
            name="cs_user_password" 
            class="custom-input validate"
            placeholder="your password"  
            <?php if($newUser){ ?>
            value="<?= $pw ?>"
            readonly
            <?php } ?>
            />
            <button type="submit" class="waves-effect red btn">Delete Account</button>
            <a href="#!" class="modal-close modal-confirm  green white-text waves-effect btn-flat">Cancel</a>
        </form>
    </div>
</div>
<script src="<?php echo $BASE_DIR ?>static/js/services/services.user.js?v=69" type="text/javascript"></script>
