<?php
namespace yii\cms\widgets;

use Yii;
use yii\helpers\Html;
use yii\xui\Ul;

use yii\cms\models\SiteModule;
use yii\cms\models\SiteModuleItem;

class Banner extends Ul {

	public $position;

	public function init() {
		parent::init();

		if($superior = SiteModule::findOne([
			'site_id' => \Yii::$app->controller->module->siteId,
			'type' => SiteModule::TYPE_BANNER,
			'position' => $this->position,
			'status' => SiteModule::STATUS_ENABLED,
		])) {
			$this->items = $superior->getItems()
				->select([
					'id',
					'title',
					'description',
					'picture',
				])
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
		$backgroundImage = $this->backgroundImage;
		$blankTarget = $this->blankTarget;

		return Html::ul($this->items, [
			'item' => function($item) use($itemOptions, $backgroundImage, $blankTarget) {
				$_content = [];
				$_options = [];
				if(isset($item['picture'])) {
					if($backgroundImage) {
						$_options['style'] = 'background-image:url(' . $item['picture'] . ');';
					} else {
						$_content[] = Html::tag('b', Html::img($item['picture']));
					}
				}
				if(isset($item['title'])) {
					$itemOptions['data-title'] = $item['title'];
				}
				if(isset($item['description'])) {
					$itemOptions['data-description'] = $item['description'];
				}
				if($blankTarget) {
					$_options['target'] = '_blank';
				}
				$content = Html::a(implode('', $_content), ['link/jump', 'id' => $item['id']], $_options);

				return Html::tag('li', $content, $itemOptions);
			},
		]);
	}

}
