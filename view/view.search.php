<?php

class Search extends DBHandler {

    private $BASE_DIR;
    private $DEFAULT;

    public function __construct($BASE_DIR, $DEFAULT) {
        $this->BASE_DIR = $BASE_DIR;
        $this->DEFAULT = $DEFAULT;
    }

    public function load($v){
        return $v;
    }

    public function searchForm($filter = false){
        ?>

        <form name="searchForm" action="<?= $this->BASE_DIR ?>search/" method="GET" class="white z-depth-1 search-bar <?php if($filter){ echo 'filter'; } ?>" >
        
            <button class="material-icons submit orange white-text" type="submit">search</button>
            <input required name="queue" type="text" class="browser-default <?php if($filter){ echo 'filter'; } ?>" placeholder="Find what you need .." value="<?= (isset($_GET['queue'])) ? $_GET['queue'] : ''  ?>"/>
            <?php if($filter){ $this->filters(); } ?>
        </form>
        <?php
    }

    public function filters(){
        ?>
        <a href="#!" class="filter grey-text">Filters</a>
        <div class="filter-panel">
        <select required name="mode" class="browser-default c">
            <option value="<?= $this->DEFAULT ?>" selected>Search in <?= $this->DEFAULT ?></option>
            <?php 
                switch($this->DEFAULT) {
                    case 'bid':
                        echo '<option value="blog">Search in Blog</option>';
                        break;
                    default:
                        echo '<option value="bid">Search in Bid</option>';
                        break;
                }
            ?>
        </select>
        <select required name="category" class="browser-default b">
            <?= $this->getCategories() ?>
        </select>
        <select required name="location" class="browser-default a">
            
            <?= $this->getLocations() ?>
        </select>
        </div>
        <?php
    }

    public function getLocations(){
        if(isset($_GET['location']) && !empty($_GET['location'])) {
            echo '<option value="'.$_GET['location'].'" selected>Search in '.$_GET['location'].'</option>';
        }
        echo '<option value="0">All Locations</option>';
        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT * FROM cs_locations ORDER BY cs_location ASC");
        $stmt->execute();
        $locations = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        if(!empty($locations)){
            foreach($locations as $key=>$value){
                ?>
                <option value="<?= $locations[$key]['cs_location'] ?>" ><?= $locations[$key]['cs_location'] ?></option>
                <?php
            }
        }
    }
    public function getCategories(){
        if(isset($_GET['category']) && !empty($_GET['category'])) {
            echo '<option value="'.$_GET['category'].'" selected>Category</option>';
        }
        echo '<option value="0">All Caregories</option>';
        $connection = $this->connectDB();
        $stmt = $connection->prepare("SELECT * FROM cs_categories ORDER BY cs_category_name ASC");
        $stmt->execute();
        $category = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        if(!empty($category)){
            foreach($category as $key=>$value){
                ?>
                <option value="<?= $category[$key]['cs_category_id'] ?>" ><?= $category[$key]['cs_category_name'] ?></option>
                <?php
            }
        }
    }
    

}