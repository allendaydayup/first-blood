<?php
/**
 * Created by PhpStorm.
 * User: erlongchen88@gmail.com
 * Since: 2016/9/12 下午16:42:34
 */
use yii\widgets\HelloWidget;
?>
<?= HelloWidget::widget(['message' => 'Good morning']) ?>
<?php //HelloWidget::begin(); ?>
<!--content that may contain <tag>'s-->
<?php //HelloWidget::end(); ?>