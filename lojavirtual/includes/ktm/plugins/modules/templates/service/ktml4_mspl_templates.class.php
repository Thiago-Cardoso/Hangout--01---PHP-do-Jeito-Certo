<?php

/**
 * KTML4 file module.
 * @access protected
 */
class ktml4_mspl_templates {
	/**
	 * The error object.
	 * @var KTML4 error object
	 * @access private
	 */
	var $errorObj;
	
	/**
	 * Absolute path of the root folder for template operations.
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
	function ktml4_mspl_templates() {
		$this->errorObj = NULL;
		$this->folderName = KT_RealPath($GLOBALS['ktml4_props']['properties']['templates']['UploadFolder'], true);
		KTML4_checkFolder($this->folderName);
		$this->outEncoding = '';
	}
	
	/**
	 * Write a template content to disk.
	 * @return KTML4 error or the path of the template
	 * @access public
	 */
	function write() {
		if (!isset($_POST['folder'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('TEMPLATES','folder'));
			$this->setError($ret);
			return $ret;
		}
		if ($_POST['folder'] != KT_replaceSpecialChars($_POST['folder'], 'folder')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('TEMPLATES','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = KT_RealPath($this->folderName . $_POST['folder'], true);
		
		if (!isset($_POST['template_name'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('TEMPLATES','template_name'));
			$this->setError($ret);
			return $ret;
		}
		$template_name = $_POST['template_name'];
		if ($template_name != KT_replaceSpecialChars($template_name, 'file')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('TEMPLATES','template_name'));
			$this->setError($ret);
			return $ret;
		}
		$template_name = KT_replaceSpecialChars($template_name, 'file');

		$fileName = $folder.$template_name.'.ktpl';
		
		if (!isset($_POST['content'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('TEMPLATES','content'));
			$this->setError($ret);
			return $ret;
		}
		$content = $_POST['content'];
		if (get_magic_quotes_gpc()) {
			$content = stripslashes($_POST['content']);
		}
		$content = KTML4_cleanContent($content);
		
		if ($content == '') {
			$ret = new ktml4_error('KTML_TEMPLATES_NO_CONTENT', array('TEMPLATES','content'));
			$this->setError($ret);
			return $ret;
		}
		
		$file = new KT_file();
		$file->writeFile($fileName, 'truncate', $content); 
		if ($file->hasError()) {
			$arr = $file->getError();
			$ret = new ktml4_error('KTML_TEMPLATES_ERROR', array($arr[1]));
			$this->setError($ret);
			return $ret;
		}
		$rel_fileName = substr($fileName, strlen($this->folderName));
		return $rel_fileName;
	}
	
	/**
	 * Read the content of a template.
	 * @return KTML4 error or the template's content
	 * @access public
	 */
	function read() {
		if (!isset($_POST['folder'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('TEMPLATES','folder'));
			$this->setError($ret);
			return $ret;
		}
		if ($_POST['folder'] != KT_replaceSpecialChars($_POST['folder'], 'folder')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('TEMPLATES','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = KT_RealPath($this->folderName . $_POST['folder'], true);
		
		if (!isset($_POST['template_name'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('TEMPLATES','template_name'));
			$this->setError($ret);
			return $ret;
		}
		$template_name = $_POST['template_name'];
		if ($template_name != KT_replaceSpecialChars($template_name, 'file')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('TEMPLATES','template_name'));
			$this->setError($ret);
			return $ret;
		}
		$template_name = KT_replaceSpecialChars($template_name, 'file');
		
		if (!isset($_POST['encoding'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('TEMPLATES','encoding'));
			$this->setError($ret);
			return $ret;
		}
		$this->outEncoding = $_POST['encoding'];
		
		$fileName = $folder.$template_name.'.ktpl';
		
		$file = new KT_file();
		$content = $file->readFile($fileName);
		if ($file->hasError()) {
			$arr = $file->getError();
			$ret = new ktml4_error('KTML_TEMPLATES_ERROR', array($arr[1]));
			$this->setError($ret);
			return $ret;
		}
		$content = KTML4_cleanContent($content);
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