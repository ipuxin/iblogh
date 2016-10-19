<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Commentstatus;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList($model->approves, ['prompt'=>'请选择状态'])->label('评论状态') ?>
<!--Yii2,表单赋值-->
    <?= $form->field($model, 'label_create_time')->textInput(['value'=>date('Y-m-d h:i:s',$model->create_time),'readonly'=>'readonly']) ?>
<!--Yii2,修改禁用表单-->
    <?= $form->field($model, 'label_id')->textInput(['value'=>$model->user->username,'readonly'=>'readonly'])->label('评论者') ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'label_post_id')->textInput(['value'=>'','placeholder'=>$model->post->title,'readonly'=>'readonly'])->label('所评文章') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
