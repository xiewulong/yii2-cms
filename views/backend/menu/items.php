<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

$module = \Yii::$app->controller->module;
$this->title = \Yii::t($module->messageCategory, '{attribute} {action}', [
	'attribute' => $superior['name'] . \Yii::t($module->messageCategory, 'Menu item'),
	'action' => \Yii::t($module->messageCategory, 'Management'),
]);

// set parent route
$this->params['route'] = $module->url('menu/list');

$statusClasses = ['text-muted', 'text-success', 'text-danger'];
?>

<!-- begin admin-title -->
<div class="clearfix admin-area admin-title">
	<?= Html::tag('h5', $this->title, ['class' => 'pull-left admin-heading']) ?>
	<?= Html::a(\Yii::t($module->messageCategory, '{action} {attribute}', [
		'action' => \Yii::t($module->messageCategory, 'Back to'),
		'attribute' => \Yii::t($module->messageCategory, 'Menu') . \Yii::t($module->messageCategory, 'list'),
	]), [$this->params['route']], ['class' => 'btn btn-link pull-left']) ?>
</div>
<!-- end admin-title -->

<!-- begin admin-tabs -->
<div class="clearfix admin-area admin-tabs"></div>
<!-- end admin-tabs -->

<!-- begin admin-options -->
<div class="clearfix admin-area-sm admin-options">
	<?= Html::beginForm(null, 'get', ['class' => 'form-inline pull-left']) ?>
		<div class="form-group">
			<?= Html::listBox('type', $type, $typeItems, [
				'class' => 'form-control',
				'size' => 1,
			]) ?>
		</div>
		<div class="form-group">
			<?= Html::listBox('stype', $stype, [
				'title' => \Yii::t($module->messageCategory, 'Menu item') . \Yii::t($module->messageCategory, 'Title'),
			], [
				'class' => 'form-control',
				'size' => 1,
			]) ?>
		</div>
		<div class="form-group">
			<?= Html::textInput('sword', $sword, [
				'class' => 'form-control',
				'placeholder' => \Yii::t($module->messageCategory, 'Please {action} {attribute}', [
					'action' => \Yii::t($module->messageCategory, 'enter'),
					'attribute' => \Yii::t($module->messageCategory, 'Search word'),
				]),
				'autofocus' => true,
			]) ?>
		</div>
		<div class="form-group">
			<?= Html::submitButton(\Yii::t($module->messageCategory, 'Search'), ['class' => 'btn btn-primary']) ?>
		</div>
	<?= Html::endForm() ?>
	<div class="pull-right">
		<?= Html::a(\Yii::t($module->messageCategory, 'Add'), ['menu/item-edit', 'mid' => $superior['id']], ['class' => 'btn btn-default pull-left']) ?>
	</div>
</div>
<!-- end admin-options -->

<!-- begin admin-table -->
<div class="admin-area-sm admin-table">
	<table class="table">
		<thead>
			<tr>
				<!-- <th width="6%" class="text-center"><?= Html::checkbox('all', null, ['data-check' => 'cb']) ?></th> -->
				<th width="15%"><?= \Yii::t($module->messageCategory, 'Title') ?></th>
				<th width="10%" class="text-center"><?= \Yii::t($module->messageCategory, 'Type') ?></th>
				<th width="10%" class="text-center"><?= \Yii::t($module->messageCategory, 'Page view') ?></th>
				<th width="10%" class="text-center"><?= \Yii::t($module->messageCategory, 'Unique visitor') ?></th>
				<th width="15%"><?= \Yii::t($module->messageCategory, 'Menu') . \Yii::t($module->messageCategory, 'Name') ?></th>
				<th width="10%" class="text-center"><?= \Yii::t($module->messageCategory, 'Menu') . \Yii::t($module->messageCategory, 'Status') ?></th>
				<th width="10%" class="text-center"><?= \Yii::t($module->messageCategory, 'Status') ?></th>
				<th class="text-center"><?= \Yii::t($module->messageCategory, 'Operations') ?></th>
			</tr>
		</thead>
		<?php if($items) { ?>
		<tbody>
			<?php foreach($items as $item) { ?>
			<tr>
				<!-- <td class="text-center"><?= Html::checkbox('cb') ?></td> -->
				<td><?= Html::a($item['title'], ['link/jump', 'id' => $item['id']], ['target' => '_blank']) ?></td>
				<td class="text-center"><?= \Yii::t($module->messageCategory, $item->getAttributeText('type')) ?></td>
				<td class="text-center"><?= $item['pv'] ?></td>
				<td class="text-center"><?= $item['uv'] ?></td>
				<td><?= Html::encode($superior['name']) ?></td>
				<td class="text-center <?= $statusClasses[$superior['status']] ?>"><?= \Yii::t($module->messageCategory, $superior->getAttributeText('status')) ?></td>
				<td class="text-center <?= $statusClasses[$item['status']] ?>"><?= \Yii::t($module->messageCategory, $item->getAttributeText('status')) ?></td>
				<td class="text-center">
					<?= Html::a(\Yii::t($module->messageCategory, 'Edit'), ['menu/item-edit', 'mid' => $superior['id'], 'id' => $item['id']]) ?>
					<?= Html::tag('span', '|') ?>
					<?= Html::a(\Yii::t($module->messageCategory, 'Delete'), ['/menu/item-delete'], ['data-delete' => $item['id']]) ?>
				</td>
			</tr>
			<? } ?>
		</tbody>
		<tfoot>
			<tr>
				<!-- <td class="text-center"><?= Html::checkbox('all', null, ['data-check' => 'cb']) ?></td> -->
				<td colspan="8">
					<!-- <?= Html::button('Batch', ['class' => 'btn btn-default']) ?> -->
					<div class="pull-right">
						<?= LinkPager::widget([
							'pagination' => $pagination,
							'prevPageLabel' => '&lt;',
							'nextPageLabel' => '&gt;',
							'firstPageLabel' => '&laquo;',
							'lastPageLabel' => '&raquo;',
							'hideOnSinglePage' => false,
						]) ?>
					</div>
				</td>
			</tr>
		</tfoot>
		<?php } else { ?>
		<tfoot>
			<tr>
				<td colspan="8" class="text-center empty">
					<?= Html::tag('i', null, ['class' => 'glyphicon glyphicon-info-sign text-success']) ?>
					<?= Html::tag('span', \Yii::t($module->messageCategory, 'No matched data')) ?>
				</td>
			</tr>
		</tfoot>
		<? } ?>
	</table>
</div>
<!-- end admin-table -->