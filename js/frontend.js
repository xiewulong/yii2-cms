/*!
 * frontend
 * xiewulong <xiewulong@vip.qq.com>
 * create: 2016/8/8
 * since: 0.0.1
 */

// styles
import '../scss/frontend.scss';

// carousel
(($, undefined) => {

	class Carousel {

		constructor(carousel, params) {
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
		}

		init() {
			if(this.len < 2) {
				this.$items.show();
				return;
			}

			this.reset();
			this.create();
			this.events();
			this.run(this.index, true);

			return;
		}

		events() {
			let _this = this;

			this.$carousel.on('mouseenter', function() {
				_this.pause();
			}).on('mouseleave', function() {
				_this.unpause();
			}).on('mouseenter', 'ol li', function() {
				_this.run(+ $(this).attr('data-index'));
			}).on('click', '.x-icons-carousel-prev', function() {
				_this.run(-1);
			}).on('click', '.x-icons-carousel-next', function() {
				_this.run();
			});
		}

		unpause() {
			this.paused = false;
			this.continue();
		}

		pause() {
			this.clear();
			this.paused = true;
		}

		run(n, init) {
			let $current, $target,
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
		}

		continue() {
			if(this.paused) return;
			this.timer = setTimeout(() => {
				this.run();
			}, this.interval);
		}

		clear() {
			clearTimeout(this.timer);
		}

		create() {
			let ol = [];
			if(!this.panels) return;
			ol.push('<ol>');
			this.$items.each(function(i) {
				ol.push('<li class="x-icons x-icons-carousel-panel" data-index="' + i + '"></li>');
			});
			ol.push('</ol>');
			this.$panels = $(ol.join('')).appendTo(this.$carousel).find('li');
			if(!this.control) return;
			this.$carousel.append('<a href="javascript:;" class="control x-icons x-icons-carousel-prev"></a><a href="javascript:;" class="control x-icons x-icons-carousel-next"></a>');
		}

		reset() {
			let $carousel = this.$carousel.find('.carousel');
			if(!$carousel.length) return;
			this.$carousel = $carousel;
		}

	}

	$.fn.carousel = function(params) {
		return this.each(function() {
			new Carousel(this, params);
		});
	};

})(jQuery);

// captcha
(($, document, undefined) => {

	class Captcha {

		constructor(button) {
			this.button = button;
			this.$button = $(this.button);
			this.$img = this.$button.attr('data-captcha-img') ? $(this.$button.attr('data-captcha-img')) : this.$button;
			this.url = this.$button.attr('data-captcha');

			return this.init();
		}

		init() {
			this.refresh();

			return false;
		}

		refresh() {
			$.ajax({
				url: this.url,
				data: {refresh: 1},
				method: 'get',
				dataType: 'json',
				success: (d) => {
					d.url && this.src(d.url);
				}
			});
		}

		src(src) {
			this.$img.attr('src', src);
		}
	}

	$(document).on('click', '[data-captcha]', function() {
		return new Captcha(this);
	});

})(jQuery, document);

// marquee
(($, document, undefined) => {

	class Marquee {

		constructor(target) {
			this.$target = $(target);
			this.$scroller = this.$target.find('.scroller');
			this.$ul = this.$scroller.find('ul');
			this.$li = this.$ul.find('li');
			this.len = this.$li.length;

			if(this.len <= 5) {
				return;
			}

			this.w = this.$li.width() + parseInt(this.$li.css('paddingRight'));
			this.width = this.w * this.len;
			this.$scroller.width(this.width * 2).append(this.$ul.clone());
			this.current = 0;
			this.speed = 30;

			this.events();
			this.go();
		}

		pause() {
			clearTimeout(this.timer);
		}

		go() {
			this.pause();

			let current = this.current - 1;
			if(current < - this.width) {
				current = 0;
			}

			this.$scroller.css({marginLeft: current});
			this.current = current;

			this.timer = setTimeout(this.go.bind(this), this.speed);
		}

		events() {
			this.$target.hover(this.pause.bind(this), this.go.bind(this));
		}

	}

	$('.J-marquee').each(function() {
		return new Marquee(this);
	});

})(jQuery, document);
