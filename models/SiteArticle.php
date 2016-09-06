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
			'id' => \Yii::t($this->messageCategory, 'Article id'),
			'site_id' => \Yii::t($this->messageCategory, 'Site'),
			'category_id' => \Yii::t($this->messageCategory, 'Category'),
			'title' => \Yii::t($this->messageCategory, 'Title'),
			'alias' => \Yii::t($this->messageCategory, 'Alias'),
			'thumbnail_id' => \Yii::t($this->messageCategory, 'Thumbnail'),
			'author' => \Yii::t($this->messageCategory, 'Author'),
			'keywords' => \Yii::t($this->messageCategory, 'Keyword'),
			'description' => \Yii::t($this->messageCategory, 'Description'),
			'content' => \Yii::t($this->messageCategory, 'Content'),
			'picture_ids' => \Yii::t($this->messageCategory, 'Picture'),
			'attachment_id' => \Yii::t($this->messageCategory, 'Attachment'),
			'status' => \Yii::t($this->messageCategory, 'Status'),
			'pv' => \Yii::t($this->messageCategory, 'Page view'),
			'uv' => \Yii::t($this->messageCategory, 'Unique Visitor'),
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
				'action' => \Yii::t($this->messageCategory, 'Choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Article id'),
			]),
			'site_id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'Choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Site'),
			]),
			'category_id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'Choose'),
				'attribute' => \Yii::t($this->messageCategory, 'Category'),
			]),
			'title' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'Enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Title'),
			]),
			'alias' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'Enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Alias'),
			]),
			'thumbnail_id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'Upload'),
				'attribute' => \Yii::t($this->messageCategory, 'Thumbnail'),
			]),
			'author' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'Enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Author'),
			]),
			'keywords' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'Enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Keyword'),
			]),
			'description' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'Enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Description'),
			]),
			'content' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'Enter'),
				'attribute' => \Yii::t($this->messageCategory, 'Content'),
			]),
			'picture_ids' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'Upload'),
				'attribute' => \Yii::t($this->messageCategory, 'Picture'),
			]),
			'attachment_id' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'Upload'),
				'attribute' => \Yii::t($this->messageCategory, 'Attachment'),
			]),
			'status' => \Yii::t($this->messageCategory, 'Please {action} {attribute}', [
				'action' => \Yii::t($this->messageCategory, 'Choose'),
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
				static::STATUS_DELETED => \Yii::t($this->messageCategory, 'Deleted'),
				static::STATUS_DRAFTED => \Yii::t($this->messageCategory, 'Drafted'),
				static::STATUS_RELEASED => \Yii::t($this->messageCategory, 'Released'),
				static::STATUS_FEATURED => \Yii::t($this->messageCategory, 'Featured'),
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
	public function getPictureIdList() {
		if($this->picture_ids && $this->_picture_id_list === null) {
			$this->_picture_id_list = Json::decode($this->picture_ids);
		}

		return $this->_picture_id_list;
	}
	private $_picture_id_list;

}
