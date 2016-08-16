<?php
use yii\components\Migration;

class m160807_123425_cms_init extends Migration {

	public $messageCategory ='cms';

	public function init() {
		$this->messagesPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'messages';

		parent::init();
	}

	public function safeUp() {
		$tableOptions = null;
		if($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable('{{%site}}', [
			'id' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'Id')),
			'type' => $this->smallInteger()->notNull()->defaultValue(1)->comment(\Yii::t($this->messageCategory, 'Type')),
			'name' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'Name')),
			'logo' => $this->text()->comment(\Yii::t($this->messageCategory, 'Logo')),
			'brief' => $this->string()->comment(\Yii::t($this->messageCategory, 'Brief')),
			'author' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'Author')),
			'keywords' => $this->string()->comment(\Yii::t($this->messageCategory, 'Keyword')),
			'description' => $this->string()->comment(\Yii::t($this->messageCategory, 'Description')),
			'phone' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'Phone')),
			'email' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'Email')),
			'address' => $this->string()->comment(\Yii::t($this->messageCategory, 'Address')),
			'qq' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'QQ')),
			'weixin' => $this->text()->comment(\Yii::t($this->messageCategory, 'Weixin')),
			'weibo' => $this->string()->comment(\Yii::t($this->messageCategory, 'Weibo')),
			'copyright' => $this->string()->comment(\Yii::t($this->messageCategory, 'Copyright')),
			'powered' => $this->string()->comment(\Yii::t($this->messageCategory, 'Powered by')),
			'powered_url' => $this->text()->comment(\Yii::t($this->messageCategory, 'Powered by url')),
			'record' => $this->string()->comment(\Yii::t($this->messageCategory, 'Record number')),
			'license' => $this->string()->comment(\Yii::t($this->messageCategory, 'License number')),
			'status' => $this->smallInteger()->notNull()->defaultValue(1)->comment(\Yii::t($this->messageCategory, 'Status')),
			'about' => $this->text()->comment(\Yii::t($this->messageCategory, 'About')),
			'about_status' => $this->smallInteger()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'About page Status')),
			'contact' => $this->text()->comment(\Yii::t($this->messageCategory, 'Contact')),
			'contact_status' => $this->smallInteger()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Contact page Status')),
			'pv' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Page view')),
			'uv' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Unique Visitor')),
			'operator_id' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Operator id')),
			'created_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Created time')),
			'updated_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Updated time')),
		], $tableOptions);
		$this->addPrimaryKey('id', '{{%site}}', 'id');
		$this->createIndex('status', '{{%site}}', 'status');
		$this->addCommentOnTable('{{%site}}', \Yii::t($this->messageCategory, 'Site'));

		$this->createTable('{{%site_category}}', [
			'id' => $this->primaryKey()->comment(\Yii::t($this->messageCategory, 'Id')),
			'site_id' => $this->string(68)->notNull()->comment(\Yii::t($this->messageCategory, 'Site id')),
			'parent_id' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Parent id')),
			'name' => $this->string(68)->notNull()->comment(\Yii::t($this->messageCategory, 'Name')),
			'status' => $this->smallInteger()->notNull()->defaultValue(1)->comment(\Yii::t($this->messageCategory, 'Status')),
			'list_order' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'List order')),
			'operator_id' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Operator id')),
			'creator_id' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Creator id')),
			'created_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Created time')),
			'updated_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Updated time')),
		], $tableOptions);
		$this->createIndex('site_id', '{{%site_category}}', 'site_id');
		$this->createIndex('parent_id', '{{%site_category}}', 'parent_id');
		$this->createIndex('status', '{{%site_category}}', 'status');
		$this->createIndex('list_order', '{{%site_category}}', 'list_order');
		$this->addCommentOnTable('{{%site_category}}', \Yii::t($this->messageCategory, 'Category'));

		$this->createTable('{{%site_article}}', [
			'id' => $this->primaryKey()->comment(\Yii::t($this->messageCategory, 'Id')),
			'site_id' => $this->string(68)->notNull()->comment(\Yii::t($this->messageCategory, 'Site id')),
			'category_id' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Category id')),
			'title' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'Title')),
			'author' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'Author')),
			'keywords' => $this->string()->comment(\Yii::t($this->messageCategory, 'Keyword')),
			'description' => $this->string()->comment(\Yii::t($this->messageCategory, 'Description')),
			'type' => $this->smallInteger()->notNull()->defaultValue(1)->comment(\Yii::t($this->messageCategory, 'Type')),
			'content' => $this->text()->comment(\Yii::t($this->messageCategory, 'Content')),
			'pictures' => $this->text()->comment(\Yii::t($this->messageCategory, 'Picture')),
			'thumbnail' => $this->text()->comment(\Yii::t($this->messageCategory, 'Thumbnail')),
			'status' => $this->smallInteger()->notNull()->defaultValue(1)->comment(\Yii::t($this->messageCategory, 'Status')),
			'list_order' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'List order')),
			'pv' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Page view')),
			'uv' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Unique Visitor')),
			'operator_id' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Operator id')),
			'creator_id' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Creator id')),
			'created_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Created time')),
			'updated_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Updated time')),
		], $tableOptions);
		$this->createIndex('site_id', '{{%site_article}}', 'site_id');
		$this->createIndex('category_id', '{{%site_article}}', 'category_id');
		$this->createIndex('type', '{{%site_article}}', 'type');
		$this->createIndex('status', '{{%site_article}}', 'status');
		$this->createIndex('list_order', '{{%site_article}}', 'list_order');
		$this->addCommentOnTable('{{%site_article}}', \Yii::t($this->messageCategory, 'Article'));

		$this->createTable('{{%site_banner}}', [
			'id' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'Id')),
			'site_id' => $this->string(68)->notNull()->comment(\Yii::t($this->messageCategory, 'Site id')),
			'name' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'Name')),
			'status' => $this->smallInteger()->notNull()->defaultValue(1)->comment(\Yii::t($this->messageCategory, 'Status')),
			'operator_id' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Operator id')),
			'creator_id' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Creator id')),
			'created_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Created time')),
			'updated_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Updated time')),
		], $tableOptions);
		$this->addPrimaryKey('id', '{{%site_banner}}', 'id');
		$this->createIndex('site_id', '{{%site_banner}}', 'site_id');
		$this->createIndex('status', '{{%site_banner}}', 'status');
		$this->addCommentOnTable('{{%site_banner}}', \Yii::t($this->messageCategory, 'Banner'));

		$this->createTable('{{%site_banner_item}}', [
			'id' => $this->primaryKey()->comment(\Yii::t($this->messageCategory, 'Id')),
			'site_id' => $this->string(68)->notNull()->comment(\Yii::t($this->messageCategory, 'Site id')),
			'banner_id' => $this->string(68)->notNull()->comment(\Yii::t($this->messageCategory, 'Banner id')),
			'title' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'Title')),
			'description' => $this->string()->comment(\Yii::t($this->messageCategory, 'Description')),
			'picture' => $this->text()->comment(\Yii::t($this->messageCategory, 'Picture')),
			'url' => $this->text()->comment(\Yii::t($this->messageCategory, 'Url')),
			'status' => $this->smallInteger()->notNull()->defaultValue(1)->comment(\Yii::t($this->messageCategory, 'Status')),
			'start_at' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Start time')),
			'end_at' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'End time')),
			'list_order' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'List order')),
			'pv' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Page view')),
			'uv' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Unique Visitor')),
			'operator_id' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Operator id')),
			'creator_id' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Creator id')),
			'created_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Created time')),
			'updated_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Updated time')),
		], $tableOptions);
		$this->createIndex('site_id', '{{%site_banner_item}}', 'site_id');
		$this->createIndex('banner_id', '{{%site_banner_item}}', 'banner_id');
		$this->createIndex('status', '{{%site_banner_item}}', 'status');
		$this->createIndex('start_at', '{{%site_banner_item}}', 'start_at');
		$this->createIndex('end_at', '{{%site_banner_item}}', 'end_at');
		$this->createIndex('list_order', '{{%site_banner_item}}', 'list_order');
		$this->addCommentOnTable('{{%site_banner_item}}', \Yii::t($this->messageCategory, 'Banner item'));
	}

	public function safeDown() {
		$this->dropTable('{{%site_banner_item}}');
		$this->dropTable('{{%site_banner}}');
		$this->dropTable('{{%site_article}}');
		$this->dropTable('{{%site_category}}');
		$this->dropTable('{{%site}}');
	}

}
