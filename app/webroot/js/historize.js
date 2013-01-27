(function(window,undefined){
	//lets test the history api (via history.js)
	//with this, life seems so great: robots and old browsers have a normal browsing experience; cool people have a full ajax xp with only the #content div reloading on each page; Accessible, SEO-friendly full AJAX website <o/
	//code snippet firstly made myself but in the end taken directly from history.js maker and modified a bit, since its better :) thanks https://gist.github.com/854622
	var History = window.History; //capital H cause we use history.js
	if (!History.enabled)
		return;
	//transform important html tags in simple div with "document-<tag>" classes
	var documentHtml = function(html){
		var result = String(html)
			.replace(/<\!DOCTYPE[^>]*>/i, '')
			.replace(/<(html|head|body|title|meta|script)([\s\>])/gi,'<div class="document-$1"$2')
			.replace(/<\/(html|head|body|title|meta|script)\>/gi,'</div>')
		;
		return result;
	},
		//website specific variables
		contentSelector = '#content',
		scriptsSelector = '#scripts',
		$content = $(contentSelector),
		$menu = $('#navigation'),
		menuChildrenSelector = 'a',
		activeClass = 'selected',
		ajaxLinkSelector = 'a[href^="/"]:not("[href^="/uploads/"], [href^="/img/"], [href^="/files/"], [href^="/admin/"], .cb, .web, .app, .no-ajax")',
		$body = $(document.body),
		rootUrl = History.getRootUrl();

	//ajaxify Helper (enable history API on internal links)
	$.fn.ajaxify = function(){
		var $this = $(this);
		$this.find(ajaxLinkSelector).click(function(e){
			var	$this = $(this),
				url = $this.attr('href'),
				title = $this.attr('title') || null;
			// continue as normal for cmd clicks etc
			if ( e.which == 2 || e.metaKey ) { return true; }
			History.pushState(null, title, url);
			e.preventDefault();
			return false;
		});
		return $this;
	};
	$body.ajaxify();
	$(window).bind("statechange", function() {
		var State = History.getState(),
			url = State.url,
			relativeUrl = url.replace(rootUrl,''),
			loading = setTimeout(function() { $('.loading').removeClass('hidden'); }, 750); //we show the loading spin only if it takes to long to load, not directly (better ux <o/)
		$.ajax({
			url: url,
			success: function(data, textStatus, jqXHR) {
				var	$data = $(documentHtml(data)),
					$dataBody = $data.find('.document-body:first'),
					$dataContent = $dataBody.find('#content'),
					$menuChildren, contentHtml, $scripts;

				//take the js, put it at bottom of page, and set it to execute when the content has finished loading
				$scripts = $dataBody.find(scriptsSelector + ' .document-script');
				if ($scripts.length) $scripts.detach();
				$scripts.each(function(){
					var script = $(this).html(),
						scriptContent = '';
					$(scriptsSelector)[0].innerHTML = '';
					if (script.length) {
						scriptContent = "$('"+ contentSelector + "').on('contentLoaded', function(){ " + $(this).html() + " })";
						$(scriptsSelector)[0].innerHTML = "<script>" + scriptContent + "</script>";
						$.globalEval(scriptContent);
					}
				});

				contentHtml = $dataContent.html() || $data.html();
				if ( !contentHtml ) {
					document.location.href = url;
					return false;
				}
				
				//change active menu links
				$menuChildren = $menu.find(menuChildrenSelector);
				$menuChildren.filter('.' + activeClass).removeClass(activeClass);
				$menuChildren = $menuChildren.filter('[href="'+relativeUrl+'"],a[href="/'+relativeUrl+'"],a[href="'+url+'"]');
				if ($menuChildren.length === 1) $menuChildren.addClass(activeClass);

				//change content without forgetting to ajaxify again the links in it
				$content.stop(true, true);
				$content.html(contentHtml).ajaxify().trigger('contentLoaded');

				scrollTo(0, 0);
				
				//change title
				document.title = $data.find('.document-title').text();
				
				//handle loading state
				$('.loading').addClass('hidden');
				clearTimeout(loading);

				changeHeaderColor(); //super great leimi's touch: the header background changes at every click

				//Google Analytics
				if (typeof window.pageTracker !== 'undefined') window.pageTracker._trackPageview(relativeUrl);
			},
			error: function(jqXHR, textStatus, errorThrown){
				document.location.href = url;
				return false;
			}
		});
	});
})(window);