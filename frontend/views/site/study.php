<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\bootstrap\Carousel;
use yii\bootstrap\Tabs;
use yii\bootstrap\Alert;
use yii\bootstrap\Nav;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;

$user = '直接 test';
?>
<div class="site-login">

    <div class="row">
        <div class="col-lg-5">

            <script src="http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script>

            <div id="wx_login"></div>

            <script type="text/javascript">
                var obj = new WxLogin({
                    id:"wx_login",
                    appid: "appid",
                    scope: "snsapi_login",
                    redirect_uri: "http%3A%2F%2Fwww.yourhost.com%2Fcallback",
                    state: "state",
                    style: "",
                    href: "https://www.yourhost.com/css/qr-style.css"
                });
            </script>

            <br>
            <br>
            <?= Html::tag('p', Html::encode('test tag'), ['class' => 'username']);
            $options = ['class' => 'btn btn-default'];
            $type = 1;;
            if ($type === 'success') {
                Html::removeCssClass($options, 'btn-default');
                Html::addCssClass($options, 'btn-success');
            }

            echo Html::tag('div', 'Pwede na', $options);

            ?>

            <?= Html::style('.danger { color: #f00; }') ?>

            Gives you

            <style>.danger { color: #f00; }</style>


            <?= Html::script('alert("Hello!");', ['defer' => true]);?>

Gives you

<script defer>alert("Hello!");</script>


            <?= Html::label('User name', 'username', ['class' => 'label username']) ?>
<!--            --><?//= Html::activeLabel($user, 'username', ['class' => 'label username']) ?>

            <br>
            <br>
            <br>
            <?php
            Modal::begin([
                             'id' => 'page-modal',
                             'header' => '<h5>这里是标题</h5>',
                             'toggleButton' => ['label' => 'click me'],
                         ]);

            echo '这里是模态内容...';

            Modal::end();
            ?>
            <?= Html::a('点击按钮', '#', [
                'class' => 'btn btn-success',
                'data-toggle' => 'modal',
                'data-target' => '#page-modal'    //此处对应Modal组件中设置的id
            ])
            ?>
            <img src="../web/img/pic.jpg"/>
            <img src=".//pic.jpg"/>

            <?php echo Carousel::widget([
                                            'items' => [
                                                // 只有图片的格式
                                                '<img src="../web/img/pic.jpg"/>',

                                                // 与上面的效果一致
                                                ['content' => '<img src="../web/img/pic.jpg"/>'],

                                                // 包含图片和字幕的格式
                                                [
                                                    'content' => '<img src="../web/img/pic.jpg"/>',
                                                    'caption' => '<h4>This is title</h4><p>This is the caption text</p>',
                                                    //'options' => [...],       //配置对应的样式
                                                ],
                                            ]
                                        ]);

                       /* [
                 // 必要的，轮播的内容（HTML），比如一个图像标签
                 'content' => '<img src="http://www.yii-china.com/statics/images/b_1.jpg'/>

                // 可选的，该轮播标题（HTML）
                 'caption' => '<h4>This is title</h4><p>This is the caption text</p>',

                 // 可选的，轮播样式
                 'options' => [],
            ]*/

echo Tabs::widget([
  'items' => [
      [
          'label' => 'One',
          'content' => 'Anim pariatur cliche...',
          'active' => true
      ],
      [
          'label' => 'Two',
          'content' => 'Anim pariatur cliche...',
          // 'headerOptions' => [...],
          'options' => ['id' => 'myveryownID'],
      ],
      [
          'label' => 'Example',
          'url' => 'http://www.example.com',
      ],
      [
          'label' => 'Dropdown',
          'items' => [
               [
                   'label' => 'DropdownA',
                   'content' => 'DropdownA, Anim pariatur cliche...',
               ],
               [
                   'label' => 'DropdownB',
                   'content' => 'DropdownB, Anim pariatur cliche...',
               ],
          ],
      ],
  ],
]);

echo Alert::widget([
  'options' => [
          'id' => 'alert1',
      'class' => 'alert-info',
  ],
  'body' => '保存失败！',
]);

            Alert::begin([
                             'options' => [
                                 'id' => 'alert12',
                                 'class' => 'alert-warning',
                             ],
                         ]);
            echo '保存失败！';
            Alert::end();


            echo Nav::widget([
                                 'items' => [
                                     [
                                         'label' => 'Home',
                                         'url' => ['site/index'],
                                         'linkOptions' => ['class'=>'style'],  //设置链接的样式
                                     ],
                                     [
                                         'label' => 'Dropdown',
                                         'items' => [
                                             ['label' => 'Level 1 - Dropdown A', 'url' => '#'],
                                             '<li class="divider"></li>',
                                             '<li class="dropdown-header">Dropdown Header</li>',
                                             ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
                                         ],
                                     ],
                                     [
                                         'label' => 'Login',
                                         'url' => ['site/login'],
                                         'visible' => Yii::$app->user->isGuest
                                     ],
                                 ],
                                 'options' => ['class' =>'nav-pills'], // 设置导航的样式
                             ]);

            echo '<br>';
            use yii\bootstrap\ButtonGroup;
            use yii\bootstrap\Button;

            // a button group with items configuration
            echo ButtonGroup::widget([
                                         'buttons' => [
                                             ['label' => '按钮A'],
                                             ['label' => '按钮B'],
                                             ['label' => '隐藏按钮C', 'visible' => false],
                                         ]
                                     ]);
            echo '<br>';
            // button group with an item as a string
            echo ButtonGroup::widget([
                                         'buttons' => [
                                             Button::widget(['label' => '按钮A']),
                                             ['label' => '按钮B'],
                                         ]
                                     ]);
            echo '<br>';
            use yii\bootstrap\ButtonDropdown;

            echo ButtonDropdown::widget([
                                            'label' => 'Action',
                                            'dropdown' => [
                                                'items' => [
                                                    ['label' => 'DropdownA', 'url' => '/'],
                                                    ['label' => 'DropdownB', 'url' => '#'],
                                                ],
                                            ],
                                        ]);



            ?>
<!--            --><?//=$form->field($model, 'pics')->widget('common\widgets\batch_upload\FileUpload')?>

        </div>
    </div>
</div>
<script>
    setTimeout(function() {
        $('#alert1').slideUp(500);
        $('#alert12').slideUp(500);
    }, 3000);
</script>
