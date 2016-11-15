<?php
namespace yii\cms\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\components\ActiveRecord;
use yii\helpers\Json;

use yii\attachment\models\Attachment;

/**
 * Article model
 *
 * @since 0.0.1
 * @property {integer} $id
 * @property {string} $site_id
 * @property {integer} $category_id
 * @property {string} $title
 * @property {string} $alias
 * @property {string} $thumbnail_id
 * @property {string} $author
 * @property {string} $keywords
 * @property {string} $description
 * @property {string} $content
 * @property {string} $picture_ids
 * @property {string} $attachment_id
 * @property {integer} $status
 * @property {integer} $pv
 * @property {integer} $uv
 * @property {integer} $creator_id
 * @property {integer} $created_at
 * @property {integer} $operator_id
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
			[[
				'title',
				'alias',
				'thumbnail_id',
				'author',
				'keywords',
				'description',
				'content',
				'attachment_id',
			], 'trim'],

			[['id', 'site_id', 'category_id', 'title'], 'required'],

			[['thumbnail_id', 'pictures'], 'required', 'when' => function($self) {
				return $self->category->type == SiteCategory::TYPE_PICTURES;
			}],

			['description', 'required', 'when' => function($self) {
				return $self->category->type == SiteCategory::TYPE_NOTICE;
			}],

			['content', 'required', 'when' => function($self) {
				return $self->category->type == SiteCategory::TYPE_NEWS
					|| $self->category->type == SiteCategory::TYPE_PAGE;
			}],

			['picture_ids', 'filter', 'filter' => function($value) {
				if(is_array($value)) {
					$value = Json::encode($value);
				}

				return $value;
			}],

			['attachment_id', 'required', 'when' => function($self) {
				return $self->category->type == SiteCategory::TYPE_DOWNLOAD;
			}],

			['status', 'default', 'value' => static::STATUS_DRAFTED],
			['status', 'in', 'range' => [
				static::STATUS_RELEASED,
				static::STATUS_FEATURED,
				static::STATUS_DRAFTED,
			]],

			[['creator_id', 'operator_id'], 'filter', 'filter' => function($value) {
				return \Yii::$app->user->isGuest ? 0 : \Yii::$app->user->identity->id;
			}],

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
			'alias',
			'thumbnail_id',
			'author',
			'keywords',
			'description',
			'content',
			'picture_ids',
			'attachment_id',
			'status',
			'creator_id',
			'operator_id',
		];

		$scenarios['edit'] = [
			'category_id',
			'title',
			'alias',
			'thumbnail_id',
			'author',
			'keywords',
			'description',
			'content',
			'picture_ids',
			'attachment_id',
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
			'id' => \Yii::t($this->messageCategory, 'article id'),
			'site_id' => \Yii::t($this->messageCategory, 'site'),
			'category_id' => \Yii::t($this->messageCategory, 'category'),
			'title' => \Yii::t($this->messageCategory, 'title'),
			'alias' => \Yii::t($this->messageCategory, 'alias'),
			'thumbnail_id' => \Yii::t($this->messageCategory, 'thumbnail'),
			'author' => \Yii::t($this->messageCategory, 'author'),
			'keywords' => \Yii::t($this->messageCategory, 'keyword'),
			'description' => \Yii::t($this->messageCategory, 'description'),
			'content' => \Yii::t($this->messageCategory, 'content'),
			'picture_ids' => \Yii::t($this->messageCategory, 'picture'),
			'attachment_id' => \Yii::t($this->messageCategory, 'attachment'),
			'status' => \Yii::t($this->messageCategory, 'status'),
			'pv' => \Yii::t($this->messageCategory, 'page view'),
			'uv' => \Yii::t($this->messageCategory, 'unique Visitor'),
			'creator_id' => \Yii::t($this->messageCategory, 'creator id'),
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
			'id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'article id'),
			]),
			'site_id' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'site'),
			]),
			'category_id' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'category'),
			]),
			'title' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'title'),
			]),
			'alias' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'alias'),
			]),
			'thumbnail_id' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'upload'),
				'attribute' => \Yii::t($this->messageCategory, 'thumbnail'),
			]),
			'author' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'Enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Author'),
			]),
			'keywords' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'keyword'),
			]),
			'description' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'description'),
			]),
			'content' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'enter'),
				'attribute' => \Yii::t($this->messageCategory, 'content'),
			]),
			'picture_ids' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'upload'),
				'attribute' => \Yii::t($this->messageCategory, 'picture'),
			]),
			'attachment_id' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'upload'),
				'attribute' => \Yii::t($this->messageCategory, 'attachment'),
			]),
			'status' => \Yii::t($this->messageCategory, 'please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'choose'),
				'attribute' => \Yii::t($this->messageCategory, 'status'),
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
					'picture_ids',
					'attachment_id',
				],
				SiteCategory::TYPE_PICTURES => [
					'content',
					'attachment_id',
				],
				SiteCategory::TYPE_PAGE => [
					'author',
					'keywords',
					'picture_ids',
					'attachment_id',
				],
				SiteCategory::TYPE_NOTICE => [
					'author',
					'keywords',
					'content',
					'picture_ids',
					'attachment_id',
				],
				SiteCategory::TYPE_DOWNLOAD => [
					'content',
					'picture_ids',
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
				static::STATUS_DELETED => \Yii::t($this->messageCategory, 'deleted'),
				static::STATUS_DRAFTED => \Yii::t($this->messageCategory, 'drafted'),
				static::STATUS_RELEASED => \Yii::t($this->messageCategory, 'released'),
				static::STATUS_FEATURED => \Yii::t($this->messageCategory, 'featured'),
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
	 * Get attachment object
	 *
	 * @since 0.0.1
	 * @return {object}
	 */
	public function getAttachment() {
		return $this->hasOne(Attachment::classname(), ['client_id' => 'attachment_id']);
	}

	/**
	 * Get picture id list
	 *
	 * @since 0.0.1
	 * @return {array}
	 */
	private $_picture_id_list;
	public function getPictureIdList() {
		if($this->_picture_id_list === null) {
			$this->_picture_id_list = $this->picture_ids ? Json::decode($this->picture_ids) : [];
		}

		return $this->_picture_id_list;
	}

}
