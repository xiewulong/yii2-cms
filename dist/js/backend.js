/*!
 * backend
 * xiewulong <xiewulong@vip.qq.com>
 * create: 2016/8/8
 * version: 0.0.1
 */

// csrf
(function($, document, undefined) {
	var param	= $('meta[name=csrf-param]').attr('content'),
		token	= $('meta[name=csrf-token]').attr('content');
	$.csrf = function(data) {
		data = data || {};
		data[param] = token;
		return data;
	};
})(jQuery, document);

// modal
(function($, document, undefined) {
	$.modal = function(html, options) {
		// html sample
		// '<div class="modal fade">' +
		// 	'<div class="modal-dialog">' +
		// 		'<div class="modal-content">' +
		// 			'<div class="modal-header">' +
		// 				'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
		// 				'<h4 class="modal-title">Modal title</h4>' +
		// 			'</div>' +
		// 			'<div class="modal-body">' +
		// 				'<p>One fine body&hellip;</p>' +
		// 			'</div>' +
		// 			'<div class="modal-footer">' +
		// 				'<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>' +
		// 				'<button type="button" class="btn btn-primary">Save changes</button>' +
		// 			'</div>' +
		// 		'</div>' +
		// 	'</div>' +
		// '</div>';

		return $(html).modal($.extend({backdrop: 'static'}, options)).on('shown.bs.modal', function() {
			$(this).find('[autofocus=autofocus]').focus();
		}).on('hidden.bs.modal', function() {
			$(this).remove();
		});
	};
})(jQuery, document);

// user logout
(function($, window, document, undefined) {
	$(document).on('click', '.J-admin-header li[data-user=logout]', function() {
		var $this	= $(this).parents('.dropdown-open').removeClass('dropdown-open').end();
		$.ajax({
			url: $this.find('a.text').attr('href'),
			data: $.csrf(),
			method: 'post',
			success: function(d) {
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
(function($, window, document, undefined) {
	$(document).on('click', '.J-admin-header li[data-password=reset]', function(e) {
		var $this	= $(this).parents('.dropdown-open').removeClass('dropdown-open').end(),
			$modal	= $.modal(	'<div class="modal fade">' +
									'<div class="modal-dialog">' +
										'<form class="modal-content form-horizontal" action="' + $this.find('a.text').attr('href') + '" method="post">' +
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
													'<button type="submit" class="btn btn-primary">确定</button>' +
													'<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>' +
												'</div>' +
											'</fieldset>' +
										'</form>' +
									'</div>' +
								'</div>');
		$modal.on('submit', 'form', function() {
			var target, error,
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
				url: this.action,
				data: $.csrf({User: User}),
				method: this.method,
				success: function(d) {
					if(d.error) {
						console.error(d.message);
						$fieldset.prop('disabled', false);
						return false;
					}
					$modal.modal('hide');
				}
			});
			return false;
		});
		return false;
	});
})(jQuery, window, document);
