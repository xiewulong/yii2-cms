<?php
namespace yii\cms\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\components\ActiveRecord;

/**
 * Module item model
 *
 * @since 0.0.1
 * @property {integer} $id
 * @property {string} $site_id
 * @property {integer} $module_id
 * @property {integer} $sub_module_id
 * @property {integer} $type
 * @property {integer} $target_id
 * @property {string} $title
 * @property {string} $alias
 * @property {string} $description
 * @property {string} $picture_id
 * @property {string} $url
 * @property {integer} $status
 * @property {integer} $start_at
 * @property {integer} $end_at
 * @property {integer} $list_order
 * @property {integer} $pv
 * @property {integer} $uv
 * @property {integer} $operator_id
 * @property {integer} $creator_id
 * @property {integer} $created_at
 * @property {integer} $updated_at
 *
 * @property {integer} $category_id
 * @property {integer} $article_id
 */
class SiteModuleItem extends ActiveRecord {

	const TYPE_LINK = 1;
	const TYPE_HOME = 2;
	const TYPE_CATEGORY = 3;
	const TYPE_ARTICLE = 4;

	const STATUS_DELETED = 0;
	const STATUS_ENABLED = 1;
	const STATUS_DISABLED = 2;

	public $category_id;

	public $article_id;

	public $messageCategory = 'cms';

	protected $statisticsEnable = true;

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%site_module_item}}';
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			TimestampBehavior::className(),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['title', 'alias', 'picture_id', 'description'], 'trim'],
			[['id', 'site_id', 'module_id', 'type'], 'required'],

			['title', 'required', 'when' => function($self) {
				return $self->module->type == SiteModule::TYPE_MENU;
			}],

			['picture_id', 'required', 'when' => function($self) {
				return $self->module->type == SiteModule::TYPE_BANNER;
			}],

			['url', 'required', 'when' => function($self) {
				return $self->type == self::TYPE_LINK;
			}],

			['category_id', 'required', 'when' => function($self) {
				return $self->type == self::TYPE_CATEGORY;
			}],

			['article_id', 'required', 'when' => function($self) {
				return $self->type == self::TYPE_ARTICLE;
			}],

			['type', 'default', 'value' => self::TYPE_LINK],
			['type', 'in', 'range' => [
				self::TYPE_LINK,
				self::TYPE_HOME,
				self::TYPE_CATEGORY,
				self::TYPE_ARTICLE,
			]],

			['status', 'default', 'value' => self::STATUS_ENABLED],
			['status', 'in', 'range' => [
				self::STATUS_ENABLED,
				self::STATUS_DISABLED,
			]],

			[['operator_id', 'creator_id'], 'filter', 'filter' => function($value) {
				return \Yii::$app->user->isGuest ? 0 : \Yii::$app->user->identity->id;
			}],

			// Query data needed
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios() {
		$scenarios = parent::scenarios();

		$scenarios['add'] = [
			'site_id',
			'module_id',
			'sub_module_id',
			'type',
			'target_id',
			'title',
			'alias',
			'description',
			'picture_id',
			'url',
			'status',
			'start_at',
			'end_at',
			'operator_id',
			'creator_id',

			'category_id',
			'article_id',
		];

		$scenarios['edit'] = [
			'sub_module_id',
			'type',
			'target_id',
			'title',
			'alias',
			'description',
			'picture_id',
			'url',
			'status',
			'start_at',
			'end_at',
			'operator_id',

			'category_id',
			'article_id',
		];

		$scenarios['sort'] = [
			'list_order',
			'operator_id',
		];

		return $scenarios;
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id' => \Yii::t($this->messageCategory, 'Module item id'),
			'site_id' => \Yii::t($this->messageCategory, 'Site'),
			'module_id' => \Yii::t($this->messageCategory, 'Module'),
			'sub_module_id' => \Yii::t($this->messageCategory, 'Sub module'),
			'type' => \Yii::t($this->messageCategory, 'Type'),
			'target_id' => \Yii::t($this->messageCategory, 'Target'),
			'title' => \Yii::t($this->messageCategory, 'Title'),
			'alias' => \Yii::t($this->messageCategory, 'Alias'),
			'description' => \Yii::t($this->messageCategory, 'Description'),
			'picture_id' => \Yii::t($this->messageCategory, 'Picture'),
			'url' => \Yii::t($this->messageCategory, 'Url'),
			'status' => \Yii::t($this->messageCategory, 'Status'),
			'start_at' => \Yii::t($this->messageCategory, 'Start time'),
			'end_at' => \Yii::t($this->messageCategory, 'End time'),
			'list_order' => \Yii::t($this->messageCategory, 'List order'),
			'pv' => \Yii::t($this->messageCategory, 'Page view'),
			'uv' => \Yii::t($this->messageCategory, 'Unique Visitor'),
			'operator_id' => \Yii::t($this->messageCategory, 'Operator id'),
			'creator_id' => \Yii::t($this->messageCategory, 'Creator id'),
			'created_at' => \Yii::t($this->messageCategory, 'Created time'),
			'updated_at' => \Yii::t($this->messageCategory, 'Updated time'),

			'category_id' => \Yii::t($this->messageCategory, 'Category'),
			'article_id' => \Yii::t($this->messageCategory, 'Article'),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeHints() {
		return [
			'id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Module item id'),
			]),
			'site_id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Site'),
			]),
			'module_id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Module'),
			]),
			'sub_module_id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Sub module'),
			]),
			'type' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Type'),
			]),
			'target_id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Target'),
			]),
			'title' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Title'),
			]),
			'alias' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Alias'),
			]),
			'description' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Description'),
			]),
			'picture_id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'upload'),
				'attribute' => \Yii::t($this->messageCategory, 'Picture'),
			]),
			'url' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Url'),
			]),
			'status' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Status'),
			]),
			'start_at' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Start time'),
			]),
			'end_at' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'End time'),
			]),
			'list_order' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'List order'),
			]),

			'category_id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Category'),
			]),
			'article_id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Article'),
			]),
		];
	}

	/**
	 * Return type items
	 *
	 * @since 0.0.1
	 * @return {array}
	 */
	public function typeItems() {
		return [
			[
				self::TYPE_LINK => \Yii::t($this->messageCategory, 'Link'),
				self::TYPE_HOME => \Yii::t($this->messageCategory, 'Home'),
				self::TYPE_CATEGORY => \Yii::t($this->messageCategory, 'Category'),
				self::TYPE_ARTICLE => \Yii::t($this->messageCategory, 'Article'),
			],
			[
				self::TYPE_LINK => [
					'category_id',
					'article_id',
				],
				self::TYPE_HOME => [
					'url',

					'category_id',
					'article_id',
				],
				self::TYPE_CATEGORY => [
					'url',

					'article_id',
				],
				self::TYPE_ARTICLE => [
					'url',

					'category_id',
				],
			],
		];
	}

	/**
	 * Return status items
	 *
	 * @since 0.0.1
	 * @return {array}
	 */
	public function statusItems() {
		return [
			[
				self::STATUS_DELETED => \Yii::t($this->messageCategory, 'Deleted'),
				self::STATUS_ENABLED => \Yii::t($this->messageCategory, 'Enabled'),
				self::STATUS_DISABLED => \Yii::t($this->messageCategory, 'Disabled'),
			],
		];
	}

	/**
	 * Running a common Handler
	 *
	 * @since 0.0.1
	 * @return {boolean}
	 */
	public function commonHandler() {
		if(!$this->validate()) {
			return false;
		}

		if(in_array($this->scenario, ['add', 'edit'])) {
			if($this->type == self::TYPE_CATEGORY) {
				$this->target_id = $this->category_id;
			}
			if($this->type == self::TYPE_ARTICLE) {
				$this->target_id = $this->article_id;
			}
		}

		return $this->save(false);
	}

	/**
	 * Superior alias
	 *
	 * @since 0.0.1
	 * @return {object}
	 */
	public function getSuperior() {
		return $this->getModule();
	}

	/**
	 * Get its belongs module
	 *
	 * @since 0.0.1
	 * @return {object}
	 */
	public function getModule() {
		return $this->hasOne(SiteModule::classname(), ['id' => 'module_id']);
	}

	/**
	 * Get sub module belongs it
	 *
	 * @since 0.0.1
	 * @return {object}
	 */
	public function getSubModule() {
		return $this->hasOne(SiteModule::classname(), ['id' => 'sub_module_id']);
	}

	/**
	 * Get target model
	 *
	 * @since 0.0.1
	 * @return {object}
	 */
	public function getTarget() {
		switch($this->type) {
			case self::TYPE_CATEGORY:
				$classname = SiteCategory::classname();
				break;
			case self::TYPE_ARTICLE:
				$classname = SiteArticle::classname();
				break;
		}

		return $this->hasOne($classname, ['id' => 'target_id'])->onCondition(['site_id' => $this->site_id]);
	}

	/**
	 * Get cache model
	 *
	 * @since 0.0.1
	 * @return {object}
	 */
	protected function getCacheTarget($type) {
		switch($type) {
			case self::TYPE_CATEGORY:
				$cache_id = $this->category_id;
				$classname = SiteCategory::classname();
				break;
			case self::TYPE_ARTICLE:
				$cache_id = $this->article_id;
				$classname = SiteArticle::classname();
				break;
		}

		if(!$cache_id && $this->getOldAttribute('type') == $type) {
			$cache_id = $this->getOldAttribute('target_id');
		}

		return $classname::findOne([
			'id' => $cache_id,
			'site_id' => $this->site_id,
		]);
	}

	/**
	 * Get category model
	 *
	 * @since 0.0.1
	 * @return {object}
	 */
	public function getCategory() {
		return $this->getCacheTarget(self::TYPE_CATEGORY);
	}

	/**
	 * Get article model
	 *
	 * @since 0.0.1
	 * @return {object}
	 */
	public function getArticle() {
		return $this->getCacheTarget(self::TYPE_ARTICLE);
	}

	/**
	 * Get jump link
	 *
	 * @since 0.0.1
	 * @param {string} [$host]
	 * @return {array|string}
	 */
	public function getLink($host = null) {
		switch($this->type) {
			case self::TYPE_LINK:
				return $this->url;
				break;
			case self::TYPE_CATEGORY:
				$url = ['article/list', 'id' => $this->target_id];
				break;
			case self::TYPE_ARTICLE:
				$url = ['article/details', 'id' => $this->target_id];
				break;
			case self::TYPE_HOME:
			default:
				$url = ['/'];
				break;
		}

		if($host) {
			$url = rtrim($host, '/') . \Yii::$app->urlManager->createUrl($url);
		}

		return $url;
	}

}
