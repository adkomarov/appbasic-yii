<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%dataforms}}`.
 */
class m240717_144653_create_dataforms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%dataforms}}', [
            'iddataforms' => $this->primaryKey(),
            'namefildsforms' => $this->string()->notNull(),
            'datafilds' => $this->string()->notNull(),
            'variable' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%dataforms}}');
    }
}