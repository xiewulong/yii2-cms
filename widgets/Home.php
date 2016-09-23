<?php
namespace yii\cms\widgets;

use Yii;
use yii\helpers\Html;

use yii\cms\models\SiteModule;
use yii\cms\models\SiteModuleItem;

class Home extends Ul {

	public $type;

	public $headingEnabled = true;

	public $aliasToIcon = false;

	public $keywordsToIcon = false;

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

	protected function renderAll() {
		return $this->items ? Html::tag($this->tag, Html::tag('div', $this->renderHeading() . $this->renderItems() . $this->renderTargetMore(), ['class' => 'container']), $this->options) : null;
	}

	protected function renderHeading() {
		if(!$this->headingEnabled || !$this->_superior) return null;

		$content = (array) Html::tag('h5', isset($this->_superior->name) ? $this->_superior->name : $this->_superior->title);
		if($this->_superior->alias) {
			$content[] = Html::tag('small', $this->_superior->alias);
		}
		$content[] = Html::tag('span', null);

		if(!isset($this->headingOptions['class'])) {
			$this->headingOptions['class'] = 'heading';
		}

		return Html::tag('div', implode('', $content), $this->headingOptions);
	}

	protected function renderItems() {
		return Html::ul($this->items, array_merge([
			'item' => function($item) {
				$_content = [];
				$_options = [];
				if(isset($item['thumbnail_id']) && $item['thumbnail_id']) {
					$_content[] = Html::tag('b', Html::img($this->createImageRoute($item['thumbnail_id'])));
				} else if(isset($item['picture_id']) && $item['picture_id']) {
					$_content[] = Html::tag('b', Html::img($this->createImageRoute($item['picture_id'])));
				} else if($this->aliasToIcon && isset($item['alias']) && $item['alias']) {
					$_content[] = Html::tag('b', Html::tag('i', null, ['class' => 'fa fa-' . $item['alias']]));
				} else if($this->keywordsToIcon && isset($item['keywords']) && $item['keywords']) {
					$_content[] = Html::tag('b', Html::tag('i', null, ['class' => 'fa fa-' . $item['keywords']]));
				}
				if(isset($item['name']) && $item['name']) {
					$_content[] = Html::tag('div', $item['name'], ['class' => 'name']);
				} else if(isset($item['title']) && $item['title']) {
					$_content[] = Html::tag('div', $item['title'], ['class' => 'title']);
				}
				if(isset($item['alias']) && $item['alias']) {
					$_content[] = Html::tag('div', $item['alias'], ['class' => 'alias']);
				}
				if(isset($item['description']) && $item['description']) {
					$_content[] = Html::tag('div', $item['description'], ['class' => 'description']);
				}
				if($this->targetBlank) {
					$_options['target'] = '_blank';
				}
				$content = Html::a(implode('', $_content), $this->createLink($item), $_options);

				$itemOptions = $this->itemOptions;
				if(isset($item['options'])) {
					$itemOptions = array_merge($item['options'], $itemOptions);
				}

				return Html::tag('li', $content, $itemOptions);
			},
		], $this->listOptions));
	}

}
