<?php
use yii\helpers\Html;

$module = \Yii::$app->controller->module;
$this->title = \Yii::t($module->messageCategory, '{attribute} {action}', [
	'attribute' => \Yii::t($module->messageCategory, 'Category'),
	'action' => \Yii::t($module->messageCategory, 'edit'),
]);

// set parent menu
$this->params['parent'] = '/' . $module->id . '/category/list';
?>

<!-- begin admin-title -->
<div class="clearfix admin-area admin-title">
	<?= Html::tag('h5', $this->title, ['class' => 'pull-left admin-heading']) ?>
	<?= Html::a(\Yii::t($module->messageCategory, '{action} {attribute}', [
		'action' => \Yii::t($module->messageCategory, 'Back to'),
		'attribute' => \Yii::t($module->messageCategory, 'list'),
	]), [$this->params['parent']], ['class' => 'btn btn-link pull-left']) ?>
</div>
<!-- end admin-title -->

<!-- begin admin-form -->
<?= Html::beginForm(null, null, ['class' => 'form-horizontal admin-area admin-form']) ?>
	<div class="fieldset">
		<?= $item->firstErrorInFirstErrors ?>
		<div class="form-group">
			<?= Html::activeLabel($item, 'name', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeTextInput($item, 'name', [
					'class' => 'form-control',
					'placeholder' => $item->getAttributeHint('name'),
					'autofocus' => $item->isFirstErrorAttribute('name') || !$item->hasErrors(),
				]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= Html::activeLabel($item, 'status', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeRadioList($item, 'status', [
					0 => \Yii::t($module->messageCategory, 'Disabled'),
					10 => \Yii::t($module->messageCategory, 'Enabled'),
				], [
					'unselect' => 10,
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