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
        $allStatus = Poststatus::find()
        ->select(['name','id'])
        ->orderBy('position')
        ->indexBy('id')
        ->column();
        */
    $allStatus = Poststatus::find();
    var_dump($allStatus);
    /**
     *object(yii\db\ActiveQuery)[72]
     * public 'sql' => null
     * public 'on' => null
     * public 'joinWith' => null
     * public 'select' => null
     * public 'selectOption' => null
     * public 'distinct' => null
     * public 'from' => null
     * public 'groupBy' => null
     * public 'join' => null
     * public 'having' => null
     * public 'union' => null
     * public 'params' =>
     * array (size=0)
     * empty
     * private '_events' (yii\base\Component) =>
     * array (size=0)
     * empty
     * private '_behaviors' (yii\base\Component) =>
     * array (size=0)
     * empty
     * public 'where' => null
     * public 'limit' => null
     * public 'offset' => null
     * public 'orderBy' => null
     * public 'indexBy' => null
     * public 'modelClass' => string 'common\models\Poststatus' (length=24)
     * public 'with' => null
     * public 'asArray' => null
     * public 'multiple' => null
     * public 'primaryModel' => null
     * public 'link' => null
     * public 'via' => null
     * public 'inverseOf' => null
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
