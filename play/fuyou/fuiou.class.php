<?php

define('FUIOU_MERCHANT_ID', '0002900F0345142');
define('FUIOU_APP_SECRET', '123456');
define('FUIOU_MERCHANT_NAME', '沃邦贷');
define('FUIOU_PROJECT_INPUT_API', 'https://fht-test.fuiou.com/fuMer/inspro.do');
define('FUIOU_REQ_API', 'https://fht-test.fuiou.com/fuMer/req.do');

/*
 * 富友代扣接口
 */
if (!defined('IN_ECM')) die('forbidden');
 
class Fuiou {
	
	private $merchant_id; // 商户号
	private $app_secret; // 秘钥
	private $bankno = array(
		'中国工商银行' => 0102,
		'中国农业银行' => 0103,
		'中国银行' => 0104,
		'中国建设银行' => 0105, 
	);
	
	function __construct($merchant_id=FUIOU_MERCHANT_ID,$app_secret=FUIOU_APP_SECRET) {
		$this->merchant_id = $merchant_id;
		$this->app_secret = $app_secret;
		$this->cache = cache_server()->_redis();
	}
	
	/*
	 * 项目录入
	 * $project_amt
	 * $contract_nm
	 * $bor_nm
	 * $id_tp
	 * $id_no
	 * $card_no
	 * $mobile_no
	 */
	function project_input( $params ) {
		extract($params);
		$orderno = date(Ymdhis).sprintf("%'6d",$this->make_inc_num('orderno'));	// 请求流水 	c(10,30)	数字串，当天必须唯一
		$mchnt_nm = FUIOU_MERCHANT_NAME;		// 商户名称
		$project_ssn = $this->make_inc_num('project_ssn');	// 项目序列	项目序列号 000001 至 999999(同一商户每日不可重复)
// 		$project_amt = '23300';			// 项目金额	单位：分
// 		$contract_nm = 'CONTRACT_NO';	// 商户借款合同编号		商户用于关联具体某一笔借款或贷款项目的编号。
		$project_deadline = '360';		// 项目期限	单位：天
// 		$bor_nm = '李玉磊';				// 借款人姓名
// 		$id_tp = '0';					// 借款人证件类型	见证件类型代码表
// 		$id_no = '321081199309052410';	// 借款人证件号码
// 		$card_no = '6228480393878363414';	// 借款人卡号
// 		$mobile_no = '15861800733';		// 借款人手机号码	协议库预留电话
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
	<max_invest_num>1</max_invest_num>
	<min_invest_num>1</min_invest_num>
	<bor_nm>%s</bor_nm>
	<id_tp>%s</id_tp>
	<id_no>%s</id_no>
	<card_no>%s</card_no>
	<mobile_no>%s</mobile_no>
</project>',$orderno,$mchnt_nm,$project_ssn,$project_amt,$contract_nm,$project_deadline,$bor_nm,$id_tp,$id_no,$card_no,$mobile_no);
	
		$merid = MERCHANT_ID;
		$mac = md5($merid.'|'.APP_SECRET.'|'.$xml);
		$post_data = "merid={$merid}&xml={$xml}&mac={$mac}";
	
		$ch = curl_init( FUIOU_PROJECT_INPUT_API );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$rt = curl_exec($ch);
		curl_close($ch);
		$rt = xmlToArray($rt);
		
// 		Array
// 		(
// 				[ret] => 0000
// 				[orderno] => 4757639181
// 				[project_id] => 0345142_20170706_850219
// 				[memo] => 项目录入成功
// 		)
		return $rt;
	}
	
	
	/*
	 * 代收
	 * $bankno
	 * $accntno
	 * $accntnm
	 * $amt
	 * $mobile
	 * $certtp
	 * $certno
	 * $txncd ？
	 * $projectid
	 */ 
	function charge($params) {
		// 参数
		extract($params);
		$merdt = date('Ymd'); 		// 请求日期
		$orderno = date(Ymdhis).sprintf("%'6d",$this->make_inc_num('orderno'));	// 请求流水 	c(10,30)	数字串，当天必须唯一
		$bankno = $this->bankno[$bankno];			// 总行代码 	参见总行代码表
// 		$accntno = '6228480393878363414';	// 用户账号	c(10,28)
// 		$accntnm = '李玉磊'; 			// 账户名称	c(30)？
// 		$amt = '23300';				// 金额		单位：分
// 		$mobile = '15861800733';	// 手机号		为将来短信通知时使用
// 		$certtp = '0';				// 证件类型 	发送交易到银行时用来做校验		0身份证,1护照,2军官证,3士兵证,5户口本,7其他
// 		$certno = '321081199309052410';	// 证件号		发送交易到银行时用来做校验
		$txncd = '06';				// 业务定义：贷款还款、逾期还款、债权转让、其他；（代收付 2.0 必填） 参见附录9.6
// 		$projectid = '0345142_20170707_396301';	// 项目 id c(10-29) 否 业务规则项目 id（代收付 2.0 必填
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
	
		$reqtype = 'sincomeforreq'; // 收款
		$merid = MERCHANT_ID;
		$mac = md5($merid.'|'.APP_SECRET.'|'.$reqtype.'|'.$xml);
		$post_data = "merid={$merid}&reqtype={$reqtype}&xml={$xml}&mac={$mac}";
	
		$ch = curl_init( FUIOU_REQ_API );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$rt = curl_exec($ch);
		curl_close($ch);
		$rt = xmlToArray($rt);
		
		return $rt;
	}
	
	/* 
	 * 代收
	 * $startdt
	 * $enddt
	 */
	function query() {
		// 参数
		$ver = '1.00'; // 版本号 c(4) 否 1.00
		$busicd = 'AC01'; // 业务代码 c(4) 否
// 		$orderno = sprintf("%'05d%'05d",rand(0,99999),rand(0,99999)); //  原请求流水 c(10,30) 是
		$startdt = '20170706'; //  开始日期 c(8) 否
		$enddt = '20170706'; //  结束日期 c(8) 否 日期段不能超过 15 天
// 		$transst = ''; //  交易状态 c(1) 是
		$xml = sprintf(
'<?xml version="1.0" encoding="utf-8" standalone="yes"?>
<qrytransreq>
	<ver>%s</ver>
	<busicd>%s</busicd>
	<startdt>%s</startdt>
	<enddt>%s</enddt>
</qrytransreq>',$ver,$busicd,$startdt,$enddt);
	
		$reqtype = 'qrytransreq'; // 收款
		$merid = MERCHANT_ID;
		$mac = md5($merid.'|'.APP_SECRET.'|'.$reqtype.'|'.$xml);
		$post_data = "merid={$merid}&reqtype={$reqtype}&xml={$xml}&mac={$mac}";
	
		$ch = curl_init( FUIOU_REQ_API );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$rt = curl_exec($ch);
		curl_close($ch);
		$rt = xmlToArray($rt);
		return $rt;
	}
	
	
	/*
	 * 一天内 生成递增的序号 1-999999
	 */
	private function make_inc_num($key) {
		$date = date('Ymd');
		for( $i=0; $i<3; $i++ ) { // try 3 times
			$lock = $this->cache->setnx($key.'_lock', 1); // 加锁
			if ( $lock ) {
				$this->cache->expire($key.'_lock', 1); // 1s过期防止死锁
				$number = $this->cache->get($key.'_'.$date);
				$number || $number=0;
				$number++;
				$this->cache->set($key.'_'.$date, $number);
				$this->cache->del($key.'_lock');
				return $number; 
			} else {
				usleep(100*1000); // 0.1s
			}
		}
		return false;
	}
	
	private function xmlToArray($xml){
		//禁止引用外部xml实体
		libxml_disable_entity_loader(true);
		$xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
		$val = json_decode(json_encode($xmlstring),true);
		return $val;
	}
	
}