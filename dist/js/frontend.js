/*!
 * frontend
 * xiewulong <xiewulong@vip.qq.com>
 * create: 2016/8/8
 * since: 0.0.1
 */

// menu
(function($, window, document) {
		var $win	= $(window),
			$doc	= $(document),
			$menu	= $('.J-x-menu'),
			$strip	= $menu.find('li.current span'),
			left	= $menu.offset().left,
			_left	= $strip.offset().left - left,
			_width	= $strip.width();
		$doc.on('mouseenter', '.J-x-menu li', function() {
			var $this	= $(this);
			$strip.stop(true).animate({left: $(this).offset().left - left - _left, width: $this.width()}, 200);
		}).on('mouseleave', '.J-x-menu li', function() {
			$strip.stop(true).animate({left: 0, width: _width}, 200);
		});
		$win.on('resize', function() {
			left = $menu.offset().left;
			_left = $strip.offset().left - left;
		});
})(jQuery, window, document);

// carousel
(function($, undefined) {
	var Carousel = function(carousel, params) {
		params = params || {};
		this.carousel = carousel;
		this.$carousel = $(this.carousel);
		this.$items = this.$carousel.find('li');
		this.len = this.$items.length;
		this.height = this.$carousel.height();
		this.index = + this.$carousel.attr('data-index') || params.index || 0;
		this.duration = + this.$carousel.attr('data-duration') || params.duration || 400;
		this.interval = + this.$carousel.attr('data-interval') || params.interval || 3000;
		this.current = + this.$carousel.attr('data-current') || params.current || 'x-icons-carousel-panel-current';
		this.panels = + this.$carousel.attr('data-panels') || params.panels || 1;
		this.control = + this.$carousel.attr('data-control') || params.control || 0;
		this.$title = $(this.$carousel.attr('data-title-target') || params.titleTarget);
		this.$desc = $(this.$carousel.attr('data-desc-target') || params.descTarget);

		return this.init();
	};

	Carousel.prototype = {
		init: function() {
			if(this.len < 2) {
				this.$items.show();
				return;
			}
			this.reset();
			this.create();
			this.events();
			this.run(this.index, true);
			return;
		},
		events: function() {
			var _this = this;
			this.$carousel.on('mouseenter', '.carousel', function() {
				_this.pause();
			}).on('mouseleave', '.carousel', function() {
				_this.unpause();
			}).on('mouseenter', 'ol li', function() {
				_this.run(+ $(this).attr('data-index'));
			}).on('click', '.x-icons-carousel-prev', function() {
				_this.run(-1);
			}).on('click', '.x-icons-carousel-next', function() {
				_this.run();
			});
		},
		unpause: function() {
			this.pause = false;
			this.continue();
		},
		pause: function() {
			this.clear();
			this.pause = true;
		},
		run: function(n, init) {
			var $current, $target,
				j = n === undefined ? this.index + 1 : n < 0 ? this.index - 1 : n;
			if(!init && j == this.index) return;
			this.clear();
			j = (j + this.len) % this.len;
			$current = this.$items.eq(this.index);
			$target = this.$items.eq(j);
			if(init) {
				this.$items.hide();
				$current.show();
			} else {
				$current.stop(true).fadeOut(this.duration, function() {
					$(this).hide();
				});
				$target.stop(true).fadeIn(this.duration);
				this.panels && this.$panels.eq(this.index).removeClass(this.current);
			}
			this.panels && this.$panels.eq(j).addClass(this.current);
			this.$title && this.$title.html($target.attr('data-title'));
			this.$desc && this.$desc.html($target.attr('data-desc'));
			this.index = j;
			this.continue();
		},
		continue: function() {
			if(this.pause) return;
			this.timer = setTimeout(this.run, this.interval);
		},
		clear: function() {
			clearTimeout(this.timer);
		},
		create: function() {
			var ol = [];
			if(!this.panels) return;
			ol.push('<ol>');
			this.$items.each(function(i) {
				ol.push('<li class="x-icons x-icons-carousel-panel" data-index="' + i + '"></li>');
			});
			ol.push('</ol>');
			this.$panels = $(ol.join('')).appendTo(this.$carousel).find('li');
			if(!this.control) return;
			this.$carousel.append('<a href="javascript:;" class="control x-icons x-icons-carousel-prev"></a><a href="javascript:;" class="control x-icons x-icons-carousel-next"></a>');
		},
		reset: function() {
			var $carousel = this.$carousel.find('.carousel');
			if(!$carousel.length) return;
			this.$carousel = $carousel;
		}
	};

	$.fn.carousel = function(params) {
		return this.each(function() {
			new Carousel(this, params);
		});
	};

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
