<?php
use yii\helpers\Html;

$module = \Yii::$app->controller->module;
$this->title = \Yii::t($module->messageCategory, 'Details');

// set parent route
$this->params['route'] = [$module->url('article/list'), 'id' => $item->category_id];
?>

<?php var_dump($item); ?>
