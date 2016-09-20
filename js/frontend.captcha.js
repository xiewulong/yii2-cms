/*!
 * frontend.captcha
 * xiewulong <xiewulong@vip.qq.com>
 * create: 2016/8/8
 * since: 0.0.1
 */
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
