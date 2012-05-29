window.leimi = {}; //just a custom namespace so we don't have any surprise with global vars
leimi.isOldIE =  $('html').hasClass('lteie7');
leimi.lightDevice = false;

//yeaaah that's kinda ugly but since MediaQueryListListener is supported only in FF, I guess I must do some dirty things
//maybe http://www.paulrhayes.com/2011-11/use-css-transitions-to-link-media-queries-and-javascript/ would be better
//but still a hack though, so whatever
$(window).on('load resize scroll', $.throttle(200, function() {
	//if the device has a high pixel ratio or a max width of 640px, we deliver a different UX
	leimi.isMobile = Modernizr.mq('screen and (max-width: 640px)') || Modernizr.mq('screen and (-webkit-min-device-pixel-ratio: 2)');
	//if we're on mobile or an oldIE, we consider the device is "light". It allows us to do some cool-but-heavy-and-not-that-important-stuff easily
	leimi.lightDevice = leimi.isMobile || leimi.isOldIE;
}));

$(function() {
	if (Modernizr.input.placeholder) $('html').addClass('placeholder');
	else $('html').addClass('noplaceholder');
	$('a.cb').colorbox({top: "3%", transition: "none"});
	$("input[type='url'][value=''], input[type='url']:not([value])").on('focus', function() {
		var $this = $(this);
		if (!$this.val().length) $this.val("http://");
	});
	$("input[type='url']").on('blur', function() {
		var $this = $(this);
		if ($this.val() == "http://") $this.val("");
		if ($this.val().length && (!$this.val().indexOf('http://') !== -1 && !$this.val().indexOf('https://') !== -1))
			$this.val( "http://" + $this.val() );
	});
}());
