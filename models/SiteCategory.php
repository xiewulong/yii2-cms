<?php
namespace yii\cms\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\components\ActiveRecord;

/**
 * Site model
 *
 * @since 0.0.1
 * @property {integer} $id
 * @property {integer} $site_id
 * @property {integer} $parent_id
 * @property {string} $name
 * @property {integer} $status
 * @property {integer} $list_order
 * @property {integer} $created_at
 * @property {integer} $updated_at
 */
class SiteCategory extends ActiveRecord {

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
			[['site_id', 'name'], 'required'],
			[['parent_id', 'list_order'], 'default', 'value' => 0],

			['name', 'string', 'min' => 6, 'max' => 16],

			['status', 'default', 'value' => self::STATUS_ENABLED],
			['status', 'in', 'range' => [
				self::STATUS_ENABLED,
				self::STATUS_DISABLED,
			]],

			// Query data needed
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios() {
		$scenarios = parent::scenarios();
		$common = ['site_id', 'parent_id', 'name', 'status'];
		$scenarios['add'] = $common;
		$scenarios['edit'] = $common;

		return $scenarios;
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id' => \Yii::t($this->messageCategory, 'Id'),
			'site_id' => \Yii::t($this->messageCategory, 'Site'),
			'parent_id' => \Yii::t($this->messageCategory, 'Parent'),
			'name' => \Yii::t($this->messageCategory, 'Name'),
			'status' => \Yii::t($this->messageCategory, 'Status'),
			'list_order' => \Yii::t($this->messageCategory, 'List order'),
			'created_at' => \Yii::t($this->messageCategory, 'Created time'),
			'updated_at' => \Yii::t($this->messageCategory, 'Updated time'),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeHints() {
		return [
			'id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Id'),
			]),
			'site_id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Site id'),
			]),
			'parent_id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Parent id'),
			]),
			'name' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Name'),
			]),
			'status' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Status'),
			]),
			'list_order' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'List order'),
			]),
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
			self::STATUS_DELETED => \Yii::t($this->messageCategory, 'Deleted'),
			self::STATUS_ENABLED => \Yii::t($this->messageCategory, 'Enabled'),
			self::STATUS_DISABLED => \Yii::t($this->messageCategory, 'Disabled'),
		];
	}

	/**
	 * Get articles belongs it
	 *
	 * @since 0.0.1
	 * @return {object}
	 */
	public function getArticles() {
		return $this->hasMany(SiteArticle::classname(), ['category_id' => 'id']);
	}

	/**
	 * Get it's articles quantity
	 *
	 * @since 0.0.1
	 * @return {object}
	 */
	public function getArticleQuantity($status = null) {
		$query = $this->getArticles();
		if($status !== null) {
			$query->where(['status' => $status]);
		}

		return $query->count();
	}

	/**
	 * Get it's articles total page view
	 *
	 * @since 0.0.1
	 * @return {object}
	 */
	public function getTotalPageView($status = null) {
		$query = $this->getArticles();
		if($status !== null) {
			$query->where(['status' => $status]);
		}

		return $query->sum('pv') ? : 0;
	}

	/**
	 * Get it's articles total unique visitor
	 *
	 * @since 0.0.1
	 * @return {object}
	 */
	public function getTotalUniqueVisitor($status = null) {
		$query = $this->getArticles();
		if($status !== null) {
			$query->where(['status' => $status]);
		}

		return $query->sum('uv') ? : 0;
	}

}
