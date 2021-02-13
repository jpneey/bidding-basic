<?php

require_once "./app/component/import.php";

$meta_title = "Add Blog";
$meta_description = "Material Dashboard v-0.1";

require_once "./app/component/head.php";
require_once "./app/component/navbar.php";
require_once "./app/model/model.category.php";

$category = new Category();

$catOpts = '';
$catOpt = $category->getCategories();
if(!empty($catOpt)) {
    foreach($catOpt as $k => $v) {
        $id = $catOpt[$k]["cs_category_id"];
        $name = $catOpt[$k]["cs_category_name"];
        $catOpts .= "<option value=\"$id\" >$name</option>";
    }
}

?>

<link rel="stylesheet" href="<?= $BASE ?>static/lib/richtext.min.css?v=1">
<link rel="stylesheet" href="<?= $BASE ?>static/lib/richtext.fix.css?v=1">
<script src="<?= $BASE ?>static/lib/richtext.min.js"></script>  
<script src="<?= $BASE ?>static/js/editor.js"></script>  

<div class="main">
    <div class="card-panel white z-depth-1">
        <form class="ajax-form row" action="<?= $BASE ?>controller/post/post.blog.php?mode=add" method="POST">
            <div class="col s12">
                <p><b>Add a blog post</b></p>
                <br>
            </div>
            
            <div class="col s12 m6">
                <input required type="text" name="cs_blog_title" placeholder="Blog Title">
            </div>

            <div class="col s12 m6">
                <select required name="cs_blog_category_id">
                    <option value="0" selected disabled>choose category</option>
                    <?= $catOpts ?>
                </select>
            </div>

            <div class="col s12">
                <input required type="url" name="cs_blog_featured_image" placeholder="Blog Featured Image URL">
            </div>

            <div class="col s12 m6">
                <input required type="text" name="cs_blog_description" placeholder="SEO Description">
            </div>

            <div class="col s12 m6">
                <input required type="text" name="cs_blog_keywords" placeholder="SEO Keywords">
            </div>

            <div class="col s12">
                <select required name="cs_blog_status">
                    <option value="2" selected>Save as Draft</option>
                    <option value="1">Publish</option>
                </select>
            </div>

            <div class="col s12" >
                <br><br>
                <textarea required name="cs_blog_content" class="blog-field" ></textarea>
                <br><br>
                <button type="submit" class="btn orange white-text">Save</button>
            </div>

        </form>
    </div>
</div>

<?php

require_once "./app/component/footer.php";