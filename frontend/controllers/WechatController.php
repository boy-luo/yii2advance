<?php
namespace frontend\controllers;
//namespace frontend\api\controllers;

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

use yii\rest\ActiveController;
class WechatController extends ActiveController
{

    public $modelClass = '';

    public function actionValid()
    {
        $echoStr = $_GET["echostr"];
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        //valid signature , option
        if($this->checkSignature($signature,$timestamp,$nonce)){
            echo $echoStr;
        }
    }

    private function checkSignature($signature,$timestamp,$nonce)
    {
        // you must define TOKEN by yourself
        $token = Yii::$app->params['wechat']['token'];
        if (!$token) {
            echo 'TOKEN is not defined!';
        } else {
            $tmpArr = array($token, $timestamp, $nonce);
            // use SORT_STRING rule
            sort($tmpArr, SORT_STRING);
            $tmpStr = implode( $tmpArr );
            $tmpStr = sha1( $tmpStr );

            if( $tmpStr == $signature ){
                return true;
            }else{
                return false;
            }
        }
    }
    public function actionAccesstoken()
    {
        $code = $_GET["code"];
        $state = $_GET["state"];
        $appid = Yii::$app->params['wechat']['appid'];
        $appsecret = Yii::$app->params['wechat']['appsecret'];
        $request_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$appsecret.'&code='.$code.'&grant_type=authorization_code';

        //初始化一个curl会话
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $request_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = $this->response($result);

        //获取token和openid成功，数据解析
        $access_token = $result['access_token'];
        $refresh_token = $result['refresh_token'];
        $openid = $result['openid'];

        //请求微信接口，获取用户信息
        $userInfo = $this->getUserInfo($access_token,$openid);
        $user_check = WechatUser::find()->where(['openid'=>$openid])->one();
        if ($user_check) {
            //更新用户资料
        } else {
            //保存用户资料
        }

        //前端网页的重定向
        if ($openid) {
            return $this->redirect($state.$openid);
        } else {
            return $this->redirect($state);
        }
    }
    public function getUserInfo($access_token,$openid)
    {
        $request_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
        //初始化一个curl会话
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $request_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = $this->response($result);
        return $result;
    }
    public function actionUserinfo()
    {
        if(isset($_REQUEST["openid"])){
            $openid = $_REQUEST["openid"];
            $user = WechatUser::find()->where(['openid'=>$openid])->one();
            if ($user) {
                $result['error'] = 0;
                $result['msg'] = '获取成功';
                $result['user'] = $user;
            } else {
                $result['error'] = 1;
                $result['msg'] = '没有该用户';
            }
        } else {
            $result['error'] = 1;
            $result['msg'] = 'openid为空';
        }
        return $result;
    }

    public function actionPay(){
        if(isset($_REQUEST["uid"])&&isset($_REQUEST["oid"])&&isset($_REQUEST["totalFee"])){
            //uid、oid、totalFee
            $uid = $_REQUEST["uid"];
            $oid = $_REQUEST["oid"];
            $totalFee = $_REQUEST["totalFee"];
            $timestamp = time();

            //微信支付参数
            $appid = Yii::$app->params['wechat']['appid'];
            $mchid = Yii::$app->params['wechat']['mchid'];
            $key = Yii::$app->params['wechat']['key'];
            $notifyUrl = Yii::$app->params['wechat']['notifyUrl'];

            //支付打包
            $wx_pay = new WechatPay($mchid, $appid, $key);
            $package = $wx_pay->createJsBizPackage($uid, $totalFee, $oid, $notifyUrl, $timestamp);
            $result['error'] = 0;
            $result['msg'] = '支付打包成功';
            $result['package'] = $package;
            return $result;
        }else{
            $result['error'] = 1;
            $result['msg'] = '请求参数错误';
        }
        return $result;
    }

    // 2.接收微信发送的异步支付结果通知
    public function actionNotify(){
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        //
        if ($postObj === false) {
            die('parse xml error');
        }
        if ($postObj->return_code != 'SUCCESS') {
            die($postObj->return_msg);
        }
        if ($postObj->result_code != 'SUCCESS') {
            die($postObj->err_code);
        }

        //微信支付参数
        $appid = Yii::$app->params['wechat']['appid'];
        $mchid = Yii::$app->params['wechat']['mchid'];
        $key = Yii::$app->params['wechat']['key'];
        $wx_pay = new WechatPay($mchid, $appid, $key);

        //验证签名
        $arr = (array)$postObj;
        unset($arr['sign']);
        if ($wx_pay->getSign($arr, $key) != $postObj->sign) {
            die("签名错误");
        }

        //支付处理正确-判断是否已处理过支付状态
        $orders = Order::find()->where(['uid'=>$postObj->openid, 'oid'=>$postObj->out_trade_no, 'status' => 0])->all();

        if(count($orders) > 0){
            //更新订单状态
            foreach ($orders as $order) {
                //更新订单
                $order['status'] = 1;
                $order->update();
            }
            return '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
        } else {
            //订单状态已更新，直接返回
            return '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
        }
    }
}