<?php
use yii\helpers\Html;
use yii\cms\widgets\Home;
use yii\cms\widgets\HomeIcon;

$module = \Yii::$app->controller->module;
$site = $module->site;
$this->title = \Yii::t($module->messageCategory, 'Home');

// set parent route
// $this->params['route'] = '';
?>

<?= HomeIcon::widget([
	'siteId' => $module->siteId,
	'position' => 'Home_projects',
	'blankTarget' => true,
	'options' => [
		'class' => 'x-home',
	],
	'listOptions' => [
		'class' => 'projects',
	],
]) ?>

<?= Home::widget([
	'siteId' => $module->siteId,
	'position' => 'Home_about',
	'blankTarget' => true,
	'options' => [
		'class' => 'x-home',
	],
	'listOptions' => [
		'class' => 'about',
	],
	'more' => Html::tag('div', Html::a(\Yii::t($module->messageCategory, 'See more'), ['article/list', 'id' => 1], ['class' => 'btn btn-primary btn-lg more', 'target' => '_blank']), ['class' => 'text-center']),
]) ?>

<?= HomeIcon::widget([
	'siteId' => $module->siteId,
	'position' => 'Home_advantages',
	'blankTarget' => true,
	'options' => [
		'class' => 'x-home x-home-inverse x-wave x-wave-top-concave x-wave-bottom-concave',
	],
	'listOptions' => [
		'class' => 'advantages',
	]
]) ?>

<?= Home::widget([
	'siteId' => $module->siteId,
	'position' => 'Home_news',
	'blankTarget' => true,
	'options' => [
		'class' => 'x-home',
	],
	'listOptions' => [
		'class' => 'news',
	],
	'more' => Html::tag('div', Html::a(\Yii::t($module->messageCategory, 'See more'), ['article/list', 'id' => 2], ['class' => 'btn btn-primary btn-lg more', 'target' => '_blank']), ['class' => 'text-center']),
]) ?>

<?= Home::widget([
	'siteId' => $module->siteId,
	'position' => 'Home_links',
	'blankTarget' => true,
	'options' => [
		'class' => 'x-home',
	],
	'listOptions' => [
		'class' => 'links',
	],
]) ?>
