<?php
use yii\helpers\Html;

use yii\cms\widgets\Crumbs;

$module = \Yii::$app->controller->module;
$this->title = $item['title'];

// set parent route
$this->params['route'] = [$module->url('article/list'), 'id' => $item->category_id];

// set crumbs
$this->params['crumbs'] = [
	['title' => $item['superior']['name'], 'url' => ['article/list', 'id' => $item['superior']['id']]],
	['title' => $this->title],
];
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
			<div class="x-sidebar">
				<div class="heading">
					<h5><?= Html::a($item['superior']['name'], ['article/list', 'id' => $item['superior']['id']]) ?></h5>
					<?php if($item['superior']['alias']) { ?>
					<small><?= Html::a($item['superior']['alias'], ['article/list', 'id' => $item['superior']['id']]) ?></small>
					<? } ?>
				</div>
				<ul>
					<?php foreach($item['superior']['featuredItems'] as $featured){ ?>
					<li<?php if($item['id'] == $featured['id']){ $hasCurrent = true; ?> class="current"<? } ?>><?= Html::a($featured['title'], ['article/details', 'id' => $featured['id']]) ?></li>
					<? } ?>
					<?php if(!isset($hasCurrent)) { ?>
					<li class="current"><?= Html::a($item['title'], ['article/details', 'id' => $item['id']]) ?></li>
					<? } ?>
				</ul>
			</div>
		</div>
		<div class="col-xs-9">
			<div class="x-details"><?= $item['content'] ?></div>
		</div>
	</div>
</div>
