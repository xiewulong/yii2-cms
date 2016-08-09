<?php
use yii\helpers\Html;

$module = \Yii::$app->controller->module;
$this->title = \Yii::t($module->messageCategory, 'Global');
?>
