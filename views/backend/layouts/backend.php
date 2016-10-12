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
<title><?= Html::encode($this->title) ?> - <?= Html::encode(($site['name'] ? : \Yii::$app->name) . \Yii::t($module->messageCategory, 'management system')) ?></title>
<meta charset="<?= \Yii::$app->charset ?>" />
<meta name="author" content="<?= $site['author'] ? : 'xiewulong<xiewulong@vip.qq.com>' ?>" />
<meta name="keywords" content="<?= $site['keywords'] ?>" />
<meta name="description" content="<?= $site['description'] ?>" />

<!-- begin ie modes -->
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<meta name="renderer" content="webkit" />
<!-- end ie modes -->

<!-- begin mobile -->
<meta name="viewport" content="width=device-width,initial-scale=1" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-touch-fullscreen" content="yes" />
<meta name="format-detection" content="telephone=no,email=no" />
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
$sidebar = array_merge([
	[
		'text' => \Yii::t($module->messageCategory, 'dashboard'),
		'icon' => 'glyphicon glyphicon-dashboard',
		'url' => [$module->url('dashboard/index')],
	],
	[
		'text' => \Yii::t($module->messageCategory, 'global'),
		'icon' => 'glyphicon glyphicon-globe',
		'url' => [$module->url('global/site')],
	],
	[
		'text' => \Yii::t($module->messageCategory, 'category'),
		'icon' => 'glyphicon glyphicon glyphicon-th-list',
		'url' => [$module->url('category/list')],
	],
	[
		'text' => \Yii::t($module->messageCategory, 'article'),
		'icon' => 'glyphicon glyphicon glyphicon-pencil',
		'url' => [$module->url('article/list')],
	],
	[
		'text' => \Yii::t($module->messageCategory, 'menu'),
		'icon' => 'glyphicon glyphicon-menu-hamburger',
		'url' => [$module->url('menu/list')],
	],
	[
		'text' => \Yii::t($module->messageCategory, 'banner'),
		'icon' => 'glyphicon glyphicon-flag',
		'url' => [$module->url('banner/list')],
	],
], $module->addSidebarItems);
$params = [
	'brand' => [
		'logo' => $module->attachmentRoute($site['logo_id']),
		'text' => ($site['name'] ? : \Yii::$app->name) . \Yii::t($module->messageCategory, 'management system'),
		'url' => [$module->url('dashboard/index')],
	],
	'menus' => [
		[
			'text' => \Yii::$app->user->identity->name,
			'icon' => 'glyphicon glyphicon-user',
			'options' => ['class' => 'pull-right border-none'],
			'dropdown' => [
				[
					'text' => \Yii::t($module->messageCategory, 'reset password'),
					'url' => ['/account/password/reset'],
					'options' => ['data-password' => 'reset'],
				],
				[
					'text' => \Yii::t($module->messageCategory, 'logout'),
					'url' => ['/account/user/logout'],
					'options' => ['data-user' => 'logout'],
				],
			],
		],
		[
			'text' => \Yii::t($module->messageCategory, '{action} {attribute}', [
				'action' => \Yii::t($module->messageCategory, 'go'),
				'attribute' => \Yii::t($module->messageCategory, 'home'),
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
	'route' => isset($this->params['route']) ? $this->params['route'] : null,
];

$params['menus'] = array_merge($params['menus'], $module->addMenuItems);
?>
<?= Admin::widget($params) ?>

<!-- begin admin-alerts -->
<div class="admin-alerts J-admin-alerts"></div>
<?php
foreach(\Yii::$app->session->allFlashes as $flash) {
	list($type, $message) = explode('|', $flash);
	$this->registerJs('$.alert("' . addslashes($message) . '", "' . $type . '");', 3);
}
?>
<!-- end admin-alerts -->

<?php $this->endBody(); ?>
</body>
<!-- end body -->

</html>
<!-- end html -->
<?php $this->endPage(); ?>
