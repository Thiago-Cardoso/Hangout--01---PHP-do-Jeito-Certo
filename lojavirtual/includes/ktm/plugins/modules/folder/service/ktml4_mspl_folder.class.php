<?php

/**
 * KTML4 folder module.
 * @access protected
 */
class ktml4_mspl_folder {
	/**
	 * The error object.
	 * @var KTML4 error object
	 * @access private
	 */
	var $errorObj;
	
	/**
	 * Absolute path of the root folder for folder operations.
	 * @var KTML4 error object
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
	 * Encoding of this module's output.
	 * @var string
	 * @access private
	 */
	var $outEncoding;
	
	/**
	 * Constructor.
	 * @access public
	 */
	function ktml4_mspl_folder() {
		$this->errorObj = NULL;
		$this->submode = strtolower($_POST['submode']);
		$this->folderName = KT_RealPath($GLOBALS['ktml4_props']['properties'][$this->submode]['UploadFolder'], true);
		KTML4_checkFolder($this->folderName);
		$this->outEncoding = '';
	}
	
	/**
	 * Recursively delete a folder (and its content).
	 * @return KTML4 error or the path of the deleted folder
	 * @access public
	 */
	function delete() {
		if ($this->submode == 'templates' && isset($GLOBALS['ktml4_props']['properties']['templates']['DenySave']) && $GLOBALS['ktml4_props']['properties']['templates']['DenySave']=='true') {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FOLDER','submode'));
			$this->setError($ret);
			return $ret;
		}
		if (!isset($_POST['folder'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('FOLDER','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folderName = $_POST['folder'];
		if ($folderName != KT_replaceSpecialChars($folderName, 'folder')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FOLDER','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folderName = KT_RealPath($this->folderName . trim($folderName), true);
		
		if ($folderName == $this->folderName) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FOLDER','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = new KT_folder();
		$folder->deleteFolder($folderName); 
		if ($folder->hasError()) {
			$arr = $folder->getError();
			$ret = new ktml4_error('KTML_FOLDER_ERROR', array($arr[1]));
			$this->setError($ret);
			return $ret;
		}
		$rel_folder = substr($folderName, strlen($this->folderName));
		return $rel_folder;
	}
	
	/**
	 * Create a folder.
	 * @return KTML4 error or the path of the new folder
	 * @access public
	 */
	function create() {
		if ($this->submode == 'templates' && isset($GLOBALS['ktml4_props']['properties']['templates']['DenySave']) && $GLOBALS['ktml4_props']['properties']['templates']['DenySave']=='true') {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FOLDER','submode'));
			$this->setError($ret);
			return $ret;
		}
		if (!isset($_POST['folder'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('FOLDER','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folderName = $_POST['folder'];
		if ($folderName != KT_replaceSpecialChars($folderName, 'folder')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FOLDER','folder'));
			$this->setError($ret);
			return $ret;
		}		
		$folderName = KT_RealPath($this->folderName . trim($folderName), true);
		
		if ($folderName == $this->folderName) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FOLDER','folder'));
			$this->setError($ret);
			return $ret;
		}

		if (file_exists($folderName)) {
			$ret = new ktml4_error('KTML_FOLDER_ERROR', array('Folder already exists.'));
			$this->setError($ret);
			return $ret;
		}
		$folder = new KT_folder();
		$folder->createFolder($folderName);
		if ($folder->hasError()) {
			$arr = $folder->getError();
			$ret = new ktml4_error('KTML_FOLDER_ERROR', array($arr[1]));
			$this->setError($ret);
			return $ret;
		}
		$rel_folder = substr($folderName, strlen($this->folderName));
		return $rel_folder;
	}

	/**
	 * Rename a folder.
	 * @return KTML4 error or the path of the new folder
	 * @access public
	 */
	function rename() {
		if ($this->submode == 'templates' && isset($GLOBALS['ktml4_props']['properties']['templates']['DenySave']) && $GLOBALS['ktml4_props']['properties']['templates']['DenySave']=='true') {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FOLDER','submode'));
			$this->setError($ret);
			return $ret;
		}
		
		if (!isset($_POST['folder'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('FOLDER','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folderName = $_POST['folder'];
		if ($folderName != KT_replaceSpecialChars($folderName, 'folder')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FOLDER','folder'));
			$this->setError($ret);
			return $ret;
		}	
		$folderName = KT_RealPath($this->folderName . $folderName, true);
		
		if (!isset($_POST['old_foldername'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('FOLDER','old_foldername'));
			$this->setError($ret);
			return $ret;
		}
		$old_foldername = trim($_POST['old_foldername']);
		if ($old_foldername != KT_replaceSpecialChars($old_foldername, 'folder') ) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FOLDER','folder'));
			$this->setError($ret);
			return $ret;
		}	
		$old_foldername = KT_replaceSpecialChars($old_foldername, 'folder');
		
		if (!isset($_POST['new_foldername'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('FOLDER','new_foldername'));
			$this->setError($ret);
			return $ret;
		}
		$new_foldername = trim($_POST['new_foldername']);
		if ($new_foldername != KT_replaceSpecialChars($new_foldername, 'folder') ) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FOLDER','folder'));
			$this->setError($ret);
			return $ret;
		}	
		$new_foldername = KT_replaceSpecialChars($new_foldername, 'folder');
		
		$folder = new KT_folder();
		$folder->renameFolder($folderName, $old_foldername, $new_foldername);
		if ($folder->hasError()) {
			$arr = $folder->getError();
			$ret = new ktml4_error('KTML_FOLDER_ERROR', array($arr[1]));
			$this->setError($ret);
			return $ret;
		}
		
		return $new_foldername;
	}
	/**
	 * Read the content of a folder.
	 * @return KTML4 error or an array with the folder's content
	 * @access public
	 */
	function read() {
		if (!isset($_POST['folder'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('FOLDER','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folderName = $_POST['folder'];
		if ($folderName != KT_replaceSpecialChars($folderName, 'folder') ) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FOLDER','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folderName = KT_RealPath($this->folderName . $folderName, true);
		$rel_folderName = substr($folderName, strlen($this->folderName));
		
		if (!isset($_POST['what'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('FOLDER','what'));
			$this->setError($ret);
			return $ret;
		} else {
			if (!in_array(strtolower($_POST['what']),array('files','folders'))) {
				$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FOLDER','what'));
				$this->setError($ret);
				return $ret;
			}
		}
		
		$folder = new KT_folder();
		$arr = $folder->readFolder($folderName, true); 
		if ($folder->hasError()) {
			$arr = $folder->getError();
			$ret = new ktml4_error('KTML_FOLDER_READ_ERROR', array($arr[1]));
			$this->setError($ret);
			return $ret;
		}
		
		$arrUtil = array();
		foreach ($arr['folders'] as $k=>$arrTemp) {
			if ($arrTemp['name'] == KT_replaceSpecialChars($arrTemp['name'], 'folder')) {
				$arrUtil[] = $arrTemp;
			}
		}
		$arrUtil = $this->sortArr($arrUtil, 'name', 'ASC');
		$arr['folders'] = $arrUtil; 
		
		if (isset($arr['files']) && count($arr['files']) > 0) {
			$arrUtil = array();
			foreach ($arr['files'] as $k=>$arrTemp) {
				if ($arrTemp['name'] == KT_replaceSpecialChars($arrTemp['name'], 'file')) {
					$arrUtil[] = $arrTemp;
				}
			}
			$arrUtil = $this->sortArr($arrUtil, 'name', 'ASC');
			$arr['files'] = $arrUtil;
		}
		
		if (!isset($_POST['filter'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('FOLDER','filter'));
			$this->setError($ret);
			return $ret;
		} else {
			if (!in_array(strtolower($_POST['filter']),array('all','documents','media','images','templates'))) {
				$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FOLDER','filter'));
				$this->setError($ret);
				return $ret;
			}
		}
		$filter = strtolower($_POST['filter']);
				
		if (($this->submode != 'templates' && $filter == 'templates') || ($this->submode == 'templates' && $filter != 'templates')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FOLDER','filter'));
			$this->setError($ret);
			return $ret;
		}
		$all_arr = array();
		if (isset($GLOBALS['ktml4_props']['properties']['media'])) {
			if ($GLOBALS['ktml4_props']['properties']['file']['UploadFolder'] == $GLOBALS['ktml4_props']['properties']['media']['UploadFolder']) {
				$all_arr = array('all','documents','media','images');
			}
		} 

		
		if ($this->submode == 'media' && !in_array($filter,array_merge(array('images','media'), $all_arr))) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FOLDER','filter'));
			$this->setError($ret);
			return $ret;
		}
		if ($this->submode == 'file' && !in_array($filter,array_merge(array('documents'), $all_arr))) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('FOLDER','filter'));
			$this->setError($ret);
			return $ret;
		}
		
		if (strtolower($_POST['what']) == 'folders') {
			$rej = $GLOBALS['ktml4_props']['properties']['filebrowser']['RejectedFolders'];
			$rej = array_map("preg_quote", $rej);
			$rej_str = "/" . implode("|", $rej) . "/";
			$ret = $this->filter_folders($folderName, $arr['folders'], $filter,$rej_str);
		} else {
			$ret = $this->filter_files($rel_folderName, $arr['files'], $filter);
		}
		return $ret;
	}
	
	function sortArr($arr, $filterKey, $direction) {
		$arrTmp = array();
		foreach ($arr as $key=>$val) {
			$arrTmp[$key] = $arr[$key][$filterKey];
		}
		natsort($arrTmp);
		$a = array();
		foreach ($arrTmp as $key => $val) {
			$a[] = $arr[$key];	
		}
		if ($direction != 'ASC') {
			$arr = array_reverse($arr);
		}
		return $arr;
	}
	
	/**
	 * Filter the subfolders and files of a read folder.
	 * @param string $folderName parent folder
	 * @param string $folders subfolders array
	 * @param string $filter read filter (images, media, documents, templates, all)
	 * @return array the folder's subfolders and files according to the filter
	 * @access private
	 */
	function filter_folders($folderName, $folders, $filter,$rej) {
		$toret = array();
		$postFolder = str_replace('//', '/', $_POST['folder']);
		foreach ($folders as $v) {
			unset($v['size']);
			if (!preg_match($rej, $v['name'])) {
				if ($filter != null) {
					if((isset($GLOBALS['KTML4_GLOBALS']['no_folder_info'])) && ($GLOBALS['KTML4_GLOBALS']['no_folder_info'] =="true") ) {
						$v['subfolders'] = 1;
						$v['folders'] = array("");
						$v['allfiles'] = array("");
						$v['filteredfiles'] = array("");
					} else {
						$folder = new KT_folder();
						$arr = $folder->readFolder($folderName . $v['name'], true); 
						if ($folder->hasError()) {
							$v['subfolders'] = 0;
						} else {
							// filter folders in subfolder
							$arr['folders'] = $this->filter_folders($folderName . $v['name'], $arr['folders'], null, $rej);
							$v['subfolders'] = count($arr['folders']);
							
							// filter files in subfolder
							// get all files
							$arr['allfiles'] = $this->filter_files($postFolder . $v['name'], $arr['files'], 'all', true);
							$v['allfiles'] = count($arr['allfiles']);
							// get files according to current filter
							if ($filter != 'all') {
								$arr['files'] = $this->filter_files($postFolder . $v['name'], $arr['files'], $filter, true);
								$v['filteredfiles'] = count($arr['files']);
							} else {
								$arr['files'] = $arr['allfiles'];
								$v['filteredfiles'] = $v['allfiles'];
							}
						}
					}
				}
				$toret[] = $v;
			}
		}
		return $toret;
	}
	
	/**
	 * Perform a filtered read of a folder's files.
	 * @param string $folderName parent folder
	 * @param string $files files array
	 * @param string $filter read filter (images, media, documents, templates, all)
	 * @param boolean $readonly if false, it will also create thumbnails for the found images an read the templates content; if true, it will only count the files
	 * @return array the folder's files according to the filter
	 * @access private
	 */
	function filter_files($folderName, $files, $filter, $readonly = false) {
		$relFolder = $folderName;
		$folderName = KT_RealPath($this->folderName . $folderName, true);
		$thumb_path = $folderName . constant('KTML4_THUMBNAIL_FOLDER');
		
		$ret = array();
		foreach ($files as $key => $value) {
			$type = $this->getFileType($value['name']);
			// 'images' filter is included in 'media' and getFileType returns media for images
			if ($type == 'media' && $filter == 'images') {
				if (KTML4_isImage($value['name'])) {
					$type = 'images';
				}
			}
			$fullFileName = $folderName . $value['name'];
			$info = KT_pathinfo($fullFileName);
			
			if ($type != 'undo') {
				if (!$readonly) {
					if (KTML4_isImage($value['name'])) {
						$fullThumbnailName = $info['filename'].'_'.constant('KTML4_THUMBNAIL_WIDTH').'x'.constant('KTML4_THUMBNAIL_HEIGHT').'.'.$info['extension'];
						$imageDetails = KTML4_getImageInfo_read($folderName, $value['name']);
						if ($imageDetails['dateLastModified'] == -1) {
							$value['thumbnail'] = 'notexist';
						} else {
							if (!file_exists($thumb_path . $fullThumbnailName)) {
								$value['thumbnail'] = 'notexist';
							} else {
								$value['thumbnail'] = $relFolder.constant('KTML4_THUMBNAIL_FOLDER').$fullThumbnailName;
							}
						}
						
						if ($imageDetails['width'] > -1) {
							$value['width'] = $imageDetails['width'];
							$value['height'] = $imageDetails['height'];
						}
					} 
                    else if ($type == 'templates') {
						$value['template_content'] = KTML4_cleanContent(file_get_contents($fullFileName));
					}
				}
				if ($filter == 'all' || $type == $filter) {
					$ret[] = $value;
				}
			} else {
				//clean-up undo files
				$props = @stat($fullFileName);
				if ($props !== false && $props['mtime'] + 60 * 10 < time()) {
					@unlink($fullFileName);
				}
			}
		}
		return $ret;
	}
	
	/**
	 * Get a file's type (media, template, document).
	 * @param string $fileName the file
	 * @return string the file type
	 * @access private
	 */
	function getFileType($fileName) {
		if (strpos($fileName,'.') !== false) {
			$ext = explode('.',$fileName);
			$ext = array_pop($ext);
		} else {
			$ext = '';
		}
		if (isset($GLOBALS['ktml4_props']['properties']['templates'])) {
			if (in_array(strtolower($ext), $GLOBALS['ktml4_props']['properties']['templates']['AllowedFileTypes'])) {
				return 'templates';
			}
		}
		if (isset($GLOBALS['ktml4_props']['properties']['media'])) {
			if (in_array(strtolower($ext), $GLOBALS['ktml4_props']['properties']['media']['AllowedFileTypes'])) {
				return 'media';
			}
		}
		if (in_array(strtolower($ext), $GLOBALS['ktml4_props']['properties']['file']['AllowedFileTypes'])) {
			return 'documents';
		}
        /* Special case, .undo file */
		if (strtolower($ext) == 'undo') {
			return 'undo';
		}
		return 'unknown';
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