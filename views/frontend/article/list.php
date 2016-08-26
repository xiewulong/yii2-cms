<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

use yii\cms\widgets\Crumbs;
use yii\cms\widgets\Menu;
use yii\cms\widgets\Ul;

$module = \Yii::$app->controller->module;
$this->title = $superior['name'];

// set parent route
// $this->params['route'] = '';

// set crumbs
$this->params['crumbs'] = [['title' => $this->title]];
?>

<div class="container">
	<div class="row">
		<div class="col-xs-9 col-xs-push-3">
			<?= Crumbs::widget([
				'headingText' => \Yii::t($module->messageCategory, 'Current location') . '：',
				'homeText' => \Yii::t($module->messageCategory, 'Home'),
				'options' => [
					'class' => 'x-crumbs',
				],
			]) ?>
		</div>
	</div>
	<div class="x-crumbs-arc x-wave x-wave-top-convex x-wave-bottom-concave"></div>
	<div class="row">
		<div class="col-xs-3">
			<?= Menu::widget([
				'siteId' => $module->siteId,
				'position' => 'List_categorys',
				'headingEnabled' => true,
				'options' => [
					'class' => 'x-sidebar',
				],
			]) ?>
		</div>
		<div class="col-xs-9">
			<?= Ul::widget([
				'items' => $items,
				'timeEnabled' => true,
				'options' => [
					'class' => 'x-list x-list-' . $superior['type'],
				],
			]) ?>
		</div>
	</div>
</div>

<?= LinkPager::widget([
	'pagination' => $pagination,
	'prevPageLabel' => '&lt;',
	'nextPageLabel' => '&gt;',
	'firstPageLabel' => '&laquo;',
	'lastPageLabel' => '&raquo;',
]) ?>
