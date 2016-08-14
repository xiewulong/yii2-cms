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
 * @property {string} $id
 * @property {string} $site_id
 * @property {string} $name
 * @property {integer} $status
 * @property {integer} $operator_id
 * @property {integer} $creator_id
 * @property {integer} $created_at
 * @property {integer} $updated_at
 */
class SiteBanner extends ActiveRecord {

	const STATUS_DELETED = 0;
	const STATUS_ENABLED = 1;
	const STATUS_DISABLED = 2;

	public $messageCategory = 'cms';

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%site_banner}}';
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
			[['id', 'name'], 'trim'],
			[['site_id', 'id', 'name'], 'required'],

			['id', 'match', 'pattern' => '/^[a-z][a-z0-9_-]{0,15}$/i'],

			['name', 'string', 'max' => 16],

			['status', 'default', 'value' => self::STATUS_ENABLED],
			['status', 'in', 'range' => [
				self::STATUS_ENABLED,
				self::STATUS_DISABLED,
			]],

			// Query data needed
			[['id'], 'unique'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios() {
		$scenarios = parent::scenarios();

		$common = [
			'id',
			'site_id',
			'name',
			'status',
			'operator_id',
			'creator_id',
		];

		$scenarios['add'] = $common;
		$scenarios['edit'] = $common;

		return $scenarios;
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id' => \Yii::t($this->messageCategory, 'Banner id'),
			'site_id' => \Yii::t($this->messageCategory, 'Site'),
			'name' => \Yii::t($this->messageCategory, 'Name'),
			'status' => \Yii::t($this->messageCategory, 'Status'),
			'operator_id' => \Yii::t($this->messageCategory, 'Operator id'),
			'creator_id' => \Yii::t($this->messageCategory, 'Creator id'),
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
				'attribute' => \Yii::t($this->messageCategory, 'Banner id'),
			]),
			'site_id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Site'),
			]),
			'name' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Name'),
			]),
			'status' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Status'),
			]),
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
			self::STATUS_DELETED => \Yii::t($this->messageCategory, 'Deleted'),
			self::STATUS_ENABLED => \Yii::t($this->messageCategory, 'Enabled'),
			self::STATUS_DISABLED => \Yii::t($this->messageCategory, 'Disabled'),
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
	 * Get items belongs it
	 *
	 * @since 0.0.1
	 * @return {object}
	 */
	public function getItems() {
		return $this->hasMany(SiteBannerItem::classname(), ['banner_id' => 'id']);
	}

	/**
	 * Get it's articles quantity
	 *
	 * @since 0.0.1
	 * @return {integer}
	 */
	public function getItemQuantity($status = null) {
		$query = $this->getItems();
		if($status !== null) {
			$query->where(['status' => $status]);
		}

		return $query->count();
	}

	/**
	 * Get it's articles total page view
	 *
	 * @since 0.0.1
	 * @return {integer}
	 */
	public function getItemTotalPageView($status = null) {
		$query = $this->getItems();
		if($status !== null) {
			$query->where(['status' => $status]);
		}

		return $query->sum('pv') ? : 0;
	}

	/**
	 * Get it's articles total unique visitor
	 *
	 * @since 0.0.1
	 * @return {integer}
	 */
	public function getItemTotalUniqueVisitor($status = null) {
		$query = $this->getItems();
		if($status !== null) {
			$query->where(['status' => $status]);
		}

		return $query->sum('uv') ? : 0;
	}

}
