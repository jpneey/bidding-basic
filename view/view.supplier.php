<?php

defined('included') || die("Bad request");

class viewSupplier extends Supplier {

    private $BASE_DIR;

    public function __construct($BASE_DIR) {
        $this->BASE_DIR = $BASE_DIR;
    }

    public function load($v){
        return $v;
    }

    public function ViewFeed(){
        $supplier = $this->getSuppliers();
        if(!empty($supplier)){
            foreach($supplier as $key=>$value){
                $rating = str_repeat('<i class="material-icons orange-text">star</i>', round($supplier[$key]['cs_owner_rating']));
                ?>
                <a href="<?= $this->BASE_DIR ?>/supplier/<?= $supplier[$key]['cs_business_link'] ?>">
                    <div class="col s12 m4">
                        <div class="supplier-card white z-depth-1">
                            <div class="logo z-depth-1">
                                <img src="<?= $this->BASE_DIR ?>static/asset/user/<?= $supplier[$key]['cs_business_logo'] ?>" />
                            </div>
                            <div class="content">
                                <div class="title grey-text text-darken-3"><b class="truncate"><?= $supplier[$key]['cs_business_name'] ?></b></div>
                                <div class="sub-title grey-text"><?= $supplier[$key]['cs_business_category'] ?></div>
                                <span class="ratings"><?= $rating ?></span>
                            </div>
                        </div>
                    </div>
                </a>
                <?php
            }
        } else {
            
            $BASE_DIR = $this->BASE_DIR;
            $emptyTitle = "It's quiet in here..";
            $emptyMessage = "Suppliers will appear here, but ufortunately there are no active suppliers right now.";
            require_once "./component/empty.php";
        }
    }

    public function viewSupplier($selector){
        $selector = Sanitizer::filter($selector, 'var');
        $supplier = $this->getSupplier($selector);
        if(!empty($supplier)){
            $title = $supplier[2];
            $rating = str_repeat('<i class="material-icons orange-text">star</i>', round($supplier[12]));
            $tags = preg_split('@,@', $supplier[4], NULL, PREG_SPLIT_NO_EMPTY);
            $tagchip = '';
            foreach($tags as $tag) {
                $tagchip .= '<span class="chip grey lighten-3">'.$tag.'</span>';
            }

        ?>
            <div class="page white z-depth-1">
                <div id="introduction" class="content scrollspy">
                    <label><a href="<?= $this->BASE_DIR ?>" class="grey-text">Home</a> > supplier > <?= $title ?></label>
                    <br>
                    <br>
                    <h1 class="no-margin">
                        <b><?= $title ?></b>
                        <span class="ratings"><?= $rating ?></span>
                    </h1>
                    <p><b>Products & Services</b></p>
                    <p><?= $supplier[10] ?></p>
                    <?= $this->featuredProduct(unserialize($supplier[5])) ?>
                    <div><span class="chip grey lighten-2"><?= $supplier[13] ?></span><?= $tagchip ?></div>
                    <p><b>Contact Details</b></p>
                    <div>
                        <?= $this->contactDetails($supplier[9]) ?>
                        <a href="mailto:<?= $supplier[8] ?>" class="chip teal white-text darken-1" ><?= $supplier[8] ?></a>
                    </div>
                    <?= $this->ratings($supplier[14]) ?>
                </div>
            </div>

            <link href="<?= $this->BASE_DIR ?>static/css/timer.css" type="text/css" rel="stylesheet"/>
            <link href="<?= $this->BASE_DIR ?>static/css/bid.css" type="text/css" rel="stylesheet"/>

        <?php
        }
    }

    public function featuredProduct($products = array()){
        
        if(!empty($products)){
        ?>
        <div class="glance white">
            <?php                
                $item = $products[1];
                $budget = number_format($products[4], '2', '.', ',');
                $qty = $products[3] . ' ' . $products[2];
                $picture = $products[0];
            ?>
            <div class="product-card item">
                <div class="thumbnail">
                    <img id="bidding-details" src="<?= $this->BASE_DIR ?>static/asset/bidding/<?= $picture ?>" class="margin-auto materialboxed" />
                </div>
                <div class="content">
                    <p><b>Featured Product</b></p>
                    <p><?= $item ?> <?= $qty ?></p>
                    <p class="truncate grey-text">₱ <?= $budget ?></p>
                </div>
            </div>
        </div>
    <?php
        }
    }
    
    public function contactDetails($contacts = array()){ 
        if(!empty($contacts)){
            $facebook = (isset($contacts['cs_facebook']) && !empty($contacts['cs_facebook'])) ? $contacts['cs_facebook'] : '#!';
            $linkedin = (isset($contacts['cs_linkedin']) && !empty($contacts['cs_linkedin'])) ? $contacts['cs_linkedin'] : '#!';
            $website = (isset($contacts['cs_website']) && !empty($contacts['cs_website'])) ? $contacts['cs_website'] : '#!';
            
            $telephone = (isset($contacts['cs_telephone']) && !empty($contacts['cs_telephone'])) ? $contacts['cs_telephone'] : '';
            $mobile = (isset($contacts['cs_mobile']) && !empty($contacts['cs_mobile'])) ? $contacts['cs_mobile'] : '';
            
            ?>
            <a href="<?= $facebook ?>" class="chip blue white-text darken-3" >Facebook</a>
            <a href="<?= $linkedin ?>" class="chip blue white-text darken-1" >Linkedin</a>
            <a href="<?= $website ?>" class="chip orange white-text darken-1" >Website</a><br>
            <?php if(!empty($telephone)){ ?>
            <a href="tel:<?= $telephone ?>" class="chip teal white-text" >+<?= $telephone ?></a>
            <? } if(!empty($mobile)) { ?>
            <a href="tel:<?= $mobile ?>" class="chip teal white-text darken-2" ><?= $mobile ?></a>
            <?php
            }
        }
    }

    public function ratings($ratings){
        if(!empty($ratings)) { 
            foreach($ratings as $key=>$value) {
        ?>
        <div>
            <div class="glance white">
                <div class="product-card item">
                    <div class="thumbnail center-align">
                        <h2 class="black-text no-margin"><b><?= $ratings[$key]['cs_rating'] ?></b><span>/5</span></h2>
                    </div>
                    <div class="content">
                        <p class="grey-text">Anonymous wrote:</p>
                        <p class="truncate"><?= $ratings[$key]['cs_comment']; ?></p>
                        <p class="ratings"><?= str_repeat('<i class="material-icons orange-text">star</i>', round($ratings[$key]['cs_rating'])) ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
        }
    }
    
}

//EOF
