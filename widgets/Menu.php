<?php
namespace yii\cms\widgets;

use Yii;
use yii\helpers\Html;
use yii\xui\Ul;

use yii\cms\models\SiteModule;
use yii\cms\models\SiteModuleItem;

class Menu extends Ul {

	public $position;

	public $route = [];

	public $paramKey = 'id';

	public function init() {
		parent::init();

		if($superior = SiteModule::findOne([
			'site_id' => \Yii::$app->controller->module->siteId,
			'type' => SiteModule::TYPE_MENU,
			'position' => $this->position,
			'status' => SiteModule::STATUS_ENABLED,
		])) {
			$this->items = $superior->getItems()
				->select('id, type, target_id, title, url')
				->where([
					'site_id' => \Yii::$app->controller->module->siteId,
					'status' => SiteModuleItem::STATUS_ENABLED,
				])
				->orderby('list_order desc, created_at desc')
				->all();
		}
	}

	protected function renderItems() {
		$itemOptions = $this->itemOptions;
		$blankTarget = $this->blankTarget;

		return Html::ul($this->items, [
			'item' => function($item) use($itemOptions, $blankTarget) {
				$_options = [];
				if($blankTarget) {
					$_options['target'] = '_blank';
				}
				if($this->isCurrent($item)) {
					$itemOptions['class'] = (isset($itemOptions['class']) ? $itemOptions['class'] : '') . ' current';
				}
				$content = Html::a($item['title'], ['link/jump', 'id' => $item['id']], $_options);

				return Html::tag('li', $content, $itemOptions);
			},
		]);
	}

	private function isCurrent($item) {
		if($item->type == SiteModuleItem::TYPE_HOME) {
			$defaultRoutes = $this->moduleDefaultRoute;

			return isset($defaultRoutes[0]) && $defaultRoutes[0] == \Yii::$app->defaultRoute && \Yii::$app->controller->route == implode('/', $defaultRoutes) . '/' . \Yii::$app->controller->defaultAction;
		}

		$url = $item->link;
		if(!is_array($url) || !isset($url[0])) {
			return false;
		}

		$id = isset($url[$this->paramKey]) ? $url[$this->paramKey] : null;
		if($id === null) {
			return false;
		}

		$route = $url[0];
		if(strpos($route, '/') !== 0) {
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

	protected function getModuleDefaultRoute($module = null) {
		if($module === null) {
			$module = \Yii::$app->controller->module;
		}

		return $module->module ? array_merge($this->getModuleDefaultRoute($module->module), (array) $module->defaultRoute) : (array) $module->defaultRoute;
	}

}
