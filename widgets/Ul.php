<?php
namespace yii\cms\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

use yii\cms\models\SiteArticle;
use yii\cms\models\SiteCategory;
use yii\cms\models\SiteModuleItem;

class Ul extends \yii\xui\Ul {

	public $siteId;

	public $position;

	public $moduleRoute;

	public $headingEnabled = false;

	public $headingOptions = [];

	public $targetEnabled = false;

	public $targetLimit = 1;

	public $targetListLimit = 10;

	public $targetMore = true;

	public $targetMoreText = 'More';

	public $targetMoreOptions = [];

	public $timeEnabled = false;

	public $timeFormat = 'Y-m-d';

	public $download = false;

	public $downloadText = 'Download';

	public $recursive = false;

	protected $_superior;

	public function run() {
		return $this->content;
	}

	protected function getContent() {
		if(!$this->targetEnabled) {
			return $this->renderAll();
		}

		$items = $this->items;
		$content = [];
		foreach($items as $index => $item) {
			if($index >= $this->targetLimit) break;

			switch($item->type) {
				case SiteModuleItem::TYPE_CATEGORY:
					$this->_superior = $item->target;
					$this->items = $item->target->getItems()
						->where([
							'site_id' => $this->siteId,
							'status' => [
								SiteArticle::STATUS_RELEASED,
								SiteArticle::STATUS_FEATURED,
							],
						])
						->orderby('status desc, created_at desc')
						->limit($this->targetListLimit)
						->all();
					break;
				case SiteModuleItem::TYPE_ARTICLE:
					$this->_superior = $item->target;
					$this->items = [$item->target];
					break;
				default:
					$this->_superior = null;
					$this->items = [];
					continue;
					break;
			}
			$content[] = $this->renderAll();
		}

		return implode('', $content);
	}

	protected function renderAll() {
		return $this->items ? Html::tag($this->tag, $this->renderHeading() . $this->renderItems() . $this->renderTargetMore(), $this->options) : null;
	}

	protected function renderTargetMore() {
		if(!$this->targetEnabled || !$this->targetMore || !$this->items) return null;

		if($this->targetBlank) {
			$this->targetMoreOptions['target'] = '_blank';
		}

		return Html::tag('div', Html::a($this->targetMoreText, $this->createLink($this->_superior), $this->targetMoreOptions), ['class' => 'more']);
	}

	protected function renderHeading() {
		if(!$this->headingEnabled || !$this->_superior) return null;

		$content = (array) Html::tag('h5', isset($this->_superior->name) ? $this->_superior->name : $this->_superior->title);
		if($this->_superior->alias) {
			$content[] = Html::tag('small', $this->_superior->alias);
		}

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
				if(isset($item['picture_id']) && $item['picture_id']) {
					if($this->backgroundImage) {
						$_options['style'] = 'background-image:url(' . Url::to($this->createImageRoute($item['picture_id'])) . ');';
					} else {
						$_content[] = Html::tag('b', Html::img($this->createImageRoute($item['picture_id'])));
					}
				}
				if($this->timeEnabled && $item['created_at']) {
					$_content[] = Html::tag('div', date($this->timeFormat, $item['created_at']), ['class' => 'time']);
				}
				if($this->download && $item[$this->download]) {
					$_content[] = Html::tag('div', $this->downloadText, ['class' => 'download']);
					$_options['target'] = '_blank';
					$link = $this->createAttachmentRoute($item[$this->download]);
				} else {
					$link = $this->createLink($item);
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
				$content = Html::a(implode('', $_content), $link, $_options);

				if($this->recursive) {
					$content .= $this->children($item);
				}

				$itemOptions = $this->itemOptions;
				if(isset($item['options'])) {
					$itemOptions = array_merge($item['options'], $itemOptions);
				}

				return Html::tag('li', $content, $itemOptions);
			},
		], $this->listOptions));
	}

	protected function children($item) {
		return null;
	}

	protected function createAttachmentRoute($id) {
		return [$this->moduleRoute . 'attachment/', 'id' => $id];
	}

	protected function createImageRoute($id) {
		return [$this->moduleRoute . 'image/', 'id' => $id];
	}

	protected function createLink($item) {
		if($item instanceof SiteModuleItem) {
			$route = [$this->moduleRoute . 'link/jump', 'id' => $item->id];
		} else if($item instanceof SiteCategory) {
			$route = [$this->moduleRoute . 'article/list', 'id' => $item->id];
		} else if($item instanceof SiteArticle) {
			$route = [$this->moduleRoute . 'article/details', 'id' => $item->id];
		} else if(isset($item['url'])) {
			$route = $item['url'];
		} else {
			$route = null;
		}

		return $route;
	}

}
