<?php
/**
 * Created by PhpStorm.
 * User: erlongchen88@gmail.com
 * Since: 2016/9/19 下午13:49:52
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\summernote\Summernote;
?>
<?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'title') ?>
    <?= $form->field($model, 'content')->widget(Summernote::className()) ?>
    <div class = 'form-group'>
        <?= Html::submitButton('submit', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end() ?>
