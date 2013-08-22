<?php

/**
 * Revert the changes of a file, overwriting it with its undo file.
 * @param string $folder absolute path of the folder which contains the file
 * @param string $file the file name
 * @return KTML4 error object or null
 * @access public
 */
function KTML4_undo($folder, $file) {
	if (!file_exists($folder . $file . '.undo')) {
		$ret = new ktml4_error('KTML_UNDO_ERROR', array('No undo file.'));
		return $ret;
	}
	$ok = @unlink($folder . $file);
	if ($ok === false) {
		$ret = new ktml4_error('KTML_UNDO_ERROR', array('Error undoing file.'));
		return $ret;
	}
	$ok = @rename($folder . $file .'.undo', $folder . $file);
	if ($ok === false) {
		$ret = new ktml4_error('KTML_UNDO_ERROR', array('Error undoing file.'));
		return $ret;
	}
	return null;
}

/**
 * Create an undo for the specified file.
 * @param string $folder absolute path of the folder which contains the file
 * @param string $file the file name
 * @return KTML4 error object or null
 * @access public
 */
function KTML4_add_undo($folder, $file) {
	if (!file_exists($folder . $file . '.undo')) {
		$ok = @copy($folder . $file, $folder . $file . '.undo');
		if ($ok === false) {
			$ret = new ktml4_error('KTML_UNDO_ERROR', array('Error copying undo file.'));
			return $ret;
		}
	}
	return null;
}

/**
 * Delete the undo of a specified file.
 * @param string $folder absolute path of the folder which contains the file
 * @param string $file the file name
 * @return KTML4 error object or null
 * @access public
 */
function KTML4_del_undo($folder, $file) {
	if (file_exists($folder . $file . '.undo')) {
		$ok = @unlink($folder . $file . '.undo');
		if ($ok === false) {
			$ret = new ktml4_error('KTML_UNDO_ERROR', array('Error deleting undo file.'));
			return $ret;
		}
	}
	return null;
}
/**
 * Delete the thumbnails of an image.
 * @param string $folder absolute path of the folder which contains the image
 * @param string $file the image file name
 * @return nothing
 * @access public
 */
function KTML4_deleteThumbnails($folder, $oldName) {
	$thumbFolder = $folder . constant('KTML4_THUMBNAIL_FOLDER');
	if ($oldName != '') {
		$path_info = KT_pathinfo($oldName);
		$regexp = '/'.preg_quote($path_info['filename'],'/').'_\d+x\d+';
		if ($path_info['extension'] != "") {
			$regexp	.= '\.'.preg_quote($path_info['extension'],'/');
		}
		$regexp	.= '/';
		
		$folderObj = new KT_folder();
		$entry = $folderObj->readFolder($thumbFolder, false); 
		if (!$folderObj->hasError()) {
			foreach($entry['files'] as $key => $fDetail) {
				if (preg_match($regexp, $fDetail['name'])) {
					@unlink($thumbFolder . $fDetail['name']);
				}
			}
		}
		KTML4_deleteImageInfo($folder, $oldName);
	}
}

/**
 * Retrieve image informations from its cache file. Create the cache file if it doesn't exist.
 * @param string $folder absolute path of the folder which contains the image
 * @param string $file the image file name
 * @return array the image informations
 * @access public
 */
function KTML4_getImageInfo($folder, $file) {
	$thumbFolder = $folder . constant('KTML4_THUMBNAIL_FOLDER');
	$fileName = $file . '.meta';
	$ret = array();
	$ret['width'] = -1;
	$ret['height'] = -1;
	$ret['dateLastModified'] = -1;
	
	if (!file_exists($thumbFolder)) {
		$folderObj = new KT_folder();
		$folderObj->createFolder($thumbFolder);
		if ($folderObj->hasError()) {
				$arr = $folderObj->getError();
				$ret['error'] =  $arr[1];
				return $ret;
		}
	}
	
	if (file_exists($thumbFolder . $fileName)) {
		$f = @fopen($thumbFolder . $fileName, 'rb');
		if (is_resource($f)) {
			$arr = explode('x', trim(@fread($f, filesize($thumbFolder . $fileName))));
			fclose($f);
			if (count($arr)==3 && @filemtime($folder . $file) == $arr[2] && $arr[0] != -1 && $arr[1] != -1) {
				$ret['width'] = $arr[0];
				$ret['height'] = $arr[1];
				$ret['dateLastModified'] = $arr[2];
				return $ret;
			} else {
				KTML4_deleteThumbnails($folder, $file);
			}
		}
	}
	
	if (!file_exists($thumbFolder . $fileName)) {
		$dateLastModified = @filemtime($folder . $file);
		$arr = @getimagesize($folder . $file);
		$f = @fopen($thumbFolder . $fileName, 'wb');
		if (is_resource($f) && count($arr)>0) {
			fwrite($f, $arr[0] . 'x' . $arr[1] . 'x' . $dateLastModified);
			fclose($f);
		}
		$ret['width'] = $arr[0];
		$ret['height'] = $arr[1];
		$ret['dateLastModified'] = $dateLastModified;
	} 
	return $ret;
}

/**
 * Retrieve image informations from its cache file. Create the cache file if it doesn't exist.
 * @param string $folder absolute path of the folder which contains the image
 * @param string $file the image file name
 * @return array the image informations
 * @access public
 */
function KTML4_getImageInfo_read($folder, $file) {
	$thumbFolder = $folder . constant('KTML4_THUMBNAIL_FOLDER');
	$fileName = $file . '.meta';
	$ret = array();
	$ret['width'] = -1;
	$ret['height'] = -1;
	$ret['dateLastModified'] = -1;
	
	if (file_exists($thumbFolder . $fileName)) {
		$f = @fopen($thumbFolder . $fileName, 'rb');
		if (is_resource($f)) {
			$arr = explode('x', trim(@fread($f, filesize($thumbFolder . $fileName))));
			fclose($f);
			if (count($arr)==3 && @filemtime($folder . $file)==$arr[2] && $arr[1]!=-1 && $arr[2]!=-1) {
				$ret['width'] = $arr[0];
				$ret['height'] = $arr[1];
				$ret['dateLastModified'] = $arr[2];
			} else {
				return KTML4_getImageInfo($folder, $file);
			}
		}
	}
	return $ret;
}


/**
 * Delete the informations file of an image.
 * @param string $folder absolute path of the folder which contains the image
 * @param string $file the image file name
 * @return nothing
 * @access public
 */
function KTML4_deleteImageInfo($folder, $file) {
	$thumbFolder = $folder . constant('KTML4_THUMBNAIL_FOLDER');
	$fileName = $file . '.meta';
	@unlink($thumbFolder . $fileName);
}

/**
 * Check if a folder exists. If not, create the specified folder.
 * @param string $folder absolute path of the folder.
 * @return nothing
 * @access public
 */
function KTML4_checkFolder($folder) {
	if (!file_exists($folder)) {
		$folderObj = new KT_folder();
		$folderObj->createFolder($folder);
	}
}

/**
 * Check if the argument file is an image.
 * @param string $fileName the file
 * @return boolean true if the file is an image
 * @access public
 */
function KTML4_isImage($fileName) {
	if (strpos($fileName,'.') !== false) {
		$ext = explode('.',$fileName);
		$ext = array_pop($ext);
	} else {
		$ext = '';
	}
	return in_array(strtolower($ext), array('gif','xbm','png','jpeg','jpg','jpe','jfif','tiff','tif','bmp'));
}

/**
 * Clean KTML content based on the allowed_tags_list / denied_tags_list globals.
 * @param string $content text to be parsed
 * @return string the stripped text
 * @access public
 */
function KTML4_cleanContent($content) {
	$denied = '';
	$allowed = '';
	if (isset($GLOBALS['KTML4_GLOBALS']['denied_tags_list'])) {
		$denied = $GLOBALS['KTML4_GLOBALS']['denied_tags_list'];
	}
	if (isset($GLOBALS['KTML4_GLOBALS']['allowed_tags_list'])) {
		$allowed = $GLOBALS['KTML4_GLOBALS']['allowed_tags_list'];
	}
	return KT_cleanContent($content, $denied, $allowed);	
}
/**
 * Prepare the allowed_tags_list / denied_tags_list globals for internal use.
 * @return nothing
 * @access public
 */
function KTML4_prepareGlobals() {
	if (isset($GLOBALS['KTML4_GLOBALS']['allowed_tags_list'])) {
		$allowed_tags_list = $GLOBALS['KTML4_GLOBALS']['allowed_tags_list'];
		if (trim($allowed_tags_list) != '') {
			$allowed_tags_list = explode(',', strtolower($allowed_tags_list));
			$allowed_tags_list = array_map('trim', $allowed_tags_list);
			$allowed_tags_list[] = 'p';
		} else {
			$allowed_tags_list = array();
		}
		if (in_array('b', $allowed_tags_list)) {
			$allowed_tags_list[] = 'strong';
		}
		if (in_array('strong', $allowed_tags_list)) {
			$allowed_tags_list[] = 'b';
		}
		if (in_array('i', $allowed_tags_list)) {
			$allowed_tags_list[] = 'em';
		}
		if (in_array('em', $allowed_tags_list)) {
			$allowed_tags_list[] = 'i';
		}
		$allowed_tags_list = array_unique($allowed_tags_list);
		$GLOBALS['KTML4_GLOBALS']['allowed_tags_list'] = implode(',', $allowed_tags_list);
	}
	
	if (isset($GLOBALS['KTML4_GLOBALS']['denied_tags_list'])) {
		$denied_tags_list = $GLOBALS['KTML4_GLOBALS']['denied_tags_list'];
		if (trim($denied_tags_list) != '') {
			$denied_tags_list = explode(',', strtolower($denied_tags_list));
			$denied_tags_list = array_map('trim', $denied_tags_list);
		} else {
			$denied_tags_list = array();
		}
		$denied_tags_list = array_diff($denied_tags_list, array('p'));
		if (in_array('b', $denied_tags_list)) {
			$denied_tags_list[] = 'strong';
		}
		if (in_array('strong', $denied_tags_list)) {
			$denied_tags_list[] = 'b';
		}
		if (in_array('i', $denied_tags_list)) {
			$denied_tags_list[] = 'em';
		}
		if (in_array('em', $denied_tags_list)) {
			$denied_tags_list[] = 'i';
		}
		$denied_tags_list = array_unique($denied_tags_list);
		$GLOBALS['KTML4_GLOBALS']['denied_tags_list'] = implode(',', $denied_tags_list);
	}
}

/**
 * Remove rich content from error messages.
 * @param string $errorMsg the error message
 * @return string the stripped error message
 * @access public
 */
function KTML4_prepareErrorMsg($errorMsg) {
	$errorMsg = trim(strip_tags($errorMsg));
	return $errorMsg;
}

/**
 * Escape the & " > < from a string with the html entities; 
 * @param string $val the value to be escaped;
 * @return string the escaped value;
 */
function KTML4_escapeAttribute($val) {
	$val = str_replace(array('&','"',"<",">"), array("&amp;","&quot;","&lt;","&gt;"), $val);
	return $val;
}


function KTML4_debug($var) {
	$hdr = date('Y-m-d H:i:s') . "\r\n";
	$ftr = "\r\n-----------------------------\r\n";
	$cnt = var_export($var, true);
	$f = fopen('log.txt', 'ab');
	fwrite($f, $hdr);
	fwrite($f, $cnt);
	fwrite($f, $ftr);
	fclose($f);
}

?>