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
 * @property {string} $site
 * @property {integer} $type
 * @property {string} $name
 * @property {string} $logo
 * @property {string} $brief
 * @property {string} $author
 * @property {string} $keywords
 * @property {string} $description
 * @property {string} $phone
 * @property {string} $email
 * @property {string} $address
 * @property {string} $qq
 * @property {string} $weixin
 * @property {string} $weibo
 * @property {string} $copyright
 * @property {string} $powered
 * @property {string} $powered_url
 * @property {string} $record
 * @property {string} $license
 * @property {integer} $status
 * @property {integer} $pv
 * @property {integer} $uv
 * @property {integer} $operator_id
 * @property {integer} $created_at
 * @property {integer} $updated_at
 */
class Site extends ActiveRecord {

	const TYPE_PERSONAL = 1;
	const TYPE_ENTERPRISE = 2;

	const STATUS_DISABLED = 0;
	const STATUS_ENABLED = 1;

	public $messageCategory = 'cms';

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
			[[
				'id',
				'name',
				'logo',
				'author',
				'keywords',
				'description',
				'phone',
				'email',
				'address',
				'qq',
				'weixin',
				'weibo',
				'copyright',
				'powered',
				'powered_url',
				'record',
				'license',
			], 'trim'],

			[[
				'id',
				'name',
				'logo',
			], 'required'],

			[[
				'qq',
				'weibo',
				'powered_url',
			], 'url'],

			['email', 'email'],

			['type', 'default', 'value' => self::TYPE_ENTERPRISE],
			['type', 'in', 'range' => [
				self::TYPE_PERSONAL,
				self::TYPE_ENTERPRISE,
			]],

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

		$scenarios['add'] = [
			'id',
		];

		$scenarios['global'] = [
			'type',
			'name',
			'logo',
			'brief',
			'author',
			'keywords',
			'description',
			'phone',
			'email',
			'address',
			'qq',
			'weixin',
			'weibo',
			'copyright',
			'powered',
			'powered_url',
			'record',
			'license',
			'status',
			'operator_id',
		];

		$scenarios['visited'] = [
			'id',
			'pv',
			'uv',
		];

		return $scenarios;
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id' => \Yii::t($this->messageCategory, 'Site id'),
			'type' => \Yii::t($this->messageCategory, 'Type'),
			'name' => \Yii::t($this->messageCategory, 'Name'),
			'logo' => \Yii::t($this->messageCategory, 'Logo'),
			'brief' => \Yii::t($this->messageCategory, 'Brief'),
			'author' => \Yii::t($this->messageCategory, 'Author') . '(SEO)',
			'keywords' => \Yii::t($this->messageCategory, 'Keyword') . '(SEO)',
			'description' => \Yii::t($this->messageCategory, 'Description') . '(SEO)',
			'phone' => \Yii::t($this->messageCategory, 'Phone'),
			'email' => \Yii::t($this->messageCategory, 'Email'),
			'address' => \Yii::t($this->messageCategory, 'Address'),
			'qq' => \Yii::t($this->messageCategory, 'QQ'),
			'weixin' => \Yii::t($this->messageCategory, 'Weixin'),
			'weibo' => \Yii::t($this->messageCategory, 'Weibo'),
			'copyright' => \Yii::t($this->messageCategory, 'Copyright'),
			'powered' => \Yii::t($this->messageCategory, 'Powered by'),
			'powered_url' => \Yii::t($this->messageCategory, 'Powered by url'),
			'record' => \Yii::t($this->messageCategory, 'Record number'),
			'license' => \Yii::t($this->messageCategory, 'License number'),
			'status' => \Yii::t($this->messageCategory, 'Status'),
			'pv' => \Yii::t($this->messageCategory, 'Page view'),
			'uv' => \Yii::t($this->messageCategory, 'Unique Visitor'),
			'operator_id' => \Yii::t($this->messageCategory, 'Operator id'),
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
				'attribute' => \Yii::t($this->messageCategory, 'Site id'),
			]),
			'type' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Type'),
			]),
			'name' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Name'),
			]),
			'logo' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'upload'),
				'attribute' => \Yii::t($this->messageCategory, 'Logo'),
			]),
			'brief' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Brief'),
			]),
			'author' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Author'),
			]),
			'keywords' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Keyword'),
			]),
			'description' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Description'),
			]),
			'phone' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Phone'),
			]),
			'email' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Email'),
			]),
			'address' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Address'),
			]),
			'qq' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'QQ'),
			]),
			'weixin' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Weixin'),
			]),
			'weibo' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Weibo'),
			]),
			'copyright' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Copyright'),
			]),
			'powered' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Powered by'),
			]),
			'powered_url' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Powered by url'),
			]),
			'record' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Record number'),
			]),
			'license' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'License number'),
			]),
			'status' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Status'),
			]),
		];
	}

	/**
	 * Return type items in every scenario
	 *
	 * @since 0.0.1
	 * @return {array}
	 */
	public function typeItems() {
		return [
			[
				self::TYPE_PERSONAL => \Yii::t($this->messageCategory, 'Personal'),
				self::TYPE_ENTERPRISE => \Yii::t($this->messageCategory, 'Enterprise'),
			],
			[
				self::TYPE_PERSONAL => [
					'address',
					'copyright',
					'powered',
					'powered_url',
					'license',
				],
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
				self::STATUS_DISABLED => \Yii::t($this->messageCategory, 'Disabled'),
				self::STATUS_ENABLED => \Yii::t($this->messageCategory, 'Enabled'),
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

}
