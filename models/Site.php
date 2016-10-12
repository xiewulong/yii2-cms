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
 * @property {integer} $type
 * @property {string} $name
 * @property {string} $alias
 * @property {string} $logo_id
 * @property {string} $sub_logo_id
 * @property {string} $brief
 * @property {string} $author
 * @property {string} $keywords
 * @property {string} $description
 * @property {string} $phone
 * @property {string} $tax
 * @property {string} $email
 * @property {string} $address
 * @property {string} $qq
 * @property {string} $weixin_id
 * @property {string} $weibo
 * @property {string} $copyright
 * @property {string} $powered
 * @property {string} $powered_url
 * @property {string} $record
 * @property {string} $license
 * @property {integer} $status
 * @property {integer} $pv
 * @property {integer} $uv
 * @property {integer} $created_at
 * @property {integer} $operator_id
 * @property {integer} $updated_at
 */
class Site extends ActiveRecord {

	const TYPE_PERSONAL = 1;
	const TYPE_ENTERPRISE = 2;

	const STATUS_DISABLED = 0;
	const STATUS_ENABLED = 1;

	public $messageCategory = 'cms';

	protected $statisticsEnable = true;

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
				'alias',
				'logo_id',
				'sub_logo_id',
				'brief',
				'author',
				'keywords',
				'description',
				'phone',
				'tax',
				'email',
				'address',
				'qq',
				'weixin_id',
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
				'logo_id',
			], 'required'],

			[[
				'qq',
				'weibo',
				'powered_url',
			], 'url'],

			['email', 'email'],

			['type', 'default', 'value' => static::TYPE_ENTERPRISE],
			['type', 'in', 'range' => [
				static::TYPE_PERSONAL,
				static::TYPE_ENTERPRISE,
			]],

			['status', 'default', 'value' => static::STATUS_ENABLED],
			['status', 'in', 'range' => [
				static::STATUS_ENABLED,
				static::STATUS_DISABLED,
			]],

			[['operator_id'], 'filter', 'filter' => function($value) {
				return \Yii::$app->user->isGuest ? 0 : \Yii::$app->user->identity->id;
			}],

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
			'powered',
		];

		$scenarios['global'] = [
			'type',
			'name',
			'alias',
			'logo_id',
			'sub_logo_id',
			'brief',
			'author',
			'keywords',
			'description',
			'phone',
			'tax',
			'email',
			'address',
			'qq',
			'weixin_id',
			'weibo',
			'copyright',
			'powered',
			'powered_url',
			'record',
			'license',
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
			'id' => \Yii::t($this->messageCategory, 'site id'),
			'type' => \Yii::t($this->messageCategory, 'type'),
			'name' => \Yii::t($this->messageCategory, 'name'),
			'alias' => \Yii::t($this->messageCategory, 'alias'),
			'logo_id' => \Yii::t($this->messageCategory, 'logo'),
			'sub_logo_id' => \Yii::t($this->messageCategory, 'sub logo'),
			'brief' => \Yii::t($this->messageCategory, 'brief'),
			'author' => \Yii::t($this->messageCategory, 'author') . '(SEO)',
			'keywords' => \Yii::t($this->messageCategory, 'keyword') . '(SEO)',
			'description' => \Yii::t($this->messageCategory, 'description') . '(SEO)',
			'phone' => \Yii::t($this->messageCategory, 'phone'),
			'tax' => \Yii::t($this->messageCategory, 'tax'),
			'email' => \Yii::t($this->messageCategory, 'email'),
			'address' => \Yii::t($this->messageCategory, 'address'),
			'qq' => \Yii::t($this->messageCategory, 'QQ'),
			'weixin_id' => \Yii::t($this->messageCategory, 'weixin'),
			'weibo' => \Yii::t($this->messageCategory, 'weibo'),
			'copyright' => \Yii::t($this->messageCategory, 'copyright'),
			'powered' => \Yii::t($this->messageCategory, 'powered by'),
			'powered_url' => \Yii::t($this->messageCategory, 'powered by url'),
			'record' => \Yii::t($this->messageCategory, 'record number'),
			'license' => \Yii::t($this->messageCategory, 'license number'),
			'status' => \Yii::t($this->messageCategory, 'status'),
			'pv' => \Yii::t($this->messageCategory, 'page view'),
			'uv' => \Yii::t($this->messageCategory, 'unique Visitor'),
			'created_at' => \Yii::t($this->messageCategory, 'created time'),
			'operator_id' => \Yii::t($this->messageCategory, 'operator id'),
			'updated_at' => \Yii::t($this->messageCategory, 'updated time'),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeHints() {
		return [
			'id' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'site id'),
			]),
			'type' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'type'),
			]),
			'name' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'name'),
			]),
			'alias' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'alias'),
			]),
			'logo_id' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'upload'),
				'attribute' => \Yii::t($this->messageCategory, 'logo'),
			]),
			'sub_logo_id' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'upload'),
				'attribute' => \Yii::t($this->messageCategory, 'sub logo'),
			]),
			'brief' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'brief'),
			]),
			'author' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'author'),
			]),
			'keywords' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'keyword'),
			]),
			'description' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'description'),
			]),
			'phone' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'phone'),
			]),
			'tax' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'tax'),
			]),
			'email' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'email'),
			]),
			'address' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'address'),
			]),
			'qq' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'QQ'),
			]),
			'weixin_id' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'weixin'),
			]),
			'weibo' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'weibo'),
			]),
			'copyright' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'copyright'),
			]),
			'powered' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'powered by'),
			]),
			'powered_url' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'powered by url'),
			]),
			'record' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'record number'),
			]),
			'license' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'license number'),
			]),
			'status' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'status'),
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
				static::TYPE_PERSONAL => \Yii::t($this->messageCategory, 'personal'),
				static::TYPE_ENTERPRISE => \Yii::t($this->messageCategory, 'enterprise'),
			],
			[
				static::TYPE_PERSONAL => [
					'tax',
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
				static::STATUS_DISABLED => \Yii::t($this->messageCategory, 'disabled'),
				static::STATUS_ENABLED => \Yii::t($this->messageCategory, 'enabled'),
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
