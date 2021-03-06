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

    public function searchProduct($queue, $location, $category){

        $queue = Sanitizer::filter($queue, 'var', 'str');
        $options = array();

        if($category){
            $options[] = array('c.cs_category_id = ?', 'i', $category);
        }

        if($location){
            $options[] = array('c.cs_category_name LIKE ?', 's', "%{$location}%");
        }

        $filter = "AND (p.cs_product_name LIKE ? OR p.cs_product_details LIKE ? OR p.cs_product_price LIKE ? OR p.cs_unit LIKE ? OR c.cs_category_name LIKE ?)";
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

    public function searchBlog($queue, $location, $category){

        $queue = Sanitizer::filter($queue, 'var', 'str');
        $options = array();

        if($category){
            $options[] = array('b.cs_blog_category_id = ?', 'i', $category);
        }

        $filter = "AND (b.cs_blog_title LIKE ? OR b.cs_blog_content LIKE ? OR b.cs_blog_description LIKE ? OR b.cs_blog_keywords LIKE ? OR c.cs_category_name LIKE ?)";
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