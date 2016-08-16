<?php
use yii\helpers\Html;
use yii\cms\widgets\Banner;

$module = \Yii::$app->controller->module;
$this->title = \Yii::t($module->messageCategory, 'List');
?>

<!-- begin x-carousel -->
<?= Banner::widget([
	'bannerId' => 'carouselHomeMain',
	'options' => ['class' => 'x-carousel J-x-carousel'],
	'backgroundImage' => true,
]) ?>
<!-- end x-carousel -->

<!-- begin x-list-page -->
<div class="x-list-page">
	<div class="container">

		<div class="col-xs-3">
			<h3 class="x-list-title"><?= $category->name ?></h3>
			<ul class="x-list x-list-news">
				<?php foreach($items as $item) { ?>
				<li>
					<b><?= Html::a(Html::img($item['thumbnail']), ['article/details', 'id' => $item['id']]) ?></b>
					<h5><?= Html::a($item['title'], ['article/details', 'id' => $item['id']]) ?></h5>
					<p><?= Html::a($item['description'], ['article/details', 'id' => $item['id']]) ?></p>
					<span><?= Html::a(date('Y-md-d', $item['created_at']), ['article/details', 'id' => $item['id']]) ?></span>
				</li>
				<? } ?>
			</ul>
		</div>

		<div class="col-xs-9">
			<div class="row">
				<h3 class="x-list-title"><?= $category->name ?></h3>
				<!-- begin x-list -->
				<ul class="x-list x-list-pictures">
					<?php foreach($items as $item) { ?>
					<li>
						<b><?= Html::a(Html::img($item['thumbnail']), ['article/details', 'id' => $item['id']]) ?></b>
						<h5><?= Html::a($item['title'], ['article/details', 'id' => $item['id']]) ?></h5>
						<p><?= Html::a($item['description'], ['article/details', 'id' => $item['id']]) ?></p>
						<span><?= Html::a(date('Y-md-d', $item['created_at']), ['article/details', 'id' => $item['id']]) ?></span>
					</li>
					<? } ?>
				</ul>
				<!-- end x-list -->

			</div>
		</div>

	</div>
</div>
<!-- end x-list-page -->
