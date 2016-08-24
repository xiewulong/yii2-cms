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
			'tax' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'Tax')),
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
			'pv' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Page view')),
			'uv' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Unique visitor')),
			'operator_id' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Operator id')),
			'created_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Created time')),
			'updated_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Updated time')),
		], $tableOptions);
		$this->addPrimaryKey('id', '{{%site}}', 'id');
		$this->createIndex('type', '{{%site}}', 'type');
		$this->createIndex('status', '{{%site}}', 'status');
		$this->addCommentOnTable('{{%site}}', \Yii::t($this->messageCategory, 'Site'));

		$this->createTable('{{%site_category}}', [
			'id' => $this->primaryKey()->comment(\Yii::t($this->messageCategory, 'Id')),
			'site_id' => $this->string(68)->notNull()->comment(\Yii::t($this->messageCategory, 'Site id')),
			'parent_id' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Parent id')),
			'type' => $this->smallInteger()->notNull()->defaultValue(1)->comment(\Yii::t($this->messageCategory, 'Type')),
			'name' => $this->string(68)->notNull()->comment(\Yii::t($this->messageCategory, 'Name')),
			'alias' => $this->string(68)->notNull()->comment(\Yii::t($this->messageCategory, 'Alias')),
			'status' => $this->smallInteger()->notNull()->defaultValue(1)->comment(\Yii::t($this->messageCategory, 'Status')),
			'list_order' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'List order')),
			'operator_id' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Operator id')),
			'creator_id' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Creator id')),
			'created_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Created time')),
			'updated_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Updated time')),
		], $tableOptions);
		$this->createIndex('site_id', '{{%site_category}}', 'site_id');
		$this->createIndex('parent_id', '{{%site_category}}', 'parent_id');
		$this->createIndex('type', '{{%site_category}}', 'type');
		$this->createIndex('status', '{{%site_category}}', 'status');
		$this->createIndex('list_order', '{{%site_category}}', 'list_order');
		$this->addCommentOnTable('{{%site_category}}', \Yii::t($this->messageCategory, 'Category'));

		$this->createTable('{{%site_article}}', [
			'id' => $this->primaryKey()->comment(\Yii::t($this->messageCategory, 'Id')),
			'site_id' => $this->string(68)->notNull()->comment(\Yii::t($this->messageCategory, 'Site id')),
			'category_id' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Category id')),
			'title' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'Title')),
			'thumbnail' => $this->text()->comment(\Yii::t($this->messageCategory, 'Thumbnail')),
			'author' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'Author')),
			'keywords' => $this->string()->comment(\Yii::t($this->messageCategory, 'Keyword')),
			'description' => $this->string()->comment(\Yii::t($this->messageCategory, 'Description')),
			'content' => $this->text()->comment(\Yii::t($this->messageCategory, 'Content')),
			'pictures' => $this->text()->comment(\Yii::t($this->messageCategory, 'Picture')),
			'status' => $this->smallInteger()->notNull()->defaultValue(1)->comment(\Yii::t($this->messageCategory, 'Status')),
			'list_order' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'List order')),
			'pv' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Page view')),
			'uv' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Unique visitor')),
			'operator_id' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Operator id')),
			'creator_id' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Creator id')),
			'created_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Created time')),
			'updated_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Updated time')),
		], $tableOptions);
		$this->createIndex('site_id', '{{%site_article}}', 'site_id');
		$this->createIndex('category_id', '{{%site_article}}', 'category_id');
		$this->createIndex('status', '{{%site_article}}', 'status');
		$this->createIndex('list_order', '{{%site_article}}', 'list_order');
		$this->addCommentOnTable('{{%site_article}}', \Yii::t($this->messageCategory, 'Article'));

		$this->createTable('{{%site_module}}', [
			'id' => $this->primaryKey()->comment(\Yii::t($this->messageCategory, 'Id')),
			'site_id' => $this->string(68)->notNull()->comment(\Yii::t($this->messageCategory, 'Site id')),
			'type' => $this->smallInteger()->notNull()->defaultValue(1)->comment(\Yii::t($this->messageCategory, 'Type')),
			'position' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'Position')),
			'name' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'Name')),
			'alias' => $this->string(68)->notNull()->comment(\Yii::t($this->messageCategory, 'Alias')),
			'status' => $this->smallInteger()->notNull()->defaultValue(1)->comment(\Yii::t($this->messageCategory, 'Status')),
			'operator_id' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Operator id')),
			'creator_id' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Creator id')),
			'created_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Created time')),
			'updated_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Updated time')),
		], $tableOptions);
		$this->createIndex('site_id', '{{%site_module}}', 'site_id');
		$this->createIndex('type', '{{%site_module}}', 'type');
		$this->createIndex('position', '{{%site_module}}', 'position');
		$this->createIndex('status', '{{%site_module}}', 'status');
		$this->addCommentOnTable('{{%site_module}}', \Yii::t($this->messageCategory, 'Module'));

		$this->createTable('{{%site_module_item}}', [
			'id' => $this->primaryKey()->comment(\Yii::t($this->messageCategory, 'Id')),
			'site_id' => $this->string(68)->notNull()->comment(\Yii::t($this->messageCategory, 'Site id')),
			'module_id' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Module id')),
			'type' => $this->smallInteger()->notNull()->defaultValue(1)->comment(\Yii::t($this->messageCategory, 'Type')),
			'target_id' => $this->integer()->comment(\Yii::t($this->messageCategory, 'Target id')),
			'title' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'Title')),
			'alias' => $this->string(68)->notNull()->comment(\Yii::t($this->messageCategory, 'Alias')),
			'description' => $this->string()->comment(\Yii::t($this->messageCategory, 'Description')),
			'picture' => $this->text()->comment(\Yii::t($this->messageCategory, 'Picture')),
			'url' => $this->text()->comment(\Yii::t($this->messageCategory, 'Url')),
			'status' => $this->smallInteger()->notNull()->defaultValue(1)->comment(\Yii::t($this->messageCategory, 'Status')),
			'start_at' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Start time')),
			'end_at' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'End time')),
			'list_order' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'List order')),
			'pv' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Page view')),
			'uv' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Unique visitor')),
			'operator_id' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Operator id')),
			'creator_id' => $this->integer()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'Creator id')),
			'created_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Created time')),
			'updated_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Updated time')),
		], $tableOptions);
		$this->createIndex('site_id', '{{%site_module_item}}', 'site_id');
		$this->createIndex('module_id', '{{%site_module_item}}', 'module_id');
		$this->createIndex('type', '{{%site_module_item}}', 'type');
		$this->createIndex('status', '{{%site_module_item}}', 'status');
		$this->createIndex('start_at', '{{%site_module_item}}', 'start_at');
		$this->createIndex('end_at', '{{%site_module_item}}', 'end_at');
		$this->createIndex('list_order', '{{%site_module_item}}', 'list_order');
		$this->addCommentOnTable('{{%site_module_item}}', \Yii::t($this->messageCategory, 'Module item'));
	}

	public function safeDown() {
		$this->dropTable('{{%site_module_item}}');
		$this->dropTable('{{%site_module}}');
		$this->dropTable('{{%site_article}}');
		$this->dropTable('{{%site_category}}');
		$this->dropTable('{{%site}}');
	}

}
