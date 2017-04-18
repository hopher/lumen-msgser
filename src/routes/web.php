<?php

// 验证码通知短信
$app->post('/shortmsgs', 'ShortMsgController@store');
// 语音验证码
$app->post('/voicecodes', 'VoiceCodeController@store');
