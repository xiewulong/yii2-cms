<?php
use yii\helpers\Html;
use yii\cms\assets\BackendAsset;
use yii\xui\Admin;

$module = \Yii::$app->controller->module;
$site = $module->site;

BackendAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!doctype html>

<!-- begin html -->
<html lang="<?= \Yii::$app->language ?>" xml:lang="<?= \Yii::$app->language ?>">

<!-- begin head -->
<head>
<title><?= Html::encode($this->title) ?> - <?= Html::encode(($site['name'] ? : \Yii::$app->name) . \Yii::t($module->messageCategory, 'Management System')) ?></title>
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

<?php
$global = [
	'text' => \Yii::t($module->messageCategory, 'Global'),
	'children' => [
		[
			'text' => \Yii::t($module->messageCategory, 'Basic'),
			'icon' => 'glyphicon glyphicon-cog',
			'url' => [$module->url('global/basic')],
		],
	],
];
if($site['type'] == 1) {
	$global['children'][] = [
		'text' => \Yii::t($module->messageCategory, 'About us'),
		'icon' => 'glyphicon glyphicon-book',
		'url' => [$module->url('global/about')],
	];
	$global['children'][] = [
		'text' => \Yii::t($module->messageCategory, 'Contact us'),
		'icon' => 'glyphicon glyphicon-earphone',
		'url' => [$module->url('global/contact')],
	];
}

$sidebar = array_merge([
	[
		'text' => \Yii::t($module->messageCategory, 'Dashboard'),
		'icon' => 'glyphicon glyphicon-dashboard',
		'url' => [$module->url('dashboard/index')],
	],
	$global,
	[
		'text' => \Yii::t($module->messageCategory, 'Banner'),
		'icon' => 'glyphicon glyphicon-flag',
		'url' => [$module->url('banner/list')],
	],
	[
		'text' => \Yii::t($module->messageCategory, 'Category'),
		'icon' => 'glyphicon glyphicon glyphicon-th-list',
		'url' => [$module->url('category/list')],
	],
	[
		'text' => \Yii::t($module->messageCategory, 'Article'),
		'icon' => 'glyphicon glyphicon glyphicon-pencil',
		'url' => [$module->url('article/list')],
	],
], $module->addSidebarItems);

$params = [
	'brand' => [
		'logo' => $site['logo'],
		'text' => ($site['name'] ? : \Yii::$app->name) . \Yii::t($module->messageCategory, 'Management System'),
		'url' => [$module->url('dashboard/index')],
	],
	'menus' => [
		[
			'text' => \Yii::$app->user->identity->username,
			'icon' => 'glyphicon glyphicon-user',
			'options' => ['class' => 'pull-right border-none'],
			'dropdown' => [
				[
					'text' => \Yii::t($module->messageCategory, 'Reset password'),
					'url' => ['/account/password/reset'],
					'options' => ['data-password' => 'reset'],
				],
				[
					'text' => \Yii::t($module->messageCategory, 'Logout'),
					'url' => ['/account/user/logout'],
					'options' => ['data-user' => 'logout'],
				],
			],
		],
		[
			'text' => \Yii::t($module->messageCategory, '{action} {attribute}', [
				'action' => \Yii::t($module->messageCategory, 'Go'),
				'attribute' => \Yii::t($module->messageCategory, 'Home'),
			]),
			'icon' => 'glyphicon glyphicon-home',
			'url' => $module->frontendUrl,
			'options' => [
				'class' => 'pull-right',
				'target' => '_blank',
			],
		],
		[
			'text' => 'Site',
			'options' => ['style' => 'display:none;'],
			'sidebar' => $sidebar,
		],
	],
	'content' => $content,
];

$params['menus'] = array_merge($params['menus'], $module->addMenuItems);
?>
<?= Admin::widget($params) ?>

<!-- begin admin-alerts -->
<div class="admin-alerts J-admin-alerts"></div>
<?php
foreach(\Yii::$app->session->allFlashes as $flash) {
	list($type, $message) = explode('|', $flash);
	$this->registerJs('$.alert("' . $message . '", "' . $type . '");', 3);
}
?>
<!-- end admin-alerts -->

<?php $this->endBody(); ?>
</body>
<!-- end body -->

</html>
<!-- end html -->
<?php $this->endPage(); ?>
