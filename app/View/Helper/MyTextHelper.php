<?php
App::uses('TextHelper', 'View/Helper');
class MyTextHelper extends TextHelper {
	/**
	 * transform twitter related text to links:
	 * @username becomes a link to a twitter user profile
	 * #hashtag becomes a link to a twitter search
	 */
	function autoLinkTwitter($text, $htmlOptions = array()) {
		$options = "";
		foreach ($htmlOptions as $key => $value) {
			$options.= ' '.$key.'="'.$value.'"';
		}
		$text = preg_replace(
			array('/^@([a-zA-Z0-9_éèêëàù]+)/', '/\s@([a-zA-Z0-9_éèêëàù]+)/'), 
			' <a href="http://twitter.com/@$1"'.$options.'>@$1</a>',
			$text
		);
		$text = preg_replace(
			array('/^#([a-zA-Z0-9_éèêëàù]+)/', '/\s#([a-zA-Z0-9_éèêëàù]+)/'),
			' <a href="http://twitter.com/search?q=%23$1"'.$options.'>#$1</a>',
			$text
		);
		return $text;
    }

    /**
     * added Twitter autolinks on the Cake basic autoLink function
     */
    function autoLink($text, $options) {
    	return $this->autoLinkTwitter(parent::autoLink($text, $options), $options);
    }

    /**
     * pluralize (or not) the $singular term based on the value of the $val number
     * prefix the returned text with the value by default
     * example: pluralize(3, 'article') returns the string '3 articles' by default, or 'articles' with $prefixWithVal set to false
     */
    function pluralize($val, $singular, $prefixWithVal = true) {
    	$prefix = $prefixWithVal ? $val.' ' : '';
    	if ($val > 1)
			return $prefix.Inflector::pluralize($singular);
		return $prefix.$singular;
    }
}