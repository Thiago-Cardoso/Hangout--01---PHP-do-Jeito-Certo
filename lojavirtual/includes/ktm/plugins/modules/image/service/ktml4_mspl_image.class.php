<?php

/**
 * KTML4 image module.
 * @access protected
 */
class ktml4_mspl_image {
	/**
	 * The error object.
	 * @var KTML4 error object
	 * @access private
	 */
	var $errorObj;
	
	/**
	 * Absolute path of the root folder for image operations.
	 * @var KTML4 error object
	 * @access private
	 */
	var $folderName;
	
	/**
	 * Constructor.
	 * @access public
	 */
	function ktml4_mspl_image() {
		$this->errorObj = NULL;
		$this->folderName = KT_RealPath($GLOBALS['ktml4_props']['properties']['media']['UploadFolder'], true);
		KTML4_checkFolder($this->folderName);
	}
	
	/**
	 * Revert the changes of an image (and refreshes its thumbanail).
	 * @return KTML4 error or the image informations
	 * @access public
	 */
	function undo() {
		if (!isset($_POST['rel_filename'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','rel_filename'));
			$this->setError($ret);
			return $ret;
		}
		$rel_filename = $_POST['rel_filename'];
		if ($rel_filename != KT_replaceSpecialChars($rel_filename, 'file')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','rel_filename'));
			$this->setError($ret);
			return $ret;
		}
		$rel_filename = KT_replaceSpecialChars($rel_filename, 'file');
		
		if (!isset($_POST['folder'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = $_POST['folder'];
		if ($folder != KT_replaceSpecialChars($folder, 'folder')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = KT_RealPath($this->folderName . $folder, true);
		
		$ret = KTML4_undo($folder, $rel_filename);
		if ($ret !== NULL) {
			$this->setError($ret);
			return $ret;
		}
		KTML4_deleteThumbnails($folder, $rel_filename);
		return $this->getfileinfo();
	}
	
	/**
	 * Erase the undo file of an image.
	 * @return KTML4 error or 'OK'
	 * @access public
	 */
	function deleteundo() {
		if (!isset($_POST['rel_filename'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','rel_filename'));
			$this->setError($ret);
			return $ret;
		}
		$rel_filename = $_POST['rel_filename'];
		if ($rel_filename != KT_replaceSpecialChars($rel_filename, 'file')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','rel_filename'));
			$this->setError($ret);
			return $ret;
		}
		$rel_filename = KT_replaceSpecialChars($rel_filename, 'folder');
		
		if (!isset($_POST['folder'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = $_POST['folder'];
		if ($folder != KT_replaceSpecialChars($folder, 'folder')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = KT_RealPath($this->folderName . $folder, true);
		
		$ret = KTML4_del_undo($folder, $rel_filename);
		if ($ret !== NULL) {
			$this->setError($ret);
			return $ret;
		}
		return 'OK';
	}
	
	/**
	 * Crop an image.
	 * @return KTML4 error or the new image's informations
	 * @access public
	 */
	function crop()	{
		if (!isset($_POST['rel_filename'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','rel_filename'));
			$this->setError($ret);
			return $ret;
		}
		$rel_filename = $_POST['rel_filename'];
		if ($rel_filename != KT_replaceSpecialChars($rel_filename, 'file')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','rel_filename'));
			$this->setError($ret);
			return $ret;
		}
		$rel_filename = KT_replaceSpecialChars($rel_filename, 'file');
		
		if (!isset($_POST['folder'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = $_POST['folder'];
		if ($folder != KT_replaceSpecialChars($folder, 'folder')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = KT_RealPath($this->folderName . $folder, true);
		
		if (!isset($_POST['left'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','left'));
			$this->setError($ret);
			return $ret;
		}
		$left = (int)$_POST['left'];
		if ($left < 0) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','left'));
			$this->setError($ret);
			return $ret;
		}
		
		if (!isset($_POST['top'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','top'));
			$this->setError($ret);
			return $ret;
		}
		$top = (int)$_POST['top'];
		if ($top < 0) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','top'));
			$this->setError($ret);
			return $ret;
		}
		
		if (!isset($_POST['width'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','width'));
			$this->setError($ret);
			return $ret;
		}
		$width = (int)$_POST['width'];
		if ($width <= 0) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','width'));
			$this->setError($ret);
			return $ret;
		}
		
		if (!isset($_POST['height'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','height'));
			$this->setError($ret);
			return $ret;
		}
		$height = (int)$_POST['height'];
		
		if ($height <= 0) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','height'));
			$this->setError($ret);
			return $ret;
		}
		
		$ret = KTML4_add_undo($folder, $rel_filename);
		if ($ret !== null) {
			$this->setError($ret);
			return $ret;
		}
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
		$image->crop($folder . $rel_filename, $left, $top, $width, $height);
		if ($image->hasError()) {
			$arr = $image->getError();
			$ret = new ktml4_error('KTML_IMAGE_ERROR', array($arr[1]));
			$this->setError($ret);
			return $ret;
		}
		
		if (!isset($_SESSION['ktml4']['filebrowser']['ExecPath']) && $image->getImageMagickPath()!='') {
			$_SESSION['ktml4']['filebrowser']['ExecPath'] = $image->getImageMagickPath();
		}

		KTML4_deleteThumbnails($folder, $rel_filename);
		return $this->getfileinfo();
	}
	
	/**
	 * Rotate an image (or multiple images at once).
	 * @return KTML4 error or an array of image informations
	 * @access public
	 */
	function rotate() {
		if (!isset($_POST['rel_filename'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','rel_filename'));
			$this->setError($ret);
			return $ret;
		}
		$rel_filename = $_POST['rel_filename'];
		if ($rel_filename != KT_replaceSpecialChars($rel_filename, 'file')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','rel_filename'));
			$this->setError($ret);
			return $ret;
		}
		$rel_filename = KT_replaceSpecialChars($rel_filename, 'file');
		
		if (!isset($_POST['folder'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = $_POST['folder'];
		if ($folder != KT_replaceSpecialChars($folder, 'folder')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = KT_RealPath($this->folderName . $folder, true);
		
		if (!isset($_POST['angle'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','angle'));
			$this->setError($ret);
			return $ret;
		}
		$angle = (int)$_POST['angle'];
		if (!in_array($angle,array(0, 90, 180, 270, 360))) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','angle'));
			$this->setError($ret);
			return $ret;		
		}
		$ret = KTML4_add_undo($folder, $rel_filename);
		if ($ret !== null) {
			$this->setError($ret);
			return $ret;
		}
		
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
		$image->rotate($folder . $rel_filename, $angle);
		if ($image->hasError()) {
			$arr = $image->getError();
			$ret = new ktml4_error('KTML_IMAGE_ERROR', array($arr[1]));
			$this->setError($ret);
			return $ret;
		}
		
		if (!isset($_SESSION['ktml4']['filebrowser']['ExecPath']) && $image->getImageMagickPath()!='') {
			$_SESSION['ktml4']['filebrowser']['ExecPath'] = $image->getImageMagickPath();
		}
		KTML4_deleteThumbnails($folder, $rel_filename);
		$ret = $this->getfileinfo();

		return $ret;
	}
	
	/**
	 * Flip an image.
	 * @return KTML4 error or the new image's informations
	 * @access public
	 */
	function flip()	{
		if (!isset($_POST['rel_filename'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','rel_filename'));
			$this->setError($ret);
			return $ret;
		}
		$rel_filename = $_POST['rel_filename'];
		if ($rel_filename != KT_replaceSpecialChars($rel_filename, 'file')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','rel_filename'));
			$this->setError($ret);
			return $ret;
		}
		$rel_filename = KT_replaceSpecialChars($rel_filename, 'file');
		
		if (!isset($_POST['folder'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = $_POST['folder'];
		if ($folder != KT_replaceSpecialChars($folder, 'folder')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = KT_RealPath($this->folderName . $folder, true);
		
		if (!isset($_POST['direction'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','direction'));
			$this->setError($ret);
			return $ret;
		} else {
			if (!in_array(strtolower($_POST['direction']),array('vertical','horizontal'))) {
				$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','direction'));
				$this->setError($ret);
				return $ret;
			}
		}
		$direction = strtolower($_POST['direction']);
		
		$ret = KTML4_add_undo($folder, $rel_filename);
		if ($ret !== null) {
			$this->setError($ret);
			return $ret;
		}
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
		$image->flip($folder . $rel_filename, $direction);
		if ($image->hasError()) {
			$arr = $image->getError();
			$ret = new ktml4_error('KTML_IMAGE_ERROR', array($arr[1]));
			$this->setError($ret);
			return $ret;
		}
		
		if (!isset($_SESSION['ktml4']['filebrowser']['ExecPath']) && $image->getImageMagickPath()!='') {
			$_SESSION['ktml4']['filebrowser']['ExecPath'] = $image->getImageMagickPath();
		}
		KTML4_deleteThumbnails($folder, $rel_filename);
		return $this->getfileinfo();
	}
	
	/**
	 * Alter the quality of an image (or multiple images at once).
	 * @return KTML4 error or an array of image informations
	 * @access public
	 */
	function degrade() {
		if (!isset($_POST['rel_filename'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','rel_filename'));
			$this->setError($ret);
			return $ret;
		}
		$rel_filename = $_POST['rel_filename'];
		if ($rel_filename != KT_replaceSpecialChars($rel_filename, 'file')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','rel_filename'));
			$this->setError($ret);
			return $ret;
		}
		$rel_filename = KT_replaceSpecialChars($rel_filename, 'file');
		
		if (!isset($_POST['folder'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = $_POST['folder'];
		if ($folder != KT_replaceSpecialChars($folder, 'folder')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = KT_RealPath($this->folderName . $folder, true);
		
		if (!isset($_POST['degradejpeg_procent'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','degradejpeg_procent'));
			$this->setError($ret);
			return $ret;
		}
		$degradejpeg_procent = (int)$_POST['degradejpeg_procent'];
		if ($degradejpeg_procent < 1 || $degradejpeg_procent > 100) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','degradejpeg_procent'));
			$this->setError($ret);
			return $ret;
		}
		
		$ret = KTML4_add_undo($folder, $rel_filename);
		if ($ret !== null) {
			$this->setError($ret);
			return $ret;
		}

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
		$image->adjustQuality($folder . $rel_filename, $degradejpeg_procent);
		if ($image->hasError()) {
			$arr = $image->getError();
			$ret = new ktml4_error('KTML_IMAGE_ERROR', array($arr[1]));
			$this->setError($ret);
			return $ret;
		}

		if (!isset($_SESSION['ktml4']['filebrowser']['ExecPath']) && $image->getImageMagickPath()!='') {
			$_SESSION['ktml4']['filebrowser']['ExecPath'] = $image->getImageMagickPath();
		}
		KTML4_deleteThumbnails($folder, $rel_filename);
		$ret = $this->getfileinfo();

		return $ret;
	}
	
	/**
	 * Sharpen an image.
	 * @return KTML4 error or the new image's informations
	 * @access public
	 */
	function sharpen() {
		if (!isset($_POST['rel_filename'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','rel_filename'));
			$this->setError($ret);
			return $ret;
		}
		$rel_filename = $_POST['rel_filename'];
		if ($rel_filename != KT_replaceSpecialChars($rel_filename, 'file')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','rel_filename'));
			$this->setError($ret);
			return $ret;
		}
		$rel_filename = KT_replaceSpecialChars($rel_filename, 'file');
		
		if (!isset($_POST['folder'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = $_POST['folder'];
		if ($folder != KT_replaceSpecialChars($folder, 'folder')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = KT_RealPath($this->folderName . $folder, true);
		
		$ret = KTML4_add_undo($folder, $rel_filename);
		if ($ret !== null) {
			$this->setError($ret);
			return $ret;
		}
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
		$image->sharpen($folder . $rel_filename);
		if ($image->hasError()) {
			$arr = $image->getError();
			$ret = new ktml4_error('KTML_IMAGE_ERROR', array($arr[1]));
			$this->setError($ret);
			return $ret;
		}
		
		if (!isset($_SESSION['ktml4']['filebrowser']['ExecPath']) && $image->getImageMagickPath()!='') {
			$_SESSION['ktml4']['filebrowser']['ExecPath'] = $image->getImageMagickPath();
		}
		KTML4_deleteThumbnails($folder, $rel_filename);
		return $this->getfileinfo();
	}
	
	/**
	 * Blur an image.
	 * @return KTML4 error or the new image's informations
	 * @access public
	 */
	function blur() {
		if (!isset($_POST['rel_filename'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','rel_filename'));
			$this->setError($ret);
			return $ret;
		}
		$rel_filename = $_POST['rel_filename'];
		if ($rel_filename != KT_replaceSpecialChars($rel_filename, 'folder')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','rel_filename'));
			$this->setError($ret);
			return $ret;
		}
		$rel_filename = KT_replaceSpecialChars($rel_filename, 'file');
		
		if (!isset($_POST['folder'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = $_POST['folder'];
		if ($folder != KT_replaceSpecialChars($folder, 'folder')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = KT_RealPath($this->folderName . $folder, true);
		
		$ret = KTML4_add_undo($folder, $rel_filename);
		if ($ret !== null) {
			$this->setError($ret);
			return $ret;
		}
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
		$image->blur($folder . $rel_filename);
		if ($image->hasError()) {
			$arr = $image->getError();
			$ret = new ktml4_error('KTML_IMAGE_ERROR', array($arr[1]));
			$this->setError($ret);
			return $ret;
		}
		
		if (!isset($_SESSION['ktml4']['filebrowser']['ExecPath']) && $image->getImageMagickPath()!='') {
			$_SESSION['ktml4']['filebrowser']['ExecPath'] = $image->getImageMagickPath();
		}
		KTML4_deleteThumbnails($folder, $rel_filename);
		return $this->getfileinfo();
	}
	
	/**
	 * Increase or decrease the contrast of an image (or multiple images at once).
	 * @return KTML4 error or an array of image informations
	 * @access public
	 */
	function contrast() {
		if (!isset($_POST['rel_filename'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','rel_filename'));
			$this->setError($ret);
			return $ret;
		}
		$rel_filename = $_POST['rel_filename'];
		if ($rel_filename != KT_replaceSpecialChars($rel_filename, 'file')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','rel_filename'));
			$this->setError($ret);
			return $ret;
		}
		$rel_filename = KT_replaceSpecialChars($rel_filename, 'file');
		
		if (!isset($_POST['folder'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = $_POST['folder'];
		if ($folder != KT_replaceSpecialChars($folder, 'folder')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = KT_RealPath($this->folderName . $folder, true);
		
		if (!isset($_POST['intensity'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','intensity'));
			$this->setError($ret);
			return $ret;
		} else {
			if (!in_array(strtolower($_POST['intensity']),array('increase','decrease'))) {
				$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','intensity'));
				$this->setError($ret);
				return $ret;
			}
		}
		$intensity = strtolower($_POST['intensity']);
		
		$ret = KTML4_add_undo($folder, $rel_filename);
		if ($ret !== null) {
			$this->setError($ret);
			return $ret;
		}
		
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
		$image->contrast($folder . $rel_filename, $intensity);
		if ($image->hasError()) {
			$arr = $image->getError();
			$ret = new ktml4_error('KTML_IMAGE_ERROR', array($arr[1]));
			$this->setError($ret);
			return $ret;
		}
		
		if (!isset($_SESSION['ktml4']['filebrowser']['ExecPath']) && $image->getImageMagickPath()!='') {
			$_SESSION['ktml4']['filebrowser']['ExecPath'] = $image->getImageMagickPath();
		}
		KTML4_deleteThumbnails($folder, $rel_filename);
		$ret = $this->getfileinfo();
		return $ret;
	}
	
	/**
	 * Increase or decrease the brightness of an image (or multiple images at once).
	 * @return KTML4 error or an array of image informations
	 * @access public
	 */
	function brightness() {
		if (!isset($_POST['rel_filename'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','rel_filename'));
			$this->setError($ret);
			return $ret;
		}
		$rel_filename = $_POST['rel_filename'];
		if ($rel_filename != KT_replaceSpecialChars($rel_filename, 'file')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','rel_filename'));
			$this->setError($ret);
			return $ret;
		}
		$rel_filename = KT_replaceSpecialChars($rel_filename, 'file');
		
		if (!isset($_POST['folder'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = $_POST['folder'];
		if ($folder != KT_replaceSpecialChars($folder, 'folder')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = KT_RealPath($this->folderName . $folder, true);
		
		if (!isset($_POST['intensity'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','intensity'));
			$this->setError($ret);
			return $ret;
		} else {
			if (!in_array(strtolower($_POST['intensity']),array('increase','decrease'))) {
				$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','intensity'));
				$this->setError($ret);
				return $ret;
			}
		}
		$intensity = strtolower($_POST['intensity']);
		
		$ret = KTML4_add_undo($folder, $rel_filename);
		if ($ret !== null) {
			$this->setError($ret);
			return $ret;
		}
		
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
		$image->brightness($folder . $rel_filename, $intensity);
		if ($image->hasError()) {
			$arr = $image->getError();
			$ret = new ktml4_error('KTML_IMAGE_ERROR', array($arr[1]));
			$this->setError($ret);
			return $ret;
		}
		
		if (!isset($_SESSION['ktml4']['filebrowser']['ExecPath']) && $image->getImageMagickPath()!='') {
			$_SESSION['ktml4']['filebrowser']['ExecPath'] = $image->getImageMagickPath();
		}
		KTML4_deleteThumbnails($folder, $rel_filename);
		$ret = $this->getfileinfo();
		return $ret;
	}
	
	/**
	 * Resize an image (or multiple images at once).
	 * @return KTML4 error or an array of image informations
	 * @access public
	 */
	function resize()	{
		if (!isset($_POST['rel_filename'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','rel_filename'));
			$this->setError($ret);
			return $ret;
		}
		$rel_filename = $_POST['rel_filename'];
		if ($rel_filename != KT_replaceSpecialChars($rel_filename, 'file')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','rel_filename'));
			$this->setError($ret);
			return $ret;
		}
		$rel_filename = KT_replaceSpecialChars($rel_filename, 'file');
		
		if (!isset($_POST['folder'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = $_POST['folder'];
		if ($folder != KT_replaceSpecialChars($folder, 'folder')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = KT_RealPath($this->folderName . $folder, true);
		
		if (!isset($_POST['keep_proportion'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','keep_proportion'));
			$this->setError($ret);
			return $ret;
		} else {
			if (!in_array(strtolower($_POST['keep_proportion']),array('true','false'))) {
				$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','keep_proportion'));
				$this->setError($ret);
				return $ret;
			}
		}
		$keep_proportion = strtolower($_POST['keep_proportion']) == 'true';
		
		if (!isset($_POST['width'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','width'));
			$this->setError($ret);
			return $ret;
		}
		$width = (int)$_POST['width'];
		if ($width < 0) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','width'));
			$this->setError($ret);
			return $ret;
		}
		if ($width == 0 && $keep_proportion == false) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','width'));
			$this->setError($ret);
			return $ret;
		}
		
		if (!isset($_POST['height'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','height'));
			$this->setError($ret);
			return $ret;
		}
		$height = (int)$_POST['height'];
		if ($height < 0) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','height'));
			$this->setError($ret);
			return $ret;
		}
		if ($height == 0 && $keep_proportion == false) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','height'));
			$this->setError($ret);
			return $ret;
		}
		
		if ($width == 0 && $height == 0) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','width'));
			$this->setError($ret);
			return $ret;
		}
		
		$ret = KTML4_add_undo($folder, $rel_filename);
		if ($ret !== null) {
			$this->setError($ret);
			return $ret;
		}
		
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
		$image->resize($folder . $rel_filename, $folder, $rel_filename, $width, $height, $keep_proportion);
		if ($image->hasError()) {
			$arr = $image->getError();
			$ret = new ktml4_error('KTML_IMAGE_ERROR', array($arr[1]));
			$this->setError($ret);
			return $ret;
		}
		
		if (!isset($_SESSION['ktml4']['filebrowser']['ExecPath']) && $image->getImageMagickPath()!='') {
			$_SESSION['ktml4']['filebrowser']['ExecPath'] = $image->getImageMagickPath();
		}
		KTML4_deleteThumbnails($folder, $rel_filename);
		$ret = $this->getfileinfo();
		return $ret;
	}
	/**
	 * Create an thumbnail for an image (or for multiple images at once, the pictures are separated by | if more than one ).
	 * @return KTML4 error or an array of thumbnails paths
	 * @access public
	 */
	function createpreview() {
		if (!isset($_POST['rel_filename'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','rel_filename'));
			$this->setError($ret);
			return $ret;
		}
		$rel_filename = $_POST['rel_filename'];
		$arrFiles = explode('|', $rel_filename);
		$arrFilesOrig = $arrFiles;
		foreach ($arrFiles as $k=>$v) {
			$arrFilesOrig[$k] = $v;
			$arrFiles[$k] = KT_replaceSpecialChars($v, 'file');
		}
				
		if (!isset($_POST['folder'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = $_POST['folder'];
		if ($folder != KT_replaceSpecialChars($folder, 'folder')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = KT_RealPath($this->folderName . $folder, true);
		
		if (!isset($_POST['size'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','size'));
			$this->setError($ret);
			return $ret;
		} else {
			if (!in_array(strtolower($_POST['size']), array('large','small'))) {
				$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','size'));
				$this->setError($ret);
				return $ret;
			}
		}
		$size = strtolower($_POST['size']);
		if ($size == 'large') {
			$width = constant('KTML4_IMAGE_WIDTH');
			$height = constant('KTML4_IMAGE_HEIGHT');
		} else {
			$width = constant('KTML4_THUMBNAIL_WIDTH');
			$height = constant('KTML4_THUMBNAIL_HEIGHT');
		}
		$ret = array();
		reset($arrFiles);
		foreach ($arrFiles as $k=>$filename) {
			$index = count($ret);
			$path_info = KT_pathinfo($filename);
			$fileNameDestination = $path_info['filename'].'_'.$width.'x'.$height.'.'.$path_info['extension'];
			
			if (!file_exists($folder . $filename)) {
				$arrErrThumb = array('thumbnail'=>'ERROR', 'error'=>array('code'=>'KTML_IMAGE_ERROR','message'=>KT_getResource('KTML_ARGUMENT_INVALID', 'KTML4', array('Image', $_POST['folder'] . $arrFilesOrig[$k]))));
				$ret[$index] = array_merge(array('orig_filename'=>$arrFilesOrig[$k]), $arrErrThumb);
				continue;
			}
						
			if (file_exists($folder . constant('KTML4_THUMBNAIL_FOLDER') . $fileNameDestination)) {
				$imageDetails = KTML4_getImageInfo_read($folder, $filename);
				if ($imageDetails['dateLastModified'] != -1) {
					$ret[$index] = array_merge(array('orig_filename'=>$arrFilesOrig[$k], 'thumbnail'=> $_POST['folder'] . constant('KTML4_THUMBNAIL_FOLDER') . $fileNameDestination), $this->getfileinfo_internal($folder, $filename));
					continue;
				}
				KTML4_deleteThumbnails($folder, $filename);
			}
			
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
			if ($size == 'large') {
				$image->resize($folder . $filename, $folder. constant('KTML4_THUMBNAIL_FOLDER'), $fileNameDestination, $width, $height, true);
			} else {
				$image->thumbnail($folder . $filename, $folder. constant('KTML4_THUMBNAIL_FOLDER'), $fileNameDestination, $width, $height, true);
			}
			$arrErrThumb = array('thumbnail'=> $_POST['folder'] . constant('KTML4_THUMBNAIL_FOLDER') . $fileNameDestination);
			if ($image->hasError()) {
				$arr = $image->getError();
				$arrErrThumb = array('thumbnail'=>'ERROR', 'error'=>array('code'=>'KTML_IMAGE_ERROR', 'message'=>$arr[1]));
				KTML4_deleteThumbnails($folder, $filename);
			} else {
				$arr = KTML4_getImageInfo($folder, $filename);
				if (isset($arr['error'])) {
					$arrErrThumb = array('thumbnail'=>'ERROR', 'error'=>array('code'=>'KTML_IMAGE_ERROR', 'message'=>$arr['error']));
				}
			}
			
			if (!isset($_SESSION['ktml4']['filebrowser']['ExecPath']) && $image->getImageMagickPath()!='') {
				$_SESSION['ktml4']['filebrowser']['ExecPath'] = $image->getImageMagickPath();
			}
			
			$ret[$index] = array_merge(array('orig_filename'=>$arrFilesOrig[$k]), $this->getfileinfo_internal($folder, $filename), $arrErrThumb);
		}
		return $ret;
	}

    
	/**
	 * Retrieve image informations.
	 * @return array image informations (width, height, size)
	 * @access public
	 */
	function getfileinfo() {
		if (!isset($_POST['rel_filename'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','rel_filename'));
			$this->setError($ret);
			return $ret;
		}
		$rel_filename = $_POST['rel_filename'];		
		if ($rel_filename != KT_replaceSpecialChars($rel_filename, 'file')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','rel_filename'));
			$this->setError($ret);
			return $ret;
		}
		$rel_filename = KT_replaceSpecialChars($rel_filename, 'file');
				
		if (!isset($_POST['folder'])) {
			$ret = new ktml4_error('KTML_ARGUMENT_NOT_SET', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = $_POST['folder'];
		if ($folder != KT_replaceSpecialChars($folder, 'folder')) {
			$ret = new ktml4_error('KTML_ARGUMENT_INVALID', array('IMAGE','folder'));
			$this->setError($ret);
			return $ret;
		}
		$folder = KT_RealPath($this->folderName . $folder, true);
				
		$arr = @getimagesize($folder . $rel_filename);
		if ($arr === false) {
			$ret = new ktml4_error('KTML_IMAGE_ERROR', array('Error reading image properties.'));
			$this->setError($ret);
			return $ret;
		}
		$arr = array("size"=>filesize($folder . $rel_filename), "width"=>$arr[0], "height"=>$arr[1]);
		return $arr;
	}

	/**
	 * Retrieve image informations. Receive the foldername and filename as arguments. It is used from createpreview().
	 * @param string folder name
	 * @param string file name
	 * @return array image informations (width, height, size)
	 * @access public
	 */
	function getfileinfo_internal($folder, $filename) {
		$arr =  KTML4_getImageInfo_read($folder, $filename);
		return array('size'=>filesize($folder . $filename), 'width'=>$arr['width'], 'height'=>$arr['height']);
	}
	
	/**
	 * Retrieve the image lib's capabilities (the operations it can perform).
	 * @return array 
	 * @access public
	 */
	function checkcapabilities() {
		$image = new KT_image();
		$imageLib = '';
		$ret = array('hasimg'=>'');
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
		$imageMagik = $image->checkImageMagik();
		
		if (!isset($_SESSION['ktml4']['filebrowser']['ExecPath']) && $image->getImageMagickPath()!='') {
			$_SESSION['ktml4']['filebrowser']['ExecPath'] = $image->getImageMagickPath();
		}
		$gdversion = $image->getVersionGd();
		$ret = array();
		if ($imageMagik === true) {
			$ret = array('hasimg'=>'yes', 'resize' => 1, 'rotate' => 1, 'crop' => 1, 'degrade' => 1, 'flip' => 1, 'sharpen' => 1, 'blur' => 1, 'contrast' => 1, 'brightness' => 1);
		} elseif ($gdversion >= 1) {
			$ret = array('hasimg'=>'yes', 'resize' => 1, 'rotate' => 1, 'crop' => 1, 'degrade' => 1, 'flip' => 1);
			if (!function_exists('imagerotate')) {
				$ret = array('hasimg'=>'yes', 'resize' => 1, 'crop' => 1, 'degrade' => 1, 'flip' => 1);
			}
			if (substr(PHP_VERSION, 0, 1) == '5') {
				if (function_exists('imagefilter')) {
					$ret = array_merge($ret, array('hasimg'=>'yes', 'blur' => 1, 'contrast' => 1, 'brightness' => 1));
				}
			}
		} else {
			$ret = array('hasimg'=>'');
		}
		return $ret;
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
