<?php

namespace backend\modules\posts\components;

use yii\base\Widget;
class FilerIndexWidgets extends Widget {

    public $title;
    public $filer;
    public $table;
    public $linkAjax;
    public $type ='';
    public $arrTitle;
    public $dataList;
    public function init() {
        // add your logic here
        parent::init();
    }

    public function run() {
//        if ($this->dataList == NULL) {
//            $this->dataList = [];
//        }
        return $this->render('filer_index', ['arrTitle'=>  $this->arrTitle,
            'link'=>  $this->linkAjax,'type'=>  $this->type,'dataList'=>  $this->dataList,
            'title' => $this->title, 'table' => $this->table]);
    }

}
?>

