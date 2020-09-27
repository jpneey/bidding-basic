<?php

class controllerSearch extends DBHandler {

    public function searchBid($queue, $location, $category){

        $queue = Sanitizer::filter($queue, 'var', 'str');
        $options = array();

        if($category){
            $options[] = array('b.cs_bidding_category_id = ?', 'i', $category);
        }
        if($location){
            $options[] = array('b.cs_bidding_location LIKE ?', 's', "%{$location}%");
        }

        $filter = "AND (b.cs_bidding_title LIKE ? OR b.cs_bidding_details LIKE ? OR b.cs_bidding_tags LIKE ? OR b.cs_bidding_location LIKE ? OR c.cs_category_name LIKE ?)";
        $type = "sssss";
        $value = array("%{$queue}%", "%{$queue}%", "%{$queue}%", "%{$queue}%", "%{$queue}%");

        if(!empty($options)){
            foreach($options as $key => $v){
                $filter .= " AND ".$options[$key][0];
                $type .= $options[$key][1];
                $value[] = $options[$key][2];
            }
        }

        return array($filter,$type,$value);
    }

}