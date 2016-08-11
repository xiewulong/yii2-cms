<?php
use yii\helpers\Html;

$module = \Yii::$app->controller->module;
$this->title = \Yii::t($module->messageCategory, 'UI');

// set parent menu
$this->params['parent'] = '/' . $module->id . '/dashboard/index';
?>

<!-- begin admin-title -->
<div class="clearfix admin-area admin-title">
	<?= Html::tag('h5', $this->title, ['class' => 'pull-left admin-heading']) ?>
	<div class="pull-right">
		<?= Html::a('Option1', 'javascript:;', ['class' => 'btn btn-default pull-left']) ?>
		<?= Html::a('Option2', 'javascript:;', ['class' => 'btn btn-default pull-left']) ?>
	</div>
</div>
<!-- end admin-title -->

<!-- begin admin-tabs -->
<div class="clearfix admin-area admin-tabs">
	<?= Html::a('Tab1', 'javascript:;', ['class' => 'current']) ?>
	<?= Html::a('Tab2', 'javascript:;') ?>
</div>
<!-- end admin-tabs -->

<!-- begin admin-options -->
<div class="clearfix admin-area-sm admin-options">
	<?= Html::beginForm(null, 'get', ['class' => 'form-inline pull-left']) ?>
		<div class="form-group">
			<?= Html::label('Username', 'form-username', ['class' => 'control-label']) ?>
			<?= Html::textInput('username', null, ['id' => 'form-username', 'class' => 'form-control', 'placeholder' => 'Please enter text', 'autofocus' => true]) ?>
		</div>
		<div class="form-group">
			<?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
		</div>
	<?= Html::endForm() ?>
	<div class="pull-right">
		<?= Html::a('Option1', 'javascript:;', ['class' => 'btn btn-default pull-left']) ?>
		<?= Html::a('Option2', 'javascript:;', ['class' => 'btn btn-default pull-left']) ?>
	</div>
</div>
<!-- end admin-options -->

<!-- begin admin-table -->
<div class="admin-area-sm admin-table">
	<table class="table">
		<thead>
			<tr>
				<th width="5%"><?= Html::checkbox('all', null, ['data-check' => 'cb']) ?></th>
				<th width="8%"><?= Html::encode('Column_0') ?></th>
				<th width="8%"><?= Html::encode('Column_1') ?></th>
				<th width="8%"><?= Html::encode('Column_2') ?></th>
				<th width="8%"><?= Html::encode('Column_3') ?></th>
				<th width="8%"><?= Html::encode('Column_4') ?></th>
				<th width="8%"><?= Html::encode('Column_5') ?></th>
				<th width="8%"><?= Html::encode('Column_6') ?></th>
				<th width="8%"><?= Html::encode('Column_7') ?></th>
				<th width="8%"><?= Html::encode('Column_8') ?></th>
				<th><?= Html::encode('Column_9') ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?= Html::checkbox('cb') ?></td>
				<td><?= Html::encode('Value_0') ?></td>
				<td><?= Html::encode('Value_1') ?></td>
				<td><?= Html::encode('Value_2') ?></td>
				<td><?= Html::encode('Value_3') ?></td>
				<td><?= Html::encode('Value_4') ?></td>
				<td><?= Html::encode('Value_5') ?></td>
				<td><?= Html::encode('Value_6') ?></td>
				<td><?= Html::encode('Value_7') ?></td>
				<td></td>
				<td>
					<?= Html::a('Edit', 'javascript:;') ?>
					<?= Html::tag('span', '|') ?>
					<?= Html::a('Delete', 'javascript:;') ?>
				</td>
			</tr>
			<tr>
				<td><?= Html::checkbox('cb') ?></td>
				<td><?= Html::encode('Value_0') ?></td>
				<td><?= Html::encode('Value_1') ?></td>
				<td><?= Html::encode('Value_2') ?></td>
				<td><?= Html::encode('Value_3') ?></td>
				<td><?= Html::encode('Value_4') ?></td>
				<td><?= Html::encode('Value_5') ?></td>
				<td><?= Html::encode('Value_6') ?></td>
				<td><?= Html::encode('Value_7') ?></td>
				<td>
					<p><?= Html::encode('Value_7') ?></p>
					<p><?= Html::encode('Value_7') ?></p>
					<p><?= Html::encode('Value_7') ?></p>
				</td>
				<td>
					<?= Html::a('Edit', 'javascript:;') ?>
					<?= Html::tag('span', '|') ?>
					<?= Html::a('Delete', 'javascript:;') ?>
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td><?= Html::checkbox('all', null, ['data-check' => 'cb']) ?></td>
				<td colspan="10">
					<?= Html::button('Batch', ['class' => 'btn btn-default']) ?>
					<div class="pull-right admin-pagination">
						<div class="info">Total: 1, Per page: 30</div>
						<ul class="pagination">
							<li class="disabled"><?= Html::a(Html::tag('span', '&laquo;'), 'javascript:;') ?></li>
							<li class="disabled"><?= Html::a(Html::tag('span', '&lt;'), 'javascript:;') ?></li>
							<li class="active"><?= Html::a('1', 'javascript:;') ?></li>
							<li><?= Html::a('2', 'javascript:;') ?></li>
							<li><?= Html::a('3', 'javascript:;') ?></li>
							<li><?= Html::a('4', 'javascript:;') ?></li>
							<li><?= Html::a('5', 'javascript:;') ?></li>
							<li><?= Html::a(Html::tag('span', '&gt;'), 'javascript:;') ?></li>
							<li><?= Html::a(Html::tag('span', '&raquo;'), 'javascript:;') ?></li>
						</ul>
					</div>
				</td>
			</tr>
		</tfoot>
	</table>
</div>
<!-- end admin-table -->

<!-- begin admin-form -->
<?= Html::beginForm(null, null, ['class' => 'form-horizontal admin-area-sm admin-form']) ?>
	<div class="fieldset">
		<div class="form-group">
			<?= Html::label('Label name 0:', 'input_id_0', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::textInput('input_0', null, ['class' => 'form-control', 'id' => 'input_id_0', 'placeholder' => 'Please input ...', 'autofocus' => true]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= Html::label('Label name 1:', 'input_id_1', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::passwordInput('input_1', null, ['class' => 'form-control', 'id' => 'input_id_1', 'placeholder' => 'Please input ...']) ?>
			</div>
		</div>
		<div class="form-group">
			<?= Html::label('Label name 2:', 'input_id_2', ['class' => 'control-label col-sm-2']) ?>
			<div class="col-sm-4">
				<?= Html::textarea('input_2', null, ['rows' => 6, 'class' => 'form-control', 'id' => 'input_id_2', 'placeholder' => 'Please input ...']) ?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-4 col-sm-push-2">
				<?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
				<?= Html::Button('Cancel', ['class' => 'btn btn-default']) ?>
			</div>
		</div>
	</div>
<?= Html::endForm() ?>
<!-- end admin-form -->
