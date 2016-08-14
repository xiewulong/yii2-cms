<?php
use yii\helpers\Html;
use yii\fileupload\Fileupload;
use yii\xui\Ueditor;

$module = \Yii::$app->controller->module;
$this->title = \Yii::t($module->messageCategory, '{attribute} {action}', [
	'attribute' => \Yii::t($module->messageCategory, 'Article'),
	'action' => \Yii::t($module->messageCategory, $item['id'] ? 'Edit' : 'Add'),
]);

// set parent menu
$this->params['parent'] = '/' . $module->id . '/article/list';
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
<?= Html::beginForm(null, 'post', ['class' => 'form-horizontal admin-area admin-form']) ?>
	<div class="fieldset">
		<div class="form-group">
			<?= Html::activeLabel($item, 'category_id', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-3">
				<?= $item['id']
					? Html::tag('p', $item['category']['name'], ['class' => 'form-control-static'])
					 : Html::activeListBox($item, 'category_id', $categoryItems, [
						'class' => 'form-control',
						'size' => 1,
					]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= Html::activeLabel($item, 'title', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeTextInput($item, 'title', [
					'class' => 'form-control',
					'placeholder' => $item->getAttributeHint('title'),
					'autofocus' => $item->isFirstErrorAttribute('title') || !$item->hasErrors(),
				]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= Html::activeLabel($item, 'keywords', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeTextInput($item, 'keywords', [
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
			<?= Html::activeLabel($item, 'type', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::activeRadioList($item, 'type', $item->getAttributeItems('type'), [
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
			<?= Html::activeLabel($item, 'picture', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-8">
				<?php
				$pictures = is_array($item['pictures']) ? $item['pictures'] : $item['pictureList'];
				foreach($pictures as $picture) {
				?>
				<?= Fileupload::widget([
					'attribute' => Html::getInputName($item, 'pictures[]'),
					'value' => $picture,
					'action' => '/' . $module->id . '/dashboard/fileupload',
					'type' => 'image',
					'max' => '2097152',
					'sizes' => '80x80|150x150',
					'options' => [
						'class' => 'glyphicon glyphicon-picture admin-fileupload admin-fileuploads J-admin-fileupload',
						'style' => 'width:80px;height:80px;',
					],
					'fileOptions' => [
						'data-show' => '80x80',
					],
					'hiddenOptions' => [
						'data-thumb' => \Yii::$app->fileupload->addSuf($picture, [80, 80]),
					],
				]) ?>
				<? } ?>
				<?= Fileupload::widget([
					'attribute' => Html::getInputName($item, 'pictures[]'),
					'action' => '/' . $module->id . '/dashboard/fileupload',
					'type' => 'image',
					'max' => '2097152',
					'sizes' => '80x80|150x150',
					'options' => [
						'class' => 'glyphicon glyphicon-plus admin-fileupload J-admin-fileupload',
						'data-fileupload-max' => 0,
						'style' => 'width:80px;height:80px;',
					],
					'fileOptions' => [
						'data-show' => '80x80',
					],
				]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= Html::activeLabel($item, 'content', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-8">
				<?= Ueditor::widget([
					'name' => Html::getInputName($item, 'content'),
					'value' => Html::getAttributeValue($item, 'content'),
					'id' => Html::getInputId($item, 'content'),
					'action' => '/' . $module->id . '/dashboard/ueditor',
					'options' => [
						'initialFrameHeight' => 600,
					],
				]) ?>
			</div>
		</div>
		<div class="form-group">
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
