<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput();  ?>
<!--                --><?//= $form->field($model, 'password')->passwordInput()->hint('测试底部提示');  ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

<!--            //listbox-->
            <?= $form->field($model, 'rememberMe')->listBox(['0'=>'box1','1'=>'box2']) ?>

<!--            //多谢框列表，常用-->
            <?= $form->field($model, 'rememberMe')->checkboxList(['0'=>'box1','1'=>'box2']) ?>

<!--            //单选框列表，常用-->
            <?= $form->field($model, 'rememberMe')->radioList(['0'=>'radio1','1'=>'radio2'])?>

<!--            //下拉框列表-->
            <?= $form->field($model, 'rememberMe')->dropDownList(
                ['1'=>'下拉选项1','2'=>'下拉选项2'],
                ['prompt' => '请选择']
            ) ?>

<!--            //插件组件应用，比如yii2编辑器插件，图片上传插件-->
            <?= $form->field($model,'rememberMe')->widget(yii\captcha\Captcha::className())?>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
