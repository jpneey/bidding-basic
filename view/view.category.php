<?php

class viewCategory extends Category {

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

    public function optionCategories() {
        $locations = $this->getCategories();
        if(!empty($locations)){
            foreach($locations as $key=>$value){
                ?>
                <option value="<?= $locations[$key]['cs_category_id'] ?>" ><?= $locations[$key]['cs_category_name'] ?></option>
                <?php
            }
        }
    }

}