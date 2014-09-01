<?php
require_once("baseOauth.class.php");
/**
 * 腾讯微博鉴权类
 * @author Fan
 * @date 2014-8-28
 */
class TencentOauth extends BaseOauth{
	protected $_sAppKey = 'YOURAPPKEY';
	protected $_sAppSecret = 'YOURAPPSECRET';

	function __construct($sToken = NULL, $sSecret = NULL, $iApptype = 2) {
		$this->iType = 2;
		$this->_client_id = $this->_sAppKey;
		$this->_client_secret = $this->_sAppSecret;
		$this->_sHost = 'https://open.t.qq.com/cgi-bin/oauth2';
		$this->_apiHost = 'https://open.t.qq.com/api';
		$this->_response_type = 'code';
		$this->_grant_type = 'authorization_code';
	}
}