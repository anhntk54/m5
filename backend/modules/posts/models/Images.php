<?php

namespace backend\modules\posts\models;

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
class Images extends \common\models\Images {

    public function Xoa() {
        if ($this->details) {
            $json = json_decode($this->details->value);
            $path = $json->path . $json->imagename;
            $pathThumbnail200 = $json->path.$json->thumbnail200;
            if (file_exists($pathThumbnail200)) {
                unlink($pathThumbnail200);
            }
            if (file_exists($path)) {
                unlink($path);
            }
            $this->details->delete();
        }
        $this->delete();
    }
    
    

}
