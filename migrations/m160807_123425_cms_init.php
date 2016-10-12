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
			'id' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'id')),
			'type' => $this->boolean()->notNull()->defaultValue(1)->comment(\Yii::t($this->messageCategory, 'Type')),
			'name' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'name')),
			'alias' => $this->string(68)->notNull()->comment(\Yii::t($this->messageCategory, 'alias')),
			'logo_id' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'logo')),
			'sub_logo_id' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'sub logo')),
			'brief' => $this->string(688)->comment(\Yii::t($this->messageCategory, 'brief')),
			'author' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'author')),
			'keywords' => $this->string()->comment(\Yii::t($this->messageCategory, 'keyword')),
			'description' => $this->string(688)->comment(\Yii::t($this->messageCategory, 'description')),
			'phone' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'phone')),
			'tax' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'tax')),
			'email' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'email')),
			'address' => $this->string()->comment(\Yii::t($this->messageCategory, 'address')),
			'qq' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'QQ')),
			'weixin_id' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'weixin')),
			'weibo' => $this->string()->comment(\Yii::t($this->messageCategory, 'weibo')),
			'copyright' => $this->string()->comment(\Yii::t($this->messageCategory, 'copyright')),
			'powered' => $this->string()->comment(\Yii::t($this->messageCategory, 'powered by')),
			'powered_url' => $this->text()->comment(\Yii::t($this->messageCategory, 'powered by url')),
			'record' => $this->string()->comment(\Yii::t($this->messageCategory, 'record number')),
			'license' => $this->string()->comment(\Yii::t($this->messageCategory, 'license number')),
			'status' => $this->boolean()->notNull()->defaultValue(1)->comment(\Yii::t($this->messageCategory, 'status')),
			'pv' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'page view')),
			'uv' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'unique visitor')),
			'created_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'created time')),
			'operator_id' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'operator id')),
			'updated_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'updated time')),
		], $tableOptions);
		$this->addPrimaryKey('id', '{{%site}}', 'id');
		$this->createIndex('type', '{{%site}}', 'type');
		$this->createIndex('status', '{{%site}}', 'status');
		$this->addCommentOnTable('{{%site}}', \Yii::t($this->messageCategory, 'site'));

		$this->createTable('{{%site_category}}', [
			'id' => $this->primaryKey()->comment(\Yii::t($this->messageCategory, 'id')),
			'site_id' => $this->string(68)->notNull()->comment(\Yii::t($this->messageCategory, 'site id')),
			'type' => $this->boolean()->notNull()->defaultValue(1)->comment(\Yii::t($this->messageCategory, 'type')),
			'name' => $this->string(68)->notNull()->comment(\Yii::t($this->messageCategory, 'name')),
			'alias' => $this->string(68)->notNull()->comment(\Yii::t($this->messageCategory, 'alias')),
			'status' => $this->boolean()->notNull()->defaultValue(1)->comment(\Yii::t($this->messageCategory, 'status')),
			'creator_id' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'creator id')),
			'created_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'created time')),
			'operator_id' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'operator id')),
			'updated_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'updated time')),
		], $tableOptions);
		$this->createIndex('site_id', '{{%site_category}}', 'site_id');
		$this->createIndex('type', '{{%site_category}}', 'type');
		$this->createIndex('status', '{{%site_category}}', 'status');
		$this->addCommentOnTable('{{%site_category}}', \Yii::t($this->messageCategory, 'category'));

		$this->createTable('{{%site_article}}', [
			'id' => $this->primaryKey()->comment(\Yii::t($this->messageCategory, 'id')),
			'site_id' => $this->string(68)->notNull()->comment(\Yii::t($this->messageCategory, 'site id')),
			'category_id' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'category id')),
			'title' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'title')),
			'alias' => $this->string(68)->notNull()->comment(\Yii::t($this->messageCategory, 'alias')),
			'thumbnail_id' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'thumbnail')),
			'author' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'author')),
			'keywords' => $this->string()->comment(\Yii::t($this->messageCategory, 'keyword')),
			'description' => $this->string(688)->comment(\Yii::t($this->messageCategory, 'description')),
			'content' => $this->text()->comment(\Yii::t($this->messageCategory, 'content')),
			'picture_ids' => $this->text()->comment(\Yii::t($this->messageCategory, 'picture')),
			'attachment_id' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'attachment')),
			'status' => $this->boolean()->notNull()->defaultValue(1)->comment(\Yii::t($this->messageCategory, 'status')),
			'pv' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'page view')),
			'uv' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'unique visitor')),
			'creator_id' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'creator id')),
			'created_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'created time')),
			'operator_id' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'operator id')),
			'updated_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'updated time')),
		], $tableOptions);
		$this->createIndex('site_id', '{{%site_article}}', 'site_id');
		$this->createIndex('category_id', '{{%site_article}}', 'category_id');
		$this->createIndex('status', '{{%site_article}}', 'status');
		$this->addCommentOnTable('{{%site_article}}', \Yii::t($this->messageCategory, 'article'));

		$this->createTable('{{%site_module}}', [
			'id' => $this->primaryKey()->comment(\Yii::t($this->messageCategory, 'id')),
			'site_id' => $this->string(68)->notNull()->comment(\Yii::t($this->messageCategory, 'site id')),
			'type' => $this->boolean()->notNull()->defaultValue(1)->comment(\Yii::t($this->messageCategory, 'type')),
			'position' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'position')),
			'name' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'name')),
			'alias' => $this->string(68)->notNull()->comment(\Yii::t($this->messageCategory, 'alias')),
			'status' => $this->boolean()->notNull()->defaultValue(1)->comment(\Yii::t($this->messageCategory, 'status')),
			'creator_id' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'creator id')),
			'created_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'created time')),
			'operator_id' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'operator id')),
			'updated_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'updated time')),
		], $tableOptions);
		$this->createIndex('site_id', '{{%site_module}}', 'site_id');
		$this->createIndex('type', '{{%site_module}}', 'type');
		$this->createIndex('position', '{{%site_module}}', 'position');
		$this->createIndex('status', '{{%site_module}}', 'status');
		$this->addCommentOnTable('{{%site_module}}', \Yii::t($this->messageCategory, 'module'));

		$this->createTable('{{%site_module_item}}', [
			'id' => $this->primaryKey()->comment(\Yii::t($this->messageCategory, 'id')),
			'site_id' => $this->string(68)->notNull()->comment(\Yii::t($this->messageCategory, 'site id')),
			'module_id' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'module id')),
			'sub_module_id' => $this->integer()->comment(\Yii::t($this->messageCategory, 'sub module id')),
			'type' => $this->boolean()->notNull()->defaultValue(1)->comment(\Yii::t($this->messageCategory, 'type')),
			'target_id' => $this->integer()->comment(\Yii::t($this->messageCategory, 'target id')),
			'title' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'title')),
			'alias' => $this->string(68)->notNull()->comment(\Yii::t($this->messageCategory, 'alias')),
			'description' => $this->string(688)->comment(\Yii::t($this->messageCategory, 'description')),
			'picture_id' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'picture')),
			'url' => $this->text()->comment(\Yii::t($this->messageCategory, 'url')),
			'status' => $this->boolean()->notNull()->defaultValue(1)->comment(\Yii::t($this->messageCategory, 'status')),
			'start_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'start time')),
			'end_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'end time')),
			'list_order' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'list order')),
			'pv' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'page view')),
			'uv' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'unique visitor')),
			'creator_id' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'creator id')),
			'created_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'created time')),
			'operator_id' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'operator id')),
			'updated_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'updated time')),
		], $tableOptions);
		$this->createIndex('site_id', '{{%site_module_item}}', 'site_id');
		$this->createIndex('module_id', '{{%site_module_item}}', 'module_id');
		$this->createIndex('type', '{{%site_module_item}}', 'type');
		$this->createIndex('status', '{{%site_module_item}}', 'status');
		$this->createIndex('list_order', '{{%site_module_item}}', 'list_order');
		$this->addCommentOnTable('{{%site_module_item}}', \Yii::t($this->messageCategory, 'module item'));
	}

	public function safeDown() {
		$this->dropTable('{{%site_module_item}}');
		$this->dropTable('{{%site_module}}');
		$this->dropTable('{{%site_article}}');
		$this->dropTable('{{%site_category}}');
		$this->dropTable('{{%site}}');
	}

}
