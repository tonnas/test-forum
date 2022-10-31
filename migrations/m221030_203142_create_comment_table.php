<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment}}`.
 */
class m221030_203142_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'article_id' => $this->integer(),
            'author' => $this->string()->notNull(),
            'content' => $this->text()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('NOW()'),
            'updated_at' => $this->timestamp()
                ->defaultExpression('CURRENT_TIMESTAMP')
                ->append('ON UPDATE NOW()'),
        ]);

        $this->addForeignKey(
            'fk-comment-article_id',
            '{{%comment}}',
            'article_id',
            '{{%article}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-comment-parent_id',
            '{{%comment}}',
            'parent_id',
            '{{%comment}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-comment-parent_id', '{{%comment}}');
        $this->dropForeignKey('fk-comment-article_id', '{{%comment}}');
        $this->dropTable('{{%comment}}');
    }
}
