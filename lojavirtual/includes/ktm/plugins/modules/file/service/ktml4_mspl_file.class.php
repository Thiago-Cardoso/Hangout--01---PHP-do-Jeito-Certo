<?php

/**
 * KTML4 file module.
 * @access protected
 */
class ktml4_mspl_file {
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
	 * Submode in which the module runs.
	 * @var string
	 * @access private
	 */
	var $submode;
	
	/**
	 * Constructor.
	 * @access public
	 */
	function ktml4_mspl_file() {
		$this->errorObj = NULL;
		if (isset($_POST['submode'])) {
			$this->submode = strtolower($_POST['submode']);
		} else {
			$this->submode = strtolower($_GET['submode']);
		}
		$this->folderName = KT_RealPath($GLOBALS['ktml4_props']['properties'][$this->submode]['UploadFolder'], true);
		KTML4_checkFolder($this->folderName);
	}
	
	/**
	 * Reset the state of the upload.
	 * @return string 'OK'
	 * @access public
	 */
	function resetuploadstatus() {
		$_SESSION['ktml4'][$GLOBALS['ktml4_props']['id']]['status'] = array();
		return 'OK';
	}

	/**
	 * Retrieve an array storing the states for each of the uploaded file.
	 * @return array states of the uploaded files
	 * @access public
	 */
	function getuploadstatus() {
		if (isset($_SESSION['ktml4'][$GLOBALS['ktml4_props']['id']]['status'])) {
			$ret = $_SESSION['ktml4'][$GLOBALS['ktml4_props']['id']]['status'];
		} else {
			$ret = array();
		}
		return $ret;
	}
	/**
	 * Upload a file.
	 * @return KTML4 error or the path of the saved file
	 * @access public
	 */
	function upload() {
		if ($this->submode == 'templates') {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FILE','submode'));
			$this->setError($ret);
			return $ret;
		}
		if (!isset($_FILES['Filedata'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('FILE','Filedata'));
			$this->setError($ret);
			return $ret;
		}
		
		if (!isset($_POST['folder'])) {
			if (isset($_GET['folder'])) {
				$folder = urldecode($_GET['folder']);
			} else {
				$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('FILE','folder'));
				$this->setError($ret);
				return $ret;
			}
		} else {
			$folder = $_POST['folder'];
		}
		$postFolder = str_replace('//', '/', $folder);
		$uploadfolder = KT_RealPath($this->folderName . $postFolder, true);
		if (substr($postFolder, 0, 1) == '/') {
			$uploadfolder = KT_RealPath($this->folderName . substr($postFolder, 1), true);
		}
		$fileName = KT_replaceSpecialChars($_FILES['Filedata']['name'], 'file');
		
		$extensions = $GLOBALS['ktml4_props']['properties'][$this->submode]['AllowedFileTypes'];
		if (isset($GLOBALS['ktml4_props']['properties']['media'])) {
			if ($GLOBALS['ktml4_props']['properties']['file']['UploadFolder'] == $GLOBALS['ktml4_props']['properties']['media']['UploadFolder']) {
				$extensions = array_merge($GLOBALS['ktml4_props']['properties']['file']['AllowedFileTypes'], $GLOBALS['ktml4_props']['properties']['media']['AllowedFileTypes']);
			}
		} 
		
		$fileUpload = new KT_fileUpload();
		$fileUpload->setFileInfo('Filedata');
		$fileUpload->setFolder($uploadfolder);
		$fileUpload->setRequired(true);
		$fileUpload->setAllowedExtensions($extensions);
		$fileUpload->setAutoRename(true);
		$fileUpload->setMinSize(0);
		$fileUpload->setMaxSize($GLOBALS['ktml4_props']['properties']['filebrowser']['MaxFileSize']);
		$file_name = $fileUpload->uploadFile($fileName, null);
		if ($fileUpload->hasError()) {
			$arr = $fileUpload->getError();
			$ret = new ktml4_error('KTML_FILEUPLOAD_ERROR', array($fileName, $arr[1]));
			$this->setError($ret);
			return $ret;
		}
		if (isset($GLOBALS['ktml4_props']['properties']['media'])) {
			if (KTML4_isImage($file_name)) {
				$fileName = $uploadfolder.$file_name;
				$arr = @getimagesize($fileName);
				if ($arr === false) {
					@unlink($fileName);
					$ret = new ktml4_error('KTML_FILEUPLOAD_ERROR', array($file_name, ''));
					$this->setError($ret);
					return $ret;
				}
				if ($arr[0] > constant('KTML4_MAX_UPLOAD_IMAGE_WIDTH') || $arr[1] > constant('KTML4_MAX_UPLOAD_IMAGE_HEIGHT')) {
					$image = new KT_image();
					$imageLib = '';
					if (isset($GLOBALS['KT_prefered_image_lib'])) {
						$imageLib = $GLOBALS['KT_prefered_image_lib'];
						$image->setPreferedLib($imageLib);
					}
					if ($imageLib == 'imagemagick') {
						if (isset($_SESSION['ktml4']['filebrowser']['ExecPath']) && $_SESSION['ktml4']['filebrowser']['ExecPath']!='') {
							$image->addCommand($_SESSION['ktml4']['filebrowser']['ExecPath']);
						} else {
							if (isset($GLOBALS['KT_prefered_imagemagick_path'])) {
								$image->addCommand($GLOBALS['KT_prefered_imagemagick_path']);
							}
						}
					}
					$image->resize($fileName, $uploadfolder, $file_name, constant('KTML4_MAX_UPLOAD_IMAGE_WIDTH'), constant('KTML4_MAX_UPLOAD_IMAGE_HEIGHT'), true);
					if ($image->hasError()) {
						@unlink($fileName);
						$arr = $image->getError();
						$ret = new ktml4_error('KTML_BOX_RESIZE_ERROR', array($file_name, constant('KTML4_MAX_UPLOAD_IMAGE_WIDTH'), constant('KTML4_MAX_UPLOAD_IMAGE_HEIGHT'), ''));
						$this->setError($ret);
						return $ret;
					}
					if (!isset($_SESSION['ktml4']['filebrowser']['ExecPath']) && $image->getImageMagickPath()!='') {
						$_SESSION['ktml4']['filebrowser']['ExecPath'] = $image->getImageMagickPath();
					}
					KTML4_deleteThumbnails($uploadfolder, $file_name);
				}
			}
		}
		return ($folder . $file_name);
	}
	
	/**
	 * Delete a file.
	 * @return KTML4 error or the path of the deleted file
	 * @access public
	 */
	function delete() {
		if ($this->submode == 'templates' && isset($GLOBALS['ktml4_props']['properties']['templates']['DenySave']) && $GLOBALS['ktml4_props']['properties']['templates']['DenySave']=='true') {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FILE','submode'));
			$this->setError($ret);
			return $ret;
		}
		if (!isset($_POST['filename'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('FILE','filename'));
			$this->setError($ret);
			return $ret;
		}
		$fileName = $_POST['filename'];
		if ($fileName != KT_replaceSpecialChars($fileName, 'folder')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FILE','filename'));
			$this->setError($ret);
			return $ret;
		}
		$fileName = KT_RealPath($this->folderName.$fileName, false);
		
		$file = new KT_file();
		$file->deleteFile($fileName); 
		if ($file->hasError()) {
			$arr = $file->getError();
			$ret = new ktml4_error('KTML_FILE_ERROR', array($arr[1]));
			$this->setError($ret);
			return $ret;
		}
		$dir_fileName = dirname($fileName).'/';
		$uploadFolder = substr($dir_fileName,strlen($this->folderName));
		$name_fileName = basename($fileName);
		KTML4_deleteThumbnails($dir_fileName, $name_fileName);
		return $uploadFolder . $name_fileName;
	}
	
	/**
	 * Rename a file.
	 * @return KTML4 error or the new path of the file
	 * @access public
	 */
	function rename() {
		if ($this->submode == 'templates' && isset($GLOBALS['ktml4_props']['properties']['templates']['DenySave']) && $GLOBALS['ktml4_props']['properties']['templates']['DenySave']=='true') {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FILE','submode'));
			$this->setError($ret);
			return $ret;
		}
	
		if (!isset($_POST['filename'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('FILE','filename'));
			$this->setError($ret);
			return $ret;
		}
		$fileName = $_POST['filename'];
		if ($fileName != KT_replaceSpecialChars($fileName, 'folder')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FILE','filename'));
			$this->setError($ret);
			return $ret;
		}
		$fileName = KT_RealPath($this->folderName.$fileName, false);
		$info = KT_pathinfo($fileName);
		$dir_fileName = $info['dirname'].'/';
		$name_fileName = $info['basename'];
		
		if (!isset($_POST['new_filebasename'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('FILE','new_filebasename'));
			$this->setError($ret);
			return $ret;
		}
		
		$new_filebasename = $_POST['new_filebasename'];
		if ($new_filebasename != KT_replaceSpecialChars($new_filebasename, 'file')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FILE','filename'));
			$this->setError($ret);
			return $ret;
		}
		$new_filebasename = KT_replaceSpecialChars($new_filebasename, 'file');
		if (trim($new_filebasename) == '') {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FILE','new_filebasename'));
			$this->setError($ret);
			return $ret;
		}
		$new_fileName = $dir_fileName . $new_filebasename;
		if ($info['extension'] != '') {
			$new_fileName .= '.'.$info['extension'];
		}
		
		if (file_exists($new_fileName)) {
			$ret = new ktml4_error('KTML_FILE_EXISTS', array($new_filebasename . '.' . $info['extension']));
			$this->setError($ret);
			return $ret;
		}
		
		$file = new KT_file();
		$file->renameFile($fileName, $new_fileName);
		if ($file->hasError()) {
			$arr = $file->getError();
			$ret = new ktml4_error('KTML_FILE_ERROR', array($arr[1]));
			$this->setError($ret);
			return $ret;
		}
		
		KTML4_deleteThumbnails($dir_fileName, $name_fileName);
		
		$dir_new_fileName = dirname($new_fileName).'/';
		$name_new_fileName = basename($new_fileName);
		$uploadFolder = substr($dir_new_fileName, strlen($this->folderName));
		return $uploadFolder.$name_new_fileName;
	}
	
	/**
	 * Copy a file.
	 * @return KTML4 error or the path of the copy
	 * @access public
	 */
	function copy() {
		if ($this->submode == 'templates' && isset($GLOBALS['ktml4_props']['properties']['templates']['DenySave']) && $GLOBALS['ktml4_props']['properties']['templates']['DenySave']=='true') {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FILE','submode'));
			$this->setError($ret);
			return $ret;
		}
	
		if (!isset($_POST['filename'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('FILE','filename'));
			$this->setError($ret);
			return $ret;
		}
		$fileName = $_POST['filename'];
		if ($fileName != KT_replaceSpecialChars($fileName, 'folder')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FILE','filename'));
			$this->setError($ret);
			return $ret;
		}
		$fileName = KT_RealPath($this->folderName.$fileName, false);
		$info = KT_pathinfo($fileName);
		$fileNameBase = $info['basename'];
		
		if (!isset($_POST['new_filefolder'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('FILE','new_filefolder'));
			$this->setError($ret);
			return $ret;
		}
		$new_filefolder = $_POST['new_filefolder'];
		if ($new_filefolder != KT_replaceSpecialChars($new_filefolder, 'folder') ) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FILE','filename'));
			$this->setError($ret);
			return $ret;
		}
		$new_filefolder = KT_RealPath($this->folderName.trim($new_filefolder));
		
		$new_fileName = $new_filefolder .$fileNameBase;
		if (file_exists($new_fileName)) {
			$new_fileName = $new_filefolder . 'Copy of ' . $fileNameBase;
			$i = 2;
			while (file_exists($new_fileName)) {
				$new_fileName = $new_filefolder . 'Copy (' . $i . ') of ' . $fileNameBase;
				$i++;
			}
		}
		
		$file = new KT_file();
		$file->copyFile($fileName, $new_fileName); 
		if ($file->hasError()) {
			$arr = $file->getError();
			$ret = new ktml4_error('KTML_FILE_ERROR', array($arr[1]));
			$this->setError($ret);
			return $ret;
		}
		
		$info = KT_pathinfo($new_fileName);
		$name_new_fileName = $info['basename'];
		$dir_new_fileName = $info['dirname'].'/';
		$uploadFolder = substr($dir_new_fileName, strlen($this->folderName));
		return $uploadFolder.$name_new_fileName;
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