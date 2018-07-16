<?php
require 'public.php';

// 平台登陆商户号:0002900F0345142
// 平台登陆操作员代码:zha001
// 平台登陆密码:fuiou888
// 接口对接密钥:123456

set_time_limit(0);
define('MERCHANT_ID', '0002900F0345142');
define('APP_SECRET', '123456');


// project_input();
// 项目录入
function project_input() {
	$orderno = sprintf("%'05d%'05d",rand(0,99999),rand(0,99999));	// 请求流水 	c(10,30)	数字串，当天必须唯一
	$mchnt_nm = '代收付测试商户';		// 商户名称
	$project_ssn = sprintf("%'06d",rand(0,999999));	// 项目序列	项目序列号 000001 至 999999(同一商户每日不可重复)
// 	$project_nm = 'foo';			// 项目名称
// 	$project_usage = 'bar';		// 项目用途
	$project_amt = '23300';			// 项目金额	单位：分
// 	$expected_return = '3.23';	// 预计收益率	n(2,1)	范围 3%--36%，两位小数点，例：3.23%
// 	$project_fee = 100;			// 手续费		decimal(16,2)	不超过 4%
	$contract_nm = 'CONTRACT_NO';	// 商户借款合同编号		商户用于关联具体某一笔借款或贷款项目的编号。
	$project_deadline = '360';			// 项目期限	单位：天
// 	$raise_deadline = 30;		// 逾期期限 	单位：天	（1—180 以内正整数）
// 	$max_invest_amt = 1000000;	// 最高投资金额 	分为单位
// 	$max_invest_num = 100;		// 最大投资份数
// 	$min_invest_num = 50;		// 最小投资份数
// 	$each_invest_amt = 10000;	// 每份金额		分为单位
	$bor_nm = '李玉磊';				// 借款人姓名
// 	$bor_sex = '0';				// 借款人性别		0:男,1:女
// 	$bor_email = '1370416033@qq.com';	// 借款人邮箱
	$id_tp = '0';					// 借款人证件类型	见证件类型代码表
	$id_no = '321081199309052410';	// 借款人证件号码
	$card_no = '6228480393878363414';	// 借款人卡号
	$mobile_no = '15861800733';		// 借款人手机号码	协议库预留电话
	// $project_memo = 'bar'; 		// 项目概述
	// $project_desc = 'qux'; 		// 其他说明
	$xml = sprintf(
'<?xml version="1.0" encoding="utf-8" standalone="yes"?>
<project>
	<ver>1.00</ver>
	<orderno>%s</orderno>
	<mchnt_nm>%s</mchnt_nm>
	<project_ssn>%s</project_ssn>
	<project_amt>%s</project_amt>
	<contract_nm>%s</contract_nm>
	<project_deadline>%s</project_deadline>
	<max_invest_num>100</max_invest_num>
	<min_invest_num>100</min_invest_num>
	<bor_nm>%s</bor_nm>
	<id_tp>%s</id_tp>
	<id_no>%s</id_no>
	<card_no>%s</card_no>
	<mobile_no>%s</mobile_no>
</project>',$orderno,$mchnt_nm,$project_ssn,$project_amt,$contract_nm,$project_deadline,$bor_nm,$id_tp,$id_no,$card_no,$mobile_no);
// 	watch($xml);exit;
	
	$merid = MERCHANT_ID;
	$mac = md5($merid.'|'.APP_SECRET.'|'.$xml);
	$post_data = "merid={$merid}&xml={$xml}&mac={$mac}";
	// watch($post_data);exit;
	
	$ch = curl_init('https://fht-test.fuiou.com/fuMer/inspro.do');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$rt = curl_exec($ch);
	
	watch($rt);
	watch(curl_error($ch));
	record($rt, null, __DIR__.'/temp');
	curl_close($ch);
}


// charge();
// 代收
function charge() {
	// 参数
	$merdt = date('Ymd'); 		// 请求日期
	$orderno = sprintf("%'05d%'05d",rand(0,99999),rand(0,99999));	// 请求流水 	c(10,30)	数字串，当天必须唯一
	$bankno = '0103';			// 总行代码 	参见总行代码表
	$accntno = '6228480393878363414';	// 用户账号	c(10,28)
	$accntnm = '李玉磊'; 			// 账户名称	c(30)？
	$amt = '23300';				// 金额		单位：分
// 	$entseq = $orderno;			// 企业流水号	c(1,32)		填写后，系统体现在交易查询和外部通知中
// 	$memo = 'hhh';				// 备注		c(1,64)		填写后，系统体现在交易查询和外部通知中
	$mobile = '15861800733';	// 手机号		为将来短信通知时使用
	$certtp = '0';				// 证件类型 	发送交易到银行时用来做校验		0身份证,1护照,2军官证,3士兵证,5户口本,7其他
	$certno = '321081199309052410';	// 证件号		发送交易到银行时用来做校验
	$txncd = '06';				// 业务定义：贷款还款、逾期还款、债权转让、其他；（代收付 2.0 必填） 参见附录9.6
	$projectid = '0345142_20170707_396301';	// 项目 id c(10-29) 否 业务规则项目 id（代收付 2.0 必填
	$xml = sprintf(
'<?xml version="1.0" encoding="utf-8" standalone="yes"?>
<incomeforreq>
	<ver>2.00</ver>
	<merdt>%s</merdt>
	<orderno>%s</orderno>
	<bankno>%s</bankno>
	<accntno>%s</accntno>
	<accntnm>%s</accntnm>
	<amt>%s</amt>
	<mobile>%s</mobile>
	<certtp>%s</certtp>
	<certno>%s</certno>
	<txncd>%s</txncd>
	<projectid>%s</projectid>
</incomeforreq>',$merdt,$orderno,$bankno,$accntno,$accntnm,$amt,$mobile,$certtp,$certno,$txncd,$projectid);
// 	watch($xml);exit;
	
	$reqtype = 'sincomeforreq'; // 收款
	$merid = MERCHANT_ID;
	$mac = md5($merid.'|'.APP_SECRET.'|'.$reqtype.'|'.$xml);
	$post_data = "merid={$merid}&reqtype={$reqtype}&xml={$xml}&mac={$mac}";
// 	watch($post_data);exit;
	
	$ch = curl_init('https://fht-test.fuiou.com/fuMer/req.do');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$rt = curl_exec($ch);
	
	watch($rt);
	watch(curl_error($ch));
	record($rt, null, __DIR__.'/temp');
	curl_close($ch);
}


query();
// 代收
function query() {
	// 参数
	$ver = '1.00'; // 版本号 c(4) 否 1.00
	$busicd = 'AC01'; // 业务代码 c(4) 否
// 	$orderno = sprintf("%'05d%'05d",rand(0,99999),rand(0,99999));; //  原请求流水 c(10,30) 是
	$startdt = '20170706'; //  开始日期 c(8) 否
	$enddt = '20170706'; //  结束日期 c(8) 否 日期段不能超过 15 天
// 	$transst = ''; //  交易状态 c(1) 是
	$xml = sprintf(
'<?xml version="1.0" encoding="utf-8" standalone="yes"?>
<qrytransreq>
	<ver>%s</ver>
	<busicd>%s</busicd>
	<startdt>%s</startdt>
	<enddt>%s</enddt>
</qrytransreq>',$ver,$busicd,$startdt,$enddt);
// 	watch($xml);exit;

	$reqtype = 'qrytransreq'; // 收款
	$merid = MERCHANT_ID;
	$mac = md5($merid.'|'.APP_SECRET.'|'.$reqtype.'|'.$xml);
	$post_data = "merid={$merid}&reqtype={$reqtype}&xml={$xml}&mac={$mac}";
// 	watch($post_data);exit;

	$ch = curl_init('https://fht-test.fuiou.com/fuMer/req.do');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$rt = curl_exec($ch);

	watch($rt);
	watch(curl_error($ch));
// 	record($rt, null, __DIR__.'/temp');
	curl_close($ch);
}


// sign_query();
// 签约查询
function sign_query() {
	// 参数
	$ver = '1.00'; 
	$mchntCd = MERCHANT_ID; // 商户号 否 生产由富友提供，测试 faq 页面提供
	$contractNo = '000036257986'; // 协议号 否 富友签约标识(唯一)
	$startdt = '20170701'; // 开始日期 否 yyyyMMdd
	$enddt = '20170706'; // 结束日期 否 yyyyMMdd
	$mobileNo = '15861800733'; // 手机号 是 签约时提供手机号
	$userNm = '李玉磊'; // 账户名称 是 用户账户名称
	$acntNo = '6228480393878363414'; // 账号 是 用户账号
	$credtNo = '321081199309052410'; // 身份证号 是 用户身份证号
	$sign_temp = [$ver,$mchntCd,$contractNo,$startdt,$enddt,$mobileNo
		,$userNm,$acntNo,$credtNo
	];
// 	watch($sign_temp);exit;
	sort( $sign_temp, SORT_STRING ); // 字典序
	$sign_temp = implode('|', $sign_temp);
	$sign_temp = sha1($sign_temp);
	$sign_temp = $sign_temp.'|'.APP_SECRET;
	$signature = sha1($sign_temp); // 校验值 否 参见附录
	
	$xml = sprintf(
'<?xml version="1.0" encoding="utf-8" standalone="yes"?>
<custmrBusi>
<ver>%s</ver>
<mchntCd>%s</mchntCd>
<contractNo>%s</contractNo>
<startdt>%s</startdt>
<enddt>%s</enddt>
<mobileNo>%s</mobileNo>
<userNm>%s</userNm>
<acntNo>%s</acntNo>
<credtNo>%s</credtNo>
<signature>%s</signature>
</custmrBusi>',$ver,$mchntCd,$contractNo,$startdt,$enddt,$mobileNo,$userNm,$acntNo,$credtNo,$signature);
	$post_data = "xml=$xml";
// 	$post_data = http_build_query( ['xml'=>$xml] ); // url_encode
// 	watch($post_data);exit;	
	
	$api_url = 'https://fht-test.fuiou.com/fuMer/api_queryContracts.do'; // 测试
// 	$api_url = 'https://fht.fuiou.com/fuMer/api_queryContracts.do'; // 生产
	
	$ch = curl_init($api_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$rt = curl_exec($ch);
	
	watch($rt);
	watch(curl_error($ch));
	record($rt, null, __DIR__.'/temp');
	curl_close($ch);
}