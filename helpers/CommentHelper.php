<?php

namespace app\helpers;

use app\models\Comment;
use Throwable;
use Yii;

class CommentHelper
{
    const SUBCOMMENT_MARGIN_LEFT = 20;

    /**
     * @param $commentId
     * @return void
     * @throws Throwable
     */
    public static function cascadeDelete($commentId): void
    {
        $comment = Comment::findOne(['id' => $commentId]);

        foreach($comment->comment as $subComment) {
            if (!$subComment->comment) {
                $subComment->delete();
            } else {
                self::cascadeDelete($subComment->id);
            }
        }

        $comment->delete();
    }

    /**
     * @param Comment $comment
     * @param int $level
     * @return void
     */
    public static function cascadeView(Comment $comment, int $level = self::SUBCOMMENT_MARGIN_LEFT): void
    {
        if ($comment->comment) {
            foreach ($comment->comment as $subComment) {
                echo Yii::$app->controller->renderPartial('commentView', [
                    'comment' => $subComment,
                    'level' => $level
                ]);

                self::cascadeView($subComment, $level + self::SUBCOMMENT_MARGIN_LEFT);
            }
        }
    }
}