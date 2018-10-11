<?php
/**
 * Template fragment for displaying Date info
 *
 * @package memex
 */

?>
<?php 

$current_post_id = get_the_ID();

if ( function_exists('mem_date_processing') ) {

	$mem_date = mem_date_processing( 
		get_post_meta($current_post_id, '_mem_start_date', true) , 
		get_post_meta($current_post_id, '_mem_end_date', true)
	);

}

if ($mem_date["start-iso"] !="" ) { 
	
	echo'<div class="date">'.$mem_date["date-basic"].' '.$mem_date["date-year"].'</div>';
	
}

