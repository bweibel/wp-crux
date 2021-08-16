<?php
/**
 * Template part for displaying a Beer Filter
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$series = get_terms(
	array(
		'taxonomy' => 'beer-series',
		'hide_empty' => true,
	)
);

$seriesSortOrder = array(
	'year-round' => 0,
	'seasonal' => 1,
	'limited-release' => 2,
	'banished' => 3,
	'archive' => 4,
);

foreach ( $series as $theSeries ) {
	$theSeries->order = $seriesSortOrder[ $theSeries->slug ];
}

usort(
	$series,
	function( $a, $b ) {
			return $a->order - $b->order;
	}
);


?>

<ul class="filter-buttons">
	<?php

	echo '<li class=""><a class="filter-button data-filtername=""' . $className . '">All Beers</a></li>';

	foreach ( $series as $theSeries ) {
		if ( $theSeries->slug != 'archive' ) {
			echo '<li><a class="filter-button "' . $className . '" data-filtername="' . $theSeries->name . '" data-filterslug="' . $theSeries->slug . '">' . $theSeries->name . '</a></li>';
		}
	}

	?>
</ul>

<?php
