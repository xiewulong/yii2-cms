<?php
namespace yii\cms\widgets;

use Yii;
use yii\helpers\Html;

use yii\cms\models\SiteModule;
use yii\cms\models\SiteModuleItem;

class Menu extends Ul {

	public $route = [];

	public $paramKey = 'id';

	protected $_home;

	public function init() {
		parent::init();

		if($this->_superior = SiteModule::findOne([
			'site_id' => $this->siteId,
			'type' => SiteModule::TYPE_MENU,
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

	protected function renderItems() {
		return Html::ul($this->items, array_merge([
			'item' => function($item) {
				$itemOptions = $this->itemOptions;
				if(isset($item['options'])) {
					$itemOptions = array_merge($item['options'], $itemOptions);
				}

				$_options = [];
				if($this->targetBlank) {
					$_options['target'] = '_blank';
				}
				if($this->isCurrent($item)) {
					$itemOptions['class'] = (isset($itemOptions['class']) ? $itemOptions['class'] : '') . ' current';
				}
				$content = Html::a($item['title'], [$this->moduleRoute . 'link/jump', 'id' => $item['id']], $_options);

				if($this->recursive) {
					$content .= $this->children($item);
				}

				return Html::tag('li', $content, $itemOptions);
			},
		], $this->listOptions));
	}

	protected function children($item) {
		if(!$item->subModule) return null;

		return static::widget([
			'siteId' => $this->siteId,
			'position' => $item->subModule->position,
			'route' => $this->route,
			'options' => ['class' => 'dropdown'],
			'listOptions' => [
				'class' => 'clearfix',
			],
		]);
	}

	private function isCurrent($item) {
		if($item->type == SiteModuleItem::TYPE_HOME) {
			return $this->atHome;
		}

		$url = $item->link;
		if(!is_array($url) || !isset($url[0])) {
			return \Yii::$app->request->absoluteUrl == ltrim(\Yii::$app->urlManager->createAbsoluteUrl($url), '/');
		}

		$id = isset($url[$this->paramKey]) ? $url[$this->paramKey] : null;
		if($id === null) {
			return false;
		}

		$route = $url[0];
		if($this->moduleRoute) {
			$route = $this->moduleRoute . $route;
		} else if(strpos($route, '/') !== 0) {
			$route = \Yii::$app->controller->module->uniqueId . '/' . $route;
		}

		$route = ltrim($route, '/');
		if($route == \Yii::$app->controller->route
			&& $id == \Yii::$app->request->get($this->paramKey)) {
			return true;
		}

		$_route = ltrim(isset($this->route[0]) ? $this->route[0] : null, '/');
		$_id = isset($this->route[$this->paramKey]) ? $this->route[$this->paramKey] : null;

		return $_route !== null
			&& $route == $_route
			&& $id == $_id;
	}

	public static function atHome() {
		$static = new static;

		return $static->atHome;
	}

	protected function getAtHome() {
		if($this->_home === null) {
			$defaultRoutes = $this->moduleDefaultRoute;

			$this->_home = isset($defaultRoutes[0]) && $defaultRoutes[0] == \Yii::$app->defaultRoute && \Yii::$app->controller->route == implode('/', $defaultRoutes) . '/' . \Yii::$app->controller->defaultAction;
		}

		return $this->_home;
	}

	protected function getModuleDefaultRoute($module = null) {
		if($module === null) {
			$module = \Yii::$app->controller->module;
		}

		return $module->module ? array_merge($this->getModuleDefaultRoute($module->module), (array) $module->defaultRoute) : (array) $module->defaultRoute;
	}

}
