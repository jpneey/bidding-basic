<?php

class Blogs extends DBHandler {

    public function getAllBlogs($filter = array()){
        
        $connection = $this->connectDB();
        $query = "SELECT 
            b.cs_blog_title,
            b.cs_blog_permalink,
            b.cs_blog_featured_image,
            b.cs_blog_category_id,
            b.cs_blog_description,
            b.cs_blog_added,
            b.cs_blog_status,
            c.cs_category_name
            FROM cs_blogs b LEFT JOIN
            cs_categories c ON b.cs_blog_category_id = c.cs_category_id
            WHERE cs_blog_status != 5";
        if(!empty($filter)) { $query .= " ".$filter[0];}

        $query .= " ORDER BY cs_blog_added DESC";

        $stmt = $connection->prepare($query);
        if(!empty($filter)) {
            $stmt->bind_param($filter[1], ...$filter[2]);
        }
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;

    }

    public function getBlog($permalink) {

        $connection = $this->connectDB();
        $query = "SELECT b.*, c.cs_category_name FROM cs_blogs b
        LEFT JOIN cs_categories c ON b.cs_blog_category_id = c.cs_category_id
        WHERE b.cs_blog_id = ? OR b.cs_blog_permalink = ? LIMIT 1";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("ss", $permalink, $permalink);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

}

// EOF