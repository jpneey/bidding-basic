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
            <button class="material-icons" type="submit">search</button>
            <input required name="queue" type="text" class="browser-default <?php if($filter){ echo 'filter'; } ?>" placeholder="Find what you need .." />
            <?php if($filter){ $this->filters(); } ?>
        </form>
        <?php
    }

    public function filters(){
        ?>
        <select required name="mode" class="browser-default c">
            <option value="<?= $this->DEFAULT ?>" selected>Search: <?= $this->DEFAULT ?></option>
        </select>
        <select required name="category" class="browser-default b">
            <option value="0" disabled selected>Category</option>
            <option value="0" >Miscelaneous</option>
        </select>
        <select required name="location" class="browser-default a">
            <option value="0" disabled selected>Location</option>
            <option value="0" >All</option>
            <?= $this->getLocations() ?>
        </select>
        <?php
    }

    public function getLocations(){
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
    

}