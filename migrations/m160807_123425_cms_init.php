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
			'name' => $this->string(68)->notNull()->comment(\Yii::t($this->messageCategory, 'Name')),
			'logo' => $this->text()->comment(\Yii::t($this->messageCategory, 'Logo')),
			'author' => $this->string(68)->comment(\Yii::t($this->messageCategory, 'Author')),
			'keywords' => $this->string()->comment(\Yii::t($this->messageCategory, 'Keywords')),
			'description' => $this->string()->comment(\Yii::t($this->messageCategory, 'Description')),
			'status' => $this->smallInteger()->notNull()->defaultValue(10)->comment(\Yii::t($this->messageCategory, 'Status')),
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
			'status' => $this->smallInteger()->notNull()->defaultValue(10)->comment(\Yii::t($this->messageCategory, 'Status')),
			'list_order' => $this->smallInteger()->notNull()->defaultValue(0)->comment(\Yii::t($this->messageCategory, 'List order')),
			'created_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Created time')),
			'updated_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Updated time')),
		], $tableOptions);
		$this->createIndex('status', '{{%site_category}}', 'status');
		$this->createIndex('list_order', '{{%site_category}}', 'list_order');
		$this->addCommentOnTable('{{%site_category}}', \Yii::t($this->messageCategory, 'Category'));
	}

	public function safeDown() {
		$this->dropTable('{{%site_category}}');
		$this->dropTable('{{%site}}');
	}

}
