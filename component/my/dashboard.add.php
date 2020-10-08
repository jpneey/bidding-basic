<?php 

defined('included') || die("Bad request");
require_once "model/model.location.php";
require_once "view/view.location.php";
require_once "model/model.category.php";
require_once "view/view.category.php";
$category = new Category();
$viewCategory = new viewCategory($BASE_DIR);
$location = new Location();
$viewLocation = new viewLocation($BASE_DIR); 

?>

<form action="<?= $BASE_DIR ?>controller/controller.bidding.php?action=add" class="add-form" method="POST" enctype="multipart/form-data" >
<div class="col s12 white page z-depth-1">
    <div class="row content">
        <div class="col s12">
            <div class="row">
                <div class="col s12">
                    <label>Home > My > Dashboard > Add</label>
                    <h1><b>Add New Bidding</b></h1>
                </div>
            
                <div class="input-field no-margin col s12 m8">
                    <p><label>Item Needed</label></p>
                    <input 
                        required 
                        type="text" 
                        name="cs_bidding_title" 
                        class="custom-input validate"  
                    />
                </div>
                
                <div class="input-field no-margin col s12 m4">
                    <p><label>Location</label></p>
                    <select 
                        required 
                        type="text" 
                        name="cs_bidding_location" 
                        class="custom-input validate browser-default"  
                    >
                    <?php 
                        $viewLocation->optionLocation(2);
                    ?>
                    </select>
                </div>
                <div class="input-field col s12 no-margin">
                    <p>
                        <label>Post Details</label>
                    </p>
                    <textarea 
                        required
                        name="cs_bidding_details"
                        class="materialize-textarea custom-input"></textarea>
                </div>
                
                <div class="input-field col s12 m6 no-margin">
                    <p>
                        <label>Category<br></label>
                    </p>
                    <select 
                        required 
                        type="text" 
                        name="cs_bidding_category_id" 
                        class="custom-input validate browser-default"  
                    >
                    <?php 
                        $viewCategory->optionCategories();
                    ?>
                    </select>
                    
                    <input 
                        required
                        name="cs_bidding_tags"
                        type="hidden"
                        value="1"
                    />
                </div>

                

                <div class="file-field input-field col s12 m6 no-margin">
                    <p><label>Product Image (optional)</label></p>
                    <div class="btn">
                        <span>Image</span>
                        <input  
                            name ="cs_bidding_picture"
                            type="file" 
                            accept="image/*">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate custom-input" type="text" placeholder="*.png, *.jpg and less then 1mb.">
                    </div>
                </div>
                
                <!-- <div class="input-field no-margin col s12">
                    <br>
                    <div class="chips myChip chips-autocomplete custom-input no-margin"></div>
                    <input 
                        required
                        name="cs_bidding_tags"
                        type="hidden"
                        id="tags"
                    />
                </div> -->

                <div class="input-field col s12 m7 no-margin">
                    <p>
                        <label>Date Needed<br>* each post expires after seven(7) days</label>
                    </p>
                    <input 
                        required 
                        type="text" 
                        name="cs_bidding_date_needed" 
                        class="custom-input datepicker validate"  
                    />
                </div>

                <div class="input-field col s12 m5 tooltipped no-margin" data-position="bottom" data-tooltip="ie: kg, pcs, in">
                    <p><label>&nbsp;<br>Unit of Measure</label></p>
                    <input 
                        required 
                        type="hidden" 
                        name="cs_product_name"  
                        value="1"
                    />
                    <input 
                        required 
                        autocomplete="off"
                        type="text" 
                        name="cs_product_unit" 
                        class="custom-input validate autocomplete input-field"
                        id="cs_product_unit"  
                    />
                    <script>
                        $(function(){
                            $('#cs_product_unit').autocomplete({
                                    minLength: 1,
                                    limit: 3,
                                    data: {
                                        "pcs": null,
                                        "kg": null,
                                        "cm": null,
                                        "oz": null,
                                        "ft": null,
                                        
                                    },
                                });
                            $('#cs_product_unit').on('keyup', function(){
                                $(this).autocomplete('open');
                            })
                            termsModal();
                        });

                        function termsModal(){
                            $('#terms').on('change', function(){
                                $('#terms-modal').modal();
                                $('#terms-modal').modal('open');
                            })
                        }
                    </script>
                </div>

                <div class="input-field no-margin col s12 m4 tooltipped" data-position="bottom" data-tooltip="* whole number only">
                    <p><label>Quantity</label></p>
                    <input 
                        required 
                        type="number" 
                        name="cs_product_qty" 
                        class="custom-input validate" 
                        min="0" 
                        step="1" 
                        oninput="validity.valid||(value='');" 
                        pattern=" 0+\.[0-9]*[1-9][0-9]*$"  
                    />
                </div>

                <div class="input-field no-margin col s12 m8">
                    <p><label>Total Budget</label></p>
                    <input 
                        required 
                        type="number" 
                        name="cs_product_price" 
                        class="custom-input validate"  
                        min="0.00" 
                        max="50000.00" 
                        step="0.01"
                    />
                </div>

                <div class="input-field no-margin col s12">
                    <p>
                        <label>
                            <input required type="checkbox" class="filled" id="terms"/>
                            <span>Terms and Conditions</span>
                        </label>
                    </p>
                    <button type="submit" class="btn z-depth-1 orange white-text">Post Bidding</button>
                </div>

                <div id="terms-modal" class="modal">
                    <div class="modal-content">
                        <p><b>Terms & Conditions</b></p>
                        <p>Lorem ipsum dotor sit amet Quisque vel ligula a velit fringilla euismod. Nulla facilisi. Donec vehicula mollis arcu a consequat. Praesent rhoncus rhoncus velit at hendrerit. Praesent porttitor quam ut ante ullamcorper volutpat. In a convallis elit. Ut posuere blandit est, ut congue libero sagittis id. Nulla orci enim, varius sed pretium eleifend, laoreet congue orci. Etiam tempor urna a ex auctor, posuere pellentesque sem varius. Donec magna leo, maximus eu risus eget, sodales fringilla eros. Mauris hendrerit augue at turpis dapibus, nec condimentum lorem vestibulum.</p>
                        <a href="#!" class="waves-effect modal-close waves-green btn">I agree</a>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
</div>
</form>
<script src="<?php echo $BASE_DIR ?>static/js/services/services.addbid.js?v=beta-69ers" type="text/javascript"></script>
