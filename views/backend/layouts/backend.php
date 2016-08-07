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
		'text' => \Yii::$app->name . Html::tag('span', $site['name']),
		'url' => ['/' . $module->id . '/dashboard/index'],
	],
	'menus' => [
		[
			'text' => \Yii::$app->user->identity->username . Html::tag('i', null, ['class' => 'glyphicon glyphicon-triangle-bottom']),
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
					'options' => ['data-method' => 'post'],
				],
			],
		],
		[
			'text' => 'Site',
			'options' => ['style' => 'display:none;'],
			'sidebar' => [
				[
					'text' => Html::tag('em', Html::tag('i', null, ['class' => 'glyphicon glyphicon-cog'])) . 'Dashboard',
					'url' => ['/' . $module->id . '/dashboard/index'],
				],
				[
					'text' => Html::tag('em', Html::tag('i', null, ['class' => 'glyphicon glyphicon-cog'])) . 'Global',
					'url' => ['/' . $module->id . '/global/index'],
				],
			],
		],
	],
	'content' => $content,
]) ?>

<?php $this->endBody(); ?>
</body>
<!-- end body -->

</html>
<!-- end html -->
<?php $this->endPage(); ?>
