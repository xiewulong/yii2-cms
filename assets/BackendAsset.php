<?php
namespace yii\cms\assets;

use Yii;
use yii\xui\ModuleAsset;

class BackendAsset extends ModuleAsset {

	public $namespace = 'backend';

	public $depends = [
		'yii\xui\BootstrapAsset',
		'yii\xui\AdminAsset',
	];

}
