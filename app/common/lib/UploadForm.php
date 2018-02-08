<?php
namespace common\lib;


use yii\base\Model;

class UploadForm extends Model  
{
    
    public $file;
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['image'], 'file', 'maxFiles' => 10,'extensions'=>'jpg,png,gif'],
        ];
    }
    
    public function attributeLabels(){
        return [
            'file'=>'多文件上传'
        ];
    }
}

