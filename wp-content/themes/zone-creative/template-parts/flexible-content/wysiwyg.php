<?php 
$content = get_sub_field('content');
$alignment = get_sub_field('alignment');
echo '<div class="flexible-content wysiwyg align-'.$alignment.'">';
    echo '<div class="wysiwyg-content">';
        echo $content;
    echo '</div>';
echo '</div>';
    