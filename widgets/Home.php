<?php
namespace yii\cms\widgets;

use Yii;
use yii\helpers\Html;

use yii\cms\models\SiteModule;
use yii\cms\models\SiteModuleItem;

class Home extends Ul {

	public $type = SiteModule::TYPE_MENU;

	public $titleEnabled = true;

	public function run() {
		return empty($this->items) ? null : Html::tag($this->tag, Html::tag('div', $this->renderTitle() . $this->renderItems() . $this->more, ['class' => 'container']), $this->options);
	}

	protected function renderTitle() {
		if(!$this->titleEnabled) return null;

		$content = (array) Html::tag('h5', $this->_superior->name);
		if($this->_superior->alias) {
			$content[] = Html::tag('small', $this->_superior->alias);
		}
		$content[] = Html::tag('span', null);

		if(!isset($this->titleOptions['class'])) {
			$this->titleOptions['class'] = 'header';
		}

		return Html::tag('div', implode('', $content), $this->titleOptions);
	}

	protected function renderItems() {
		$itemOptions = $this->itemOptions;
		$blankTarget = $this->blankTarget;
		$moduleRoute = $this->moduleRoute;

		return Html::ul($this->items, array_merge([
			'item' => function($item) use($itemOptions, $blankTarget, $moduleRoute) {
				$_content = [];
				$_options = [];
				if($item['picture']) {
					$_content[] = Html::tag('b', Html::img($item['picture']));
				}
				if($item['title']) {
					$_content[] = Html::tag('div', $item['title'], ['class' => 'title']);
				}
				if($item['alias']) {
					$_content[] = Html::tag('div', $item['alias'], ['class' => 'alias']);
				}
				if($item['description']) {
					$_content[] = Html::tag('div', $item['description'], ['class' => 'description']);
				}
				if($blankTarget) {
					$_options['target'] = '_blank';
				}
				$content = Html::a(implode('', $_content), [$moduleRoute . 'link/jump', 'id' => $item['id']], $_options);

				return Html::tag('li', $content, $itemOptions);
			},
		], $this->listOptions));
	}

}
