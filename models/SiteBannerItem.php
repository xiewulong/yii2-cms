<?php
namespace yii\cms\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\components\ActiveRecord;
use yii\web\Cookie;

/**
 * Site model
 *
 * @since 0.0.1
 * @property {integer} $id
 * @property {string} $site_id
 * @property {string} $banner_id
 * @property {string} $title
 * @property {string} $description
 * @property {string} $picture
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
 */
class SiteBannerItem extends ActiveRecord {

	const STATUS_DELETED = 0;
	const STATUS_ENABLED = 1;
	const STATUS_DISABLED = 2;

	public $messageCategory = 'cms';

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%site_banner_item}}';
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
			[['name', 'picture'], 'trim'],
			[['id', 'site_id', 'banner_id', 'title', 'picture'], 'required'],

			['url', 'url'],

			['status', 'default', 'value' => self::STATUS_ENABLED],
			['status', 'in', 'range' => [
				self::STATUS_ENABLED,
				self::STATUS_DISABLED,
			]],

			['pv', 'filter', 'filter' => function($value) {
				if(!\Yii::$app->request->isPost && !\Yii::$app->request->isAjax) {
					$value += 1;
				}

				return $value;
			}],

			// Query data needed
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios() {
		$scenarios = parent::scenarios();

		$common = [
			'site_id',
			'banner_id',
			'title',
			'description',
			'picture',
			'url',
			'status',
			'start_at',
			'end_at',
			'operator_id',
			'creator_id',
		];

		$scenarios['add'] = $common;
		$scenarios['edit'] = $common;

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
			'id' => \Yii::t($this->messageCategory, 'Banner item id'),
			'site_id' => \Yii::t($this->messageCategory, 'Site'),
			'banner_id' => \Yii::t($this->messageCategory, 'Banner'),
			'title' => \Yii::t($this->messageCategory, 'Title'),
			'description' => \Yii::t($this->messageCategory, 'Description'),
			'picture' => \Yii::t($this->messageCategory, 'Picture'),
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
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeHints() {
		return [
			'id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Banner item id'),
			]),
			'site_id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Site'),
			]),
			'banner_id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Banner'),
			]),
			'title' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Title'),
			]),
			'description' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Description'),
			]),
			'picture' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
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
	 * Add pv and uv when visited
	 *
	 * @since 0.0.1
	 * @return {boolean}
	 */
	public function visitedHandler() {
		if(!$this->validate()) {
			return false;
		}

		$uvCookieName = "site-$this->site_id-banner-$this->banner_id-item-$this->id";
		if(!\Yii::$app->request->cookies->has($uvCookieName)) {
			$cookie = new Cookie([
				'name' => $uvCookieName,
				'value' => true,
				'expire' => strtotime(date('Y-m-d', time() + 60 * 60 * 24)),
			]);
			\Yii::$app->response->cookies->add($cookie);
			$this->uv += 1;
		}

		return $this->save(false);
	}

	/**
	 * Get its belongs banner
	 *
	 * @since 0.0.1
	 * @return {object}
	 */
	public function getBanner() {
		return $this->hasOne(SiteBanner::classname(), ['id' => 'banner_id']);
	}

}
