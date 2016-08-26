<?php
namespace yii\cms\widgets;

use Yii;
use yii\helpers\Html;

class Crumbs extends Ul {

	public $headingText;

	public $homeText = 'Home';

	public function init() {
		parent::init();

		$this->items = [['title' => $this->homeText, 'url' => \Yii::$app->homeUrl, 'options' => ['class' => 'home']]];
		if($this->headingText) {
			array_unshift($this->items, ['title' => $this->headingText, 'options' => ['class' => 'heading']]);
		}
		if(isset($this->view->params['crumbs']) && is_array($this->view->params['crumbs']) && $this->view->params['crumbs']) {
			$this->items = array_merge($this->items, $this->view->params['crumbs']);
		}
	}

}
