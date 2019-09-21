<?php

/**
 * Takes a datetime as input and returns the time that has elapsed since then
 *
 * @param string $datetime
 * @param string $full
 *
 * @return string
 **/
function time_elapsed($datetime, $full = false) {
	$now = new DateTime;
	$ago = new DateTime($datetime);
	$diff = $now->diff($ago);

	$diff->w = floor($diff->d / 7);
	$diff->d -= $diff->w * 7;

	$string = array(
		'y' => 'year',
		'm' => 'month',
		'w' => 'week',
		'd' => 'day',
		'h' => 'hour',
		'i' => 'minute',
		's' => 'second',
		);
	foreach ($string as $k => &$v) {
		if ($diff->$k) {
			$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
		} else {
			unset($string[$k]);
		}
	}

	if ($now <= $ago)
	{
		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) : '0 days';
	}
		return '0 days';
}

/**
 * Takes a datetime as input and returns the time that has elapsed since then
 *
 * @param string $datetime
 * @param string $full
 *
 * @return string
 **/
function is_expired($datetime)
{
	$now = new DateTime(date('Y-m-d'));
	$ago = new DateTime($datetime);
	
	return ($now <= $ago) ? false : true; 
}

?>