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

	const STATUS_DISABLED = 0;

	const STATUS_ENABLED = 10;

	public $messageCategory = 'cms';

	protected $_statuses = [
		self::STATUS_DISABLED => 'Disabled',
		self::STATUS_ENABLED => 'Enabled',
	];

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
			[['id', 'site_id', 'name'], 'required'],
			[['parent_id', 'list_order'], 'default', 'value' => 0],

			['name', 'string', 'min' => 6, 'max' => 16],

			['status', 'default', 'value' => self::STATUS_ENABLED],
			['status', 'in', 'range' => [self::STATUS_DISABLED, self::STATUS_ENABLED]],

			['list_order', 'number'],

			// Query data needed
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios() {
		$scenarios = parent::scenarios();
		$scenarios['add'] = ['site_id', 'parent_id', 'name', 'status'];
		$scenarios['edit'] = ['id', 'site_id', 'parent_id', 'name', 'status'];

		return $scenarios;
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id' => \Yii::t($this->messageCategory, 'Id'),
			'site_id' => \Yii::t($this->messageCategory, 'Site id'),
			'parent_id' => \Yii::t($this->messageCategory, 'Parent id'),
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
	 * Running a common handler
	 *
	 * @since 0.0.1
	 * @return {boolean}
	 */
	public function runCommon() {
		return $this->validate() && $this->save();
	}

}
