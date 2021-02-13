<?php

class Category extends DBHandler {

    private $conn;

    public function __construct() {
        $this->conn = $this->connectDB();
    }

    public function getCategories() {
        $query = "SELECT * FROM cs_categories";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    public function getTags() {
        $query = "SELECT * FROM cs_tags";
        $stmt = $this->prepareQuery($this->conn, $query);
        return $this->fetchAssoc($stmt);
    }

    
    public function getCategoryTags($categoryId) {
        $query = "SELECT * FROM cs_tags WHERE cs_category_id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "i", array($categoryId));
        return $this->fetchAssoc($stmt);
    }

    public function getCategory($id) {
        $query = "SELECT * FROM cs_categories WHERE cs_category_id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "i", array($id));
        return $this->fetchRow($stmt);    
    }

    public function postCategory($name, $description) {
        $query = "INSERT INTO cs_categories(cs_category_name, cs_category_desciption) VALUES(?,?)";
        $stmt = $this->prepareQuery($this->conn, $query, "ss", array($name, $description));
        $this->execute($stmt);
        return true;
    }

    public function postTag($id, $name) {
        $query = "INSERT INTO cs_tags(cs_category_id, cs_tag) VALUES(?,?)";
        $stmt = $this->prepareQuery($this->conn, $query, "is", array($id, $name));
        $this->execute($stmt);
        return true;
    }

    public function updateCategory($name, $description, $id) {
        $query = "UPDATE cs_categories SET cs_category_name = ?, cs_category_desciption = ? WHERE cs_category_id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "ssi", array($name, $description, $id));
        $this->execute($stmt);
        return true;
    }

    public function deleteCategory($id) {
        $query = "DELETE FROM cs_categories WHERE cs_category_id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "i", array($id));
        $this->execute($stmt);
        $query = "DELETE FROM cs_tags WHERE cs_category_id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "i", array($id));
        return $this->execute($stmt);
    }

    public function deleteTag($id) {
        $query = "DELETE FROM cs_tags WHERE cs_tag_id = ?";
        $stmt = $this->prepareQuery($this->conn, $query, "i", array($id));
        return $this->execute($stmt);
    }


}