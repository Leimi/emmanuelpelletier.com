var changeHeaderColor = function() { };
$(function() {
	var menuIsSynced = false,
	syncMenuToMouse = function() {
		if (leimi.lightDevice) return;
		if (Modernizr.csstransforms3d && Modernizr.prefixed('transform') == "WebkitTransform") { //this trick is cool only on Safari and Chrome as of now
			$(document).on('mousemove.syncMenu', $.throttle(10, function(e) {
				var rotate = (e.pageX/$('body').width()*50)-25;
				$("#headerContainer").css(Modernizr.prefixed('transform'), 'rotateY(' + rotate + 'deg)');
			}));
		} else if (Modernizr.csstransforms) {
			$(document).on('mousemove.syncMenu', $.throttle(10, function(e) {
				var left = (e.pageX/$('body').width()*50)-25;
				$("#headerContainer").css(Modernizr.prefixed('transform'), 'translateX(' + -left*0.5 + 'px)');
				$("#navContainer").css(Modernizr.prefixed('transform'), 'translateX(' + left + 'px)');
			}));
		}
		menuIsSynced = true;
	},
	unsyncMenuToMouse = function() {
		$(document).off('mousemove.syncMenu');
		if (Modernizr.csstransforms) $("#headerContainer, #navContainer").css(Modernizr.prefixed('transform'), '');
		menuIsSynced = false;
	};
	//the Color object lets us create colors in rgb or hsl format, convert them (transform rgb to hsl & vice versa), alter hsl colors easily and transform these values in string so that CSS likes it
	var Color = {
		rgb: function(r, g, b) {
			return {
				r: r,
				g: g,
				b: b,
				toString: function() { return "rgb(" + r +", " + g + ", " + b + ")"; }
			};
		},
		hsl: function(h, s, l) {
			return {
				h: h,
				s: s,
				l: l,
				toString: function() { return "hsl(" + h +", " + s*100 + "%, " + l*100 + "%)"; }
			};
		},
		alteredHsl: function(hsl, sMultiplier, lMultiplier) {
			// if (isNaN(hMultiplier)) hMultiplier = 1;
			if (isNaN(sMultiplier)) sMultiplier = 1;
			if (isNaN(lMultiplier)) lMultiplier = 1;
			var s = hsl.s * sMultiplier,
			l = hsl.l * lMultiplier,
			// h = hsl.h * hMultiplier,
			h = hsl.h,
			max = 1,
			min = 0,
			result;
			// h = h > 359 ? 359 : (h < 0 ? 0 : h);
			s = s > max ? max : (s < min ? min : s);
			l = l > max ? max : (l < min ? min : l);
			return Color.hsl(h, s, l);
		},
		//conversion function (modified a bit) taken from http://mjijackson.com/2008/02/rgb-to-hsl-and-rgb-to-hsv-color-model-conversion-algorithms-in-javascript
		hsl2Rgb: function(hsl) {
			var h = hsl.h/360, s = hsl.s, l = hsl.l, r, g, b;
			function hue2rgb(p, q, t) {
				if(t < 0) t += 1;
				if(t > 1) t -= 1;
				if(t < 1/6) return p + (q - p) * 6 * t;
				if(t < 1/2) return q;
				if(t < 2/3) return p + (q - p) * (2/3 - t) * 6;
				return p;
			}
			if (s === 0) {
				r = g = b = l; // achromatic
			} else {
				var q = l < 0.5 ? l * (1 + s) : l + s - l * s;
				var p = 2 * l - q;
				r = Math.floor( (hue2rgb(p, q, h + 1/3)) * 255);
				g = Math.floor( (hue2rgb(p, q, h)) * 255);
				b = Math.floor( (hue2rgb(p, q, h - 1/3)) * 255);
			}
			return Color.rgb(r, g, b);
		}
	};
	var colors = [ //we set a collection of colors that the header can take as bg. Here, because were so happy to live, its all the colors! rainbow time \o> <o/ \o/
		Color.hsl(  0, 1, 0.3),
		Color.hsl( 30, 1, 0.3),
		Color.hsl( 60, 1, 0.3),
		Color.hsl( 90, 1, 0.3),
		Color.hsl(120, 1, 0.3),
		Color.hsl(150, 1, 0.3),
		Color.hsl(180, 1, 0.3),
		Color.hsl(210, 1, 0.3),
		Color.hsl(240, 1, 0.3),
		Color.hsl(270, 1, 0.3),
		Color.hsl(300, 1, 0.3),
		Color.hsl(330, 1, 0.3)
	];
	changeHeaderColor = function(options) {
		/**
		* default options
		* list: the list of colors to work with
		* to  : we can pass a Color object to directly change the header to it. If so, the list is obviously ignored
		* random: if true, a random color from the list will be taken, else the next color of the list will be taken (the one after the current header one)
		* simple: we only change the #header bg color and not all the > div
		*/
		var defaults = { list: colors.slice(0), to: undefined, random: false, simple: leimi.lightDevice },
			opts = $.extend(defaults, options),
			currentColor = $('#header').attr('data-color'),
			color = opts.list[0],
			rand = function() { return Math.floor(Math.random()*(25+25+1)-25); };
		if (opts.to === undefined) {
			for (i = opts.list.length; i--;) {
				if (Color.hsl2Rgb(opts.list[i]).toString() === currentColor) {
					if (opts.random)
						opts.list.splice(i, 1);
					else
						color = i+1 == opts.list.length ? opts.list[0] : opts.list[i+1];
					break;
				}
			}
			if (opts.random)
				color = opts.list[Math.round(Math.random()*(opts.list.length-1))];
		} else {
			color = opts.to;
		}

		$('#header').attr('data-color', Color.hsl2Rgb(color).toString());
		if (opts.simple) {
			$('#headerContainer').css({backgroundColor: Color.hsl2Rgb(Color.alteredHsl(color, 1.2, 1.08)).toString()});
		} else {
			$('#headerContainer > div:nth-child(7), #headerContainer > div:nth-child(12), #headerContainer > div:nth-child(13)')
																							.css({backgroundColor: Color.hsl2Rgb(color).toString()});
			$('#header, #headerContainer > div:nth-child(1), #headerContainer > div:nth-child(8)').css({backgroundColor: Color.hsl2Rgb(Color.alteredHsl(color, 1.2, 1.08)).toString()});
			$('#headerContainer > div:nth-child(2), #headerContainer > div:nth-child(9)')         .css({backgroundColor: Color.hsl2Rgb(Color.alteredHsl(color, 0.9, 0.9)).toString()});
			$('#headerContainer > div:nth-child(3), #headerContainer > div:nth-child(10)')        .css({backgroundColor: Color.hsl2Rgb(Color.alteredHsl(color, 0.7, 1.3)).toString()});
			$('#headerContainer > div:nth-child(4), #headerContainer > div:nth-child(11)')        .css({backgroundColor: Color.hsl2Rgb(Color.alteredHsl(color, 0.5, 1.3)).toString()});
			$('#headerContainer > div:nth-child(6)')                                              .css({backgroundColor: Color.hsl2Rgb(Color.alteredHsl(color, 1.3, 0.7)).toString()});

			$('#headerContainer > .moving').each(function(i, item) {
				$(this).css(Modernizr.prefixed('transform'), 'translate3d(' + rand() + 'px, 0, 0)');
			});
		}
	};
	changeHeaderColor({ to: colors[Math.round(Math.random()*(colors.length-1))] });
	setInterval(function() {
		changeHeaderColor();
	}, 3000);
	var closeClass= 'closed',
	changeHeaderOffset = function() {
		var $header = $('#header'), $toggler = $('#header-toggler'), $content = $('#container');
		if (!$header.hasClass(closeClass) && leimi.isMobile) {
			$header.css('top', (window.scrollY)*1 + 'px');
		} else {
			$header.css('top', 'auto');
			$content.css('top', '0');
		}
		$toggler.css('top', (window.pageYOffset + $header.height())*1+ 'px');
	},
	toggleHeader = function() {
		var $header = $('#header'), $toggler = $('#header-toggler'), $content = $('#container');
		if ($header.hasClass(closeClass)) {
			$header.removeClass(closeClass);
			$content.css('top', $header.height() + 'px');
			$toggler.css('top', $header.height() + 'px');
		}
		else {
			$content.css('top', '0');
			$toggler.css('top', '0');
			$header.addClass(closeClass);
		}
		changeHeaderOffset();
	};

	$('body').on('click', '#header-toggler', function(e) {
		e.preventDefault();
		toggleHeader();
	});

	toggleHeader();
	$(window).on('load resize scroll', $.debounce(250, function() {
		changeHeaderOffset();
		//if (leimi.isMobile && menuIsSynced) unsyncMenuToMouse();
		//if (!leimi.isMobile && !menuIsSynced) syncMenuToMouse();
	}));

	var konami = [38,38,40,40,37,39,37,39,66,65],
	typed = [],
	onTypedKonamiCode = function() {
		var $konami = $('#konamiiii');
		$konami.find('.reward').html('chargement');
		if (Modernizr.audio) document.getElementById('discovered-sound').play();
		$.colorbox({ html: $konami.html(), top: "3%", height: "90%", width: "550px", transition: "none"});
		$.getJSON('/konami', function(data) {
			if (Modernizr.audio) document.getElementById('discovered-sound-2').play();
			$('#cboxLoadedContent').find('.reward').html('Une image ' + (data.from.indexOf('bonjourmadame') !== -1 ? ' (un peu NSFW) ' : '') + '! <br><img src="' + data.src + '" alt="Récompense en image"><br>Génial.<br><br>PS : Si jamais tu repasses par là, peut-être que tu retrouveras pas la même chose, qui sait...');
		});
	};
	$(document).on('keydown', function(e) {
		if (typed.length >= konami.length) typed.shift();
		typed.push(e.keyCode);
		if (typed.toString() == konami.toString()) onTypedKonamiCode();
	});
}());