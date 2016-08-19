<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

$module = \Yii::$app->controller->module;
$this->title = \Yii::t($module->messageCategory, 'List');

// set parent route
// $this->params['route'] = '';
?>

<?php var_dump($superior); ?>

<?php var_dump($items); ?>

<?= LinkPager::widget([
	'pagination' => $pagination,
	'prevPageLabel' => '&lt;',
	'nextPageLabel' => '&gt;',
	'firstPageLabel' => '&laquo;',
	'lastPageLabel' => '&raquo;',
	'hideOnSinglePage' => false,
]) ?>
