<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property integer $author_id
 * @property string $title
 * @property string $description
 * @property string $status
 * @property integer $views
 * @property string $create_at
 * @property string $update_at
 * @property string $slug
 * @property string $type
 */
class Posts extends \yii\db\ActiveRecord
{
    const STATUS_TRASH = 1;
    const STATUS_DRAFT = 2;
    const STATUS_ACTIVE = 5;

    public $seo_title;
    public $seo_description;
    public $seo_keyword;
    public $fb_title;
    public $fb_description;
    public $fb_image;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id', 'title', 'description', 'status', 'update_at', 'slug', 'type'], 'required'],
            [['author_id', 'views'], 'integer'],
            [['description'], 'string'],
            [['create_at', 'update_at'], 'safe'],
            [['title', 'slug', 'type'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'title' => 'Title',
            'description' => 'Description',
            'status' => 'Status',
            'views' => 'Views',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'slug' => 'Slug',
            'type' => 'Type',
        ];
    }
    //relational model
    function getAuthor() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'author_id']);
    }

    function getCategories() {
        return $this->hasMany(Category::className(), ['id' => 'table_id'])->viaTable("post_relationships", ['post_id' => 'id'], function ($query) {
                    $query->where(['table_name' => 'category', 'post_table' => Posts::tableName()]);
                });
    }

    function getTags() {
        return $this->hasMany(Tags::className(), ['id' => 'table_id'])->viaTable("post_relationships", ['post_id' => 'id'], function ($query) {
                    $query->where(['table_name' => 'tags', 'post_table' => Posts::tableName()]);
                });
    }

    function getImage() {
        return $this->hasOne(Images::className(), ['id' => 'table_id'])->viaTable("post_relationships", ['post_id' => 'id'], function ($query) {
                    $query->where(['table_name' => 'images', 'post_table' => Posts::tableName()]);
                });
    }

    function getFbimage() {
        return $this->hasOne(Images::className(), ['id' => 'table_id'])->viaTable("post_relationships", ['post_id' => 'id'], function ($query) {
                    $query->where(['table_name' => 'fbimages', 'post_table' => Posts::tableName()]);
                });
    }
    public function getTitle($the ='',$className = '') {

        if ($the != '') {
            $link = "<a href='" . $this->getLink() . "' class='$className'><$the>$this->title</$the></a>";
        }  else {
            $link = "<a href='" . $this->getLink() . "' class='$className'>$this->title</a>";
        }
        return $link;
    }
    public function getLink(){
        $link = \yii\helpers\Url::to(['/M5/default/post','slug'=>  $this->slug]);
        return $link;;
    }
    function getHinhAnhLink() {
        $img = "<a href='".$this->getLink()."' class='img-feature'>".$this->getHinhAnh()."</a>";
        return $img;
    }
    function getHinhAnh() {
        $src = $this->getLinkAnh();
        $img = "<img src='$src' alt='' class='img-responsive'>";
        return $img;
    }

    function getLinkAnh() {
        $src = '';
        if ($this->image) {
            $src = $this->image->getUrl();
        }
        return $src;
    }
    public function getMota() {
        $this->getSeoPost();
        $link = "<p>$this->seo_description</p>";
        return $link;
    }
    function getSeoPost() {
        $taxonomy = Taxonomy::findOne(['table_name' => Posts::tableName(), 'type' => \common\func\StaticDefine::$SEO_BAI_VIET, 'table_id' => $this->id]);
        if ($taxonomy) {
            $json[] = json_decode($taxonomy->value);
            $this->seo_title = $json[0]->seo_title;
            $this->seo_description = $json[0]->seo_description;
            $this->seo_keyword = $json[0]->seo_keyword;
            $this->fb_description = $json[0]->fb_description;
            $this->fb_title = $json[0]->fb_title;
            if ($this->fbimage) {
                $this->fb_image = $this->fbimage->id;
            }
        }
    }
    function getStringTags() {
        $s = "";
        $i = 0;
        if ($this->tags != NULL) {
            foreach ($this->tags as $value) {
                if ($i == count($this->tags) - 1) {
                    $s .= $value->title;
                } else {
                    $s .= $value->title . ',';
                }
                $i++;
            }
        }
        return $s;
    }

    function getStringCategories() {
        $s = "";
        $i = 0;
        if ($this->categories != NULL) {
            foreach ($this->categories as $value) {
                if ($i == count($this->categories) - 1) {
                    $s .= $value->title;
                } else {
                    $s .= $value->title . ',';
                }
                $i++;
            }
        }
        return $s;
    }
}
