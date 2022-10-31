<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property integer $id
 * @property string $tittle
 * @property string $content
 */
class Article extends ActiveRecord
{
    const FIRST_ARTICLE_ID = 1;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%article}}';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['tittle', 'text'], 'required'],
            [['tittle', 'text'], 'string'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'tittle' => 'Tittle',
            'content' => 'Content',
        ];
    }

    /**
     * @return Article|null
     */
    public static function first(): ?Article
    {
        return self::findOne(['id' => self::FIRST_ARTICLE_ID]);
    }
}