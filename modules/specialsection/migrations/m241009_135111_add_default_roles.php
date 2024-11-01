<?php

use yii\db\Migration;
use common\models\Role;

/**
 * Class m241009_135111_add_default_roles
 */
class m241009_135111_add_default_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        \Yii::$app->db->createCommand()
                     ->batchInsert(
                         Role::tableName(),
                         ['name'],
                         [
                             ['editor_paidedu'],
                             ['editor_grants'],
                             ['editor_document'],
                             ['editor_common'],
                             ['editor_edustandarts'],
                             ['editor_inter'],
                             ['editor_budget'],
                             ['editor_objects'],
                             ['editor_catering'],
                             ['editor_education'],
                         ]
                     )
                     ->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241009_135111_add_default_roles cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241009_135111_add_default_roles cannot be reverted.\n";

        return false;
    }
    */
}