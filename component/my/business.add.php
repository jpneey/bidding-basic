<?php 

defined('included') || die("Bad request");

require_once "model/model.business.php"; 
require_once "view/view.business.php"; 
require_once "model/model.category.php";
require_once "view/view.category.php";

$viewCategory = new viewCategory($BASE_DIR, $conn);
$viewBusiness = new viewBusiness($BASE_DIR, $conn);

$business = new Business($conn);

$userBusiness = $business->getUserBusiness($__user_id);

$product = unserialize($userBusiness[5]);
if(empty($product)){
    $product[1] = '';
    $product[2] = '';
    $product[3] = '';
    $product[4] = '';
}
ob_start();
$viewCategory->optionCategories();
$optionCategory = ob_get_clean();
?>

<div class="col s12 white page z-depth-1">
    <div class="row content">
        <div class="col s12">
            <form action="<?= $BASE_DIR ?>controller/controller.business.php?action=update" class="add-form" method="POST" enctype="multipart/form-data" >
            <div class="row">
                <div class="col s12">
                    <label><a class="grey-text" href="<?= $BASE_DIR ?>">Home</a > > My > Business</label>
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
                    <?= $optionCategory ?>
                    </select>
                </div>

                <div class="input-field no-margin col s12">
                    <br>
                    <input type="submit" class="btn z-depth-0 orange white-text" value="Update Business" />
                </div>
            </div>
            </form>
        </div>

        <div class="col s12">
            <div class="row" id="products">
                <div class="col s12">
                    <p><label>Featured Products</label></p>
                    <?php if(!empty($loggedInAccountType)){ ?>
                    <form action="<?= $BASE_DIR ?>controller/controller.business.php?action=product" class="add-form" method="POST" enctype="multipart/form-data" >
                        <div id="add-product-pro" class="modal modal-sm">
                            <div class="modal-content">
                                
                                <div class="row">   
                                    <div class="input-field no-margin col s12">
                                        <p><label>Product / Service Name</label></p>
                                        <input 
                                            required 
                                            type="text" 
                                            name="cs_product_name" 
                                            class="custom-input validate"
                                            placeholder="Product Name"  
                                        />
                                    </div>
                                    <div class="input-field no-margin col s12">
                                        <p><label>Category</label></p>
                                        <select 
                                            required 
                                            name="cs_category_id" 
                                            class="custom-input validate browser-default"  
                                        >
                                        <option 
                                            value="<?= $userBusiness[7] ?>"  
                                        >Selected</option>
                                        <?= $optionCategory ?>
                                        </select>
                                    </div>

                                    <div class="input-field no-margin col s12">
                                        <p><label>Product Details </label></p>
                                        <textarea required name="cs_product_details" class="custom-input materialize-textarea"></textarea>
                                    </div>

                                    <div class="file-field input-field no-margin col s12">
                                        <p><label>Product Image </label></p>
                                        <div class="btn">
                                            <span>Image</span>
                                            <input
                                                required
                                                name ="cs_product_image"
                                                type="file"
                                                accept="image/*">
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input class="file-path validate custom-input" type="text" placeholder="*.png, *.jpg">
                                        </div>
                                    </div>
                                    
                                    <div class="input-field no-margin col s12">
                                        <p><label>Unit of Selling</label></p>
                                        <input 
                                            required 
                                            type="text" 
                                            name="cs_unit" 
                                            class="custom-input validate"
                                            placeholder="box / pack / kilos"  
                                        />
                                    </div>
                                    <div class="input-field no-margin col s12">
                                        <p><label>Product / Service price</label></p>
                                        <input required type="number" name="cs_product_price" class="custom-input validate" min="0.00" step="0.01" placeholder="0.0000">
                                    </div>

                                    <div class="input-field no-margin col s12">
                                        <p><label>Sale price (leave blank if not on sale)</label></p>
                                        <input type="number" name="cs_sale_price" class="custom-input validate" min="0.00" step="0.01" placeholder="0.0000">
                                    </div>

                                </div>    

                                <input type="submit" class="btn z-depth-0 orange white-text" value="Add Product" />
                                <a href="#!" class="modal-close red white-text waves-effect btn-flat">Cancel Submission</a>
                            </div>
                        </div>
                    </form>
                    <div id="update-product" class="modal modal-sm">
                        <div class="modal-content">
                            <form action="<?= $BASE_DIR ?>controller/controller.business.php?action=product-update" class="add-form" method="POST" enctype="multipart/form-data" >
                            <div class="row">   
                                <div class="input-field no-margin col s12">
                                    <p><label>Product / Service Name</label></p>
                                    <input 
                                        required 
                                        type="text" 
                                        name="cs_product_name" 
                                        class="custom-input validate"
                                        placeholder="Product Name"
                                        id="edit-name"  
                                    />
                                    <input type="hidden" name="cs_product_id" id="edit-id" required />
                                </div>
                                <div class="input-field no-margin col s12">
                                    <p><label>Category</label></p>
                                    <select 
                                        required 
                                        name="cs_category_id" 
                                        class="custom-input validate browser-default"
                                        id="edit-category"  
                                    >
                                    <option 
                                        value="<?= $userBusiness[7] ?>"  
                                    >Selected</option>
                                    <?= $optionCategory ?>
                                    </select>
                                </div>

                                <div class="input-field no-margin col s12">
                                    <p><label>Product Details </label></p>
                                    <textarea 
                                    id="edit-details"
                                    required name="cs_product_details" class="custom-input materialize-textarea"></textarea>
                                </div>
                                
                                <div class="input-field no-margin col s12">
                                    <p><label>Unit of Selling</label></p>
                                    <input 
                                        required 
                                        type="text" 
                                        name="cs_unit" 
                                        class="custom-input validate"
                                        placeholder="box / pack / kilos"  
                                        id="edit-unit"  

                                    />
                                </div>
                                <div class="input-field no-margin col s12">
                                    <p><label>Product / Service price</label></p>
                                    <input 
                                    id="edit-price"  
                                    required type="number" name="cs_product_price" class="custom-input validate" min="0.00" step="0.01" placeholder="0.0000">
                                </div>

                                <div class="input-field no-margin col s12">
                                    <p><label>Sale price (leave blank if not on sale)</label></p>
                                    <input 
                                    id="edit-sale"
                                    type="number" name="cs_sale_price" class="custom-input validate" min="0.00" step="0.01" placeholder="0.0000">
                                </div>

                            </div>    
                            <input type="submit" class="btn z-depth-0 orange white-text" value="Update Product" />
                            </form>
                            <br>
                            <div class="divider"></div>
                            <br>
                            <form action="<?= $BASE_DIR ?>controller/controller.business.php?action=product-image" class="add-form" method="POST" enctype="multipart/form-data" >
                            <div class="row">   
                                <div class="file-field input-field no-margin col s12">
                                    <p><label>Product Image </label></p>
                                    <div class="btn">
                                        <span>Image</span>
                                        <input
                                            required
                                            name ="cs_product_image"
                                            type="file"
                                            accept="image/*">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate custom-input" type="text" placeholder="*.png, *.jpg">
                                    </div>
                                    <input type="hidden" name="cs_product_id" id="edit-id-img" required />
                                    <input type="hidden" name="cs_product_old_image" id="edit-image" required />

                                </div>
                            </div>
                            
                            <input type="submit" class="btn z-depth-0 orange white-text" value="Update Image" />
                            <a href="#!" class="modal-close red white-text waves-effect btn-flat">Cancel</a>
                            </form>
                        </div>
                    </div>
                    <form action="<?= $BASE_DIR ?>controller/controller.business.php?action=product-delete" class="add-form" method="POST" enctype="multipart/form-data" >
                        <div id="delete-product" class="modal modal-sm">
                            <div class="modal-content">
                                <p><b>Product Deletion.</b></p>
                                <p>Press 'delete' below to confirm this item's deletion.</p>
                                <input type="hidden" name="to-d" id="to-d" required />
                                <a href="#!" class="modal-close orange white-text waves-effect btn-flat">Cancel</a>
                                <input type="submit" class="btn z-depth-0 red white-text" value="Delete" />
                            </div>
                        </div>
                    </form>
                    <?php 
                        $viewBusiness->viewBusinessProducts($__user_id);
                        } else {
                    ?>
                    <div class="card-panel grey lighten-4 z-depth-0">
                        <p><b>Upgrade to pro</b></p>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Delectus accusantium quisquam, rem asperiores quo minima animi! Perspiciatis eum cumque eius. Impedit, sint delectus! Voluptatum optio a ea corporis alias? Quibusdam?</p>
                        <a href="#upgrade-to-pro" class="modal-trigger"><span class="chip chip white-text orange darken-2">Upgrade</span></a>
                    </div>
                    <?php } ?>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script src="<?php echo $BASE_DIR ?>static/js/services/services.product.js?v=5sss" type="text/javascript"></script>
<script src="<?php echo $BASE_DIR ?>static/js/services/services.addbid.js?v=beta-1" type="text/javascript"></script>