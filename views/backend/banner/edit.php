<?php
use yii\helpers\Html;

$module = \Yii::$app->controller->module;
$this->title = \Yii::t($module->messageCategory, '{attribute} {action}', [
	'attribute' => \Yii::t($module->messageCategory, 'Banner'),
	'action' => \Yii::t($module->messageCategory, $item['id'] ? 'Edit' : 'Add'),
]);

// set parent route
$this->params['route'] = $module->url('banner/list');
?>

<!-- begin admin-title -->
<div class="clearfix admin-area admin-title">
	<?= Html::tag('h5', $this->title, ['class' => 'pull-left admin-heading']) ?>
	<?= Html::a(\Yii::t($module->messageCategory, '{action} {attribute}', [
		'action' => \Yii::t($module->messageCategory, 'Back to'),
		'attribute' => \Yii::t($module->messageCategory, 'list'),
	]), [$this->params['route']], ['class' => 'btn btn-link pull-left']) ?>
</div>
<!-- end admin-title -->

<!-- begin admin-form -->
<?= Html::beginForm(null, 'post', ['class' => 'form-horizontal admin-area admin-form']) ?>
	<div class="fieldset">
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
		<div class="form-group position">
			<?= Html::activeLabel($item, 'position', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeTextInput($item, 'position', [
					'class' => 'form-control',
					'placeholder' => $item->getAttributeHint('position'),
					'autofocus' => $item->isFirstErrorAttribute('position'),
				]) ?>
			</div>
		</div>
		<div class="form-group status">
			<?= Html::activeLabel($item, 'status', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeRadioList($item, 'status', $item->getAttributeItems('status'), [
					'unselect' => 1,
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
