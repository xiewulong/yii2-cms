/*!
 * backend.user
 * xiewulong <xiewulong@vip.qq.com>
 * create: 2016/8/8
 * since: 0.0.1
 */

// logout
(($, window, document, undefined) => {

	$(document).on('click', '[data-user=logout] a.text', function() {
		let $this = $(this).parents('.dropdown-open').removeClass('dropdown-open').end();

		$.ajax({
			url: $this.attr('href'),
			data: $.csrf(),
			method: 'post',
			success: (d) => {
				if(d.error) {
					console.error(d.message);

					return false;
				}
				window.location.reload();
			}
		});

		return false;
	});

})(jQuery, window, document);

// password reset
(($, window, document, undefined) => {

	$(document).on('click', '[data-password=reset] a.text', function(e) {
		let $this	= $(this).parents('.dropdown-open').removeClass('dropdown-open').end(),
			$modal	= $.modal(	'<div class="modal fade">' +
									'<div class="modal-dialog">' +
										'<form class="modal-content form-horizontal">' +
											'<fieldset>' +
												'<div class="modal-header">' +
													'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
													'<h5 class="modal-title">' + $this.text() + '</h5>' +
												'</div>' +
												'<div class="modal-body">' +
													'<div class="form-group">' +
														'<label class="col-sm-3 control-label" for="password-old">原密码</label>' +
														'<div class="col-sm-6"><input type="password" name="password_old" id="password-old" class="form-control" autofocus="autofocus" /></div>' +
													'</div>' +
													'<div class="form-group">' +
														'<label class="col-sm-3 control-label" for="password">新密码</label>' +
														'<div class="col-sm-6"><input type="password" name="password" id="password" class="form-control" /></div>' +
													'</div>' +
													'<div class="form-group">' +
														'<label class="col-sm-3 control-label" for="password-repeat">确认新密码</label>' +
														'<div class="col-sm-6"><input type="password" name="password_repeat" id="password-repeat" class="form-control" /></div>' +
													'</div>' +
												'</div>' +
												'<div class="modal-footer">' +
													'<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>' +
													'<button type="submit" class="btn btn-primary">确定</button>' +
												'</div>' +
											'</fieldset>' +
										'</form>' +
									'</div>' +
								'</div>');

		$modal.on('submit', 'form', function() {
			let target, error,
				$fieldset	= $(this).find('fieldset').prop('disabled', true),
				User		= {
					password_old: this.password_old.value,
					password: this.password.value,
					password_repeat: this.password_repeat.value,
				};

			if(User.password_old == '') {
				target = this.password_old;
				error = '请输入原密码';
			} else if(User.password == '') {
				target = this.password;
				this.password.focus();
				error = '请输入新密码';
			} else if(User.password_repeat == '') {
				target = this.password_repeat;
				error = '请确认新密码';
			} else if(User.password != User.password_repeat) {
				target = this.password_repeat;
				error = '两次输入的新密码不一致';
			}
			if(error) {
				$fieldset.prop('disabled', false);
				target.focus();
				return false;
			}

			$.ajax({
				url: $this.attr('href'),
				data: $.csrf({User: User}),
				method: 'post',
				dataType: 'json',
				success: (d) => {
					d.error ? $fieldset.prop('disabled', false) : $modal.modal('hide');
					$.alert(d.message, d.error);
				}
			});

			return false;
		});

		return false;
	});

})(jQuery, window, document);
