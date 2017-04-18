### 信息服务模块
秒滴短信，语音服务模块

##### Lumen 应用
在 bootstrap/app.php 中 82 行左右：

```
// bootstrap/app.php 中，添加
$app->register(MsgService\MsgServiceProvider::class);
```


####  短信发送使用说明
```
$sender->setMobile($mobile);        // 手机号
$sender->setContent($content);      // 短信内容
$sender->setSignature($signature);  // 频道签名，如：【点看宁波】、【视听襄阳】
$sender->send();
```

#### 发送短信验证码
```
$sender->setMobile($mobile);        // 手机号
$sender->setCaptcha($captcha);      // 短信验证码
$sender->setSignature($signature);  // 频道签名，如：【点看宁波】、【视听襄阳】
$sender->send();
```

#### 语音发送使用说明

$sender->setMobile($mobile);        // 手机号
$sender->setCaptcha($content);      // 验证码 4-8 位
$sender->send();
