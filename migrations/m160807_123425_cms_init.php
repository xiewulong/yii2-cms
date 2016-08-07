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
			'id' => $this->string(50)->comment(\Yii::t($this->messageCategory, 'Site')),
			'name' => $this->string(50)->comment(\Yii::t($this->messageCategory, 'Site name')),
			'logo' => $this->text()->comment(\Yii::t($this->messageCategory, 'Site logo')),
			'author' => $this->string(50)->comment(\Yii::t($this->messageCategory, 'Author')),
			'keywords' => $this->string()->comment(\Yii::t($this->messageCategory, 'Keywords')),
			'description' => $this->string()->comment(\Yii::t($this->messageCategory, 'Description')),
			'status' => $this->smallInteger()->notNull()->defaultValue(10)->comment(\Yii::t($this->messageCategory, 'Site status')),
			'created_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Created time')),
			'updated_at' => $this->integer()->notNull()->comment(\Yii::t($this->messageCategory, 'Updated time')),
		], $tableOptions);

		$this->addPrimaryKey('id', '{{%site}}', 'id');
		$this->createIndex('status', '{{%site}}', 'status');
	}

	public function safeDown() {
		$this->dropTable('{{%site}}');
	}

}
