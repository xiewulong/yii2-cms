/*!
 * frontend.carousel
 * xiewulong <xiewulong@vip.qq.com>
 * create: 2016/8/8
 * since: 0.0.1
 */
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
