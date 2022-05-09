
/*
 *
 * Color picker colors for acf swatches
 * 
 */
acf.add_filter('color_picker_args', function( args, $field ){
	//add our colros to acf pallette
    args.palettes = ['#FFF','#F6B3C5','#14181B','#404346','#78787D','#C3C3C8','#E3E2E4'];
	return args;
});