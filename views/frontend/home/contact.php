<?php
use yii\helpers\Html;
use yii\cms\widgets\Banner;

$module = \Yii::$app->controller->module;
$this->title = \Yii::t($module->messageCategory, 'Contact us');
?>

<!-- begin x-carousel -->
<?= Banner::widget([
	'bannerId' => 'carouselHomeMain',
	'options' => ['class' => 'x-carousel J-x-carousel'],
	'backgroundImage' => true,
]) ?>
<!-- end x-carousel -->

<!-- begin x-details -->
<div class="x-details">
	<div class="container">

		<!-- begin x-details-body -->
		<div class="x-details-body">
			<h3 class="x-rich-title"><?= \Yii::t($module->messageCategory, 'Contact us') ?></h3>
			<div class="x-rich"><?= $module->site['contact'] ?></div>
		</div>
		<!-- end x-details-body -->

	</div>
</div>
<!-- end x-details -->
