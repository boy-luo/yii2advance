<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class MagictestController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
//        var_dump(90);
//        exit();
        $this->nomethod();

        echo '<br>';
        echo '<br>';
        var_dump($this->noattribut);
        $this->noattribut = '不存在属性';
        unset($this->noattribut);

        echo '<br>';
        echo '<br>';
        $temp = $this->noattribut;


        echo '<br>';
        echo '<br>';
        echo $this;


        echo '<br>';
        echo '<br>';
        var_dump(serialize([1, 2, 3]));
        var_dump(unserialize(serialize([1, 2, 3])));

//        var_dump(serialize($this));
//        var_dump(unserialize(serialize($this)));

        self::teststatic();

        $temp = clone $this;



        $this->MagictestController();

        var_export($this);


        var_dump($this);
        var_dump('.');
        exit();
        return $this->render('index');
    }


    // todo: 失败
    // todo: 失败
    // todo: 失败
    public static function __callStatic($name, $arguments)
    {

        var_dump('调用静态方法的方式调用正常方法??');

        // TODO: Implement __callStatic() method.
    }

    // todo: 失败
    // todo: 失败
    // todo: 失败
    // 这个方法报错  Call to a member function getUniqueId() on null
    //     public function __construct() {
////    private function __construct() {
////         parent::__construct();
//
//        var_dump('构造方法  运行开始');
//    }

    function teststatic()
    {

        var_dump('测试调用静态方法的方式调用正常方法');
    }

    public function __destruct()
    {
        var_dump(' __destruct 析构方法  运行结束');
        // TODO: Implement __destruct() method.
    }

    public function __call($name, $arguments)
    {
        var_dump(' __call 你确定方法存在??', $name, $arguments);
        return '';
        // TODO: Implement __call() method.
    }

    public function __get($name)
    {

        echo ' __get 你确定属性存在?? : ' . $name;
        return '';
        // TODO: Implement __get() method.
    }

    public function __set($name, $value)
    {
        echo '__set 你确定属性存在?? : ' . $name;
        return '';
        // TODO: Implement __set() method.
    }

    public function __isset($name)
    {
        echo '__isset 不存在: ' . $name;
        return '';
        // TODO: Implement __isset() method.
    }

    public function __unset($name)
    {
        echo '__unset 不存在: ' . $name;
        return '';

        // TODO: Implement __unset() method.
    }

// 方法常用于提交未提交的数据，或类似的清理操作。同时，如果有一些很大的对象，但不需要全部保存，这个功能就很好用。
// serialize() 函数会检查类中是否存在一个魔术方法 __sleep()
    public function __sleep()
    {
        echo '__sleep 调用 serialize';
        return [2,2,6];
        // TODO: Implement __sleep() method.
    }

// 经常用在反序列化操作中，例如重新建立数据库连接，或执行其它初始化操作。
    // 内类推上面的 这就是 unserialize()时调用
    public function __wakeup()
    {
        echo '__wakeup 调用 unserialize';
        return '';
        // TODO: Implement __wakeup() method.
    }

// 方法用于一个类被当成字符串时应怎样回应。
    public function __toString()
    {

        echo '__toString 对象用作字符串了';
        return '';
        // TODO: Implement __toString() method.
    }


    // 当尝试以调用函数的方式调用一个对象时，__invoke() 方法会被自动调用。
    public function __invoke()
    {

        var_dump('__invoke 这是对象 不是方法');
        // TODO: Implement __invoke() method.
    }

    public function __debugInfo()
    {

        echo '__debugInfo 正在使用 var_dump 打印类(的属性).';
        return [36,36,66];
        // TODO: Implement __debugInfo() method.
    }

// 自 PHP 5.1.0 起当调用 var_export() 导出类时，此静态 方法会被调用。
    public static function __set_state($an_array)
    {
        var_dump('__set_state 正在导出类.');
        // TODO: Implement __set_state() method.
    }

    public function __clone()
    {
        var_dump('__clone 正在??');
        // TODO: Implement __clone() method.
    }


}
