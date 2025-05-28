<?php

use yii\db\Migration;

class m250527_183927_create_url_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('url', [
            'id'           => $this->primaryKey(),
            'original_url' => $this->text()->notNull(),
            'short_code'   => $this->string(10)->notNull()->unique(),
            'created_at'   => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'clicks'       => $this->integer()->defaultValue(0)
        ]);

        $this->createTable('url_log', [
            'id' => $this->primaryKey(),
            'url_id' => $this->integer()->notNull(),
            'ip_address' => $this->string(45),
            'accessed_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')
        ]);

        $this->addForeignKey(
            'fk-url_log-url_id',
            'url_log',
            'url_id',
            'url',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-url_log-url_id', 'url_log');
        $this->dropTable('url_log');
        $this->dropTable('url');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250527_183927_create_url_tables cannot be reverted.\n";

        return false;
    }
    */
}
