<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
    <?php foreach($reviews as $review) : ?>
    <div class="review row">
        <div class="col-sm-3">
            <span class="review-name"><?=$review['name']?></span>
        </div>
        <div class="col-sm-9">
            <span class="review-date"><?=$review['plain_datetime']?></span>
            <span class="ratings-<?=$review['rating']?>"></span>
            <h3 class="heading-three"><?=$review['title']?></h3>
            <p class="review-description"><?=html_entity_decode($review['description'])?></p>
        </div>
    </div>
    <?php endforeach; ?>
</div>
