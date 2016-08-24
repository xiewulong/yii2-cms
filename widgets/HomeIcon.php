<?php
namespace yii\cms\widgets;

use Yii;
use yii\helpers\Html;

class HomeIcon extends Home {

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
				} else if($item['description']) {
					$_content[] = Html::tag('b', Html::tag('i', null, ['class' => 'fa fa-' . $item['description']]));
				}
				if($item['title']) {
					$_content[] = Html::tag('div', $item['title'], ['class' => 'title']);
				}
				if($item['alias']) {
					$_content[] = Html::tag('div', $item['alias'], ['class' => 'alias']);
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
