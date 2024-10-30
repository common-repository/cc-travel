<?php
/**
 * Created by vagrant.
 * User: vagrant
 * Date: 9/17/2019
 * Time: 3:31 PM
 */

$details	= cc_travel_get_tour_details($post->ID);
$map		= cc_travel_get_value_in_array($details, '_map');
?>

<div class="tour-location">
	<iframe src="<?php echo $map; ?>" width="640" height="480"></iframe>
</div>
