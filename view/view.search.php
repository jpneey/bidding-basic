<?php

class Search extends DBHandler {

    private $BASE_DIR;
    private $DEFAULT;
    private $connect;

    public function __construct($BASE_DIR, $DEFAULT, $conn = null) {
        $this->BASE_DIR = $BASE_DIR;
        $this->DEFAULT = $DEFAULT;
        if($conn) {
            $this->connect = $conn; 
        } else {
            $this->connect = $this->connectDB();
        }
    }

    public function load($v){
        return $v;
    }

    public function getconn(){
        if(!$this->connect){
            $this->connect = $this->connectDB();
        }
        return $this->connect;
    }

    public function searchForm($filter = false){
        ?>

        <form name="searchForm" action="<?= $this->BASE_DIR ?>search/" method="GET" class="input-field white z-depth-0 search-bar <?php if($filter){ echo 'filter'; } ?>" >
        
            <button class="material-icons submit orange white-text" type="submit">search</button>
            <input autocomplete="off" required name="queue" type="text" class="browser-default <?php if($filter){ echo 'filter'; } ?> autocomplete" placeholder="Find what you need .." value="<?= (isset($_GET['queue'])) ? $_GET['queue'] : ''  ?>"/>
            <script>
                getSuggestion();
                $(function(){
                    $('input[name=queue]').on('keyup', function(){
                        $('input.autocomplete').autocomplete('open')
                    })
                })
                function suggest(s) {
                    var s = JSON.parse(s);
                    $('input.autocomplete').autocomplete({
                        data: s,
                        minLength: 2
                    })
                }

                function getSuggestion() {
                    $.ajax({
                        url: root + 'controller/controller.autocomplete.php?mode=generic',
                        type: 'GET',
                        processData: false,
                        contentType: false,
                        success: function(data){
                            suggest(data);
                        }
                    })
                }
            </script>
            <?php if($filter){ $this->filters(); } ?>
        </form>
        <?php
    }

    public function filters(){
        ?>
        <a href="#!" class="filter grey-text"><i class="search material-icons">tune</i></a>
        <div class="filter-panel">
        <select required name="mode" class="browser-default c">
            <option value="<?= $this->DEFAULT ?>" selected>Search in <?= ucfirst($this->DEFAULT) ?></option>
            <?php 
                echo '<option value="blog">Search in Blog</option>';
                echo '<option value="product">Search in Products</option>';
                echo '<option value="bid">Search in Bid</option>';
            ?>
        </select>
        <select required name="category" class="browser-default b" id="search-category">
            <?= $this->getCategories() ?>
        </select>
        <select required name="location" class="browser-default a" id="search-location">
            <?= $this->getLocations() ?>
        </select>
        <button type="button" class="btn waves-effect white black-text z-depth-0 clear-filter">Clear Filters</button>
        </div>
        <?php
    }

    public function getLocations(){
        /* if(isset($_GET['location']) && !empty($_GET['location'])) {
            echo '<option value="'.$_GET['location'].'" selected>Search in '.$_GET['location'].'</option>';
        } */
        echo '<option value="0">All Locations</option>';
        $connection = $this->getconn();
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
        /* if(isset($_GET['category']) && !empty($_GET['category'])) {
            echo '<option value="'.$_GET['category'].'" selected>Category</option>';
        } */
        echo '<option value="0">All Categories</option>';
        $connection = $this->getconn();
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