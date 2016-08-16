/*!
 * frontend.home
 * xiewulong <xiewulong@vip.qq.com>
 * create: 2016/8/8
 * since: 0.0.1
 */

// carousel
(function($) {
	$('.J-x-carousel').carousel();
})(jQuery);

var rolling = function() {
	var _run, rolling, pause,
		$doc		= $(document),
		_this		= this,
		$this		= $(this),
		$frame		= $this.find('.frame'),
		$roller		= $frame.find('.roller'),
		$list		= $roller.find('ul'),
		$items		= $list.find('li'),
		len			= $items.length,
		frameW		= $frame.width(),
		itemW		= $items.width() + parseInt($items.css('marginRight')),
		listW		= itemW * len,
		showLen		= Math.floor(frameW / itemW),
		maxLen		= len - showLen,
		index		= + $this.attr('data-index') || 0,
		duration	= + $this.attr('data-duration') || 400,
		interval	= + $this.attr('data-interval') || 3000,
		seamless	= $this.attr('data-seamless');
	if(len <= showLen) return;
	if(seamless) {
		$roller.width(listW * 2).append($list.width(listW).clone());
	} else {
		$roller.width(listW);
	}
	$frame.append('<a href="javascript:;" class="carousel-control left"><span class="icon-prev"></span></a><a href="javascript:;" class="carousel-control right"><span class="icon-next"></span></a>');
	(_run = function(n, init) {
		var j = n === undefined ? index + 1 : n < 0 ? index - 1 : n;
		if(!init && j == index) return;
		if(seamless) {
			if(rolling) return;
			rolling = 1;
			if(j < 0) {
				$roller.css({marginLeft: - itemW * (index + len)});
				j = j + len;
			}
		} else if(j < 0 || j >= maxLen) {
			return;
		}
		clearTimeout(_this.timer);
		if(init) {
			$roller.css({marginLeft: - itemW * j});
			if(seamless) {
				rolling = 0;
			}
		} else {
			$roller.stop(true).animate({marginLeft: - itemW * j}, duration, function() {
				if(j >= len) {
					j = j % len;
					$roller.css({marginLeft: - itemW * j});
					index = j;
				}
				if(seamless) {
					rolling = 0;
				}
			});
		}
		index = j;
		if(seamless && !pause) {
			_this.timer = setTimeout(_run, interval);
		}
	})(index, 1);
	$this.on('mouseenter', '.carousel', function() {
		if(seamless) {
			clearTimeout(_this.timer);
			pause = 1;
		}
	}).on('mouseleave', '.carousel', function() {
		if(seamless) {
			_this.timer = setTimeout(_run, interval);
			pause = 0;
		}
	}).on('click', '.left', function() {
		_run(-1);
	}).on('click', '.right', function() {
		_run();
	});
};

$('.J-x-rolling').each(rolling);
