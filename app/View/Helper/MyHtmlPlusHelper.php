<?php
App::uses('HtmlPlusHelper', 'BakingPlate.View/Helper');
class MyHtmlPlusHelper extends HtmlPlusHelper {
	var $helpers = array('Session');
	
	public function scriptBlock($script, $options = array()) {
		$options += array('safe' => false, 'inline' => false);
		parent::scriptBlock($script, $options);
	}

	public function smartLink($title, $url = null, $htmlAttributes = array(), $confirmMessage = false) {
		$class = "selected";
		if ($this->request->here == Router::url($url))
			$htmlAttributes['class'] = isset($htmlAttributes['class']) ? $htmlAttributes['class'].' '.$class : $class;
		$link = $this->link($title, $url, $htmlAttributes, $confirmMessage);
		return $this->output($link);
	}
}