<?php 
$image = get_sub_field('image');
$image_size = get_sub_field('image_size');
$force_images_full_width = get_sub_field('force_images_full_width');
$image_alignment = get_sub_field('image_alignment'); 
$image_padding = get_sub_field('image_padding'); ?>
<div class="flexible-content image-module <?php echo $force_images_full_width; ?> align-<?php echo $image_alignment; ?>" style="padding:<?php echo $image_padding; ?>">
    <div>    
        <?php echo wp_get_attachment_image( $image, $image_size ); ?>
    </div>
</div>
