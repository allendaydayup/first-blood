<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/6
 * Time: 下午15:04:39
 */

namespace app\models;

use Yii;
use yii\base\Model;

class EntryForm extends Model
{
    public $name;
    public $email;

    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            ['email', 'email'],
        ];
    }
}