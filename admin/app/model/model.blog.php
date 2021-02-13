<?php

class BLog extends DBHandler {

    private $conn;

    public function __construct() {
        $this->conn = $this->connectDB();
    }

    public function getBLogs() {
        $query = "SELECT 
            b.cs_blog_id, 
            b.cs_blog_title,
            b.cs_blog_permalink,
            b.cs_blog_featured_image,
            b.cs_blog_added,
            b.cs_blog_status,
            c.cs_category_name AS cs_blog_category
            FROM cs_blogs b LEFT JOIN cs_categories c ON b.cs_blog_category_id = c.cs_category_id";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function getBlog($id) {
        $query = "SELECT b.*, c.cs_category_name FROM cs_blogs b LEFT JOIN cs_categories c ON b.cs_blog_category_id = c.cs_category_id WHERE cs_blog_id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "i", array($id));
        return $this->fetchAssoc($stmt);
    }

    public function postBlog(
        $cs_blog_title, 
        $cs_blog_permalink, 
        $cs_blog_featured_image, 
        $cs_blog_category_id, 
        $cs_blog_content, 
        $cs_blog_description,
        $cs_blog_keywords,
        $cs_blog_added,
        $cs_blog_status) {
        
        $query = "INSERT INTO cs_blogs(
            cs_blog_title, 
            cs_blog_permalink,
            cs_blog_featured_image,
            cs_blog_category_id,
            cs_blog_content,
            cs_blog_description,
            cs_blog_keywords,
            cs_blog_added,
            cs_blog_status
        ) VALUES(?,?,?,?,?,?,?,?,?)";

        $stmt = $this->prepareQuery($this->conn, $query, "sssissssi", 
        array(
        $cs_blog_title, 
        $cs_blog_permalink, 
        $cs_blog_featured_image, 
        $cs_blog_category_id, 
        $cs_blog_content, 
        $cs_blog_description,
        $cs_blog_keywords,
        $cs_blog_added,
        $cs_blog_status));

        return $this->execute($stmt);

    }    

    public function updateBlog(
        $cs_blog_title, 
        $cs_blog_permalink, 
        $cs_blog_featured_image, 
        $cs_blog_category_id, 
        $cs_blog_content, 
        $cs_blog_description,
        $cs_blog_keywords,
        $cs_blog_added,
        $cs_blog_status, $id) {
        
        $query = "UPDATE cs_blogs SET
            cs_blog_title = ?, 
            cs_blog_permalink = ?,
            cs_blog_featured_image = ?,
            cs_blog_category_id = ?,
            cs_blog_content = ?,
            cs_blog_description = ?, 
            cs_blog_keywords = ?,
            cs_blog_added = ?,
            cs_blog_status = ?
            WHERE cs_blog_id = ?
        ";

        $stmt = $this->prepareQuery($this->conn, $query, "sssissssii", 
        array(
        $cs_blog_title, 
        $cs_blog_permalink, 
        $cs_blog_featured_image, 
        $cs_blog_category_id, 
        $cs_blog_content, 
        $cs_blog_description,
        $cs_blog_keywords,
        $cs_blog_added,
        $cs_blog_status, $id));

        return $this->execute($stmt);

    }    

    public function deleteBlog($id) {
        $query = "DELETE FROM cs_blogs WHERE cs_blog_id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "i", array($id));
        return $this->execute($stmt);
    }


}