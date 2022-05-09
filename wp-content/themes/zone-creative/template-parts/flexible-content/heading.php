<?php 
$heading = get_sub_field( 'heading' );
$tag = get_sub_field('tag');
$size = get_sub_field('size'); ?>
<div class="flexible-content heading">
    <?php if($heading != '') {
        echo '<'.$tag.' class="'.$size.'">'.zone_content_filters($heading).'</'.$tag.'>';
    } ?>
</div>
