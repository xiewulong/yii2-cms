<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\cms\models\SiteArticle;

$module = \Yii::$app->controller->module;
$this->title = \Yii::t($module->messageCategory, '{attribute} {action}', [
	'attribute' => \Yii::t($module->messageCategory, 'banner'),
	'action' => \Yii::t($module->messageCategory, 'list'),
]);

$statusClasses = ['text-muted', 'text-success', 'text-danger'];
?>

<!-- begin admin-title -->
<div class="clearfix admin-area admin-title">
	<?= Html::tag('h5', $this->title, ['class' => 'pull-left admin-heading']) ?>
</div>
<!-- end admin-title -->

<!-- begin admin-tabs -->
<div class="clearfix admin-area admin-tabs"></div>
<!-- end admin-tabs -->

<!-- begin admin-options -->
<div class="clearfix admin-area-sm admin-options">
	<?= Html::beginForm(null, 'get', ['class' => 'form-inline pull-left']) ?>
		<div class="form-group">
			<?= Html::listBox('stype', $stype, [
				'name' => \Yii::t($module->messageCategory, 'name'),
				'position' => \Yii::t($module->messageCategory, 'position'),
			], [
				'class' => 'form-control',
				'size' => 1,
			]) ?>
		</div>
		<div class="form-group">
			<?= Html::textInput('sword', $sword, [
				'class' => 'form-control',
				'placeholder' => \Yii::t($module->messageCategory, 'please {action} {attribute}', [
					'action' => \Yii::t($module->messageCategory, 'enter'),
					'attribute' => \Yii::t($module->messageCategory, 'search word'),
				]),
				'autofocus' => true,
			]) ?>
		</div>
		<div class="form-group">
			<?= Html::submitButton(\Yii::t($module->messageCategory, 'search'), ['class' => 'btn btn-primary']) ?>
		</div>
	<?= Html::endForm() ?>
	<div class="pull-right">
		<?= Html::a(\Yii::t($module->messageCategory, 'add'), ['banner/edit'], ['class' => 'btn btn-default pull-left']) ?>
	</div>
</div>
<!-- end admin-options -->

<!-- begin admin-table -->
<div class="admin-area-sm admin-table">
	<table class="table">
		<thead>
			<tr>
				<!-- <th width="6%" class="text-center"><?= Html::checkbox('all', null, ['data-check' => 'cb']) ?></th> -->
				<th width="20%"><?= \Yii::t($module->messageCategory, '{attribute} {action}', [
					'attribute' => \Yii::t($module->messageCategory, 'banner'),
					'action' => \Yii::t($module->messageCategory, 'name'),
				]) ?></th>
				<th width="10%"><?= \Yii::t($module->messageCategory, 'position') ?></th>
				<th width="10%" class="text-center"><?= \Yii::t($module->messageCategory, '{attribute} {action}', [
					'attribute' => \Yii::t($module->messageCategory, 'banner item'),
					'action' => \Yii::t($module->messageCategory, 'quantity'),
				]) ?></th>
				<th width="10%" class="text-center"><?= \Yii::t($module->messageCategory, '{action} {attribute}', [
					'action' => \Yii::t($module->messageCategory, 'total'),
					'attribute' => \Yii::t($module->messageCategory, 'page view'),
				]) ?></th>
				<th width="10%" class="text-center"><?= \Yii::t($module->messageCategory, '{action} {attribute}', [
					'action' => \Yii::t($module->messageCategory, 'total'),
					'attribute' => \Yii::t($module->messageCategory, 'unique visitor'),
				]) ?></th>
				<th width="10%" class="text-center"><?= \Yii::t($module->messageCategory, 'status') ?></th>
				<th class="text-center"><?= \Yii::t($module->messageCategory, 'operations') ?></th>
			</tr>
		</thead>
		<?php if($items) { ?>
		<tbody>
			<?php foreach($items as $item) { ?>
			<tr>
				<!-- <td class="text-center"><?= Html::checkbox('cb') ?></td> -->
				<td><?= Html::encode($item['name']) ?></td>
				<td><?= Html::encode($item['position']) ?></td>
				<td class="text-center"><?= Html::a($item['itemQuantity'], ['banner/items', 'mid' => $item['id']]) ?></td>
				<td class="text-center"><?= $item['itemTotalPageView'] ?></td>
				<td class="text-center"><?= $item['itemTotalUniqueVisitor'] ?></td>
				<td class="text-center <?= $statusClasses[$item['status']] ?>"><?= $item->getAttributeText('status') ?></td>
				<td class="text-center">
					<?= Html::a(\Yii::t($module->messageCategory, 'add') . \Yii::t($module->messageCategory, 'banner item'), ['banner/item-edit', 'mid' => $item['id']]) ?>
					<?= Html::tag('span', '|') ?>
					<?= Html::a(\Yii::t($module->messageCategory, 'manage') . \Yii::t($module->messageCategory, 'banner item'), ['banner/items', 'mid' => $item['id']]) ?>
					<?= Html::tag('span', '|') ?>
					<?= Html::a(\Yii::t($module->messageCategory, 'edit'), ['banner/edit', 'id' => $item['id']]) ?>
					<?= Html::tag('span', '|') ?>
					<?= Html::a(\Yii::t($module->messageCategory, 'delete'), ['module/delete'], ['data-delete' => $item['id']]) ?>
				</td>
			</tr>
			<? } ?>
		</tbody>
		<tfoot>
			<tr>
				<!-- <td class="text-center"><?= Html::checkbox('all', null, ['data-check' => 'cb']) ?></td> -->
				<td colspan="7">
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
				<td colspan="7" class="text-center empty">
					<?= Html::tag('i', null, ['class' => 'glyphicon glyphicon-info-sign text-success']) ?>
					<?= Html::tag('span', \Yii::t($module->messageCategory, 'no matched data')) ?>
				</td>
			</tr>
		</tfoot>
		<? } ?>
	</table>
</div>
<!-- end admin-table -->
