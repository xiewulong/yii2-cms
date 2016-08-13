<?php
use yii\helpers\Html;
use yii\fileupload\Fileupload;

$module = \Yii::$app->controller->module;
$this->title = \Yii::t($module->messageCategory, 'Global');
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
			<?= Html::activeLabel($item, 'logo', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Fileupload::widget([
					'model' => $item,
					'attribute' => 'logo',
					'action' => '/' . $module->id . '/dashboard/fileupload',
					'type' => 'image',
					'max' => '2097152',
					'sizes' => '80x80|150x150',
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
		<div class="form-group">
			<?= Html::activeLabel($item, 'author', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeTextInput($item, 'author', [
					'class' => 'form-control',
					'placeholder' => $item->getAttributeHint('author'),
					'autofocus' => $item->isFirstErrorAttribute('author'),
				]) ?>
			</div>
		</div>
		<div class="form-group">
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
		<div class="form-group">
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
		<div class="form-group">
			<?= Html::activeLabel($item, 'status', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeRadioList($item, 'status', $item->getAttributeItems('status'), [
					'unselect' => 2,
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
