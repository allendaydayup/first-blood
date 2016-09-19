<?php
/**
 * Created by PhpStorm.
 * User: erlongchen88@gmail.com
 * Since: 2016/9/19 下午13:42:08
 */

namespace app\models;

class Post extends \yii\base\Model
{
    public $title;
    public $content;

    public function rules()
    {
        return [
            [['title', 'content'], 'required']
        ];
    }
}