<?php

/**
 * KTML4 file module.
 * @access protected
 */
class ktml4_mspl_xhtml {
	/**
	 * The error object.
	 * @var KTML4 error object
	 * @access private
	 */
	var $errorObj;
	
	/**
	 * Absolute path of the root folder for file operations.
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
	function ktml4_mspl_xhtml() {
		$this->errorObj = NULL;
		$this->folderName = KT_RealPath($GLOBALS['KTML4_XHTMLTempPath'],true);
		$this->outEncoding = '';
	}
	
	/**
	 * Execute a Tidy instance and return the response.
	 * @return KTML4 error or the response
	 * @access public
	 */
	function xhtml() {
		if (!isset($_POST['action'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('XHTML','action'));
			$this->setError($ret);
			return $ret;
		} else {
			if (!in_array(strtolower($_POST['action']),array('test','cleanup'))) {
				$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('XHTML','action'));
				$this->setError($ret);
				return $ret;
			}
		}
		
		$arg_test = array('--version');
		if (isset($_SESSION['ktml4']['xhtml']['ExecPath'])) {
			$KTML4_XHTMLLocations = array($_SESSION['ktml4']['xhtml']['ExecPath']);
		} else {
			$KTML4_XHTMLLocations = $GLOBALS['KTML4_XHTMLLocations'];
			if (isset($GLOBALS['KT_prefered_tidy_path'])) {
				array_unshift($KTML4_XHTMLLocations, $GLOBALS['KT_prefered_tidy_path'].'tidy');
				array_unshift($KTML4_XHTMLLocations, $GLOBALS['KT_prefered_tidy_path'].'tidy.exe');
			}
		}
		$shell = new KT_shell();
		$shell->execute($KTML4_XHTMLLocations, $arg_test);
		if ($shell->hasError()) {
			$arr = $shell->getError();
			$ret = new ktml4_error('KTML_XHTML_ERROR', array($arr[1]));
			$this->setError($ret);
			return $ret;
		}
		$execPath = $shell->getExecutedCommand();
		if (!isset($_SESSION['ktml4']['xhtml']['ExecPath'])) {
			$_SESSION['ktml4']['xhtml']['ExecPath'] = $execPath;
			$KTML4_XHTMLLocations = array($execPath);
		}
		
		if (!isset($_POST['encoding']) && !isset($_GET['encoding'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('XHTML','encoding'));
			$this->setError($ret);
			return $ret;
		} 
		$this->outEncoding = (isset($_POST['encoding']) ? $_POST['encoding'] : $_GET['encoding']);
		
		if (strtolower($_POST['action']) == 'test') {
				return 'OK';
		}
		
		$tidyEncoding = 'raw';
		if (strtolower($this->outEncoding) == 'iso-8859-1') {
			$tidyEncoding = 'ascii';
		}
		if (strpos(strtolower($this->outEncoding), 'utf-8') !== false) {
			$tidyEncoding = 'utf8';
		}
			
		if (!isset($_POST['xhtml_text'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('XHTML','xhtml_text'));
			$this->setError($ret);
			return $ret;
		}
		
		$string = $_POST['xhtml_text'];
		if (get_magic_quotes_gpc()) {
			$string = stripslashes($string);
		}
		$string = str_replace("&amp;nbsp;", "&amp;amp;nbsp;", $string);
		$string = str_replace("&nbsp;", "&amp;nbsp;", $string);
		
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
		
		$fileName = tempnam(substr($this->folderName,0,-1),'tidy');
		if ($fileName === false) {
			$ret = new ktml4_error('KTML_XHTML_ERROR', array());
			$this->setError($ret);
			return $ret;
		}
		$fileNameOut = $fileName.'_out';
		
		$file = new KT_file();
		$file->writeFile($fileName,'append', $string); 
		if ($file->hasError()) {
			$arr = $file->getError();
			$ret = new ktml4_error('KTML_XHTML_ERROR', array($arr[1]));
			$this->setError($ret);
			return $ret;
		}
		$path = $GLOBALS['KTML4_XHTMLConfigPath'];
		$arg = array(
					"-config",
					$path,
					'-' . $tidyEncoding,
					"-o",
					$fileNameOut,
					$fileName
				);
		
		$shell = new KT_shell();
		$output = $shell->execute($KTML4_XHTMLLocations, $arg);
		if ($shell->hasError() && !file_exists($fileNameOut)) {
			$arr = $shell->getError();
			$ret = new ktml4_error('KTML_XHTML_ERROR', array($arr[1]));
			$this->setError($ret);
			@unlink($fileName);
			@unlink($fileNameOut);
			return $ret;
		}
		
		$file = new KT_file();
		$content = $file->readFile($fileNameOut);
		if ($file->hasError()) {
			$arr = $file->getError();
			$ret = new ktml4_error('KTML_XHTML_ERROR', array($arr[1]));
			$this->setError($ret);
			@unlink($fileName);
			@unlink($fileNameOut);
			return $ret;
		}
		$file->deleteFile($fileName);
		if ($file->hasError()) {
			$arr = $file->getError();
			$ret = new ktml4_error('KTML_XHTML_ERROR', array($arr[1]));
			$this->setError($ret);
			@unlink($fileNameOut);
			return $ret;
		}
		$file->deleteFile($fileNameOut);
		if ($file->hasError()) {
			$arr = $file->getError();
			$ret = new ktml4_error('KTML_XHTML_ERROR', array($arr[1]));
			$this->setError($ret);
			return $ret;
		}
		$content = str_replace("&amp;nbsp;", "&nbsp;", $content);
		$content = str_replace("&amp;amp;nbsp;", "&amp;nbsp;", $content);
		$content = KTML4_cleanContent($content);
		$content = KTML4_escapeAttribute($content);
		return $content;
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