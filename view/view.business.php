<?php

class viewBusiness extends Business {

    private $BASE_DIR;

    public function __construct($BASE_DIR, $conn = null) {
        $this->BASE_DIR = $BASE_DIR;
        if($conn){
            parent::__construct($conn);
        }
    }

    public function load($v){
        return $v;
    }

    public function viewBusinessProducts($user_id){
        $products = $this->getBusinessProducts($user_id);
        $max = $this->getMaxProduct($user_id);
        $total = count($products);
        ?>
        <button type="button" class="btn grey grey-text lighten-4 z-depth-0"><?= $total ?> / <?= $max ?> active products</button>
        <?php if ($total < $max) { ?>                         
        <button type="button" class="waves-effect btn z-depth-0 orange darken-2 white-text modal-trigger" data-target="add-product-pro">Add <i class="right material-icons">add</i></button>                         
        <?php } ?>
        <br><br>            
        <?php
        foreach($products as $key=>$value){             
            $sale = ($products[$key]["cs_sale_price"] < $products[$key]["cs_product_price"]) ? true : false;
            ?>
            <div class="card feed z-depth-0 myproduct">
                <div class="card-image">
                    <img class="lazy" src="<?= $this->BASE_DIR.'static/asset/product/'.$products[$key]["cs_product_image"] ?>" alt="<?= $products[$key]["cs_product_name"] ?>"/>
                    <div class="overlay"></div>
                    <span class="card-title">
                        <small><?= $products[$key]["cs_category_name"] ?></small> 
                        <br>
                        <?= $products[$key]["cs_product_name"] ?>
                    </span>
                </div>
                <div class="card-content on-dashboard">
                    <button type="button" class="waves-effect btn z-depth-0 yellow darken-2 white-text update-product"
                        data-name = "<?= $products[$key]["cs_product_name"] ?>"
                        data-id = "<?= $products[$key]["cs_product_id"] ?>"
                        data-category = "<?= $products[$key]["cs_category_id"] ?>"
                        data-details = "<?= $products[$key]["cs_product_details"] ?>"
                        data-unit = "<?= $products[$key]["cs_unit"] ?>"
                        data-price = "<?= $products[$key]["cs_product_price"] ?>"
                        data-sale = "<?= $products[$key]["cs_sale_price"] ?>"
                        data-image = "<?= $products[$key]["cs_product_image"] ?>"
                    >Update Details</button>                        
                    <button type="button" class="waves-effect btn z-depth-0 red darken-2 white-text delete-product" data-target="<?= $products[$key]["cs_product_id"] ?>"><i class="material-icons">delete</i></button>                         
                </div>
            </div>
            <?php
        }
    }

}