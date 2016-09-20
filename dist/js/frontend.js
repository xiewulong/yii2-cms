/*!
 * frontend
 * xiewulong <xiewulong@vip.qq.com>
 * create: 2016/8/8
 * since: 0.0.1
 */
'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/*!
 * frontend.carousel
 * xiewulong <xiewulong@vip.qq.com>
 * create: 2016/8/8
 * since: 0.0.1
 */
(function ($, undefined) {
	var Carousel = function () {
		function Carousel(carousel, params) {
			_classCallCheck(this, Carousel);

			params = params || {};
			this.carousel = carousel;
			this.$carousel = $(this.carousel);
			this.$items = this.$carousel.find('li');
			this.len = this.$items.length;
			this.height = this.$carousel.height();
			this.index = +this.$carousel.attr('data-index') || params.index || 0;
			this.duration = +this.$carousel.attr('data-duration') || params.duration || 400;
			this.interval = +this.$carousel.attr('data-interval') || params.interval || 3000;
			this.current = +this.$carousel.attr('data-current') || params.current || 'x-icons-carousel-panel-current';
			this.panels = +this.$carousel.attr('data-panels') || params.panels || 1;
			this.control = +this.$carousel.attr('data-control') || params.control || 0;
			this.$title = $(this.$carousel.attr('data-title-target') || params.titleTarget);
			this.$desc = $(this.$carousel.attr('data-desc-target') || params.descTarget);

			return this.init();
		}

		_createClass(Carousel, [{
			key: 'init',
			value: function init() {
				if (this.len < 2) {
					this.$items.show();
					return;
				}

				this.reset();
				this.create();
				this.events();
				this.run(this.index, true);

				return;
			}
		}, {
			key: 'events',
			value: function events() {
				var _this = this;

				this.$carousel.on('mouseenter', function () {
					_this.pause();
				}).on('mouseleave', function () {
					_this.unpause();
				}).on('mouseenter', 'ol li', function () {
					_this.run(+$(this).attr('data-index'));
				}).on('click', '.x-icons-carousel-prev', function () {
					_this.run(-1);
				}).on('click', '.x-icons-carousel-next', function () {
					_this.run();
				});
			}
		}, {
			key: 'unpause',
			value: function unpause() {
				this.paused = false;
				this.continue();
			}
		}, {
			key: 'pause',
			value: function pause() {
				this.clear();
				this.paused = true;
			}
		}, {
			key: 'run',
			value: function run(n, init) {
				var $current = void 0,
				    $target = void 0,
				    j = n === undefined ? this.index + 1 : n < 0 ? this.index - 1 : n;
				if (!init && j == this.index) return;
				this.clear();
				j = (j + this.len) % this.len;
				$current = this.$items.eq(this.index);
				$target = this.$items.eq(j);
				if (init) {
					this.$items.hide();
					$current.show();
				} else {
					$current.stop(true).fadeOut(this.duration, function () {
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
		}, {
			key: 'continue',
			value: function _continue() {
				var _this2 = this;

				if (this.paused) return;
				this.timer = setTimeout(function () {
					_this2.run();
				}, this.interval);
			}
		}, {
			key: 'clear',
			value: function clear() {
				clearTimeout(this.timer);
			}
		}, {
			key: 'create',
			value: function create() {
				var ol = [];
				if (!this.panels) return;
				ol.push('<ol>');
				this.$items.each(function (i) {
					ol.push('<li class="x-icons x-icons-carousel-panel" data-index="' + i + '"></li>');
				});
				ol.push('</ol>');
				this.$panels = $(ol.join('')).appendTo(this.$carousel).find('li');
				if (!this.control) return;
				this.$carousel.append('<a href="javascript:;" class="control x-icons x-icons-carousel-prev"></a><a href="javascript:;" class="control x-icons x-icons-carousel-next"></a>');
			}
		}, {
			key: 'reset',
			value: function reset() {
				var $carousel = this.$carousel.find('.carousel');
				if (!$carousel.length) return;
				this.$carousel = $carousel;
			}
		}]);

		return Carousel;
	}();

	$.fn.carousel = function (params) {
		return this.each(function () {
			new Carousel(this, params);
		});
	};
})(jQuery);

/*!
 * frontend.captcha
 * xiewulong <xiewulong@vip.qq.com>
 * create: 2016/8/8
 * since: 0.0.1
 */
(function ($, document, undefined) {
	var Captcha = function () {
		function Captcha(button) {
			_classCallCheck(this, Captcha);

			this.button = button;
			this.$button = $(this.button);
			this.$img = this.$button.attr('data-captcha-img') ? $(this.$button.attr('data-captcha-img')) : this.$button;
			this.url = this.$button.attr('data-captcha');

			return this.init();
		}

		_createClass(Captcha, [{
			key: 'init',
			value: function init() {
				this.refresh();

				return false;
			}
		}, {
			key: 'refresh',
			value: function refresh() {
				var _this3 = this;

				$.ajax({
					url: this.url,
					data: { refresh: 1 },
					method: 'get',
					dataType: 'json',
					success: function success(d) {
						d.url && _this3.src(d.url);
					}
				});
			}
		}, {
			key: 'src',
			value: function src(_src) {
				this.$img.attr('src', _src);
			}
		}]);

		return Captcha;
	}();

	$(document).on('click', '[data-captcha]', function () {
		return new Captcha(this);
	});
})(jQuery, document);
//# sourceMappingURL=frontend.js.map
