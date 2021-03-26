<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post_comments}}`.
 */
class m210326_150704_create_post_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%post_comments}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer(),
            'email' => $this->string(),
            'comment' => $this->text()
        ], $tableOptions);

        $this->createIndex(
            'idx-post_comments-post_id',
            'post_comments',
            'post_id'
        );

        $this->addForeignKey(
            'fk-post_comments-post_id',
            'post_comments',
            'post_id',
            'posts',
            'id',
            'CASCADE',
            'NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-post_comments-post_id', 'post_comments');
        $this->dropIndex('idx-post_comments-post_id', 'post_comments');
        $this->dropTable('{{%post_comments}}');
    }
}
