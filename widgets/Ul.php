<?php
namespace yii\cms\widgets;

use Yii;
use yii\helpers\Html;

use yii\cms\models\SiteModule;
use yii\cms\models\SiteModuleItem;

class Ul extends \yii\xui\Ul {

	public $siteId;

	public $type;

	public $position;

	public $moduleRoute;

	public $titleEnabled = false;

	public $titleOptions = [];

	public $more;

	protected $_superior;

	public function init() {
		parent::init();

		if($this->_superior = SiteModule::findOne([
			'site_id' => $this->siteId,
			'type' => $this->type,
			'position' => $this->position,
			'status' => SiteModule::STATUS_ENABLED,
		])) {
			$this->items = $this->_superior->getItems()
				->where([
					'site_id' => $this->siteId,
					'status' => SiteModuleItem::STATUS_ENABLED,
				])
				->orderby('list_order desc, created_at desc')
				->all();
		}
	}

	public function run() {
		return empty($this->items) ? null : Html::tag($this->tag, $this->renderTitle() . $this->renderItems() . $this->more, $this->options);
	}

	protected function renderTitle() {
		if(!$this->titleEnabled) return null;

		$content = (array) Html::tag('h5', $this->_superior->name);
		if($this->_superior->alias) {
			$content[] = Html::tag('small', $this->_superior->alias);
		}

		if(!isset($this->titleOptions['class'])) {
			$this->titleOptions['class'] = 'header';
		}

		return Html::tag('div', implode('', $content), $this->titleOptions);
	}

	protected function renderItems() {
		$itemOptions = $this->itemOptions;
		$backgroundImage = $this->backgroundImage;
		$blankTarget = $this->blankTarget;
		$moduleRoute = $this->moduleRoute;

		return Html::ul($this->items, array_merge([
			'item' => function($item) use($itemOptions, $backgroundImage, $blankTarget, $moduleRoute) {
				$_content = [];
				$_options = [];
				if($item['picture']) {
					if($backgroundImage) {
						$_options['style'] = 'background-image:url(' . $item['picture'] . ');';
					} else {
						$_content[] = Html::tag('b', Html::img($item['picture']));
					}
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
