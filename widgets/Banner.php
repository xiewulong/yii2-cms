<?php
namespace yii\cms\widgets;

use Yii;
use yii\helpers\Html;

use yii\cms\models\SiteBanner;
use yii\cms\models\SiteBannerItem;

class Banner extends \yii\xui\Banner {

	public $bannerId;

	public function init() {
		parent::init();

		if($banner = SiteBanner::findOne([
			'id' => $this->bannerId,
			'site_id' => \Yii::$app->controller->module->siteId,
			'status' => SiteBanner::STATUS_ENABLED,
		])) {
			$this->items = $banner->getItems()
				->select('id, title, description, picture as src')
				->where([
					'site_id' => \Yii::$app->controller->module->siteId,
					'status' => SiteBannerItem::STATUS_ENABLED,
				])
				->orderby('list_order desc, created_at desc')
				->asArray()
				->all();
		}
	}

	protected function renderItems() {
		$itemOptions = $this->itemOptions;
		$target = $this->target;
		$backgroundImage = $this->backgroundImage;

		return Html::ul($this->items, [
			'item' => function($item) use($itemOptions, $backgroundImage, $target) {
				$aOptions = ['target' => $target];
				if($backgroundImage) {
					$aOptions['style'] = 'background-image:url(' . $item['src'] . ');';
				}
				if(isset($item['title'])) {
					$itemOptions['data-title'] = $item['title'];
				}
				if(isset($item['description'])) {
					$itemOptions['data-desc'] = $item['description'];
				}
				$content = Html::a($backgroundImage ? null : Html::img($item['src'])
						, ['/' . \Yii::$app->controller->module->id . '/banner', 'id' => $item['id']]
						, $aOptions);

				return Html::tag('li', $content, $itemOptions);
			},
		]);
	}

}
