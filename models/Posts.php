<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $author
 * @property string|null $full_text
 * @property string|null $file_path
 * @property int|null $created_at
 */
class Posts extends \yii\db\ActiveRecord
{

    const MAX_FILE_SIZE = 1024 * 1024 * 5;

    /**
     * @var UploadedFile
     */
    public $file;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => [],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_text'], 'string'],
            [['created_at'], 'integer'],
            [['title', 'author', 'file_path'], 'string', 'max' => 255],
            [
                ['file'],
                'file',
                'skipOnEmpty' => true,
                'extensions' => 'docx, xls, xlsx, xlsm, doc, pdf, txt, text, jpg, jpeg, png, tif',
                'maxFiles' => 1,
                'maxSize' => self::MAX_FILE_SIZE,
                'tooBig' => 'Limit is 5 MB'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'author' => 'Author',
            'full_text' => 'Full Text',
            'file_path' => 'File Path',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return bool
     */
    public function upload()
    {
        if ($this->validate()) {
            if (!is_null($this->file)) {
                $this->file->saveAs('uploads/posts/' . $this->file->baseName . '.' . $this->file->extension);
                $this->setAttribute('file_path', '/uploads/posts/' . $this->file->name);
            }
            $this->file = null;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(PostComments::class, ['post_id' => 'id']);
    }
}
