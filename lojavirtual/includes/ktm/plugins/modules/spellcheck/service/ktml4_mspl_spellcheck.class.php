<?php
/**
 * KTML4 spellchecker module.
 * @access protected
 */
class ktml4_mspl_spellcheck {
	/**
	 * The error object.
	 * @var KTML4 error object
	 * @access private
	 */
	var $errorObj;
	
	/**
	 * Absolute path of the root folder for file operations (needed to save temporary files).
	 * @var string
	 * @access private
	 */
	var $folderName;
	
	/**
	 * Encoding of this module's output.
	 * @var string
	 * @access private
	 */
	var $outEncoding;
	
	/**
	 * Constructor.
	 * @access public
	 */
	function ktml4_mspl_spellcheck() {
		$this->errorObj = NULL;
		$this->folderName = KT_RealPath($GLOBALS['KTML4_aspellTempPath'],true);
		$this->outEncoding = 'UTF-8';
	}
	
	/**
	 * Retrieve a list of currently available dictionaries.
	 * @return array available dictionaries
	 * @access public
	 */
	function listlanguages() {
		$languages = array();
		
		if (isset($GLOBALS['KTML4_GLOBALS']['online_interakt_spellcheck']) && $GLOBALS['KTML4_GLOBALS']['online_interakt_spellcheck'] === 'true') {
			foreach ($GLOBALS['KTML4_languagelist'] as $key => $lang) {
				if ($lang[0]=='ro') {
					continue;
				} else if ($lang[0]=='es') {
					$lang[1] = 'esponol';
				} else if ($lang[0]=='no') {
					$lang[1] = 'norsk';
				}
				$isocode = $lang[0];
				$dictname = $lang[1];
				$languages[] = $lang[0]."|".$lang[1]."|".$lang[2];
			}
		} else {
			$dictionaries = $this->get_dictionaries();
			if (is_object($dictionaries) || (is_array($dictionaries) && count($dictionaries) == 0)) {
				if (@extension_loaded('pspell')) {
					$dictionaries = $this->get_dictionaries_pspell();
					if (is_array($dictionaries) && count($dictionaries) > 0) {
						$this->errorObj = NULL;
						$_SESSION['ktml4']['spellchecker']['UsePspell'] = true;
					}
				}
			}
			if (is_object($dictionaries)) {
				$this->setError($dictionaries);
				return $dictionaries;
			}
			foreach ($GLOBALS['KTML4_languagelist'] as $key => $lang) {
				$isocode = $lang[0];
				$dictname = $lang[1];
				if (in_array($isocode, $dictionaries)) {
					if ($lang[0]=='es') {
						$lang[1] = 'esponol';
					} else if ($lang[0]=='no') {
						$lang[1] = 'norsk';
					}
					$languages[] = $lang[0]."|".$lang[1]."|".$lang[2];
				}
			}
		}
		return $languages;
	}
	
	/**
	 * Add a word to custom dictionary.
	 * @return KTML4 error or the word
	 * @access public
	 */
	function addword() {
		if (!isset($_POST['word'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('SPELLCHECK','word'));
			$this->setError($ret);
			return $ret;
		}
		$word = $_POST['word'];
		
		if (!file_exists($this->folderName)) {
			$folder = new KT_folder();
			$folder->createFolder($this->folderName); 
			if ($folder->hasError()) {
				$arr = $folder->getError();
				$ret = new ktml4_error('KTML_TEMP_FOLDER_ERROR', array($arr[1]));
				$this->setError($ret);
				return $ret;
			}
		}
		
		$fileName = $this->folderName . 'custom_dictionary.txt';
		$file = new KT_file();
		$file->writeFile($fileName, 'append', $word . "\n");
		if ($file->hasError()) {
			$arr = $file->getError();
			$ret = new ktml4_error('PHP_KTML_SPELLCHECK_ERROR', array($arr[1]));
			$this->setError($ret);
			return $ret;
		}
		return $word;
	}
	
	/**
	 * Perform spell check on a text.
	 * @return KTML4 error or array of spelling suggestions
	 * @access public
	 */
	function spellcheck() {
		//print_r($_POST);die();
		if (!isset($_POST['dialect'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('SPELLCHECK','dialect'));
			$this->setError($ret);
			return $ret;
		}
		$dialect = $_POST['dialect'];
		$params = explode("|", $dialect);
		if (!is_array($params) || count($params) < 3) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('SPELLCHECK','dialect'));
			$this->setError($ret);
			return $ret;
		}
		if ( !isset($params[1]) || $params[1] == '' || !preg_match('/^[a-zA-Z_]+$/', $params[1]) ) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('SPELLCHECK','dialect'));
			$this->setError($ret);
			return $ret;
		}
		$language = $params[1];
		
		if (!isset($_POST['text'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('SPELLCHECK','text'));
			$this->setError($ret);
			return $ret;
		}
		$text = $_POST['text'];
		// case when spellchecked text is empty
		if (trim($text) == '') {
			return array();
		}

		if (!file_exists($this->folderName)) {
			$folder = new KT_folder();
			$folder->createFolder($this->folderName); 
			if ($folder->hasError()) {
				$arr = $folder->getError();
				$ret = new ktml4_error('KTML_TEMP_FOLDER_ERROR', array($arr[1]));
				$this->setError($ret);
				return $ret;
			}
		}
		
		$fileName = $this->folderName . 'custom_dictionary.txt';
		$file = new KT_file();
		$content = $file->readFile($fileName);
		$addedWords = array();
		$tmpAddedWords = split("[\n\r]", $content);
		foreach ($tmpAddedWords as $key => $value) {
			$addedWords[trim($value)] = 1;
		}
		
		if (isset($GLOBALS['KTML4_GLOBALS']['online_interakt_spellcheck']) && $GLOBALS['KTML4_GLOBALS']['online_interakt_spellcheck'] === 'true') {
			return $this->spellChecker_spellCheck_webservice($language, $text, $addedWords);
		} else {
			if (isset($_SESSION['ktml4']['spellchecker']['UsePspell'])) {
				return $this->spellChecker_spellCheck_pspell($language, $text, $addedWords);
			} else {
				return $this->spellChecker_spellCheck($language, $text, $addedWords);
			}
		}
	}
	
	/**
	 * Make POST request to the KTML4 Spellcheck Service
	 * @param string $host name of the host providing the service
	 * @param string $path the path to the service
	 * @param string $data post data in x-www-form-urlencoded format
	 * @return KTML4 error or buffer with the spellcheck result
	 * @access private
	 */
	function sendToHost($host,$path,$data)	{
		$header = "POST $path HTTP/1.0\r\n";
		$header .= "Host: $host\r\n";
		$header .= "Content-type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-length: " . strlen($data) . "\r\n";
		$header .= "User-Agent: KTML_Spellchecker\r\n";
		$header .= "Connection: close\r\n\r\n";
		$fp = fsockopen($host, 80, $errno, $errstr, 10);
		if (!$fp) {
			$ret = new ktml4_error('KTML_SPELLCHECK_SERVICE_CONNECT_ERROR', array($errstr));
			$this->setError($ret);
			return $ret;
		}
		if (@fwrite($fp, $header.$data) === false) {
			@fclose($fp);
			$ret = new ktml4_error('KTML_SPELLCHECK_SERVICE_WRITE_ERROR', array(''));
			$this->setError($ret);
			return $ret;
		}
		
		$buf = '';
		$head = '';
		$i = 0;
		while (!feof($fp)) {
			$line = fgets($fp,1024);
			if (false === $line) {
				fclose($fp);
				$ret = new ktml4_error('KTML_SPELLCHECK_SERVICE_READ_ERROR', array($buf));
				$this->setError($ret);
				return $ret;
			}
			$buf .= $line;
			if (($line == "\r\n" && $i==0)) {
				$head = $buf;
				$buf = '';
				$i ++;
			}
		}
		@fclose($fp);
		if (!preg_match("/HTTP\/1\.(1|0)\s*200\s*OK/ims", $head)) {
			$ret = new ktml4_error('KTML_SPELLCHECK_SERVICE_SERVER_ERROR', array(substr($head,0,strpos($head,"\n"))));
			$this->setError($ret);
			return $ret;
		}
		if (strpos($buf,"KTML4_OK") !== 0) {
			if (strpos($buf,"KTML_") !== 0) {
				$ret = new ktml4_error('KTML_SPELLCHECK_SERVICE_ERROR', array($buf));
				$this->setError($ret);
				return $ret;
			} else {
				$error = explode("\r\n",$buf);
				$errorMessage = trim($error[0]);
				array_shift($error);
				$ret = new ktml4_error($errorMessage, $error);
				$this->setError($ret);
				return $ret;
			}
		} else {
			$buf = substr($buf, strpos($buf, "@"));
		}
		return $buf;
	}
	
	/**
	 * Perform spell check on a text using interakt's web service
	 * @param string $language language of the text
	 * @param string $text text content
	 * @param string $addedWords words from the custom dictionary
	 * @return KTML4 error or array of spelling suggestions
	 * @access private
	 */
	function spellChecker_spellCheck_webservice($language, $text, $addedWords) {
		//$data = '';
		$data = 'sm=PHP&language='.urlencode($language).'&text='.urlencode($text);
		$response = $this->sendToHost($GLOBALS['KTML4_interakt_service_server'], $GLOBALS['KTML4_interakt_service_path'], $data);
		if (is_object($response)) {
			return $response;
		}
		$text = str_replace(array("\r"), array(""), $text);
		$arrTextLines = explode("\n", $text);
		return $this->parse_spellcheck_response($response, $arrTextLines, $addedWords);
	}
	
	/**
	 * Perform spell check on a text using Aspell.
	 * @param string $language language of the text
	 * @param string $text text content
	 * @param string $addedWords words from the custom dictionary
	 * @return KTML4 error or array of spelling suggestions
	 * @access private
	 */
	function spellChecker_spellCheck($language, $text, $addedWords) {
		$fileName = tempnam($this->folderName, "chk");
		if ($fileName === false) {
			$ret = new ktml4_error('KTML_SPELLCHECK_ERROR', array());
			$this->setError($ret);
			return $ret;
		}
		$fileNameOut = $fileName.'.out.tmp';
		
		$text = str_replace(array("\r"), array(""), $text);
		$arrTextLines = explode("\n", $text);
		$content = '';
		foreach($arrTextLines as $key=>$value) {
			$content .= "^$value\n"; //prohibit aspell from believing that lines are aspell commands
		}
		
		$file = new KT_file();
		$file->writeFile($fileName, 'truncate', $content);
		// do not check alt attributes
		if ($file->hasError()) {
				$arr = $file->getError();
				$ret = new ktml4_error('KTML_SPELLCHECK_ERROR', array($arr[1]));
				$this->setError($ret);
				@unlink($fileName);
				@unlink($fileNameOut);
				return $ret;
		}
		
		$ret = $this->spellchecker_exec(array('-a', '--encoding=utf-8', '-d', $language, ' -H', '--rem-sgml-check=alt', '<', $fileName, '>', $fileNameOut));
		if (is_object($ret)) {
			$this->setError($ret);
			@unlink($fileName);
			@unlink($fileNameOut);
			return $ret;
		}
		$output = $file->readFile($fileNameOut);
		if ($file->hasError()) {
			$arr = $file->getError();
			$ret = new ktml4_error('KTML_SPELLCHECK_ERROR', array($arr[1]));
			$this->setError($ret);
			@unlink($fileName);
			@unlink($fileNameOut);
			return $ret;
		}
		// unlink tempfile
		$file->deleteFile($fileName);
		if ($file->hasError()) {
			$arr = $file->getError();
			$ret = new ktml4_error('KTML_SPELLCHECK_ERROR', array($arr[1]));
			$this->setError($ret);
			@unlink($fileNameOut);
			return $ret;
		}
		$file->deleteFile($fileNameOut);
		if ($file->hasError()) {
			$arr = $file->getError();
			$ret = new ktml4_error('KTML_SPELLCHECK_ERROR', array($arr[1]));
			$this->setError($ret);
			return $ret;
		}
		
		$arrFinal = $this->parse_spellcheck_response($output, $arrTextLines, $addedWords);
		return $arrFinal;
	}
	
	/**
	 * Parse Aspell's response.
	 * @param string $text spellchecker's response
	 * @param string $arrTextLines original text content, split into lines
	 * @param string $addedWords words from the custom dictionary
	 * @return array of spelling suggestions
	 * @access private
	 */
	function parse_spellcheck_response($text, $arrTextLines, $addedWords) {
		$lines = split("[\r\n]", $text);
		
		$arrFinal = array();
		foreach($lines as $key=>$value) {
			//the first line is Aspell signature, ignore
			if (substr($value,0,1)=="@") {
				continue;
			}
			
			// if there is a correction here, processes it, else move the $textarray pointer to the next line
			if (substr($value,0,1)=="&") {
				$correction= explode(" ",$value);
				$word = $correction[1];
				if (isset($addedWords[$word])) {
					continue;
				}
				
				$suggstart = strpos($value, ":") + 2;
				$suggestions = substr($value, $suggstart);
				$suggestionarray = explode(", ", $suggestions);
				
				$k = array_search($word, $arrTextLines);
				if ($k !== false) {
					$arrFinal[$k] = array($word, join("\t", $suggestionarray));
				}
			} elseif (substr($value,0,1)=="#") {
				$correction = explode(" ",$value);
				$word = $correction[1];
				if (isset($addedWords[$word])) {
					continue;
				}
				$k = array_search($word, $arrTextLines);
				if ($k !== false) {
					$arrFinal[$k] = array($word);
				}
			}
		}
		return $arrFinal;
	}
	
	/**
	 * Perform spell check on a text using php_pspell.
	 * @param string $language language of the text
	 * @param string $text text content
	 * @param string $addedWords words from the custom dictionary
	 * @return KTML4 error or array of spelling suggestions
	 * @access private
	 */
	function spellChecker_spellCheck_pspell($language, $text, $addedWords) {
		$isocode = '';
		foreach ($GLOBALS['KTML4_languagelist'] as $key => $lang) {
			if ($lang[1] == $language) {
				$isocode = $lang[0];
				break;
			}
		}
		//pspell parse initialisation
		$pspell_config = @pspell_config_create($isocode, $language, 'utf-8');
		ob_start();
		$pspell_link = pspell_new($isocode, $language, '', 'utf-8', PSPELL_NORMAL);
		$output = ob_get_contents();
		ob_end_clean();
		
		if ($pspell_link === false) {
			$output = preg_replace('/^.*\spspell/im', 'PSPELL', $output);
			$output = preg_replace('/\sin\s.*[\\/]+.*$/im', '', $output);
			$output = str_replace("\n", '', $output);
			$ret = new ktml4_error('PHP_KTML_SPELLCHECK_PSPELL_ERROR', array($output));
			$this->setError($ret);
			return $ret;
		}
		//split text by space
		$words = preg_split("/\s/", $text);
		$arrFinal = array();
		
		for ($i = 0; $i < count($words); $i++) {
			$word = $words[$i];
			if (isset($addedWords[$word])) {
				continue;
			}
			if(!pspell_check($pspell_link, $word)) {
				$suggestionarray = pspell_suggest($pspell_link, $word);
				if (count($suggestionarray) > 0) {
					$arrFinal[$i] = array($word, join("\t", $suggestionarray));
				}
			}
		}
		return $arrFinal;
	}

	/**
	 * Execute an Aspell instance and return the result.
	 * @param array $arrArg parameters for the execution
	 * @return KTML4 error or the response
	 * @access private
	 */
	function spellChecker_exec($arrArg) {
		if (isset($_SESSION['ktml4']['spellchecker']['ExecPath'])) {
			$aspellPaths = array($_SESSION['ktml4']['spellchecker']['ExecPath']);
		} else {
			$aspellPaths = $GLOBALS['KTML4_aspellpaths'];
			if (isset($GLOBALS['KT_prefered_aspell_path'])) {
				array_unshift($aspellPaths, $GLOBALS['KT_prefered_aspell_path'].'aspell');
				array_unshift($aspellPaths, $GLOBALS['KT_prefered_aspell_path'].'aspell.exe');
			}
		}
		$shell = new KT_shell();
		$output = $shell->execute($aspellPaths, $arrArg);
		if ($shell->hasError()) {
			$arr = $shell->getError();
			$ret = new ktml4_error('KTML_SPELLCHECK_ERROR', array($arr[1]));
			return $ret;
		}
		$execPath = $shell->getExecutedCommand();
		if (!isset($_SESSION['ktml4']['spellchecker']['ExecPath'])) {
			$_SESSION['ktml4']['spellchecker']['ExecPath'] = $execPath;
		}
		return $output;
	}
	
	/**
	 * Get a list of installed Aspell dictionaries.
	 * @return array of dictionaries
	 * @access private
	 */
	function get_dictionaries() {
		if (!isset($GLOBALS['ktml4']['dictionaries'])) {
			$dicts = $this->spellchecker_exec(array('dump', 'dicts'));
			if (is_object($dicts)) {
				$this->setError($dicts);
				$GLOBALS['ktml4']['dictionaries'] = $dicts;
				return $dicts;
			}
			$GLOBALS['ktml4']['dictionaries'] = split("[\r\n]", $dicts);
		}
		return $GLOBALS['ktml4']['dictionaries'];
	}
	
	/**
	 * Get a list of installed php_pspell dictionaries.
	 * @return array of dictionaries
	 * @access private
	 */
	function get_dictionaries_pspell() {
		if (!isset($GLOBALS['ktml4']['dictionaries_pspell'])) {
			$GLOBALS['ktml4']['dictionaries_pspell'] = array();
			foreach ($GLOBALS['KTML4_languagelist'] as $key => $lang) {
				$isocode = $lang[0];
				$pspell_config = @pspell_config_create($isocode);
				$pspell_link = @pspell_new($isocode);
				if (!($pspell_link === false)) {
					$GLOBALS['ktml4']['dictionaries_pspell'][] = $isocode;
				}
			}
			if (count($GLOBALS['ktml4']['dictionaries_pspell']) == 0) {
				$errObj = new ktml4_error('PHP_KTML_SPELLCHECK_PSPELL_NODICT', array());
				$this->setError($errObj);
				$GLOBALS['ktml4']['dictionaries_pspell'] = $errObj;
			}
		}
		return $GLOBALS['ktml4']['dictionaries_pspell'];
	}
	
	/**
	 * Get the output encoding.
	 * @return string
	 * @access public
	 */
	function getOutputEncoding() {
		return $this->outEncoding;
	}
	
	/**
	 * Set the error object.
	 * @param string $errorObj the error object
	 * @access private
	 */
	function setError($errorObj) {
		$this->errorObj = $errorObj;
	}

	/**
	 * Get the error object.
	 * @return error object
	 * @access public
	 */
	function getError() {
		return $this->errorObj;
	}
}

?>
