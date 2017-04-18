<?php

namespace MsgService\Services\MiaoDi;

use StatusCode;
use MsgService\Services\VoiceCodeService as IVoiceCodeService;

/**
 * 秒嘀短信发送类
 *
 * @see http://www.miaodiyun.com/doc/https_voice.html
 */
class VoiceCodeService implements IVoiceCodeService
{

    public $playTimes = 3;
    public $callDisplayNumber = '075552823298';

    public function __construct($options = [])
    {
        $this->debug = config('msgService.debug');
        $this->baseUrl = config('msgService.voiceCode.miaodi.baseUrl');
        $this->accountSid = config('msgService.voiceCode.miaodi.accountSid');
        $this->authToken = config('msgService.voiceCode.miaodi.authToken');

        foreach ($options as $option) {
            $this->$option = $option;
        }
    }

    /**
     * 短信发送
     */
    public function send()
    {

        if ($this->debug) {
            return true;
        }

        $headers = ['Content-Type: application/x-www-form-urlencoded'];

        $date = new \Datetime('now', new \DateTimeZone('Asia/Shanghai'));
        $timestamp = $date->format('YmdHis');

        $fields = array(
            'accountSid' => $this->accountSid,
            'verifyCode' => $this->captcha,
            'called' => $this->mobile,
            'callDisplayNumber' => $this->callDisplayNumber,
            'playTimes' => $this->playTimes,
            'timestamp' => $timestamp,
            'sig' => md5($this->accountSid . $this->authToken . $timestamp),
            'respDataType' => 'JSON'
        );

        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));

        $result = curl_exec($ch);

        // Close connection
        curl_close($ch);

        $respond = json_decode($result);

        if (isset($respond->respCode) && $respond->respCode == '00000') {
            return $respond;
        }
        
        throw new \Exception(StatusCode::getMessage($respond->respCode), $respond->respCode);
    }

    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
        return $this;
    }

    public function setCaptcha($captcha)
    {
        $this->captcha = $captcha;
        return $this;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function setSignature($signature)
    {
        $this->signature = sprintf("【%s】", $signature);
        return $this;
    }

}
