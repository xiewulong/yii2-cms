<?php
use yii\helpers\Html;
use yii\xui\Ueditor;

$module = \Yii::$app->controller->module;
$this->title = \Yii::t($module->messageCategory, 'About us');
?>

<!-- begin admin-title -->
<div class="clearfix admin-area admin-title">
	<?= Html::tag('h5', $this->title, ['class' => 'pull-left admin-heading']) ?>
</div>
<!-- end admin-title -->

<!-- begin admin-form -->
<?= Html::beginForm(null, null, ['class' => 'form-horizontal admin-area admin-form']) ?>
	<div class="fieldset">
		<div class="form-group">
			<?= Html::activeLabel($item, 'about', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-8">
				<?= Ueditor::widget([
					'name' => Html::getInputName($item, 'about'),
					'value' => Html::getAttributeValue($item, 'about'),
					'id' => Html::getInputId($item, 'about'),
					'action' => $module->url('dashboard/ueditor'),
					'options' => [
						'initialFrameHeight' => 600,
					],
				]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= Html::activeLabel($item, 'about_status', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeRadioList($item, 'about_status', $item->getAttributeItems('about_status'), [
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
