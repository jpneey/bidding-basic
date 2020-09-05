<?php 

defined('included') || die("Bad request");

require_once "model/model.business.php"; 
require_once "view/view.business.php"; 
require_once "model/model.category.php";
require_once "view/view.category.php";
$category = new Category();
$viewCategory = new viewCategory($BASE_DIR);

$business = new Business();

$userBusiness = $business->getUserBusiness($__user_id);

$product = unserialize($userBusiness[5]);
if(empty($product)){
    $product[1] = '';
    $product[2] = '';
    $product[3] = '';
    $product[4] = '';
}
?>

<form action="<?= $BASE_DIR ?>controller/controller.business.php?action=update" class="add-form" method="POST" enctype="multipart/form-data" >
<div class="col s12 white page z-depth-1">
    <div class="row content">
        <div class="col s12">
            <div class="row">
                <div class="col s12">
                    <label><a class="grey-text" href="<?= $BASE_DIR ?>">Home</a > My > Business</label>
                    <h1><b>My Business</b></h1>
                </div>
            
                <div class="input-field no-margin col s12 m8">
                    <p><label>Business Name</label></p>
                    <input 
                        required 
                        type="text" 
                        name="cs_business_name" 
                        class="custom-input validate"
                        value="<?= $userBusiness[2] ?>"  
                    />
                </div>

                
                <div class="input-field no-margin col s12 m4">
                    <p><label>Business Category</label></p>
                    <select 
                        required 
                        name="cs_business_category" 
                        class="custom-input validate browser-default"  
                    >
                    <option 
                        value="<?= $userBusiness[7] ?>"  
                    >Selected</option>
                    <?php 
                        $viewCategory->optionCategories();
                    ?>
                    </select>
                </div>


                <div class="input-field no-margin col s12">
                    <p>
                        <label>Enter up to five(5) tags.</label>
                    </p>
                </div>
                
                <div class="input-field no-margin col s12">
                    <div class="chips myChip custom-input no-margin">
                        <input 
                            class="custom-input validate"
                        />
                    </div>
                    <input 
                        required
                        name="cs_bidding_tags"
                        type="hidden"
                        id="tags"
                    />
                </div>

                <div class="input-field no-margin col s12">
                    <br>
                    <input type="submit" class="btn z-depth-1 orange white-text" value="Update Business" />
                </div>

                
            </div>
        </div>
    </div>
</div>
</form>
<script src="<?php echo $BASE_DIR ?>static/js/services/services.addbid.js?v=beta-1" type="text/javascript"></script>
<form action="<?= $BASE_DIR ?>controller/controller.business.php?action=update-product" class="add-form" method="POST" enctype="multipart/form-data" >
<div class="col s12 white page z-depth-1">
    <div class="row content">
        <div class="col s12">
            <div class="row">
                <div class="col s12">
                    
                    <div class="col s12">
                        <p><b>Featured Product</b></p>
                    </div>
                    
                    <div class="file-field input-field no-margin col s12 m8">
                        <p><label>Featured Product Image</label></p>
                        <div class="btn">
                            <span>Image</span>
                            <input  
                                name ="cs_featured_image"
                                type="file" 
                                accept="image/*">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate custom-input" type="text" placeholder="*.png, *.jpg and less then 1mb.">
                        </div>
                    </div>

                    <div class="input-field no-margin col s12 m4">
                        <p><label>Featured Product</label></p>
                        <input 
                            required 
                            type="text" 
                            name="cs_product_name" 
                            class="custom-input validate"
                            value="<?= $product[1] ?>"  
                        />
                    </div>

                    <div class="input-field no-margin col s6 m2 tooltipped" data-position="bottom" data-tooltip="ie: kg, pcs, in">
                        <p><label>Unit</label></p>
                        <input 
                            required 
                            type="text" 
                            name="cs_product_unit" 
                            class="custom-input validate" 
                            value="<?= $product[2] ?>"  

                        />
                    </div>

                    <div class="input-field no-margin col s6 m2 tooltipped" data-position="bottom" data-tooltip="* whole number only">
                        <p><label>Qty</label></p>
                        <input 
                            required 
                            type="number" 
                            name="cs_product_qty" 
                            class="custom-input validate" 
                            min="0" 
                            step="1" 
                            oninput="validity.valid||(value='');" 
                            pattern=" 0+\.[0-9]*[1-9][0-9]*$"  
                            value="<?= $product[3] ?>"  
                        />
                    </div>

                    <div class="input-field no-margin col s12 m4">
                        <p><label>Budget</label></p>
                        <input 
                            required 
                            type="number" 
                            name="cs_product_price" 
                            class="custom-input validate"  
                            min="0.00" 
                            max="10000.00" 
                            step="0.01"
                            value="<?= $product[4] ?>"  

                        />
                    </div>
                    <?php if(!empty($product[1])){ ?>
                    
                    <div class="input-field no-margin col s12 m4">
                        <p><label>Remove featured product</label></p>
                        <span data-selector="x" data-mode="featured" class="data-delete btn red white-text">Remove</span>
                    </div>
                    <script src="<?= $BASE_DIR ?>static/js/services/services.delete.js" type="text/javascript"></script> 
                    <?php } ?>

                    <div class="input-field no-margin col s12">
                        <br>
                        <input type="submit" class="btn z-depth-1 orange white-text" value="Update Product" />
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</form>