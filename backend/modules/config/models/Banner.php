<?php
namespace backend\modules\config\models;
use backend\modules\posts\models\PostRelationships;
use backend\modules\posts\models\Images;

use Yii;

/**
 * This is the model class for table "banner".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $value
 * @property string $position
 * @property integer $new_tab
 * @property string $date_begin
 * @property string $date_end
 * @property string $type
 * @property integer $banner_order
 */
class Banner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','type', 'position', 'new_tab'], 'required'],
            [['url', 'value'], 'string'],
            [['date_begin', 'date_end'], 'safe'],
            [['name', 'position', 'type'], 'string', 'max' => 255]
        ];
    }
    function getImage() {
        return $this->hasOne(Images::className(), ['id' => 'table_id'])->viaTable("post_relationships", ['post_id' => 'id'], function ($query) {
                    $query->where(['table_name' => 'images', 'post_table' => Banner::tableName()]);
                });
    }
    public static function createPosts($model) {
        if (isset($_POST['idimage'])) {
            $idimage = $_POST['idimage'];
            $image = Images::findOne(['id' => $idimage]);
            if ($image) {
                PostRelationships::setPost($idimage, $model->id, Images::tableName(),$model->tableName());
            }
        }
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'url' => 'Url',
            'value' => 'Value',
            'position' => 'Position',
            'new_tab' => 'New Tab',
            'date_begin' => 'Date Begin',
            'date_end' => 'Date End',
            'type' => 'Type',
            'banner_order' => 'Banner Order',
        ];
    }
}
