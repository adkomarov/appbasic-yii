<?php

namespace app\modules\takedatam\models;

use Yii;

/**
 * This is the model class for table "savefiles".
 *
 * @property int $idsavefiles
 * @property string|null $Titel
 * @property string|null $NameFile
 * @property string|null $Link
 * @property string|null $Position
 */
class Savefiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'savefiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Titel', 'NameFile'],'required'],
            [['Titel', 'NameFile','Position'],'string'],
            ['Position','match','pattern'=>'/^[a-zA-Z0-9_-]{31,32}$/'],
            [ 'Link','url'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idsavefiles' => 'Idsavefiles',
            'Titel' => 'Titel',
            'NameFile' => 'Name File',
            'Link' => 'Link',
            'Position' => 'Position',
        ];
    }
}
