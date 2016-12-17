/*!
 * backend
 * xiewulong <xiewulong@vip.qq.com>
 * create: 2016/8/8
 * since: 0.0.1
 */

// styles
import '../scss/backend.scss';

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

// switch
(($, undefined) => {

	class Radio {

		constructor($target, unsupportList, defaultValue, staticSelect, parentItems, parentItemsValue) {
			this.$target = $target;
			this.unsupportList = unsupportList;
			this.value = defaultValue;
			this.parentItems = parentItems;
			this.parentItemsValue = parentItemsValue;
			this.$formGroups = $('.form-group');
			if(staticSelect) {
				this.$static = $(staticSelect);
				this.value = this.value == '' ? this.$target.val() : this.value;
			}

			return this.init();
		}

		init() {
			this.events();
			this.switch();

			return this.$target;
		}

		events() {
			let _this = this;
			this.$target.on('change', function() {
				_this.value = this.value;
				_this.switch();
			});
		}

		switch() {
			let unsupports, itemValue, itemName;
			if(this.$static) {
				itemValue = this.parentItems[this.value];
				this.$static.html(this.parentItemsValue[itemValue] || '');
				this.value = itemValue;
			}
			unsupports	= this.unsupportList[this.value] || [];
			this.$formGroups.show();
			if(!unsupports.length) return;
			this.$formGroups.filter('.' + unsupports.join(', .')).hide();
		}

	}

	$.fn.radioFormSwitch = function(unsupportList, defaultValue, staticSelect, parentItems, parentItemsValue) {
		return new Radio(this, unsupportList, defaultValue, staticSelect, parentItems, parentItemsValue);
	};

	$.fn.formSwitch = function(unsupportList, defaultValue, staticSelect, parentItems, parentItemsValue) {
		let type = this.attr('data-form-switch');

		if(this[type + 'FormSwitch']) {
			return this[type + 'FormSwitch'](unsupportList, defaultValue, staticSelect, parentItems, parentItemsValue);
		}

		return this;
	};

})(jQuery);

// data selection
(($, document, undefined) => {
	let $doc		= $(document);

	class Selection {

		constructor(button) {
			this.$button	= $(button);
			this.$formGroup	= this.$button.parents('.form-group');
			this.$label		= this.$formGroup.find('label');
			this.$hidden	= this.$formGroup.find('input[type=hidden]');
			this.$name		= this.$formGroup.find('span');
			this.url		= this.$button.attr('data-form-selection');
			this._value		= this.$hidden.val();

			return this.init();
		}

		init() {
			this.getData();
			this.modal();
			this.events();

			return;
		}

		events() {
			let _this	= this;
			this.$modal.on('click', 'ul li p', function() {
				let $this	= $(this);
				if($this.next('ul').length) {
					$this.parent('li').toggleClass('unfold');
					return false;
				}
				if($this.hasClass('active')) {
					return false;
				}
				_this.value = $this.attr('data-id');
				_this.name = $this.attr('data-name');
				_this.setValue();
				return false;
			});
			this.$name.on('click', 'i', function() {
				_this.clearAll();
			});
		}

		setValue() {
			this.$hidden.val(this.value);
			this.$name.html((this.$button.attr('data-form-selected-clear') ? '<i class="glyphicon glyphicon-remove" data-form-selected="clear"></i>' : '') + this.name);
			this.close();
		}

		close() {
			this.$modal.modal('hide');
		}

		modal() {
			let html =	'<div class="modal fade">' +
							'<div class="modal-dialog">' +
								'<div class="modal-content">' +
									'<div class="modal-header">' +
										'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
										'<h5 class="modal-title">' + this.$label.text() + '</h5>' +
									'</div>' +
									'<div class="modal-body admin-selection admin-loading"></div>' +
								'</div>' +
							'</div>' +
						'</div>';
			this.$modal = $.modal(html);
			this.setData();
		}

		setData() {
			let _render, list,
				_this	= this;
			if(this.loaded || !this.data) return;
			this.loaded = true;
			list = (_render = (items) => {
				let item,
					i		= 0,
					len		= items.length,
					html	= ['<ul>'];
				for(; i < len; i++) {
					let hasSub;
					item = items[i];
					hasSub = item.children || item.items;
					html.push('<li><p' + (!hasSub && this._value && item.id == this._value ? ' class="active"' : '') + ' data-id="' + item.id + '" data-name="' + item.name + '">' + (hasSub ? '<i class="glyphicon glyphicon-triangle-bottom"></i>' : '') + item.name + '</p>');
					item.children && html.push(_render(item.children));
					item.items && html.push(_render(item.items));
					html.push('</li>');
				}
				html.push('</ul>');
				return html.join('');
			})(this.data);
			this.$modal.find('.admin-loading').removeClass('admin-loading').html(list);
		}

		getData() {
			$.ajax({
				url: this.url,
				data: {},
				method: 'get',
				dataType: 'json',
				success: (d) => {
					if(d.error) {
						$.alert(d.message);
					}
					this.data = d.data;
					this.setData();
				}
			});
		}

	}

	$doc.on('click', '[data-form-selection]', function() {
		new Selection(this);
	}).on('click', '[data-form-selected=clear]', function() {
		let $this	= $(this);
		$this.parent('.selection-name').html('').prevAll('input[type=hidden]').val('');
	});
})(jQuery, document);
