<?php 
$text_left = get_sub_field( 'text_left' );
$text_right = get_sub_field( 'text_right' ); ?>
<div class="flexible-content eyebrow">
    <?php if($text_left != '') {
        echo '<div class="text-left">'.zone_content_filters($text_left).'</div>';
    }
    if($text_right != '') {
        echo '<div class="text-right">'.zone_content_filters($text_right).'</div>';
    } ?>
</div>
