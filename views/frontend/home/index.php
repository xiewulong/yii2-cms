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

<?= Home::widget([
	'siteId' => $module->siteId,
	'type' => 1,
	'position' => 'Home_projects',
	'targetBlank' => true,
	'targetEnabled' => true,
	'targetListLimit' => 5,
	'targetMore' => false,
	'keywordsToIcon' => true,
	'options' => [
		'class' => 'x-home',
	],
	'listOptions' => [
		'class' => 'projects',
	],
]) ?>

<?= Home::widget([
	'siteId' => $module->siteId,
	'type' => 1,
	'position' => 'Home_advantages',
	'targetBlank' => true,
	'targetEnabled' => true,
	'targetListLimit' => 4,
	'targetMore' => false,
	'keywordsToIcon' => true,
	'options' => [
		'class' => 'x-home x-home-inverse x-wave x-wave-top-concave x-wave-bottom-concave',
	],
	'listOptions' => [
		'class' => 'advantages',
	],
]) ?>

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
