<?php
include_once dirname(dirname(__FILE__)) . '/public/public.php';
require LIB_PATH.'/PHPMailer-master/PHPMailerAutoload.php';
set_time_limit(0);

header('Content-Type:text/html;Charset=utf-8');
$mail = new PHPMailer;
$mail->isSMTP();                                      // 设置邮件使用SMTP
$mail->Host = 'smtp.exmail.qq.com';                     // 邮件服务器地址
$mail->SMTPAuth = true;                               // 启用SMTP身份验证
$mail->CharSet = "UTF-8";                             // 设置邮件编码
$mail->setLanguage('zh_cn');                          // 设置错误中文提示
$mail->Username = 'li.yulei@njswtz.com';              // SMTP 用户名，即个人的邮箱地址
$mail->Password = 'Liyulei1993';                        // SMTP 密码，即个人的邮箱密码
$mail->SMTPSecure = 'tls';                            // 设置启用加密，注意：必须打开 php_openssl 模块
$mail->Priority = 3;                                  // 设置邮件优先级 1：高, 3：正常（默认）, 5：低
$mail->From = 'li.yulei@njswtz.com';                 // 发件人邮箱地址
$mail->FromName = 'Salvare000';                     // 发件人名称
$mail->addAddress('1370416033@qq.com', 'Lee');     // 添加接受者
// $mail->addAddress('ellen@example.com');               // 添加多个接受者
// $mail->addReplyTo('info@example.com', 'Information'); // 添加回复者
// $mail->addCC('mail2@sina.com');                // 添加抄送人
// $mail->addCC('mail3@qq.com');                     // 添加多个抄送人
// $mail->ConfirmReadingTo = 'liruxing@wanzhao.com';     // 添加发送回执邮件地址，即当收件人打开邮件后，会询问是否发生回执
// $mail->addBCC('mail4@qq.com');                    // 添加密送者，Mail Header不会显示密送者信息
// $mail->WordWrap = 50;                                 // 设置自动换行50个字符
// $mail->addAttachment('./1.jpg');                      // 添加附件
// $mail->addAttachment('/tmp/image.jpg', 'one pic');    // 添加多个附件
$mail->isHTML(true);                                  // 设置邮件格式为HTML
$mail->Subject = 'Here is the 主题';
$mail->Body    = 'This is the HTML 信息 body <b style="color:red">hhhhh</b>. Time:'.date('Y-m-d H:i:s');
$mail->AltBody = 'This is the 主体 in plain text for non-HTML mail clients';

if(!$mail->send()) {
	echo 'Message could not be sent.';
	echo 'Mailer Error: ' . $mail->ErrorInfo;
	exit;
}

echo 'Message has been sent';
