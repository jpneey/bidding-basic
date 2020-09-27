<?php 

$selector = Sanitizer::filter($uri[1], 'var');
require_once "model/model.blog.php";
require_once "view/view.blog.php";

$blog = new Blogs();
$viewBlog = new viewBlogs($BASE_DIR);

$perma = Sanitizer::filter($uri[1], 'var');

$thisBlog = $viewBlog->getBlog($perma);

if(empty($thisBlog)) { 
    require_once "blogs.php";
    die();
}

$cs_blog_title = $thisBlog[0]["cs_blog_title"];
$cs_blog_description = $thisBlog[0]["cs_blog_description"];
$cs_blog_keywords = $thisBlog[0]["cs_blog_keywords"];
$cs_blog_added = $thisBlog[0]["cs_blog_added"];
$cs_category_name = $thisBlog[0]["cs_category_name"];
$cs_blog_content = $thisBlog[0]["cs_blog_content"];
$cs_blog_featured_image = $thisBlog[0]["cs_blog_featured_image"];

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Canvasspoint - <?= $cs_blog_title ?></title>
  <meta name="description" content="<?= $cs_blog_description ?>">
  <?php
    require "component/head.php";
  ?>

</head>
<body class="minimal">

  <?php
    require "component/navbar.php";
  ?>
  <div class="main">
    <div class="wrapper wrapper-top-bottom">
      <div class="row">
        <div class="col s12">
            
            <div class="page white z-depth-0">
                <div id="introduction" class="content scrollspy">
                    <label><a href="<?= $this->BASE_DIR ?>" class="grey-text">Home</a> > blog > <?= $cs_category_name ?></label>
                    <br>
                    <br>
                    <h1 class="no-margin">
                        <b><?= $cs_blog_title ?></b>
                    </h1>
                    <br>
                    <a href=""><span class="chip grey lighten-1 white-text"><?= $cs_category_name ?></span></a>
                    <a href=""><span class="chip grey lighten-1 white-text"><?= date_format(date_create($cs_blog_added), "M j Y") ?></span></a>
                </div>
            </div>
            <img src="<?= $cs_blog_featured_image ?>" alt="<?= $cs_blog_title ?>" class="responsive-img" />
            <div class="page white z-depth-0">
                <div class="content" id="blog-post">
                    <?= $cs_blog_content ?>
                </div>
            </div>

        </div>
        
      </div>
    </div>
  </div>

  <link href="<?= $BASE_DIR ?>static/css/blog.css?v=1s67asds6E" type="text/css" rel="stylesheet"/>
  <script src="<?= $BASE_DIR ?>static/js/blog.js?v=beta-1s6599"></script>

<?php
    require "./component/footer.php";
?>