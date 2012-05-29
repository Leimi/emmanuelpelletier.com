<?php
class FrHelper extends AppHelper {
	function month($monthNumber, $abbr = false) {
		$months = array(
			array('janv' => 'ier'),
			array('févr' => 'ier'),
			array('mars'),
			array('avr' => 'il'),
			array('mai'),
			array('juin'),
			array('juill' => 'et'),
			array('août'),
			array('sept' => 'embre'),
			array('oct' => 'obre'),
			array('nov' => 'embre'),
			array('déc' => 'embre')
		);
		$month = $months[$monthNumber-1];
		$monthKey = key($months[$monthNumber-1]);
		return is_numeric($monthKey) ? $month[0] : ($abbr ? $monthKey : $monthKey.$month[$monthKey]);
	}
	function date($date, $format = 'd/m/Y') {
		return date($format, strtotime($date));
	}
	function num($number, $decimals = 0) {
		return number_format($number, $decimals, ',', ' ');
	}
}