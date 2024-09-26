<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%savefiles}}`.
 */
class m240718_114938_create_savefiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%savefiles}}', [
            'idsavefiles' => $this->primaryKey(),
            'Titel' => $this->string()->notNull(),
            'NameFile' => $this->string()->notNull(),
            'Link' => $this->string(),
            'Position' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%savefiles}}');
    }
}