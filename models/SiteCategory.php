<?php
namespace yii\cms\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\components\ActiveRecord;

/**
 * Category model
 *
 * @since 0.0.1
 * @property {integer} $id
 * @property {string} $site_id
 * @property {integer} $type
 * @property {string} $name
 * @property {string} $alias
 * @property {integer} $status
 * @property {integer} $creator_id
 * @property {integer} $created_at
 * @property {integer} $operator_id
 * @property {integer} $updated_at
 */
class SiteCategory extends ActiveRecord {

	const TYPE_PARENT = 0;
	const TYPE_NEWS = 1;
	const TYPE_PICTURES = 2;
	const TYPE_PAGE = 3;
	const TYPE_NOTICE = 4;
	const TYPE_DOWNLOAD = 5;

	const STATUS_DELETED = 0;
	const STATUS_ENABLED = 1;
	const STATUS_DISABLED = 2;

	public $messageCategory = 'cms';

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%site_category}}';
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
			[['name', 'alias'], 'trim'],
			[['site_id', 'name'], 'required'],

			['name', 'string', 'max' => 16],

			['type', 'default', 'value' => static::TYPE_NEWS],
			['type', 'in', 'range' => [
				static::TYPE_NEWS,
				// static::TYPE_PICTURES,
				static::TYPE_PAGE,
				static::TYPE_NOTICE,
				static::TYPE_DOWNLOAD,
			]],

			['status', 'default', 'value' => static::STATUS_ENABLED],
			['status', 'in', 'range' => [
				static::STATUS_ENABLED,
				static::STATUS_DISABLED,
			]],

			[['creator_id', 'operator_id'], 'filter', 'filter' => function($value) {
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
			'type',
			'name',
			'alias',
			'status',
			'creator_id',
			'operator_id',
		];

		$scenarios['edit'] = [
			'type',
			'name',
			'alias',
			'status',
			'operator_id',
		];

		return $scenarios;
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id' => \Yii::t($this->messageCategory, 'Category id'),
			'site_id' => \Yii::t($this->messageCategory, 'Site'),
			'type' => \Yii::t($this->messageCategory, 'Type'),
			'name' => \Yii::t($this->messageCategory, 'Name'),
			'alias' => \Yii::t($this->messageCategory, 'Alias'),
			'status' => \Yii::t($this->messageCategory, 'Status'),
			'creator_id' => \Yii::t($this->messageCategory, 'Creator id'),
			'created_at' => \Yii::t($this->messageCategory, 'Created time'),
			'operator_id' => \Yii::t($this->messageCategory, 'Operator id'),
			'updated_at' => \Yii::t($this->messageCategory, 'Updated time'),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeHints() {
		return [
			'id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Category id'),
			]),
			'site_id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Site'),
			]),
			'type' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Type'),
			]),
			'name' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Name'),
			]),
			'alias' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Alias'),
			]),
			'status' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Status'),
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
				static::TYPE_NEWS => \Yii::t($this->messageCategory, 'News'),
				static::TYPE_PICTURES => \Yii::t($this->messageCategory, 'Gallery'),
				static::TYPE_PAGE => \Yii::t($this->messageCategory, 'Single page'),
				static::TYPE_NOTICE => \Yii::t($this->messageCategory, 'Notice'),
				static::TYPE_DOWNLOAD => \Yii::t($this->messageCategory, 'Download'),
			],
		];
	}

	/**
	 * Return status items in every scenario
	 *
	 * @since 0.0.1
	 * @return {array}
	 */
	public function statusItems() {
		return [
			[
				static::STATUS_DELETED => \Yii::t($this->messageCategory, 'Deleted'),
				static::STATUS_ENABLED => \Yii::t($this->messageCategory, 'Enabled'),
				static::STATUS_DISABLED => \Yii::t($this->messageCategory, 'Disabled'),
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
		return $this->save();
	}

	/**
	 * @inheritdoc
	 */
	public function beforeDelete() {
		return !$this->getItems()->count() || SiteArticle::deleteAll([
			'category_id' => $this->id,
		]);
	}

	/**
	 * Get articles belongs it
	 *
	 * @since 0.0.1
	 * @return {array}
	 */
	public function getArticles() {
		return $this->hasMany(SiteArticle::classname(), ['category_id' => 'id']);
	}

	/**
	 * Subordinates alias
	 *
	 * @since 0.0.1
	 * @return {array}
	 */
	public function getItems() {
		return $this->getArticles();
	}

	/**
	 * Filter articles
	 *
	 * @since 0.0.1
	 * @return {array}
	 */
	public function getFeaturedItems() {
		return $this->getItems()->onCondition([
			'status' => SiteArticle::STATUS_FEATURED,
		])->orderby('created_at desc');
	}

	/**
	 * Get it's items quantity
	 *
	 * @since 0.0.1
	 * @return {integer}
	 */
	public function getItemQuantity() {
		return $this->getItems()->count();
	}

	/**
	 * Get it's items total page view
	 *
	 * @since 0.0.1
	 * @return {integer}
	 */
	public function getItemTotalPageView() {
		return $this->getItems()->sum('pv') ? : 0;
	}

	/**
	 * Get it's items total unique visitor
	 *
	 * @since 0.0.1
	 * @return {integer}
	 */
	public function getItemTotalUniqueVisitor() {
		return $this->getItems()->sum('uv') ? : 0;
	}

}
