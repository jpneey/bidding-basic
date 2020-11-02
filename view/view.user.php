<?php

class viewUser extends User {

    private $BASE_DIR;

    public function __construct($BASE_DIR, $conn = null){
        $this->BASE_DIR = $BASE_DIR;
        if($conn){
            parent::__construct($conn);
        }
    }

    public function viewProfile($selector){
        $user = $this->getProfile($selector);
        if(!empty($user)) {
        $rating = str_repeat('<i class="material-icons orange-text">star</i>', round($user[0]['cs_user_rating']));
        ?>
            <div class="page white z-depth-1">
                <div id="introduction" class="content scrollspy">
                    <label><a href="<?= $this->BASE_DIR ?>" class="grey-text">Home</a> > User > @<?= $selector ?></label>
                    <br>
                    <div class="glance white">
                        <div class="product-card item">
                            <div class="thumbnail">
                                <img id="bidding-details" src="<?= $this->BASE_DIR ?>static/asset/user/<?= $user[0]['cs_user_avatar'] ?>" class="margin-auto materialboxed" />
                            </div>
                            <div class="content">
                                <p><b><?= $user[0]['cs_user_name'] ?></b></p>
                                <p><?= $user[0]['cs_user_email'] ?></p>
                                <p class="ratings"><?= $rating ?></p>
                            </div>
                        </div>
                    </div>
                    <p><b>Contact Details</b></p>
                    <div>
                        <?= $this->contactDetails(unserialize($user[0]['cs_contact_details']), $user[0]['cs_user_business']) ?>
                        <a href="mailto:<?= $user[0]['cs_user_email'] ?>" class="chip teal white-text darken-1" ><?= $user[0]['cs_user_email'] ?></a>
                    </div>
                    <p><?= $user[0]['cs_user_detail'] ?></p>

                    <?php $this->viewBusinessProducts($user[0]['cs_user_id']);  ?>
                    <?php $this->ratings($user[0]['cs_user_ratings']);  ?>
                </div>
            </div>
            <link href="<?= $this->BASE_DIR ?>static/css/bid.css" type="text/css" rel="stylesheet"/>
            <link href="<?= $this->BASE_DIR ?>static/css/feed.css" type="text/css" rel="stylesheet"/>
        <?php
        } else {
            $BASE_DIR = $this->BASE_DIR;
            $emptyTitle = "Ah yes, 404";
            $emptyMessage = "It seems like the page you are looking for was moved, deleted or didn't exist at all.";
            require_once "./component/empty.php";
        }
    }

    public function contactDetails($contacts = array(), $business){ 
        if(!empty($contacts)){
            $facebook = (isset($contacts['cs_facebook']) && !empty($contacts['cs_facebook'])) ? $contacts['cs_facebook'] : '#!';
            $linkedin = (isset($contacts['cs_linkedin']) && !empty($contacts['cs_linkedin'])) ? $contacts['cs_linkedin'] : '#!';
            $website = (isset($contacts['cs_website']) && !empty($contacts['cs_website'])) ? $contacts['cs_website'] : '#!';
            
            $telephone = (isset($contacts['cs_telephone']) && !empty($contacts['cs_telephone'])) ? $contacts['cs_telephone'] : '';
            $mobile = (isset($contacts['cs_mobile']) && !empty($contacts['cs_mobile'])) ? $contacts['cs_mobile'] : '';
            
            ?>
            <a href="<?= $facebook ?>" class="chip blue white-text darken-3" >Facebook</a>
            <a href="<?= $linkedin ?>" class="chip blue white-text darken-1" >Linkedin</a>
            <a href="<?= $website ?>" class="chip orange white-text darken-1" >Website</a>
            <?php if(!empty($telephone)){ ?>
            <br><a href="tel:<?= $telephone ?>" class="chip teal white-text" >+<?= $telephone ?></a>
            <? } if(!empty($mobile)) { ?>
            <a href="tel:<?= $mobile ?>" class="chip teal white-text darken-2" ><?= $mobile ?></a>
            <?php
            }
        }
    }

    public function ratings($ratings){
        if(!empty($ratings)) { 
            echo '<p><b>What other people say</b></p>';
            foreach($ratings as $key=>$value) {
        ?>
            <div class="content">
                <p class="no-margin black-text">Anonymous</p>
                <p class="no-margin grey-text text-darken-1"><?= $ratings[$key]['cs_comment']; ?></p>
                <p class="ratings no-margin"><?= str_repeat('<i class="material-icons orange-text">star</i>', round($ratings[$key]['cs_rating'])) ?></p>
            </div>
            <br>
        <?php
            }
        }
    }

    public function viewBusinessProducts($user_id){
        $products = $this->getBusinessProducts($user_id);
        if(!empty($products)) {
            echo "<br><p><b>Featured Products/Services</b></p>";
            echo "
            <div class=\"feed-wrap-main\">
            ";
            foreach($products as $key=>$value){             
                $sale = ($products[$key]["cs_sale_price"] < $products[$key]["cs_product_price"]) ? true : false;
                ?>
                <div class="card feed z-depth-0 myproduct on-profile">
                    <div class="card-image">
                        <img class="lazy" src="<?= $this->BASE_DIR.'static/asset/product/'.$products[$key]["cs_product_image"] ?>" alt="<?= $products[$key]["cs_product_name"] ?>"/>
                        <div class="overlay"></div>
                        <span class="card-title">
                            <small><?= $products[$key]["cs_category_name"] ?></small> 
                            <br>
                            <?= $products[$key]["cs_product_name"] ?>
                        </span>
                    </div>
                    <div class="card-content">
                        <p class="un-margin"><?= $products[$key]["cs_product_details"] ?></p>
                        <br>
                        <p>
                            <b>&#8369; <?= ($sale) ? number_format($products[$key]["cs_sale_price"], 2, '.', '.') : number_format($products[$key]["cs_product_price"], 2, '.', '.') ?></b>
                            <?= ($sale) ? '<small><s>'.number_format($products[$key]["cs_product_price"], 2, '.', '.') .'</s></small>' : "" ?>
                            <?= " / " . $products[$key]["cs_unit"]  ?>
                        </p>
                    </div>
                </div>
                <?php
            }
            echo "</div>";
        }
    }

}