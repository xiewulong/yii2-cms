<?php
namespace yii\cms\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\components\ActiveRecord;

/**
 * Module model
 *
 * @since 0.0.1
 * @property {integer} $id
 * @property {string} $site_id
 * @property {integer} $type
 * @property {string} $position
 * @property {string} $name
 * @property {string} $alias
 * @property {integer} $status
 * @property {integer} $creator_id
 * @property {integer} $created_at
 * @property {integer} $operator_id
 * @property {integer} $updated_at
 */
class SiteModule extends ActiveRecord {

	const TYPE_MENU = 1;
	const TYPE_BANNER = 2;

	const STATUS_DELETED = 0;
	const STATUS_ENABLED = 1;
	const STATUS_DISABLED = 2;

	public $messageCategory = 'cms';

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%site_module}}';
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
			[['name', 'alias', 'position'], 'trim'],
			[['site_id', 'name', 'position'], 'required'],

			['name', 'string', 'max' => 16],

			['position', 'match', 'pattern' => '/^[a-z][a-z0-9_-]{0,15}$/i'],

			['type', 'default', 'value' => static::TYPE_MENU],
			['type', 'in', 'range' => [
				static::TYPE_MENU,
				static::TYPE_BANNER,
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
			[['position'], 'unique', 'targetAttribute' => ['site_id', 'type', 'position']],
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
			'position',
			'name',
			'alias',
			'status',
			'creator_id',
			'operator_id',
		];

		$scenarios['edit'] = [
			'position',
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
			'id' => \Yii::t($this->messageCategory, 'Id'),
			'site_id' => \Yii::t($this->messageCategory, 'Site'),
			'type' => \Yii::t($this->messageCategory, 'Type'),
			'position' => \Yii::t($this->messageCategory, 'Position'),
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
				'attribute' => \Yii::t($this->messageCategory, 'Module id'),
			]),
			'site_id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Site'),
			]),
			'type' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Type'),
			]),
			'position' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Position'),
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
				static::TYPE_MENU => \Yii::t($this->messageCategory, 'Menu'),
				static::TYPE_BANNER => \Yii::t($this->messageCategory, 'Banner'),
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
		return !$this->getItems()->count() || SiteModuleItem::deleteAll([
			'module_id' => $this->id,
		]);
	}

	/**
	 * Get items belongs it
	 *
	 * @since 0.0.1
	 * @return {array}
	 */
	public function getItems() {
		return $this->hasMany(SiteModuleItem::classname(), ['module_id' => 'id']);
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
