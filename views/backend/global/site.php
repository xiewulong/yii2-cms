<?php
use yii\helpers\Html;
use yii\fileupload\Fileupload;

$module = \Yii::$app->controller->module;
$this->title = \Yii::t($module->messageCategory, 'Global');

// set parent route
// $this->params['route'] = '';
?>

<!-- begin admin-title -->
<div class="clearfix admin-area admin-title">
	<?= Html::tag('h5', $this->title, ['class' => 'pull-left admin-heading']) ?>
</div>
<!-- end admin-title -->

<!-- begin admin-form -->
<?= Html::beginForm(null, 'post', ['class' => 'form-horizontal admin-area admin-form']) ?>
	<div class="fieldset">
		<div class="form-group type">
			<?= Html::activeLabel($item, 'type', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeRadioList($item, 'type', $item->getAttributeItems('type'), [
					'itemOptions' => [
						'data-form-switch' => 'radio',
						'labelOptions' => [
							'class' => 'radio-inline',
						],
					],
				]) ?>
				<?php $this->registerJs('$("[data-form-switch=radio]").formSwitch(' . $item->getAttributeItems('type', 1, true) . ', "' . $item['type'] . '");', 3); ?>
			</div>
		</div>
		<div class="form-group name">
			<?= Html::activeLabel($item, 'name', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeTextInput($item, 'name', [
					'class' => 'form-control',
					'placeholder' => $item->getAttributeHint('name'),
					'autofocus' => $item->isFirstErrorAttribute('name') || !$item->hasErrors(),
				]) ?>
			</div>
		</div>
		<div class="form-group logo">
			<?= Html::activeLabel($item, 'logo', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Fileupload::widget([
					'model' => $item,
					'attribute' => 'logo',
					'action' => $module->url('dashboard/fileupload'),
					'type' => 'image',
					'max' => '2097152',
					'sizes' => '80x80',
					'options' => [
						'class' => 'glyphicon glyphicon-picture admin-fileupload J-admin-fileupload',
						'style' => 'width:80px;height:80px;',
					],
					'fileOptions' => [
						'data-show' => '80x80',
					],
					'hiddenOptions' => [
						'data-thumb' => \Yii::$app->fileupload->addSuf($item['logo'], [80, 80]),
					],
				]) ?>
			</div>
		</div>
		<div class="form-group brief">
			<?= Html::activeLabel($item, 'brief', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeTextarea($item, 'brief', [
					'rows' => 6,
					'class' => 'form-control',
					'placeholder' => $item->getAttributeHint('brief'),
					'autofocus' => $item->isFirstErrorAttribute('brief'),
				]) ?>
			</div>
		</div>
		<div class="form-group author">
			<?= Html::activeLabel($item, 'author', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-3">
				<?= Html::activeTextInput($item, 'author', [
					'class' => 'form-control',
					'placeholder' => $item->getAttributeHint('author'),
					'autofocus' => $item->isFirstErrorAttribute('author'),
				]) ?>
			</div>
		</div>
		<div class="form-group keywords">
			<?= Html::activeLabel($item, 'keywords', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeTextarea($item, 'keywords', [
					'rows' => 6,
					'class' => 'form-control',
					'placeholder' => $item->getAttributeHint('keywords'),
					'autofocus' => $item->isFirstErrorAttribute('keywords'),
				]) ?>
			</div>
		</div>
		<div class="form-group description">
			<?= Html::activeLabel($item, 'description', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeTextarea($item, 'description', [
					'rows' => 6,
					'class' => 'form-control',
					'placeholder' => $item->getAttributeHint('description'),
					'autofocus' => $item->isFirstErrorAttribute('description'),
				]) ?>
			</div>
		</div>
		<div class="form-group phone">
			<?= Html::activeLabel($item, 'phone', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-3">
				<?= Html::activeTextInput($item, 'phone', [
					'class' => 'form-control',
					'placeholder' => $item->getAttributeHint('phone'),
					'autofocus' => $item->isFirstErrorAttribute('phone'),
				]) ?>
			</div>
		</div>
		<div class="form-group email">
			<?= Html::activeLabel($item, 'email', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-3">
				<?= Html::activeTextInput($item, 'email', [
					'class' => 'form-control',
					'placeholder' => $item->getAttributeHint('email'),
					'autofocus' => $item->isFirstErrorAttribute('email'),
				]) ?>
			</div>
		</div>
		<div class="form-group address">
			<?= Html::activeLabel($item, 'address', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeTextarea($item, 'address', [
					'rows' => 6,
					'class' => 'form-control',
					'placeholder' => $item->getAttributeHint('address'),
					'autofocus' => $item->isFirstErrorAttribute('address'),
				]) ?>
			</div>
		</div>
		<div class="form-group qq">
			<?= Html::activeLabel($item, 'qq', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeTextInput($item, 'qq', [
					'class' => 'form-control',
					'placeholder' => $item->getAttributeHint('qq'),
					'autofocus' => $item->isFirstErrorAttribute('qq'),
				]) ?>
			</div>
		</div>
		<!-- <div class="form-group weixin">
			<?= Html::activeLabel($item, 'weixin', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Fileupload::widget([
					'model' => $item,
					'attribute' => 'weixin',
					'action' => $module->url('dashboard/fileupload'),
					'type' => 'image',
					'max' => '2097152',
					'sizes' => '80x80',
					'options' => [
						'class' => 'glyphicon glyphicon-picture admin-fileupload J-admin-fileupload',
						'style' => 'width:80px;height:80px;',
					],
					'fileOptions' => [
						'data-show' => '80x80',
					],
					'hiddenOptions' => [
						'data-thumb' => \Yii::$app->fileupload->addSuf($item['weixin'], [80, 80]),
					],
				]) ?>
			</div>
		</div> -->
		<div class="form-group weibo">
			<?= Html::activeLabel($item, 'weibo', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeTextInput($item, 'weibo', [
					'class' => 'form-control',
					'placeholder' => $item->getAttributeHint('weibo'),
					'autofocus' => $item->isFirstErrorAttribute('weibo'),
				]) ?>
			</div>
		</div>
		<!-- <div class="form-group copyright">
			<?= Html::activeLabel($item, 'copyright', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeTextInput($item, 'copyright', [
					'class' => 'form-control',
					'placeholder' => $item->getAttributeHint('copyright'),
					'autofocus' => $item->isFirstErrorAttribute('copyright'),
				]) ?>
			</div>
		</div> -->
		<div class="form-group powered">
			<?= Html::activeLabel($item, 'powered', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeTextInput($item, 'powered', [
					'class' => 'form-control',
					'placeholder' => $item->getAttributeHint('powered'),
					'autofocus' => $item->isFirstErrorAttribute('powered'),
				]) ?>
			</div>
		</div>
		<div class="form-group powered_url">
			<?= Html::activeLabel($item, 'powered_url', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeTextInput($item, 'powered_url', [
					'class' => 'form-control',
					'placeholder' => $item->getAttributeHint('powered_url'),
					'autofocus' => $item->isFirstErrorAttribute('powered_url'),
				]) ?>
			</div>
		</div>
		<div class="form-group record">
			<?= Html::activeLabel($item, 'record', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeTextInput($item, 'record', [
					'class' => 'form-control',
					'placeholder' => $item->getAttributeHint('record'),
					'autofocus' => $item->isFirstErrorAttribute('record'),
				]) ?>
			</div>
		</div>
		<!-- <div class="form-group license">
			<?= Html::activeLabel($item, 'license', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeTextInput($item, 'license', [
					'class' => 'form-control',
					'placeholder' => $item->getAttributeHint('license'),
					'autofocus' => $item->isFirstErrorAttribute('license'),
				]) ?>
			</div>
		</div> -->
		<div class="form-group status">
			<?= Html::activeLabel($item, 'status', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeRadioList($item, 'status', $item->getAttributeItems('status'), [
					'itemOptions' => [
						'labelOptions' => [
							'class' => 'radio-inline',
						],
					],
				]) ?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-4 col-sm-push-2">
				<?= Html::submitButton(\Yii::t($module->messageCategory, 'Submit'), ['class' => 'btn btn-primary']) ?>
			</div>
		</div>
	</div>
<?= Html::endForm() ?>
<!-- end admin-form -->
