<?php
use yii\helpers\Html;

$module = \Yii::$app->controller->module;
$this->title = $name;
?>

<div class="container">
	<h3><?= Html::encode($this->title) ?></h3>
	<div class="alert alert-danger admin-alert"><?= nl2br(Html::encode($message)) ?></div>
</div>
