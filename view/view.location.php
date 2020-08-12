<?php

class viewLocation extends Location {

    private $BASE_DIR;

    public function __construct($BASE_DIR) {
        $this->BASE_DIR = $BASE_DIR;
    }

    public function load($v){
        return $v;
    }

    public function optionLocation($type) {
        $locations = $this->getLocations($type);
        if(!empty($locations)){
            foreach($locations as $key=>$value){
                ?>
                <option value="<?= $locations[$key]['cs_location'] ?>" ><?= $locations[$key]['cs_location'] ?></option>
                <?php
            }
        }
    }

}