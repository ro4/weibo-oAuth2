<?php
/**
 * 微博鉴权基类
 * 一些腾讯和新浪共同的抽象
 * @author Fan
 * @date 2014-8-28
 */
class BaseOauth {
	protected $_iType;	//类型，1为新浪，2为腾讯
	protected $_client_id;	//client_id app_key
	protected $_client_secret;	//申请应用时分配的app_secret
	protected $_redirect_url = 'http://www.yoururl.com/test/callback';
	protected $_response_type;	//应答类型
	protected $_sHost;	//鉴权固定地址
	protected $_apiHost; //api地址
	protected $_grant_type;	//authorization_code

	public function auth($isCallBack = NULL){
		$aParams = array(
			'client_id' => $this->_client_id,
			'redirect_uri' => $this->_redirect_url,
			'response_type' => $this->_response_type);
		$url = $this->_sHost.'/authorize?';
		$url .= http_build_query($aParams);
		header('location:'.$url);
	}

	public function getAuthToken($_code){
		$aParams = array(
			'client_id' => $this->_client_id,
			'client_secret' => $this->_client_secret,
			'grant_type' => $this->_grant_type,
			'code' => $_code,
			'redirect_uri' => $this->_redirect_url
			);
		$url = $this->_sHost.'/access_token?';
		$url .= http_build_query($aParams);
		$back = file_get_contents($url);
		$back = explode('&', $back);
		$back_para = array();
		foreach ($back as $value) {
			$tmp = explode('=', $value);
			$back_para[$tmp[0]] = $tmp [1];
		}
		return $back_para;
	}

	public function getUserInfo($token,$openid){
		$aParams = array(
				'oauth_consumer_key' =>$this->_client_id,
				'access_token' => $token,
				'openid' => $openid,
				'clientip' => getIp() //得到ip
		);
		$url = $this->_apiHost.'/user/info?';
		$url .= http_build_query($aParams);
		$url .= '&format=json&oauth_version=2.a&scope=all';//固定值
		$handle = fopen($url,"rb");
		$content = "";
		while (!feof($handle)) {
			$content .= fread($handle, 10000);
		}
		fclose($handle);
		$res = json_decode($content,true);
        return $res;
	}
}