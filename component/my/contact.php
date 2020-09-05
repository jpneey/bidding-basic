<?php 

defined('included') || die("Bad request"); 

$message = Sanitizer::filter('p', 'get');

$contact = unserialize($user->getUser($__user_id, "cs_contact_details"));


?>

<form action="<?= $BASE_DIR ?>controller/controller.user.php?action=update-contact" class="user-form" method="POST" enctype="multipart/form-data" >
<div class="col s12 white page z-depth-1">
    <div class="row content">
        <div class="col s12">
            <div class="row">
                <div class="col s12">
                    <label><a class="grey-text" href="<?= $BASE_DIR ?>">Home</a> > My > Contact</label>
                    <h1><b>Contact Details</b></h1>
                </div>

                <div class="input-field no-margin col s12">
                    <p><label>Facebook page link</label></p>
                    <input 
                        type="url" 
                        name="cs_facebook" 
                        class="link-trigger custom-input validate"
                        placeholder="https://facebook.com/your-page"
                        value="<?= ($contact) ? $contact['cs_facebook'] : '' ?>"
                    />
                    <a href="<?= ($contact && $contact['cs_facebook']) ? $contact['cs_facebook'] : '#!' ?>" target="_blank" class="btn blue darken-4 url-checker"><i class="material-icons">open_in_new</i></a>
                </div>

                <div class="input-field no-margin col s12">
                    <p><label>Linkedin link</label></p>
                    <input 
                        type="url" 
                        name="cs_linkedin" 
                        class="link-trigger custom-input validate"
                        placeholder="https://linkedin.ph/in/company-name"
                        value="<?= ($contact) ? $contact['cs_linkedin'] : '' ?>"
                    />
                    <a href="<?= ($contact && $contact['cs_linkedin']) ? $contact['cs_linkedin'] : '#!' ?>" target="_blank" class="btn blue darken-1 url-checker"><i class="material-icons">open_in_new</i></a>
                </div>

                <div class="input-field no-margin col s12">
                    <p><label>Website link</label></p>
                    <input 
                        type="url" 
                        name="cs_website" 
                        class="link-trigger custom-input validate"
                        placeholder="https://yourwebsite.com"
                        value="<?= ($contact) ? $contact['cs_website'] : '' ?>"
                    />
                    <a href="<?= ($contact && $contact['cs_website']) ? $contact['cs_website'] : '#!' ?>" target="_blank" class="btn url-checker"><i class="material-icons">open_in_new</i></a>
                </div>

                <div class="input-field no-margin col s12 m6">
                    <p><label>Telephone Number</label></p>
                    <input 
                        type="number" 
                        name="cs_telephone" 
                        class="custom-input validate"
                        placeholder="xxxxxxxxx"
                        value="<?= ($contact) ? $contact['cs_telephone'] : '' ?>"
                    />
                </div>

                <div class="input-field no-margin col s12 m6">
                    <p><label>Mobile Number</label></p>
                    <input 
                        type="number" 
                        name="cs_mobile" 
                        class="custom-input validate"
                        placeholder="xxxxxxxxx"
                        value="<?= ($contact) ? $contact['cs_mobile'] : '' ?>"
                        
                    />
                </div>

                <div class="input-field no-margin col s12 m8">
                    <p><label>Current Password *</label></p>
                    <input 
                        required 
                        type="text" 
                        name="cs_user_password" 
                        class="custom-input validate"
                        placeholder="my-secret"  
                    />
                </div>

                
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
