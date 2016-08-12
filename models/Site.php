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
 * @property {string} $name
 * @property {string} $logo
 * @property {string} $author
 * @property {string} $keywords
 * @property {string} $description
 * @property {integer} $status
 * @property {integer} $created_at
 * @property {integer} $updated_at
 */
class Site extends ActiveRecord {

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
		return '{{%site}}';
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
			[['id', 'name', 'logo'], 'required'],

			// ['logo', 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],

			[['author', 'keywords', 'description'], 'safe'],

			['status', 'default', 'value' => self::STATUS_ENABLED],
			['status', 'in', 'range' => [self::STATUS_DISABLED, self::STATUS_ENABLED]],

			// Query data needed
			['id', 'unique'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios() {
		$scenarios = parent::scenarios();
		$scenarios['add'] = ['id', 'name'];
		$scenarios['edit'] = ['name', 'logo', 'author', 'keywords', 'description', 'status'];

		return $scenarios;
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id' => \Yii::t($this->messageCategory, 'Id'),
			'name' => \Yii::t($this->messageCategory, 'Name'),
			'logo' => \Yii::t($this->messageCategory, 'Logo'),
			'author' => \Yii::t($this->messageCategory, 'Author'),
			'keywords' => \Yii::t($this->messageCategory, 'Keywords'),
			'description' => \Yii::t($this->messageCategory, 'Description'),
			'status' => \Yii::t($this->messageCategory, 'Status'),
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
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Id'),
			]),
			'name' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Name'),
			]),
			'logo' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'upload'),
				'attribute' => \Yii::t($this->messageCategory, 'Logo'),
			]),
			'author' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Author'),
			]),
			'keywords' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Keywords'),
			]),
			'description' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Description'),
			]),
			'status' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Status'),
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
		// return $this->validate() && $this->saveUploadedFiles() && $this->save();
		return $this->validate() && $this->save();
	}

}
