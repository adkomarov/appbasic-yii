<?php
/*
use yii\db\Migration;

class m240716_143338_create_fieldsform_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%fieldsform}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%fieldsform}}');
    }
}
*/

//basic/modules/takedatam/migrations/m240716_143338_create_fieldsform_table.php
use yii\db\Migration;

class m240716_143338_create_fieldsform_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('fieldsforms', [
            'idfieldsforms' => $this->primaryKey(),
            'nameform' => $this->string()->null(),
            'fieldform' => $this->string()->null(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('fieldsforms');
    }
}