<?php
use yii\helpers\Html;

use yii\cms\widgets\Home;
use yii\cms\widgets\HomeIcon;

$module = \Yii::$app->controller->module;
$site = $module->site;
$this->title = \Yii::t($module->messageCategory, 'Home');

// set parent route
// $this->params['route'] = [];
?>

<div class="x-home-mt20">

	<?= $module->hook('Hook_home_begin') ?>

	<?= Home::widget([
		'siteId' => $module->siteId,
		'type' => 1,
		'position' => 'Home_advantages',
		'targetBlank' => true,
		'aliasToIcon' => true,
		'options' => [
			'class' => 'x-home',
		],
		'listOptions' => [
			'class' => 'advantages',
		],
	]) ?>

	<?= $module->hook('Hook_home_0') ?>

	<?= Home::widget([
		'siteId' => $module->siteId,
		'type' => 1,
		'position' => 'Home_news',
		'targetBlank' => true,
		'targetEnabled' => true,
		'targetListLimit' => 8,
		'targetMoreText' => \Yii::t($module->messageCategory, 'See more'),
		'targetMoreOptions' => [
			'class' => 'btn btn-primary btn-lg',
		],
		'options' => [
			'class' => 'x-home',
		],
		'listOptions' => [
			'class' => 'news',
		],
	]) ?>

	<?= $module->hook('Hook_home_1') ?>

</div>

<?= Home::widget([
	'siteId' => $module->siteId,
	'type' => 1,
	'position' => 'Home_projects',
	'targetBlank' => true,
	'targetEnabled' => true,
	'targetListLimit' => 6,
	'targetMore' => false,
	'keywordsToIcon' => true,
	'options' => [
		'class' => 'x-home x-home-inverse x-wave x-wave-top-concave x-wave-bottom-concave',
	],
	'listOptions' => [
		'class' => 'projects',
	],
]) ?>

<div class="x-home-mt20">

	<?= $module->hook('Hook_home_2') ?>

	<?= Home::widget([
		'siteId' => $module->siteId,
		'type' => 1,
		'position' => 'Home_about',
		'targetBlank' => true,
		'targetEnabled' => true,
		'targetMoreText' => \Yii::t($module->messageCategory, 'See more'),
		'targetMoreOptions' => [
			'class' => 'btn btn-primary btn-lg',
		],
		'options' => [
			'class' => 'x-home',
		],
		'listOptions' => [
			'class' => 'about',
		],
	]) ?>

	<?= $module->hook('Hook_home_3') ?>

	<?= Home::widget([
		'siteId' => $module->siteId,
		'type' => 2,
		'position' => 'Home_cases',
		'targetBlank' => true,
		'options' => [
			'class' => 'x-home',
		],
		'listOptions' => [
			'class' => 'links',
		],
	]) ?>

	<?= $module->hook('Hook_home_4') ?>

	<?= Home::widget([
		'siteId' => $module->siteId,
		'type' => 2,
		'position' => 'Friendly_links',
		'targetBlank' => true,
		'options' => [
			'class' => 'x-home',
		],
		'listOptions' => [
			'class' => 'links',
		],
	]) ?>

	<?= $module->hook('Hook_home_end') ?>

</div>
