<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/6
 * Time: 下午15:48:57
 */
use yii\helpers\Html;
?>
<p>填写下边表单内容</p>
<ul>
    <li><label>姓名</label>：<?= Html::encode($model->name) ?></li>
    <li><label>邮箱</label>：<?= Html::encode($model->email) ?></li>
</ul>
