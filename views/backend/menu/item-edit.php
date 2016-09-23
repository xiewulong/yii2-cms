<?php
use yii\helpers\Html;
use yii\attachment\widgets\Attachment;

$module = \Yii::$app->controller->module;
$this->title = \Yii::t($module->messageCategory, '{attribute} {action}', [
	'attribute' => \Yii::t($module->messageCategory, '{attribute} {action}', [
		'attribute' => $superior['name'],
		'action' => \Yii::t($module->messageCategory, 'Menu item'),
	]),
	'action' => \Yii::t($module->messageCategory, $item['isNewRecord'] ? 'Add' : 'Edit'),
]);

// set parent route
$this->params['route'] = $module->url('menu/list');
?>

<!-- begin admin-title -->
<div class="clearfix admin-area admin-title">
	<?= Html::tag('h5', $this->title, ['class' => 'pull-left admin-heading']) ?>
	<?= Html::a(\Yii::t($module->messageCategory, '{action} {attribute}', [
		'action' => \Yii::t($module->messageCategory, 'Back to'),
		'attribute' => \Yii::t($module->messageCategory, '{attribute} {action}', [
			'attribute' => \Yii::t($module->messageCategory, 'Menu item'),
			'action' => \Yii::t($module->messageCategory, 'List'),
		]),
	]), ['menu/items', 'mid' => $superior['id']], ['class' => 'btn btn-link pull-left']) ?>
</div>
<!-- end admin-title -->

<!-- begin admin-form -->
<?= Html::beginForm(null, 'post', ['class' => 'form-horizontal admin-area admin-form']) ?>
	<div class="fieldset">
		<div class="form-group title">
			<?= Html::activeLabel($item, 'title', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeTextInput($item, 'title', [
					'class' => 'form-control',
					'placeholder' => $item->getAttributeHint('title'),
					'autofocus' => $item->isFirstErrorAttribute('title') || !$item->hasErrors(),
				]) ?>
			</div>
		</div>
		<div class="form-group alias">
			<?= Html::activeLabel($item, 'alias', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeTextInput($item, 'alias', [
					'class' => 'form-control',
					'placeholder' => $item->getAttributeHint('alias'),
					'autofocus' => $item->isFirstErrorAttribute('alias'),
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
		<div class="form-group picture_id">
			<?= Html::activeLabel($item, 'picture_id', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Attachment::widget([
					'model' => $item,
					'attribute' => 'picture_id',
					'uploadAction' => $module->url('attachment/upload'),
					'loadAction' => $module->url('attachment'),
					'options' => [
						'class' => 'glyphicon glyphicon-picture admin-attachment J-admin-attachment',
						'style' => 'width:80px;height:80px;',
					],
				]) ?>
			</div>
		</div>
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
		<div class="form-group url">
			<?= Html::activeLabel($item, 'url', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeTextInput($item, 'url', [
					'class' => 'form-control',
					'placeholder' => $item->getAttributeHint('url'),
					'autofocus' => $item->isFirstErrorAttribute('url'),
				]) ?>
			</div>
		</div>
		<div class="form-group category_id">
			<?= Html::activeLabel($item, 'category_id', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-8">
				<?= Html::activeHiddenInput($item, 'category_id') ?>
				<?= Html::button(\Yii::t($module->messageCategory, 'Choose'), [
					'class' => 'btn btn-default',
					'data-form-selection' => $module->url('category/get'),
				]) ?>
				<?= Html::tag('span', $item['category'] ? $item['category']['name'] : null) ?>
			</div>
		</div>
		<div class="form-group article_id">
			<?= Html::activeLabel($item, 'article_id', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-8">
				<?= Html::activeHiddenInput($item, 'article_id') ?>
				<?= Html::button(\Yii::t($module->messageCategory, 'Choose'), [
					'class' => 'btn btn-default',
					'data-form-selection' => $module->url('article/get'),
				]) ?>
				<?= Html::tag('span', $item['article'] ? $item['article']['title'] : null) ?>
			</div>
		</div>
		<div class="form-group sub_module_id">
			<?= Html::activeLabel($item, 'sub_module_id', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-8">
				<?= Html::activeHiddenInput($item, 'sub_module_id') ?>
				<?= Html::button(\Yii::t($module->messageCategory, 'Choose'), [
					'class' => 'btn btn-default',
					'data-form-selection' => $module->url('menu/get?id=' . $superior['id']),
					'data-form-selected-clear' => 'enabled',
				]) ?>
				<?= Html::tag('span', $item['subModule'] ? Html::tag('i', null, ['class' => 'glyphicon glyphicon-remove', 'data-form-selected' => 'clear']) . $item['subModule']['name'] : null, ['class' => 'selection-name']) ?>
			</div>
		</div>
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
