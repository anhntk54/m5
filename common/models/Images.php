<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "images".
 *
 * @property integer $id
 * @property integer $author_id
 * @property string $title
 * @property string $description
 * @property string $alt
 * @property string $url
 * @property integer $status
 * @property string $create_at
 * @property string $update_at
 */
class Images extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'images';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title'], 'required'],
            [['id', 'author_id', 'status'], 'integer'],
            [['description'], 'string'],
            [['create_at', 'update_at'], 'safe'],
            [['title', 'alt', 'url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'title' => 'Title',
            'description' => 'Description',
            'alt' => 'Alt',
            'url' => 'Url',
            'status' => 'Status',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }

    public function getDetails() {
        return $this->hasOne(Taxonomy::className(), ['table_id' => 'id'])->where(['table_name' => 'images', 'type' => \common\func\StaticDefine::$CHI_TIET_HINH_ANH]);
    }

    public function getUrl($size = 0) {
        $link = "";
        if ($size == 0) {
            $link = $this->url;
        } else if ($size > 0) {
            if ($this->details) {
                $json = json_decode($this->details->value);
                if ($json->thumbnail200 && $size == 200) {
                    $link = $json->url . $json->thumbnail200;
                }
                if (isset($json->thumbnail150) && $json->thumbnail150 && $size == 150) {
                    $link = $json->url . $json->thumbnail150;
                }
            }
        }
        return $link;
    }

}
