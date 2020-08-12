<?php

class controllerSearch extends DBHandler {

    public function searchBid($queue, $location, $category){

        $queue = Sanitizer::filter($queue, 'var', 'str');
        $options = array();

        if($category){
            $options[] = array('cs_bidding_category_id = ?', 'i', $category);
        }
        if($location){
            $options[] = array('cs_bidding_location LIKE ?', 's', "%{$location}%");
        }

        $filter = "AND (cs_bidding_title LIKE ? OR cs_bidding_details LIKE ? OR cs_bidding_tags LIKE ? OR cs_bidding_location LIKE ?)";
        $type = "ssss";
        $value = array("%{$queue}%", "%{$queue}%", "%{$queue}%", "%{$queue}%");

        if(!empty($options)){
            foreach($options as $key => $v){
                $filter .= " AND ".$options[$key][0];
                $type .= $options[$key][1];
                $value[] = $options[$key][2];
            }
        }

        $filter .= " ORDER BY cs_bidding_id DESC LIMIT 20";

        return array($filter,$type,$value);
    }

}