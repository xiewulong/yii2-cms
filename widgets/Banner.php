<?php
namespace yii\cms\widgets;

use Yii;
use yii\helpers\Html;

use yii\cms\models\SiteModule;
use yii\cms\models\SiteModuleItem;

class Banner extends Ul {

	public $type = SiteModule::TYPE_BANNER;

	public $carousel = false;

	public $carouselIdPre = 'J-x-carousel-';

	protected $_id;

	public function init() {
		parent::init();

		if($this->items && $this->carousel) {
			$this->options['id'] = $this->randomId;
			$this->view->registerJs("$('#{$this->randomId}').carousel();", 3);
		}
	}

	protected function getRandomId() {
		if($this->_id === null) {
			$this->_id = $this->carouselIdPre . time() . str_pad(mt_rand(0, 9999), 4, 0, STR_PAD_LEFT);
		}

		return $this->_id;
	}

}
