<?php 
$embed_url = get_sub_field('embed_url');
$aspect_ratio= get_sub_field('aspect_ratio');
$autoplay_videos_on_hover = get_sub_field('autoplay_videos_on_hover');
echo '<div class="flexible-content video '.$autoplay_videos_on_hover.'">';
    echo '<div class="responsive-video" style="padding-bottom: '.$aspect_ratio.'%;">';
        echo '<iframe src="'.$embed_url.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope;';
        if($autoplay_videos_on_hover == 'no-autoplay') {
            echo 'picture-in-picture';
        }
        echo '"';
        if($autoplay_videos_on_hover == 'no-autoplay') {
            echo ' allowfullscreen';
        }
        echo '></iframe>';
    echo '</div>';    
echo '</div>';