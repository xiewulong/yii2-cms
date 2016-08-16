<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\cms\models\SiteArticle;

$module = \Yii::$app->controller->module;
$this->title = \Yii::t($module->messageCategory, '{attribute} {action}', [
	'attribute' => $banner['name'] . \Yii::t($module->messageCategory, 'Banner item'),
	'action' => \Yii::t($module->messageCategory, 'Management'),
]);

// set parent menu
$this->params['parent'] = $module->url('banner/list');

$statusClasses = ['text-muted', 'text-success', 'text-danger'];
?>

<!-- begin admin-title -->
<div class="clearfix admin-area admin-title">
	<?= Html::tag('h5', $this->title, ['class' => 'pull-left admin-heading']) ?>
	<?= Html::a(\Yii::t($module->messageCategory, '{action} {attribute}', [
		'action' => \Yii::t($module->messageCategory, 'Back to'),
		'attribute' => \Yii::t($module->messageCategory, 'Banner') . \Yii::t($module->messageCategory, 'list'),
	]), [$this->params['parent']], ['class' => 'btn btn-link pull-left']) ?>
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
				'name' => \Yii::t($module->messageCategory, 'Banner item') . \Yii::t($module->messageCategory, 'Name'),
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
		<?= Html::a(\Yii::t($module->messageCategory, 'Add'), ['banner/item-edit', 'bid' => $banner['id']], ['class' => 'btn btn-default pull-left']) ?>
	</div>
</div>
<!-- end admin-options -->

<!-- begin admin-table -->
<div class="admin-area-sm admin-table">
	<table class="table">
		<thead>
			<tr>
				<!-- <th width="6%" class="text-center"><?= Html::checkbox('all', null, ['data-check' => 'cb']) ?></th> -->
				<th width="18%"><?= \Yii::t($module->messageCategory, 'Title') ?></th>
				<th width="18%"><?= \Yii::t($module->messageCategory, 'Picture') ?></th>
				<th width="18%"><?= \Yii::t($module->messageCategory, 'Banner') . \Yii::t($module->messageCategory, 'Name') ?></th>
				<th width="10%" class="text-center"><?= \Yii::t($module->messageCategory, 'Total') . \Yii::t($module->messageCategory, 'Page view') ?></th>
				<th width="10%" class="text-center"><?= \Yii::t($module->messageCategory, 'Total') . \Yii::t($module->messageCategory, 'Unique Visitor') ?></th>
				<th width="10%" class="text-center"><?= \Yii::t($module->messageCategory, 'Status') ?></th>
				<th class="text-center"><?= \Yii::t($module->messageCategory, 'Operations') ?></th>
			</tr>
		</thead>
		<?php if($items) { ?>
		<tbody>
			<?php foreach($items as $item) { ?>
			<tr>
				<!-- <td class="text-center"><?= Html::checkbox('cb') ?></td> -->
				<td><?= Html::a($item['title'], $item['url'] ? ['banner/jump', 'id' => $item['id']] : null, ['target' => '_blank']) ?></td>
				<td><?= Html::a(Html::img($item['picture'], ['class' => 'admin-image-limit']), $item['url'] ? ['banner/jump', 'id' => $item['id']] : null, ['target' => '_blank']) ?></td>
				<td><?= Html::encode($item['banner']['name']) ?></td>
				<td class="text-center"><?= $item['pv'] ?></td>
				<td class="text-center"><?= $item['uv'] ?></td>
				<td class="text-center <?= $statusClasses[$item['status']] ?>"><?= \Yii::t($module->messageCategory, $item->getAttributeText('status')) ?></td>
				<td class="text-center">
					<?= Html::a(\Yii::t($module->messageCategory, 'Edit'), ['banner/item-edit', 'bid' => $banner['id'], 'id' => $item['id']]) ?>
					<?= Html::tag('span', '|') ?>
					<?= Html::a(\Yii::t($module->messageCategory, 'Delete'), ['/banner/item-delete'], ['data-delete' => $item['id']]) ?>
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
					<?= Html::tag('span', \Yii::t($module->messageCategory, 'No matched data')) ?>
				</td>
			</tr>
		</tfoot>
		<? } ?>
	</table>
</div>
<!-- end admin-table -->
