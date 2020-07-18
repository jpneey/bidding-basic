<?php defined('included') || die("Bad request"); ?>

<form action="<?= $BASE_DIR ?>controller/controller.bidding.php?action=add" class="add-form" method="POST" enctype="multipart/form-data" >
<div class="col s12 white page z-depth-1">
    <div class="row content">
        <div class="col s12">
            <div class="row">
                <div class="col s12">
                    <label>Home > My > Dashboard > Add</label>
                    <h1>Add New Bidding</h1>
                    <p>Post Details:</p>
                </div>
            
                <div class="input-field no-margin col s12 m6">
                    <p><label>Enter Bidding Title</label></p>
                    <input 
                        required 
                        type="text" 
                        name="cs_bidding_title" 
                        class="custom-input validate"  
                    />
                </div>

                <div class="input-field no-margin col s12 m6 tooltipped" data-position="bottom" data-tooltip="No spaces and must contain text and dashes(-) only.">
                    <p><label>Enter Post Permalink</label></p>
                    <input 
                        required 
                        type="text" 
                        name="cs_bidding_permalink" 
                        class="custom-input validate" 
                        placeholder="sample-good-permalink" 
                    />
                </div>
                <div class="input-field col s12">
                    <p>
                        <label>Post Details</label>
                    </p>
                    <textarea 
                        required
                        name="cs_bidding_details"
                        class="materialize-textarea custom-input"></textarea>
                </div>
                <div class="input-field no-margin col s12">
                    <p>
                        <label>Enter up to five(5) tags.<br></label>
                        <label>* single word only. To add tags, just enter your tag text and press enter. You can delete them by clicking on the close icon or by using your delete button.</label>
                    </p>
                    <div class="chips myChip custom-input">
                        <input 
                            name="cs_bidding_tags" 
                            class="custom-input validate" 
                        />
                    </div>
                </div>

                <div class="col s12">
                    <p>Product Details:</p>
                </div>

                <div class="input-field no-margin col s12 m4 tooltipped" data-position="bottom" data-tooltip="* each post expires after seven(7) days.">
                    <p>
                        <label>Date Needed</label>
                    </p>
                    <input 
                        required 
                        type="text" 
                        name="cs_bidding_date_needed" 
                        class="custom-input datepicker validate"  
                    />
                </div>

                <div class="file-field input-field no-margin col s12 m8">
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

                <div class="input-field no-margin col s12 m4">
                    <p><label>Item Needed</label></p>
                    <input 
                        required 
                        type="text" 
                        name="cs_bidding_product" 
                        class="custom-input validate"  
                    />
                </div>

                <div class="input-field no-margin col s6 m2 tooltipped" data-position="bottom" data-tooltip="ie: kg, pcs, in">
                    <p><label>Unit</label></p>
                    <input 
                        required 
                        type="text" 
                        name="cs_bidding_product_unit" 
                        class="custom-input validate"  
                    />
                </div>

                <div class="input-field no-margin col s6 m2 tooltipped" data-position="bottom" data-tooltip="* whole number only">
                    <p><label>Qty</label></p>
                    <input 
                        required 
                        type="number" 
                        name="cs_bidding_product_qty" 
                        class="custom-input validate" 
                        min="0" 
                        step="1" 
                        oninput="validity.valid||(value='');" 
                        pattern=" 0+\.[0-9]*[1-9][0-9]*$"  
                    />
                </div>

                <div class="input-field no-margin col s12 m4">
                    <p><label>Budget</label></p>
                    <input 
                        required 
                        type="number" 
                        name="cs_bidding_product_price" 
                        class="custom-input validate"  
                        min="0.00" 
                        max="10000.00" 
                        step="0.01"
                    />
                </div>

                <div class="input-field no-margin col s12">
                    <p>
                        <label>
                            <input required type="checkbox" />
                            <span>Terms and Conditions</span>
                        </label>
                    </p>
                    <input type="submit" class="btn z-depth-1 orange white-text" value="Add New Posting" />
                </div>

                
            </div>
        </div>
    </div>
</div>
</form>
<script src="<?php echo $BASE_DIR ?>static/js/services/services.addbid.js" type="text/javascript"></script>
