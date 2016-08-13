<?php
namespace yii\cms\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\components\ActiveRecord;
use yii\helpers\Json;

/**
 * Site model
 *
 * @since 0.0.1
 * @property {integer} $id
 * @property {integer} $site_id
 * @property {integer} $category_id
 * @property {integer} $type
 * @property {string} $title
 * @property {string} $keywords
 * @property {string} $abstract
 * @property {string} $content
 * @property {string} $picture
 * @property {string} $thumbnail
 * @property {string} $author
 * @property {integer} $pv
 * @property {integer} $uv
 * @property {integer} $status
 * @property {integer} $list_order
 * @property {integer} $created_at
 * @property {integer} $updated_at
 */
class SiteArticle extends ActiveRecord {

	const TYPE_NEWS = 1;
	const TYPE_GALLERY = 2;

	const STATUS_DELETED = 0;
	const STATUS_DRAFTED = 1;
	const STATUS_RELEASED = 2;
	const STATUS_FEATURED = 3;

	public $messageCategory = 'cms';

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%site_article}}';
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
			[['id', 'site_id', 'category_id', 'type', 'title'], 'required'],

			['title', 'trim'],

			['type', 'default', 'value' => self::TYPE_NEWS],
			['type', 'in', 'range' => [
				self::TYPE_NEWS,
				self::TYPE_GALLERY,
			]],

			['content', 'required', 'when' => function($self) {
				return $self->type == $self::TYPE_NEWS;
			}],

			['picture', 'required', 'when' => function($self) {
				return $self->type == $self::TYPE_GALLERY;
			}],
			['picture', 'filter', 'filter' => function($value) {
				if(is_array($value)) {
					$value = Json::encode($value);
				}
				return $value;
			}],

			['status', 'default', 'value' => self::STATUS_DRAFTED],
			['status', 'in', 'range' => [
				self::STATUS_RELEASED,
				self::STATUS_FEATURED,
				self::STATUS_DRAFTED,
			]],

			['list_order', 'default', 'value' => 0],

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
			'category_id',
			'type',
			'title',
			'keywords',
			'abstract',
			'content',
			'picture',
			'thumbnail',
			'status',
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
			'id' => \Yii::t($this->messageCategory, 'Id'),
			'site_id' => \Yii::t($this->messageCategory, 'Site'),
			'category_id' => \Yii::t($this->messageCategory, 'Category'),
			'type' => \Yii::t($this->messageCategory, 'Type'),
			'title' => \Yii::t($this->messageCategory, 'Title'),
			'keywords' => \Yii::t($this->messageCategory, 'Keywords'),
			'abstract' => \Yii::t($this->messageCategory, 'Abstract'),
			'content' => \Yii::t($this->messageCategory, 'Content'),
			'picture' => \Yii::t($this->messageCategory, 'Picture'),
			'thumbnail' => \Yii::t($this->messageCategory, 'Thumbnail'),
			'author' => \Yii::t($this->messageCategory, 'Author'),
			'pv' => \Yii::t($this->messageCategory, 'Page view'),
			'uv' => \Yii::t($this->messageCategory, 'Unique Visitor'),
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
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Id'),
			]),
			'site_id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Site id'),
			]),
			'category_id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Category id'),
			]),
			'type' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Type'),
			]),
			'title' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Title'),
			]),
			'keywords' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Keywords'),
			]),
			'abstract' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Abstract'),
			]),
			'content' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Content'),
			]),
			'picture' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'upload'),
				'attribute' => \Yii::t($this->messageCategory, 'Picture'),
			]),
			'thumbnail' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'upload'),
				'attribute' => \Yii::t($this->messageCategory, 'Thumbnail'),
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
			self::TYPE_NEWS => \Yii::t($this->messageCategory, 'News'),
			self::TYPE_GALLERY => \Yii::t($this->messageCategory, 'Gallery'),
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
			self::STATUS_DRAFTED => \Yii::t($this->messageCategory, 'Drafted'),
			self::STATUS_RELEASED => \Yii::t($this->messageCategory, 'Released'),
			self::STATUS_FEATURED => \Yii::t($this->messageCategory, 'Featured'),
		];
	}

	/**
	 * Get its belongs category
	 *
	 * @since 0.0.1
	 * @return {object}
	 */
	public function getCategory() {
		return $this->hasOne(SiteCategory::classname(), ['id' => 'category_id']);
	}

	/**
	 * Get picture list
	 *
	 * @since 0.0.1
	 * @return {object}
	 */
	public function getPictureList() {
		return $this->picture ? Json::decode($this->picture) : [];
	}

}
