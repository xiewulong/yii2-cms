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
 * @property {string} $site_id
 * @property {integer} $category_id
 * @property {string} $title
 * @property {string} $thumbnail
 * @property {string} $author
 * @property {string} $keywords
 * @property {string} $description
 * @property {string} $content
 * @property {string} $pictures
 * @property {integer} $status
 * @property {integer} $list_order
 * @property {integer} $pv
 * @property {integer} $uv
 * @property {integer} $operator_id
 * @property {integer} $creator_id
 * @property {integer} $created_at
 * @property {integer} $updated_at
 */
class SiteArticle extends ActiveRecord {

	const STATUS_DELETED = 0;
	const STATUS_DRAFTED = 1;
	const STATUS_RELEASED = 2;
	const STATUS_FEATURED = 3;

	public $messageCategory = 'cms';

	protected $statisticsEnable = true;

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
			[['title', 'thumbnail', 'author', 'keywords', 'description', 'content'], 'trim'],
			[['id', 'site_id', 'category_id', 'title'], 'required'],

			[['thumbnail', 'pictures'], 'required', 'when' => function($self) {
				return $self->category->type == SiteCategory::TYPE_PICTURES;
			}],

			['description', 'required', 'when' => function($self) {
				return $self->category->type == SiteCategory::TYPE_NOTICE;
			}],

			['content', 'required', 'when' => function($self) {
				return $self->category->type == SiteCategory::TYPE_NEWS
					|| $self->category->type == SiteCategory::TYPE_PAGE;
			}],

			['pictures', 'filter', 'filter' => function($value) {
				if(is_array($value)) {
					$value = Json::encode($value);
				}

				return $value;
			}],

			['list_order', 'default', 'value' => 0],

			['status', 'default', 'value' => self::STATUS_DRAFTED],
			['status', 'in', 'range' => [
				self::STATUS_RELEASED,
				self::STATUS_FEATURED,
				self::STATUS_DRAFTED,
			]],

			// Query data needed
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios() {
		$scenarios = parent::scenarios();

		$scenarios['add'] = [
			'site_id',
			'category_id',
			'title',
			'thumbnail',
			'author',
			'keywords',
			'description',
			'content',
			'pictures',
			'status',
			'creator_id',
		];

		$scenarios['edit'] = [
			'title',
			'thumbnail',
			'author',
			'keywords',
			'description',
			'content',
			'pictures',
			'status',
			'operator_id',
		];

		$scenarios['sort'] = [
			'list_order',
		];

		return $scenarios;
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id' => \Yii::t($this->messageCategory, 'Article id'),
			'site_id' => \Yii::t($this->messageCategory, 'Site'),
			'category_id' => \Yii::t($this->messageCategory, 'Category'),
			'title' => \Yii::t($this->messageCategory, 'Title'),
			'thumbnail' => \Yii::t($this->messageCategory, 'Thumbnail'),
			'author' => \Yii::t($this->messageCategory, 'Author'),
			'keywords' => \Yii::t($this->messageCategory, 'Keyword'),
			'description' => \Yii::t($this->messageCategory, 'Description'),
			'content' => \Yii::t($this->messageCategory, 'Content'),
			'pictures' => \Yii::t($this->messageCategory, 'Picture'),
			'status' => \Yii::t($this->messageCategory, 'Status'),
			'pv' => \Yii::t($this->messageCategory, 'Page view'),
			'uv' => \Yii::t($this->messageCategory, 'Unique Visitor'),
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
				'attribute' => \Yii::t($this->messageCategory, 'Article id'),
			]),
			'site_id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Site'),
			]),
			'category_id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Category'),
			]),
			'title' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Title'),
			]),
			'thumbnail' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'upload'),
				'attribute' => \Yii::t($this->messageCategory, 'Thumbnail'),
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
			'content' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Content'),
			]),
			'pictures' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'upload'),
				'attribute' => \Yii::t($this->messageCategory, 'Picture'),
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
	 * Return type items
	 *
	 * @since 0.0.1
	 * @return {array}
	 */
	public function categoryTypeItems() {
		return [
			[],
			[
				SiteCategory::TYPE_NEWS => [
					'pictures',
				],
				SiteCategory::TYPE_PICTURES => [
					'content',
				],
				SiteCategory::TYPE_PAGE => [
					'author',
					'keywords',
					'pictures',
				],
				SiteCategory::TYPE_NOTICE => [
					'author',
					'keywords',
					'content',
					'pictures',
				],
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
				self::STATUS_DRAFTED => \Yii::t($this->messageCategory, 'Drafted'),
				self::STATUS_RELEASED => \Yii::t($this->messageCategory, 'Released'),
				self::STATUS_FEATURED => \Yii::t($this->messageCategory, 'Featured'),
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
	 * Get its belongs category
	 *
	 * @since 0.0.1
	 * @return {object}
	 */
	public function getCategory() {
		return $this->hasOne(SiteCategory::classname(), ['id' => 'category_id']);
	}

	/**
	 * Superior alias
	 *
	 * @since 0.0.1
	 * @return {object}
	 */
	public function getSuperior() {
		return $this->getCategory();
	}

	/**
	 * Get picture list
	 *
	 * @since 0.0.1
	 * @return {object}
	 */
	public function getPictureList() {
		return $this->pictures ? Json::decode($this->pictures) : [];
	}

}
