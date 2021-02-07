<?php 

$selector = Sanitizer::filter($uri[1], 'var');
require_once "model/model.blog.php";
require_once "view/view.blog.php";

$blog = new Blogs($conn);

$viewBlog = new viewBlogs($BASE_DIR, $conn);
$shareablelink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

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

$catID = $thisBlog[0]["cs_blog_category_id"];
$curPerma = $thisBlog[0]["cs_blog_permalink"];

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
<body class="minimal blog">

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

                    <br><br>
                    <?php
                    $related = $blog->getRelated($catID, $curPerma);
                    if(!empty($related)) { ?>

                      <a href="<?= $BASE_DIR ?>blog/<?= $related[0]["cs_blog_permalink"] ?>"><p><small>Read Next</small><br><b><?= $related[0]["cs_blog_title"] ?></b></p></a>

                    <?php } ?>
                    <div>

                      <a href="#!" id="c-form-on"><p><small>Reach out to us</small><br><b>Do you want your product to get featured here? Contact Us!</b></p></a>
                      <form id="c-form" method="post" action="<?= $BASE_DIR ?>controller/controller.notification.php?mode=2">
                        <div class="input-field no-margin">
                          <p><label>User Name *</label></p>
                            <input 
                                required 
                                type="email" 
                                name="email" 
                                class="custom-input validate"
                                placeholder="Your Email Address"
                            />
                        </div>
                        
                        <div class="input-field no-margin">
                          <p><label>Your message *</label></p>
                          <textarea required name="message" class="custom-input materialize-textarea"></textarea>
                        </div>
                        <div class="input-field no-margin">
                          <button type="submit" class="z-depth-0 btn waves-effect orange white-text">Contact Us</button>
                          <button type="button" id="c-form-off" class="z-depth-0 btn waves-effect red white-text">Cancel</button>
                        </div>
                      </form>
                        
                      <br>
                      <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $shareablelink ?>" class="sb-sharer" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                      </a>

                      <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $shareablelink ?>" class="sb-sharer" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/></svg>
                      </a>

                    </div>
                </div>
            </div>

        </div>
        
      </div>
    </div>
  </div>

  <div id="contact-us" class="modal">
    <div class="modal-content">
      <h4>Modal Header</h4>
      <p>A bunch of text</p>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">Agree</a>
    </div>
  </div>

  <link href="<?= $BASE_DIR ?>static/css/blog.css?v=1s67asds6E-oip" type="text/css" rel="stylesheet"/>
  <script src="<?= $BASE_DIR ?>static/js/blog.js?v=beta-1s6599-iiop"></script>

<?php
    require "./component/footer.php";
?>