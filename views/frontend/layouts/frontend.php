<?php
use yii\helpers\Html;

use yii\cms\assets\FrontendAsset;
use yii\cms\widgets\Banner;
use yii\cms\widgets\Menu;
use yii\xui\Statistics;

$module = \Yii::$app->controller->module;
$site = $module->site;

FrontendAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!doctype html>

<!-- begin html -->
<html lang="<?= \Yii::$app->language ?>" xml:lang="<?= \Yii::$app->language ?>">

<!-- begin head -->
<head>
<title><?= Html::encode($this->title) ?> - <?= Html::encode($site['name'] ? : \Yii::$app->name) ?></title>
<meta charset="<?= \Yii::$app->charset ?>" />
<meta name="author" content="<?= $site['author'] ? : 'xiewulong<xiewulong@vip.qq.com>' ?>" />
<meta name="keywords" content="<?= $site['keywords'] ?>" />
<meta name="description" content="<?= $site['description'] ?>" />

<!-- begin ie modes -->
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<meta name="renderer" content="webkit" />
<!-- end ie modes -->

<!-- begin mobile -->
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<meta name="format-detection" content="telephone=no" />
<!-- end mobile -->

<!-- begin csrf -->
<?= Html::csrfMetaTags() ?>
<!-- end csrf -->

<?php $this->head(); ?>
</head>
<!-- end head -->

<!-- begin body -->
<body class="non-responsive">
<?php $this->beginBody(); ?>

<!-- begin x-header -->
<div class="x-header">
	<div class="container">
		<div class="row">
			<h1 class="pull-left">
				<?= Html::a(Html::img($module->imageRoute($site['logo_id'])), \Yii::$app->homeUrl) ?>
				<?= Html::tag('span', $site['name']) ?><!-- for seo -->
			</h1>
			<?= Menu::widget([
				'siteId' => $module->siteId,
				'position' => 'Menu_main',
				'recursive' => true,
				'route' => isset($this->params['route']) ? $this->params['route'] : null,
				'options' => [
					'class' => 'pull-right',
				],
				'listOptions' => [
					'class' => 'clearfix',
				],
			]) ?>
		</div>
	</div>
</div>
<!-- end x-header -->

<!-- begin x-carousel -->
<div class="x-wave x-wave-bottom-concave">
	<div class="container-fluid">
		<div class="row">
			<?= Banner::widget([
				'siteId' => $module->siteId,
				'position' => 'Carousel_main',
				'backgroundImage' => true,
				'targetBlank' => true,
				'carousel' => true,
				'options' => [
					'class' => 'x-carousel',
				],
			]) ?>
		</div>
	</div>
</div>
<!-- end x-carousel -->

<?= $content ?>

<!-- begin x-footer -->
<div class="x-footer x-wave x-wave-top-convex">
	<div class="container">
		<div class="row">
			<div class="col-xs-2 logo">
				<?= Html::a(Html::img($module->imageRoute($site['sub_logo_id'])), \Yii::$app->homeUrl) ?>
			</div>
			<div class="col-xs-8 contact">
				<?= Html::tag('h5', \Yii::t($module->messageCategory, 'Contact us')) ?>
				<div class="row">
					<div class="col-xs-6"><?= \Yii::t($module->messageCategory, '{action} {attribute}', [
						'action' => \Yii::t($module->messageCategory, 'Contact'),
						'attribute' => \Yii::t($module->messageCategory, 'Phone'),
					]) ?>：<?= $site['phone'] ?></div>
					<div class="col-xs-6"><?= Yii::t($module->messageCategory, '{action} {attribute}', [
						'action' => \Yii::t($module->messageCategory, 'Company'),
						'attribute' => \Yii::t($module->messageCategory, 'Tax'),
					]) ?>：<?= $site['tax'] ?></div>
				</div>
				<div class="row">
					<div class="col-xs-6"><?= Yii::t($module->messageCategory, '{action} {attribute}', [
						'action' => \Yii::t($module->messageCategory, 'Company'),
						'attribute' => \Yii::t($module->messageCategory, 'Email'),
					]) ?>：<?= $site['email'] ?></div>
					<div class="col-xs-6"><?= Yii::t($module->messageCategory, '{action} {attribute}', [
						'action' => \Yii::t($module->messageCategory, 'Company'),
						'attribute' => \Yii::t($module->messageCategory, 'Address'),
					]) ?>：<?= $site['address'] ?></div>
				</div>
			</div>
			<div class="col-xs-2 follow">
				<?= Html::tag('h5', \Yii::t($module->messageCategory, 'Follow us')) ?>
				<p>
					<?= $site['qq'] ? Html::a(Html::tag('i', null, ['class' => 'fa fa-qq']), $site['qq'], ['target' => '_blank']) : null ?>
					<?= $site['weibo'] ? Html::a(Html::tag('i', null, ['class' => 'fa fa-weibo']), $site['weibo'], ['target' => '_blank']) : null ?>
				</p>
			</div>
		</div>
		<?php if($site['type'] == 2 && $site['copyright']) { ?>
		<div class="row copyright"><?= $site['copyright'] ?></div>
		<? } ?>
	</div>
</div>
<!-- end x-footer -->

<?= Statistics::widget([
	'baidu' => 'id',
	'cnzz' => 1,
	'piwik' => [
		'host' => 'piwik.domain.com',
		'id' => 1,
	],
]) ?>

<?php $this->endBody(); ?>
</body>
<!-- end body -->

</html>
<!-- end html -->
<?php $this->endPage(); ?>
