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
			<?= Html::activeLabel($site, 'name', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeTextInput($site, 'name', [
					'class' => 'form-control',
					'placeholder' => $site->getAttributeHint('name'),
					'autofocus' => $site->isFirstErrorAttribute('name') || !$site->hasErrors(),
				]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= Html::activeLabel($site, 'logo', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<div class="glyphicon glyphicon-picture admin-fileupload J-admin-fileupload" style="width:80px;height:80px;">
					<?= Fileupload::widget([
						'model' => $site,
						'attribute' => 'logo',
						'action' => '/' . $module->id . '/dashboard/fileupload',
						'type' => 'image',
						'max' => '2097152',
						'sizes' => '80x80|150x150',
						'options' => [
							'data-show' => '80x80',
						],
						'hiddenOptions' => [
							'data-thumb' => \Yii::$app->fileupload->addSuf($site->logo, [80, 80]),
						],
					]) ?>
				</div>
			</div>
		</div>
		<div class="form-group">
			<?= Html::activeLabel($site, 'author', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeTextInput($site, 'author', [
					'class' => 'form-control',
					'placeholder' => $site->getAttributeHint('author'),
					'autofocus' => $site->isFirstErrorAttribute('author'),
				]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= Html::activeLabel($site, 'keywords', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeTextarea($site, 'keywords', [
					'rows' => 6,
					'class' => 'form-control',
					'placeholder' => $site->getAttributeHint('keywords'),
					'autofocus' => $site->isFirstErrorAttribute('keywords'),
				]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= Html::activeLabel($site, 'description', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeTextarea($site, 'description', [
					'rows' => 6,
					'class' => 'form-control',
					'placeholder' => $site->getAttributeHint('description'),
					'autofocus' => $site->isFirstErrorAttribute('description'),
				]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= Html::activeLabel($site, 'status', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeRadioList($site, 'status', [
					0 => \Yii::t($module->messageCategory, 'Disabled'),
					10 => \Yii::t($module->messageCategory, 'Enabled'),
				], [
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
