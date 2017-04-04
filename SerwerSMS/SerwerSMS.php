<?php

namespace SerwerSMS\SerwerSMSBundle\SerwerSMS;

class SerwerSMS {

	public $username;

	public $password;

	public $api_url;

	public $format;

	public $messages;

	public $files;

	public $premium;

	public $account;

	public $senders;

	public $groups;

	public $contacts;

	public $phones;

	public $subaccounts;

	public $blacklist;

	public $payments;

	public $stats;

	public $tamplates;

	public $error;
    
    public $config;
  
    
	public function __construct($username = null , $password = null,$api_url = 'https://api2.serwersms.pl/', $format = 'json') {
        
        $this->setConfig($username,$password,$api_url,$format);  
		$this->messages = new Messages($this);
		$this->files = new Files($this);
		$this->premium = new Premium($this);
		$this->account = new Account($this);
		$this->senders = new Senders($this);
		$this->groups = new Groups($this);
		$this->contacts = new Contacts($this);
		$this->phones = new Phones($this);
		$this->subaccounts = new Subaccounts($this);
		$this->blacklist = new Blacklist($this);
		$this->payments = new Payments($this);
		$this->stats = new Stats($this);
		$this->templates = new Templates($this);
		$this->error = new Error($this);
            
	}

	public function call($url, $params = array()) {

		$params['username'] = $this->username;
		$params['password'] = $this->password;
		$params['system']   = 'symfony2';
		$curl = curl_init($this->api_url . $url . '.' . $this->format);

		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		$answer = curl_exec($curl);
        //die(var_dump($answer,$this->username,$this->password));
		if (curl_errno($curl)) {
			throw new Exception('Failed call: ' . curl_error($curl) . ' ' . curl_errno($curl));
		}
		curl_close($curl);

		if ($this->format == 'xml') {
            $result = simplexml_load_string($answer);
            if(isset($result->code) and isset($result->type) and isset($result->message)){
                throw new \Exception($result->message,(int) $result->code);
            }
        } else {
            $result = json_decode($answer);
            if(isset($result->error)){
                throw new \Exception($result->error->message,(int) $result->error->code);
            }
        }
        return $result;
	}
    private function setConfig($username,$password,$api_url,$format){
        
        if (!$username) {
			throw new \Exception('Username is empty');
		}

		if (!$password) {
			throw new \Exception('Password is empty');
		}
        
        $this->username = $username;
		$this->password = $password;
        $this->api_url =  $api_url;
        $this->format =   $format;

    }
}