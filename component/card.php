<a href="<?php echo $BASE_DIR.$bidCardAction ?>">
  <div class="custom-card hoverable">
    
    <div class="card-image">
      <img class="z-depth-1" src="<?php echo $BASE_DIR ?>static/asset/bidding/<?php echo $bidCardThumb ?>">
    </div>

    <div class="content">
      <p>
        <span class="title black-text">
          <?php echo $bidCardProduct ?>
          <span class="truncate mini grey-text">until <?php echo $bidCardNeededDate ?></span>
        </span>
      </p>
    </div>

  </div>
</a>