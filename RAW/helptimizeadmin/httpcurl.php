<?php

define('EMAIL_PATTERN', '/([\s]*)([_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*([ ]+|)@([ ]+|)([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,}))([\s]*)/i');

interface HttpScraper
{
	public function parse($body, $head);
}

class Scraper implements HttpScraper
{
	
	public function parse($body, $head)	{
	   if ($head == 200) {
		$p = preg_match_all(EMAIL_PATTERN, $body, $matches);
			if ($p) {
				foreach($matches[0] as $emails) {
					echo "<pre>";
					print_r($emails);	
					echo "<pre>";
				}
			}
		}
	}
}

class HttpCurl {
	protected $_cookie, $_parser, $_timeout;
	private $_ch, $_info, $_body, $_error;
	
	public function __construct($p = null) {
        if (!function_exists('curl_init')) {
            throw new Exception('cURL not enabled!');
        }	
		$this->setParser($p);
	}

	public function get($url) {	
		return $this->request($url);
	}

	protected function request($url) {
        $ch = curl_init($url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 5);		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $url);
		$this->_body = curl_exec($ch);
        $this->_info  = curl_getinfo($ch);
        $this->_error = curl_error($ch);
        curl_close($ch);

		$this->runParser($this->_body, $this->getStatus());				
    }

	public function getStatus() {
		return $this->_info[http_code];
	}
	
	public function getHeader() {
		return $this->_info;
	}

	public function getBody() {
		return $this->_body;
	}
	
	public function __destruct() {
	}	
	
	public function setParser($p)	{
		if ($p === null || $p instanceof HttpScraper || is_callable($p))	
			$this->_parser = $p;
	}

	public function runParser($content, $header)	{
		if ($this->_parser !== null)
		{
			if ($this->_parser instanceof HttpScraper)
				$this->_parser->parse($content, $header);	
			else
				call_user_func($this->_parser, $content, $header);
		}
	}	
}

?>