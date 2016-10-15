<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Poststatus;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tags')->textarea(['rows' => 6]) ?>

    <?php
    /*
        第一种方法：
        $psObjs = Poststatus::find()->all();
        $allStatus = ArrayHelper::map($psObjs,'id','name');

        第二种方法：
        $psArray = Yii::$app->db->createCommand('select id,name from poststatus')->queryAll();
        $allStatus = ArrayHelper::map($psArray,'id','name');

        第三种方法：
        $allStatus = (new \yii\db\Query())
        ->select(['name','id'])
        ->from('poststatus')
        ->indexBy('id')
        ->column();

        第四种方法：
        allStatus = Poststatus::find()
        ->select(['name','id'])
        ->orderBy('position')
        ->indexBy('id')
        ->column();
        */
    $allStatus = (new \yii\db\Query())
        ->select(['name', 'id'])
        ->from('poststatus')
        ->indexBy('id')
        ->all();
    var_dump($allStatus);
    /**
     * array (size=3)
     * 1 =>
     * array (size=2)
     * 'name' => string '草稿' (length=6)
     * 'id' => string '1' (length=1)
     * 2 =>
     * array (size=2)
     * 'name' => string '已发布' (length=9)
     * 'id' => string '2' (length=1)
     * 3 =>
     * array (size=2)
     * 'name' => string '已归档' (length=9)
     * 'id' => string '3' (length=1)
     */
    ?>
    <?= $form->field($model, 'status')->dropDownList($allStatus, ['prompt' => '请选择状态']) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <?= $form->field($model, 'author_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
