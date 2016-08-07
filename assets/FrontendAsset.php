<?php
namespace yii\cms\assets;

use Yii;
use yii\xui\ModuleAsset;

class FrontendAsset extends ModuleAsset {

	public $distPath = 'dist/frontend';

	public $depends = [
		'yii\xui\BootstrapAsset',
	];

}
