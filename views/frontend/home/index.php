<?php
use yii\helpers\Html;
use yii\cms\widgets\Banner;

$module = \Yii::$app->controller->module;
$this->title = \Yii::t($module->messageCategory, 'Home');

// set parent route
// $this->params['route'] = '';
?>

<?= Banner::widget([
	'position' => 'Carousel_main',
	// 'backgroundImage' => true,
	'blankTarget' => true,
]) ?>
