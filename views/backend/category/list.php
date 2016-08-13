<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\cms\models\SiteArticle;

$module = \Yii::$app->controller->module;
$this->title = \Yii::t($module->messageCategory, '{attribute} {action}', [
	'attribute' => \Yii::t($module->messageCategory, 'Category'),
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
	<div class="pull-right">
		<?= Html::a(\Yii::t($module->messageCategory, 'Add'), ['/' . $module->id . '/category/edit'], ['class' => 'btn btn-default pull-left']) ?>
	</div>
</div>
<!-- end admin-options -->

<!-- begin admin-table -->
<div class="admin-area-sm admin-table">
	<table class="table">
		<thead>
			<tr>
				<!-- <th width="6%" class="text-center"><?= Html::checkbox('all', null, ['data-check' => 'cb']) ?></th> -->
				<th width="30%"><?= \Yii::t($module->messageCategory, 'Category') . \Yii::t($module->messageCategory, 'Name') ?></th>
				<th width="10%" class="text-center"><?= \Yii::t($module->messageCategory, 'Article') . \Yii::t($module->messageCategory, 'Quantity') ?></th>
				<th width="10%" class="text-center"><?= \Yii::t($module->messageCategory, 'Total') . \Yii::t($module->messageCategory, 'Page view') ?></th>
				<!-- <th width="10%" class="text-center"><?= \Yii::t($module->messageCategory, 'Total') . \Yii::t($module->messageCategory, 'Unique Visitor') ?></th> -->
				<th width="20%" class="text-center"><?= \Yii::t($module->messageCategory, 'Status') ?></th>
				<th class="text-center"><?= \Yii::t($module->messageCategory, 'Operations') ?></th>
			</tr>
		</thead>
		<?php if($items) { ?>
		<tbody>
			<?php foreach($items as $item) { ?>
			<tr>
				<!-- <td class="text-center"><?= Html::checkbox('cb') ?></td> -->
				<td><?= $item['name'] ?></td>
				<td class="text-center"><?= Html::a($item['articleQuantity'], ['/' . $module->id . '/article/list', 'cid' => $item['id']]) ?></td>
				<td class="text-center"><?= $item['totalPageView'] ?></td>
				<!-- <td class="text-center"><?= $item['totalUniqueVisitor'] ?></td> -->
				<td class="text-center <?= $statusClasses[$item['status']] ?>"><?= \Yii::t($module->messageCategory, $item->getAttributeText('status')) ?></td>
				<td class="text-center">
					<?= Html::a(\Yii::t($module->messageCategory, 'Add') . \Yii::t($module->messageCategory, 'Article'), ['/' . $module->id . '/article/edit', 'cid' => $item['id']]) ?>
					<?= Html::tag('span', '|') ?>
					<?= Html::a(\Yii::t($module->messageCategory, 'Edit'), ['/' . $module->id . '/category/edit', 'id' => $item['id']]) ?>
					<?= Html::tag('span', '|') ?>
					<?= Html::a(\Yii::t($module->messageCategory, 'Delete'), ['/' . $module->id . '/category/delete'], ['data-delete' => $item['id']]) ?>
				</td>
			</tr>
			<? } ?>
		</tbody>
		<tfoot>
			<tr>
				<!-- <td class="text-center"><?= Html::checkbox('all', null, ['data-check' => 'cb']) ?></td> -->
				<td colspan="5">
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
				<td colspan="5" class="text-center empty">
					<?= Html::tag('i', null, ['class' => 'glyphicon glyphicon-info-sign text-success']) ?>
					<?= Html::tag('span', \Yii::t($module->messageCategory, 'No matched data')) ?>
				</td>
			</tr>
		</tfoot>
		<? } ?>
	</table>
</div>
<!-- end admin-table -->
