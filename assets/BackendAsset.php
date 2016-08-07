<?php
namespace yii\cms\assets;

use Yii;
use yii\xui\ModuleAsset;

class BackendAsset extends ModuleAsset {

	public $distPath = 'dist/backend';

	public $depends = [
		'yii\xui\BootstrapAsset',
		'yii\xui\AdminAsset',
	];

}
