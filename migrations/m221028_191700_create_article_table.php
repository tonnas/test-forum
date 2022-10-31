<?php

use app\models\Article;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%article}}`.
 */
class m221028_191700_create_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%article}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'content' => $this->text()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('NOW()'),
            'updated_at' => $this->timestamp()
                ->defaultExpression('CURRENT_TIMESTAMP')
                ->append('ON UPDATE NOW()'),
        ]);

        $this->insert('{{%article}}', [
            'id' => Article::FIRST_ARTICLE_ID,
            'title' => 'Fiktívny článok',
            'content' => 'Vytvor diskusiu pod fiktívny článok. Do diskusie môže prispievať ktokoľvek, pričom sa dá 
            reagovať na jednotlivé komentáre. Komentár musí obsahovať autora, dátum pridania a samotný text. Nad touto 
            diskusiou vytvor administračné rozhranie kde bude mať prístup iba oprávnená osoba a bude vedieť tieto 
            komentáre zmazať, upraviť alebo vytvoriť reakciu na akýkoľvek komentár. Pri implementácii sa sústreď na 
            softvérový návrh, bezpečnosť riešenia a dátovú udržateľnosť. Zaujíma nás tvoj prístup k OOP a čistote kódu.',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%article}}', [ 'id' => Article::FIRST_ARTICLE_ID ]);
        $this->dropTable('{{%article}}');
    }
}
