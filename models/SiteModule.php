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
 * @property {string} $site_id
 * @property {integer} $type
 * @property {string} $position
 * @property {string} $name
 * @property {integer} $status
 * @property {integer} $operator_id
 * @property {integer} $creator_id
 * @property {integer} $created_at
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
			[['name', 'position'], 'trim'],
			[['site_id', 'name', 'position'], 'required'],

			['name', 'string', 'max' => 16],

			['position', 'match', 'pattern' => '/^[a-z][a-z0-9_-]{0,15}$/i'],

			['type', 'default', 'value' => self::TYPE_MENU],
			['type', 'in', 'range' => [
				self::TYPE_MENU,
				self::TYPE_BANNER,
			]],

			['status', 'default', 'value' => self::STATUS_ENABLED],
			['status', 'in', 'range' => [
				self::STATUS_ENABLED,
				self::STATUS_DISABLED,
			]],

			// Query data needed
			[['position'], 'unique', 'targetAttribute' => ['position', 'type']],
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
			'status',
			'creator_id',
		];

		$scenarios['edit'] = [
			'position',
			'name',
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
				self::TYPE_MENU => \Yii::t($this->messageCategory, 'Menu'),
				self::TYPE_BANNER => \Yii::t($this->messageCategory, 'Banner'),
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

		$this->operator_id = \Yii::$app->user->isGuest ? 0 : \Yii::$app->user->identity->id;
		if($this->scenario == 'add') {
			$this->creator_id = $this->operator_id;
		}

		return $this->save(false);
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
	 * Get it's articles quantity
	 *
	 * @since 0.0.1
	 * @return {integer}
	 */
	public function getItemQuantity() {
		return $this->getItems()->count();
	}

	/**
	 * Get it's articles total page view
	 *
	 * @since 0.0.1
	 * @return {integer}
	 */
	public function getItemTotalPageView() {
		return $this->getItems()->sum('pv') ? : 0;
	}

	/**
	 * Get it's articles total unique visitor
	 *
	 * @since 0.0.1
	 * @return {integer}
	 */
	public function getItemTotalUniqueVisitor() {
		return $this->getItems()->sum('uv') ? : 0;
	}

}
