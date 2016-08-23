<?php
use yii\helpers\Html;
use yii\cms\assets\FrontendAsset;
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
<body>
<?php $this->beginBody(); ?>

<!-- begin x-navbar -->
<div class="x-navbar">
	<div class="container">
		<div class="pull-right">
			<?php if($module->backendEntrance) { ?>
			<?= Html::a(Html::tag('i', null, ['class' => 'glyphicon glyphicon-dashboard']) . \Yii::t($module->messageCategory, 'Manage'), $module->backendUrl, ['target' => '_blank']) ?>
			<? } ?>
		</div>
		<?php if($site['type'] == 1 && $site['email']) { ?>
		<?= Html::a(Html::tag('i', null, ['class' => 'glyphicon glyphicon-envelope']) . $site['email'], 'mailto:' . $site['email'], ['class' => 'pull-left']) ?>
		<? } ?>
		<?php if($site['type'] == 2 && $site['phone']) { ?>
		<?= Html::a(Html::tag('i', null, ['class' => 'glyphicon glyphicon-earphone']) . $site['phone'], 'tel:' . $site['phone'], ['class' => 'pull-left']) ?>
		<? } ?>
	</div>
</div>
<!-- end x-navbar -->

<div>/******** begin header ********/</div>
<div><?= Html::a($site['name'], \Yii::$app->homeUrl) ?></div>
<?php if($module->backendEntrance) { ?>
<div><?= Html::a(\Yii::t($module->messageCategory, 'Manage'), $module->backendUrl, ['target' => '_blank']) ?></div>
<? } ?>
<h1>
	<?= Html::a(Html::img($site['logo']), \Yii::$app->homeUrl) ?>
	<?= Html::tag('span', $site['name']) ?><!-- for seo -->
</h1>
<?= Menu::widget([
	'position' => 'Menu_main',
	'route' => isset($this->params['route']) ? $this->params['route'] : null,
]) ?>
<div>/******** end header ********/</div>

<div>/******** begin content ********/</div>
<?= $content ?>
<div>/******** end content ********/</div>

<div>/******** begin footer ********/</div>
<div><?= $site['brief'] ?></div>
<div><?= $site['type'] == 1 ? null : $site['address'] ?></div>
<div><?= $site['phone'] ?></div>
<div><?= $site['email'] ?></div>
<div><?= $site['qq'] ?></div>
<div><?= $site['weixin'] ?></div>
<div><?= $site['weibo'] ?></div>
<div><?= $site['type'] == 1 ? null : $site['copyright'] ?></div>
<div><?= $site['record'] ?></div>
<div><?= $site['type'] == 1 ? null : $site['license'] ?></div>
<div><?= $site['type'] == 1 ? null : Html::a($site['powered'] . '111', $site['powered_url'] ? : null, ['target' => '_blank']) ?></div>
<div>/******** end footer ********/</div>

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
