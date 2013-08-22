<?php require_once('../Connections/lojavirtual.php'); ?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

// Load the common classes
require_once('../includes/common/KT_common.php');

// Require the MXI classes
require_once ('../includes/mxi/MXI.php');

// KTML 4 Server Side Include
require_once("../includes/ktm/ktml4.php");

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_lojavirtual = new KT_connection($lojavirtual, $database_lojavirtual);

// Start trigger
$formValidation = new tNG_FormValidation();
$tNGs->prepareValidation($formValidation);
// End trigger

// Make an update transaction instance
$upd_geral = new tNG_update($conn_lojavirtual);
$tNGs->addTransaction($upd_geral);
// Register triggers
$upd_geral->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_geral->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_geral->registerTrigger("END", "Trigger_Default_Redirect", 99, "abanner.php?id=1");
// Add columns
$upd_geral->setTable("geral");
$upd_geral->addColumn("titulo", "STRING_TYPE", "POST", "titulo");
$upd_geral->addColumn("conteudo", "STRING_TYPE", "POST", "conteudo");
$upd_geral->addColumn("leia_mais", "STRING_TYPE", "POST", "leia_mais");
$upd_geral->addColumn("data", "DATE_TYPE", "POST", "data");
$upd_geral->setPrimaryKey("id", "NUMERIC_TYPE", "GET", "id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsgeral = $tNGs->getRecordset("geral");
$row_rsgeral = mysql_fetch_assoc($rsgeral);
$totalRows_rsgeral = mysql_num_rows($rsgeral);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>www.ajaxme.com</title>
<link href="css.css" rel="stylesheet" type="text/css" />
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
<script src="../includes/ktm/core/ktml.js" type="text/javascript"></script>
<script src="../includes/resources/ktml.js" type="text/javascript"></script>
<link href="../includes/ktm/core/styles/ktml.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript">
	ktml_init_object = {
		"debugger_params": false,
		"path": "../includes/ktm/",
		"server": "php"
	};
</script>
<script type="text/javascript">
	conteudo_config = {
		"width": 400,
		"height": 350,
		"show_toolbar": "load",
		"show_pi": true,
		"background_color": "#FFFFFF",
		"strip_server_location": false,
		"auto_focus": true,
		"module_props": { },
		"buttons": [
			[1, "standard", ["cut", "copy", "paste", "undo", "redo", "find_replace", "toggle_visible", "spellcheck", "toggle_editmode", "toggle_fullscreen", "help"]],
			[1, "formatting", ["bold", "italic", "underline", "align_left", "align_center", "align_right", "align_justify", "numbered_list", "bulleted_list", "outdent", "indent", "clean_menu", "foreground_color", "background_color", "superscript", "subscript"]],
			[2, "styles", ["heading_list", "style_list", "fonttype_list", "fontsize_list"]],
			[2, "insert", ["insert_link", "insert_anchor", "insert_table", "insert_image", "insert_file", "insert_template", "horizontal_rule", "insert_character"]],
			[3, "form", ["insert_form", "insert_textfield", "insert_hiddenfield", "insert_textarea", "insert_checkbox", "insert_radiobutton", "insert_listmenu", "insert_filefield", "insert_button", "insert_label", "insert_fieldset"]]
		]
	};
	<?php
		$ktml_conteudo = new ktml4("conteudo");
		$ktml_conteudo->setModuleProperty("filebrowser", "AllowedModule", "true", false);
		$ktml_conteudo->setModuleProperty("filebrowser", "MaxFileSize", "1024", true);
		$ktml_conteudo->setModuleProperty("filebrowser", "RejectedFolders", "", false);
		$ktml_conteudo->setModuleProperty("file", "UploadFolder", "../uploads/files/", false);
		$ktml_conteudo->setModuleProperty("file", "UploadFolderUrl", "../uploads/files/", true);
		$ktml_conteudo->setModuleProperty("file", "AllowedFileTypes", "doc, pdf, csv, xls, rtf, sxw, odt", true);
		$ktml_conteudo->setModuleProperty("media", "UploadFolder", "../uploads/media/", false);
		$ktml_conteudo->setModuleProperty("media", "UploadFolderUrl", "../uploads/media/", true);
		$ktml_conteudo->setModuleProperty("media", "AllowedFileTypes", "bmp, mov, mpg, mp3, avi, mpeg, swf, wmv, jpg, jpeg, gif, png", true);
		$ktml_conteudo->setModuleProperty("templates", "AllowedModule", "true", false);
		$ktml_conteudo->setModuleProperty("templates", "UploadFolder", "../uploads/templates/", false);
		$ktml_conteudo->setModuleProperty("xhtml", "AllowedModule", "true", false);
		$ktml_conteudo->setModuleProperty("xhtml", "xhtml_view_source", "true", true);
		$ktml_conteudo->setModuleProperty("xhtml", "xhtml_save", "true", true);
		$ktml_conteudo->setModuleProperty("spellchecker", "AllowedModule", "true", false);
		$ktml_conteudo->setModuleProperty("css", "PathToStyle", "../includes/ktm/styles/KT_styles.css", true);
		$ktml_conteudo->setModuleProperty("hyperlink_browser", "ServiceProvider", "../includes/ktm/hyperlink_service.php", true);
		$ktml_conteudo->Execute();
	?>
</script>
<script type="text/javascript">
	leia_mais_config = {
		"width": 400,
		"height": 350,
		"show_toolbar": "load",
		"show_pi": true,
		"background_color": "#FFFFFF",
		"strip_server_location": false,
		"auto_focus": true,
		"module_props": { },
		"buttons": [
			[1, "standard", ["cut", "copy", "paste", "undo", "redo", "find_replace", "toggle_visible", "spellcheck", "toggle_editmode", "toggle_fullscreen", "help"]],
			[1, "formatting", ["bold", "italic", "underline", "align_left", "align_center", "align_right", "align_justify", "numbered_list", "bulleted_list", "outdent", "indent", "clean_menu", "foreground_color", "background_color", "superscript", "subscript"]],
			[2, "styles", ["heading_list", "style_list", "fonttype_list", "fontsize_list"]],
			[2, "insert", ["insert_link", "insert_anchor", "insert_table", "insert_image", "insert_file", "insert_template", "horizontal_rule", "insert_character"]],
			[3, "form", ["insert_form", "insert_textfield", "insert_hiddenfield", "insert_textarea", "insert_checkbox", "insert_radiobutton", "insert_listmenu", "insert_filefield", "insert_button", "insert_label", "insert_fieldset"]]
		]
	};
	<?php
		$ktml_leia_mais = new ktml4("leia_mais");
		$ktml_leia_mais->setModuleProperty("filebrowser", "AllowedModule", "true", false);
		$ktml_leia_mais->setModuleProperty("filebrowser", "MaxFileSize", "1024", true);
		$ktml_leia_mais->setModuleProperty("filebrowser", "RejectedFolders", "", false);
		$ktml_leia_mais->setModuleProperty("file", "UploadFolder", "../uploads/files/", false);
		$ktml_leia_mais->setModuleProperty("file", "UploadFolderUrl", "../uploads/files/", true);
		$ktml_leia_mais->setModuleProperty("file", "AllowedFileTypes", "doc, pdf, csv, xls, rtf, sxw, odt", true);
		$ktml_leia_mais->setModuleProperty("media", "UploadFolder", "../uploads/media/", false);
		$ktml_leia_mais->setModuleProperty("media", "UploadFolderUrl", "../uploads/media/", true);
		$ktml_leia_mais->setModuleProperty("media", "AllowedFileTypes", "bmp, mov, mpg, mp3, avi, mpeg, swf, wmv, jpg, jpeg, gif, png", true);
		$ktml_leia_mais->setModuleProperty("templates", "AllowedModule", "true", false);
		$ktml_leia_mais->setModuleProperty("templates", "UploadFolder", "../uploads/templates/", false);
		$ktml_leia_mais->setModuleProperty("xhtml", "AllowedModule", "true", false);
		$ktml_leia_mais->setModuleProperty("xhtml", "xhtml_view_source", "true", true);
		$ktml_leia_mais->setModuleProperty("xhtml", "xhtml_save", "true", true);
		$ktml_leia_mais->setModuleProperty("spellchecker", "AllowedModule", "true", false);
		$ktml_leia_mais->setModuleProperty("css", "PathToStyle", "../includes/ktm/styles/KT_styles.css", true);
		$ktml_leia_mais->setModuleProperty("hyperlink_browser", "ServiceProvider", "../includes/ktm/hyperlink_service.php", true);
		$ktml_leia_mais->Execute();
	?>
</script>
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="../includes/resources/calendar.js"></script>
</head>

<body>
<div class="container">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="2"><div class="container_header">
        <?php
  mxi_includes_start("new_header.php");
  require(basename("new_header.php"));
  mxi_includes_end();
?></div></td>
    </tr>
    <tr>
      <td width="20%" valign="top"><div class="container_menu">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="30" class="header_menu">Menu</td>
          </tr>
          <tr>
            <td>
              <?php
  mxi_includes_start("new_menu.php");
  require(basename("new_menu.php"));
  mxi_includes_end();
?></td>
          </tr>
        </table>
       
      </div>
	  </td>
      <td width="80%" valign="top"><div class="container_conteudo">
       
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="header_conteudo">Atualizar banner </td>
          </tr>
          <tr>
            <td height="135"><div align="center">
              <p>&nbsp;
                <?php
	echo $tNGs->getErrorMsg();
?>

              <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
                <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                  <tr>
                    <td class="KT_th"><label for="titulo">Titulo:</label></td>
                    <td><input type="text" name="titulo" id="titulo" value="<?php echo KT_escapeAttribute($row_rsgeral['titulo']); ?>" size="32" />
                        <?php echo $tNGs->displayFieldHint("titulo");?> <?php echo $tNGs->displayFieldError("geral", "titulo"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="conteudo">Conteudo:</label></td>
                    <td><input type="hidden" id="conteudo" name="conteudo" value="<?php echo KTML4_escapeAttribute($row_rsgeral['conteudo']); ?>" />
                      <script type="text/javascript">
  // KTML4 Object
  ktml_conteudo = new ktml("conteudo");
</script>
                      <?php echo $tNGs->displayFieldHint("conteudo");?> <?php echo $tNGs->displayFieldError("geral", "conteudo"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="leia_mais">Leia_mais:</label></td>
                    <td><input type="hidden" id="leia_mais" name="leia_mais" value="<?php echo KTML4_escapeAttribute($row_rsgeral['leia_mais']); ?>" />
                      <script type="text/javascript">
  // KTML4 Object
  ktml_leia_mais = new ktml("leia_mais");
</script>
                      <?php echo $tNGs->displayFieldHint("leia_mais");?> <?php echo $tNGs->displayFieldError("geral", "leia_mais"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="data">Data:</label></td>
                    <td><input name="data" id="data" value="<?php echo KT_formatDate($row_rsgeral['data']); ?>" size="32" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="false" wdg:restricttomask="yes" wdg:readonly="true" />
                        <?php echo $tNGs->displayFieldHint("data");?> <?php echo $tNGs->displayFieldError("geral", "data"); ?> </td>
                  </tr>
                  <tr class="KT_buttons">
                    <td colspan="2"><input type="submit" name="KT_Update1" id="KT_Update1" value="Atualizar" />
                    </td>
                  </tr>
                </table>
              </form>
              <p>&nbsp;</p>
              </p>
</div></td>
          </tr>
        </table>
        </div></td>
    </tr>
    <tr>
      <td colspan="2"><div class="container_header">
        <?php
  mxi_includes_start("new_footer.php");
  require(basename("new_footer.php"));
  mxi_includes_end();
?></div></td>
    </tr>
  </table>
</div>
</body>
</html>
