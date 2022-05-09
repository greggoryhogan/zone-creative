<?php 
$desktop_height = get_sub_field( 'desktop_height' );
$tablet_height = get_sub_field( 'tablet_height' );
$mobile_height = get_sub_field( 'mobile_height' );
echo '<div class="flexible-content spacer desktop-only" style="height:'.$desktop_height.'rem;"></div>';
echo '<div class="flexible-content spacer tablet-only" style="height:'.$tablet_height.'rem;"></div>';
echo '<div class="flexible-content spacer mobile-only" style="height:'.$mobile_height.'rem;"></div>';