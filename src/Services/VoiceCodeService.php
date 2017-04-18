<?php

namespace MsgService\Services;

/**
 * 短信发送接口
 */
interface VoiceCodeService
{
    public function send();

    public function setMobile($mobile);

    public function setContent($content);

    public function setCaptcha($captcha);
}
