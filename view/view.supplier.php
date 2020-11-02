<?php

defined('included') || die("Bad request");

class viewSupplier extends Supplier {

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

    public function ViewFeed(){
        
        $products = $this->getProducts();
        if(!empty($products)){
            ?>    
            <script type="text/javascript" src="<?= $this->BASE_DIR ?>static/js/lazy.js"></script>
            <script type="text/javascript" src="<?= $this->BASE_DIR ?>static/js/lazy-init.js"></script>
            <?php
            
            foreach($products as $key=>$value){ 
                $rating = str_repeat('<i class="material-icons orange-text">star</i>', round($products[$key]['cs_owner_rating']));
                
                $sale = ($products[$key]["cs_sale_price"] < $products[$key]["cs_product_price"]) ? true : false;

                ?>
                <a href="<?= $this->BASE_DIR . 'user/' . $products[$key]["cs_user_name"] ?>" class="grey-text text-darken-3">               
                    <div class="card feed z-depth-0 categ-filter"
                    data-category="<?= $products[$key]["cs_category_name"] ?>"
                    >
                        <div class="card-image">
                            
                            <img class="lazy" data-src="<?= $this->BASE_DIR.'static/asset/product/'.$products[$key]["cs_product_image"] ?>" alt="<?= $products[$key]["cs_product_name"] ?>"/>
                            <div class="overlay"></div>
                            <span class="card-title truncate">
                                <small><?= $products[$key]["cs_category_name"] ?></small> 
                                <br>
                                <?= $products[$key]["cs_product_name"] ?>
                                <small class="m-tag orange darken-1">PRODUCT</small>
                            </span>
                        </div>
                        <div class="card-content">
                            <span class="ratings un-pad"><?= $rating ?></span>
                            <p class="truncate un-margin"><?= $products[$key]["cs_product_details"] ?></p>
                            <p>
                                <b>&#8369; <?= ($sale) ? number_format($products[$key]["cs_sale_price"], 2, '.', ',') : number_format($products[$key]["cs_product_price"], 2, '.', ',') ?></b>
                                <?= ($sale) ? '<small><s>'.number_format($products[$key]["cs_product_price"], 2, '.', ',').'</s></small>' : "" ?>
                                <?= " / " . $products[$key]["cs_unit"]  ?>
                            </p>
                        </div>
                    </div>
                </a>

                <?php
            }
        } else {
            ?>
            <div class="card feed z-depth-0">
                <div class="card-content">
                    <p><b>There's nothing here yet.</b></p>
                    <br>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate odit aperiam maxime itaque autem aliquid enim ipsam repellendus quod laboriosam, vel cum unde pariatur debitis tempore temporibus excepturi ut officiis.</p>
                    <br>
                    <p class="sub-title grey-text"><a href="<?= $this->BASE_DIR ?>" class="btn orange white-text z-depth-0">Back to home</a></p>
                </div>
            </div>
            <?php
        }
    }
    
}

//EOF
