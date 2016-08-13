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
<title><?= Html::encode($this->title) ?> - <?= Html::encode($site['name']) ?> - <?= Html::encode(\Yii::$app->name) ?></title>
<meta charset="<?= \Yii::$app->charset ?>" />
<meta name="author" content="<?= $site['author'] ?>" />
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

<?= Admin::widget([
	'brand' => [
		'logo' => $site['logo'],
		'text' => \Yii::$app->name . Html::tag('small', $site['name']),
		'url' => ['/' . $module->id . '/dashboard/index'],
	],
	'menus' => [
		[
			'text' => \Yii::$app->user->identity->username,
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
			'text' => 'Site',
			'options' => ['style' => 'display:none;'],
			'sidebar' => [
				[
					'text' => \Yii::t($module->messageCategory, 'Dashboard'),
					'icon' => 'glyphicon glyphicon-dashboard',
					'url' => ['/' . $module->id . '/dashboard/index'],
				],
				[
					'text' => \Yii::t($module->messageCategory, 'Global'),
					'icon' => 'glyphicon glyphicon-globe',
					'url' => ['/' . $module->id . '/global/edit'],
				],
				[
					'text' => \Yii::t($module->messageCategory, 'Category'),
					'icon' => 'glyphicon glyphicon glyphicon-th-list',
					'url' => ['/' . $module->id . '/category/list'],
				],
				[
					'text' => \Yii::t($module->messageCategory, 'Article'),
					'icon' => 'glyphicon glyphicon glyphicon-pencil',
					'url' => ['/' . $module->id . '/article/list'],
				],
			],
		],
	],
	'content' => $content,
]) ?>

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
