<?php

class viewBlogs extends Blogs {
    private $BASE_DIR;

    public function __construct($BASE_DIR) {
        $this->BASE_DIR = $BASE_DIR;
    }
    public function ViewBlogs($filter = array()) {
        $blogs = $this->getAllBlogs($filter);
        ?>
        <script type="text/javascript" src="<?= $this->BASE_DIR ?>static/js/lazy.js"></script>
        <script type="text/javascript" src="<?= $this->BASE_DIR ?>static/js/lazy-init.js"></script>
        <?php
        if(!empty($blogs)){
        foreach($blogs as $key => $value) {
            $blog_title = $blogs[$key]["cs_blog_title"];
            $category_name = $blogs[$key]["cs_category_name"];
            $blog_description = $blogs[$key]["cs_blog_description"];
            $blog_permalink = $blogs[$key]["cs_blog_permalink"];
            $blog_featured_image = $blogs[$key]["cs_blog_featured_image"];
            $blog_added = $blogs[$key]["cs_blog_added"];

            $blog_featured_image = '
            <div class="feed-image-wrapper">
                <img class="lazy" data-src="'.$blog_featured_image.'" alt="'.$blog_title.'"/>
            </div>
            ';


        ?>
        <a href="<?= $this->BASE_DIR.'blog/'.$blog_permalink ?>">
            <div class="post-card white z-depth-0 waves-effect">    
                <div class="title grey-text text-darken-3"><b class="truncate"><?= $blog_title ?></b></div>
                <div class="sub-title grey-text"><?= $category_name.' @ '.$blog_added ?></div>
                <div class="preview grey-text text-darken-3"><span class="truncate"><?= $blog_description ?></span></div>
                
                <div class="image-wrapper">
                    <?= $blog_featured_image ?>
                </div>
            </div>
        </a>
        <?php
        }
        } else {
        ?>
            
        <div class="post-card white z-depth- waves-effect">    
            <div class="title"><b>There's nothing here.</b></div>
            <div class="sub-title grey-text">Sadly, there are no blog post related to your searching criteria. If you are using multiple filters, please try again with less filter.</div>
            <p class="sub-title grey-text"><a href="<?= $this->BASE_DIR ?>" class="btn orange white-text">Home</a></p>
            <div class="image-wrapper"></div>
        </div>
        <?php
        }
    }

    public function viewBlog($link){
        return $this->getBlog($link);
    }

}