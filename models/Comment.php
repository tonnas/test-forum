<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property integer $id_comment
 * @property string $content
 * @property integer $confirmation
 * @property integer $parent_id
 *
 * @property Comment $parent
 * @property Comment $comment
 */
class Comment extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%comment}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['content'], 'required'],
            [['content'], 'string'],
            [['parent_id'], 'integer'],
            [['author'], 'required'],
            [['author'], 'string'],
            [['article_id'], 'integer'],
            [
                ['parent_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => self::class,
                'targetAttribute' => ['parent_id' => 'id']
            ],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'content' => 'Comment',
            'parent_id' => 'Parent ID',
            'author' => 'Author name',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getParent(): ActiveQuery
    {
        return $this->hasOne(self::class, ['id' => 'parent_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getComment(): ActiveQuery
    {
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }

    /**
     * @param int|null $parentId
     * @return bool
     */
    public function saveComment(int $parentId = null): bool
    {
        $loaded = $this->load(Yii::$app->request->post());

        if ($parentId) {
            $this->parent_id = $parentId;
        }

        return $loaded && $this->validate() && $this->save();
    }
}