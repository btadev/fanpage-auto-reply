<?php
/* class.check.php
 * Code by HTTZIP
 * Share on httzip.com
*/

class Check
{
	public $_token;
	public $_post_id;
	public $_link;
	public $_messID;
	public $_userID;
	public $_userName;
	public function __construct()
	{
		
	
	}
	public function check()
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->_link,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false
		));
		$get = curl_exec($curl);
		curl_close($curl);

		$decode = json_decode($get,JSON_UNESCAPED_UNICODE);
		if(!empty($decode['data'])){
			return $this->docheck($decode['data']);
	
		}else{
			return false;	
		}
	}
	public function doCheck($dataGraph)
	{
		foreach ($dataGraph['data'] as $data) {
				if(!empty($data['from']['id']))
				{
					$this->_userID = $data['from']['id'];
					$this->_messID = $data['id'];
					$this->_userName = $data['from']['name'];
					if( strpos(file_get_contents("list.txt"),$this->_messID) !== false) 
					{
						return false;
					}
					else
					{
						
						return array($this->saveID(),$this->reply());
					}
				}
				else{
					echo "Lỗi !!!";
				}
			}
	}
	public function saveID()
	{
		$list='list.txt';
		$file = fopen($list, 'a');
		fwrite($file,$this->_messID."\n");
		fclose($file);
		
	}
	public function reply()
	{
		$reply = "https://graph.facebook.com/".$this->_messID."/comments?message=Xin+Chào+@[".$this->_userID."]+vui+lòng+inbox+để+nhận+link+nhé+!&method=POST&access_token=".$this->_token;
		$curlrep = curl_init();
		curl_setopt_array($curlrep, array(
			CURLOPT_URL => $reply,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false
		));
		$res = curl_exec($curlrep);
		curl_close($curlrep);
		echo "Đã trả lời bình luận của ".$this->_userName;
	}
}