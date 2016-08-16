<?php
use yii\helpers\Html;
use yii\cms\assets\FrontendAsset;
use yii\xui\Statistics;

$module = \Yii::$app->controller->module;
$site = $module->site;
$isHome = $module->isCurrent('home/index');

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
<body>
<?php $this->beginBody(); ?>

<!-- begin x-topbar -->
<div class="x-topbar">
	<div class="container">
		<div class="row">
			<div class="col-xs-4">
				<h2><?= Html::a($site['name'], \Yii::$app->homeUrl) ?></h2>
			</div>
			<div class="col-xs-8">
				<ul>
					<?php if($module->backendEntrance) { ?>
					<li><?= Html::a(\Yii::t($module->messageCategory, 'Manage'), $module->backendUrl, ['target' => '_blank']) ?></li>
					<? } ?>
					<?php if($site['phone']) { ?>
					<li><?= Html::a(Html::tag('i', null, ['class' => 'x-icons x-icons-phone']) . \Yii::t($module->messageCategory, 'Phone'), 'tel:' . $site['phone']) ?></li>
					<? } ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- begin x-topbar -->

<!-- begin x-header -->
<div class="x-header">
	<div class="container">
		<div class="row">
			<div class="col-xs-3">
				<h1>
					<?= Html::a(Html::img($site['logo']), \Yii::$app->homeUrl) ?>
					<?= Html::tag('span', $site['name']) ?><!-- for seo -->
				</h1>
			</div>
			<div class="col-xs-9">
				<ul class="x-menu J-x-menu">
					<li<?= $isHome ? ' class="current"' : '' ?>>
						<?= Html::a('首页', \Yii::$app->homeUrl) ?>
						<?= $isHome ? Html::tag('span') : null ?>
					</li>
					<?php
					foreach($site->menus as $menu) {
						$isCurrent = $module->isCurrent('article/list', ['cid' => $menu['id']]);
					?>
					<li<?= $isCurrent ? ' class="current"' : '' ?>>
						<?= Html::a($menu['name'], ['article/list', 'cid' => $menu['id']]) ?>
						<?= $isCurrent ? Html::tag('span') : null ?>
					</li>
					<? } ?>
					<?php
					if($site['type'] == 1 && $site['about_status'] == 1) {
						$isCurrent = $module->isCurrent('home/about');
					?>
					<li<?= $isCurrent ? ' class="current"' : '' ?>>
						<?= Html::a(\Yii::t($module->messageCategory, 'About us'), ['home/about']) ?>
						<?= $isCurrent ? Html::tag('span') : null ?>
					</li>
					<? } ?>
					<?php
					if($site['type'] == 1 && $site['contact_status'] == 1) {
						$isCurrent = $module->isCurrent('home/contact');
					?>
					<li<?= $isCurrent ? ' class="current"' : '' ?>>
						<?= Html::a(\Yii::t($module->messageCategory, 'Contact us'), ['home/contact']) ?>
						<?= $isCurrent ? Html::tag('span') : null ?>
					</li>
					<? } ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- end x-header -->

<?= $content ?>

<?php if($site['brief']
	|| $site['address']
	|| $site['phone']
	|| $site['email']
	|| $site['qq']
	|| $site['weixin']
	|| $site['weibo']) { ?>
<!-- begin x-footer -->
<div class="x-footer">
	<div class="container">
		<div class="row">
			<div class="col-xs-4">
				<dl>
					<?php if($site['brief']){ ?>
					<dt><?= \Yii::t($module->messageCategory, 'About us') ?><b></b></dt>
					<dd><?= $site['brief'] ?></dd>
					<? } ?>
				</dl>
			</div>
			<div class="col-xs-4">
				<dl class="contact">
					<?php if($site['address']
						|| $site['phone']
						|| $site['email']){ ?>
					<dt><?= \Yii::t($module->messageCategory, 'Contact us') ?><b></b></dt>
						<?php if($site['address']) { ?>
					<dd>
						<b><i class="x-icons x-icons-address"></i></b>
						<p><?= $site['address'] ?></p>
					</dd>
						<? } ?>
						<?php if($site['phone']) { ?>
					<dd>
						<b><i class="x-icons x-icons-tel"></i></b>
						<p class="single"><?= $site['phone'] ?></p>
					</dd>
						<? } ?>
						<?php if($site['email']) { ?>
					<dd>
						<b><i class="x-icons x-icons-email"></i></b>
						<p class="single"><?= $site['email'] ?></p>
					</dd>
						<? } ?>
					<? } ?>
				</dl>
			</div>
			<div class="col-xs-4">
				<dl>
					<?php if($site['qq']
						|| $site['weixin']
						|| $site['weibo']){ ?>
					<dt><?= \Yii::t($module->messageCategory, 'Social service account') ?><b></b></dt>
					<!-- <dd>绿色基地官网 : http://www.cnltj.org</dd>
					<dd>清华同方官网 : http://www.thtf.com.cn</dd>
					<dd>同方融达官网 : http://www.wxtfrd.com.cn</dd> -->
					<dd class="icons">
						<?php if($site['qq']) { ?>
						<?= Html::a(Html::tag('i', null, ['class' => 'x-icons x-icons-tencent']), $site['qq'], ['target' => '_blank']) ?>
						<? } ?>
						<?php if($site['weixin']) { ?>
						<?= Html::a(Html::tag('i', null, ['class' => 'x-icons x-icons-weixin']), $site['weixin'], ['target' => '_blank']) ?>
						<? } ?>
						<?php if($site['weibo']) { ?>
						<?= Html::a(Html::tag('i', null, ['class' => 'x-icons x-icons-weibo']), $site['weibo'], ['target' => '_blank']) ?>
						<? } ?>
					</dd>
					<? } ?>
				</dl>
			</div>
		</div>
	</div>
</div>
<!-- end x-footer -->
<? } ?>

<!-- begin x-bottombar -->
<div class="x-bottombar">
	<div class="container">
		<div class="row">
			<div class="col-xs-6"><?= $site['record'] ?></div>
			<div class="col-xs-6 text-right"><?= \Yii::t($module->messageCategory, 'Powered by') ?>: <?= Html::a($site['powered'] ? : \Yii::t($module->messageCategory, 'Nanning Automan Technology Co., Ltd.'), $site['powered_url'] ? : 'javascript:;', ['target' => '_blank']) ?></div>
		</div>
	</div>
</div>
<!-- end x-bottombar -->

<?= Statistics::widget([
	'baidu' => '41a2c8c1e4b6e0f225db6ce2e6e6dec4',
	'cnzz' => 1,
	'piwik' => [
		'url' => 'piwik.diankego.com',
		'id' => 1,
	],
]) ?>

<?php $this->endBody(); ?>
</body>
<!-- end body -->

</html>
<!-- end html -->
<?php $this->endPage(); ?>
