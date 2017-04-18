<?php

namespace MsgService\Services\MiaoDi;

use MsgService\Services\MiaoDi\StatusCode;
use MsgService\Services\ShortMsgService as IShortMsgService;

/**
 * 秒嘀短信发送类
 */
class ShortMsgService implements IShortMsgService
{

    public $funAndOperate = 'industrySMS/sendSMS';
    public $mobile;
    public $content;

    public function __construct($options = [])
    {
        $this->debug = config('msgser.debug');
        $this->baseUrl = config('msgser.shortMsg.miaodi.baseUrl');
        $this->accountSid = config('msgser.shortMsg.miaodi.accountSid');
        $this->authToken = config('msgser.shortMsg.miaodi.authToken');

        // 注意时区问题，秒嘀 一定要设置为Asia/Shanghai
        $date = new \Datetime('now', new \DateTimeZone('Asia/Shanghai'));
        $this->timestamp = $date->format('YmdHis');

        foreach ($options as $option) {
            $this->$option = $option;
        }
    }

    /**
     * 创建url
     *
     * @param funAndOperate 请求的功能和操作
     * @return
     */
    private function createUrl()
    {
        return $this->baseUrl . $this->funAndOperate;
    }

    /**
     * 签名
     * @return type
     */
    private function createSig()
    {
        return md5($this->accountSid . $this->authToken . $this->timestamp);
    }

    private function createBasicAuthData()
    {
        // 签名
        $sig = $this->createSig();
        return [
            "accountSid" => $this->accountSid,
            "timestamp" => $this->timestamp,
            "sig" => $sig,
            "respDataType" => "JSON"
        ];
    }

    /**
     * 创建请求头
     * @param body
     * @return
     */
    private function createHeaders()
    {
        return [
            'Content-type: application/x-www-form-urlencoded',
            'Accept: application/json'
        ];
    }

    /**
     * 短信发送
     */
    public function send()
    {
        if ($this->debug) {
            return true;
        }

        $postData = [
            'smsContent' => sprintf("%s%s", $this->content, $this->signature),
            'to' => $this->mobile
        ];

        $body = array_merge($postData, $this->createBasicAuthData());

        // 要求post请求的消息体为&拼接的字符串，所以做下面转换
        $fieldsString = http_build_query($body);

        // 提交请求
        $con = curl_init();
        curl_setopt($con, CURLOPT_URL, $this->createUrl());
        curl_setopt($con, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($con, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($con, CURLOPT_HEADER, 0);
        curl_setopt($con, CURLOPT_POST, 1);
        curl_setopt($con, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($con, CURLOPT_HTTPHEADER, $this->createHeaders());
        curl_setopt($con, CURLOPT_POSTFIELDS, $fieldsString);
        $result = curl_exec($con);

        curl_close($con);

        $respond = json_decode($result);

        if(isset($respond->respCode) && $respond->respCode =='00000'){
            return $respond;
        }

        throw new \Exception(StatusCode::getMessage($respond->respCode));
    }

    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
        return $this;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function setCaptcha($captcha)
    {
        $this->captcha = $captcha;
        $this->content = $captcha. '(动态验证码)，请在3分钟内填写';
        return $this;
    }

    public function setSignature($signature)
    {
        $this->signature = sprintf("【%s】", $signature);
        return $this;
    }

}
