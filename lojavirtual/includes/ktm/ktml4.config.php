<?php
/**
 * Folder where the images' thumbnails are kept
 * @var string
 */
define('KTML4_THUMBNAIL_FOLDER', '.thumbnails/');

/**
 * Image browser thumbnail width (in pixels)
 * @var numeric
 */
define('KTML4_THUMBNAIL_WIDTH', '100');

/**
 * Image browser thumbnail height (in pixels)
 * @var numeric
 */
define('KTML4_THUMBNAIL_HEIGHT', '100');

/**
 * Image editor thumbnail width (in pixels)
 * @var numeric
 */
define('KTML4_IMAGE_WIDTH', '480');

/**
 * Image editor thumbnail height (in pixels)
 * @var numeric
 */
define('KTML4_IMAGE_HEIGHT', '360');

/**
 * Maximum image width (in pixels). If the uploaded image is wider, the image is resized.
 * @var numeric
 */
define('KTML4_MAX_UPLOAD_IMAGE_WIDTH', '800');

/**
 * Maximum image height (in pixels). If the uploaded image is higher, the image is resized.
 * @var numeric
 */
define('KTML4_MAX_UPLOAD_IMAGE_HEIGHT', '600');
/**
 * Custom modules list.
 * @var array
 */
$GLOBALS['KTML4_custom_modules'] = array(
  'date' => array(
    'date' => array ('getCurrentDate')
  )
);

/**
 * Global configuration variables list.
 * @var array
 */
$GLOBALS['KTML4_GLOBALS'] = array(
	'allowed_tags_list' => '',
	'denied_tags_list' => 'script,iframe,frame',
	'add_new_paragraph_on_enter' => 'true',
	'special_chars' => '',
	'colors' => '',
	'fonts' => 'Arial, Helvetica, sans-serif|Times New Roman, Times, serif|Courier New, Courier, mono|Georgia, Times New Roman, Times, serif|Verdana, Arial, Helvetica, sans-serif|Geneva, Arial, Helvetica, sans-serif',
	'editor_inner_dimensions' => 'false',
	'stop_parent_scroll_on_focus' => 'true',
	'auto_clean_on_paste' => 'word',
	'skip_doctype_check' => 'false',
	'logical_emphasis' => 'true',
	'online_interakt_spellcheck' => 'false',
	'insertlink_prompt_for_url' => 'true',
	'debug' => 'false',
	'no_folder_info' => 'false',
);
?>
