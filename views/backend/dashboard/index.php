<?php
use yii\helpers\Html;

$module = \Yii::$app->controller->module;
$this->title = \Yii::t($module->messageCategory, 'dashboard');

// set parent route
// $this->params['route'] = '';
?>
