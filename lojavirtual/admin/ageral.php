<?php require_once('../Connections/lojavirtual.php'); ?>
<?php
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
$upd_template = new tNG_update($conn_lojavirtual);
$tNGs->addTransaction($upd_template);
// Register triggers
$upd_template->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_template->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_template->registerTrigger("END", "Trigger_Default_Redirect", 99, "ageral.php?id=1");
// Add columns
$upd_template->setTable("template");
$upd_template->addColumn("titulo", "STRING_TYPE", "POST", "titulo");
$upd_template->addColumn("palavras", "STRING_TYPE", "POST", "palavras");
$upd_template->addColumn("descricao", "STRING_TYPE", "POST", "descricao");
$upd_template->addColumn("header", "STRING_TYPE", "POST", "header");
$upd_template->addColumn("rodape", "STRING_TYPE", "POST", "rodape");
$upd_template->setPrimaryKey("id", "NUMERIC_TYPE", "GET", "id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rstemplate = $tNGs->getRecordset("template");
$row_rstemplate = mysql_fetch_assoc($rstemplate);
$totalRows_rstemplate = mysql_num_rows($rstemplate);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
	header_config = {
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
		$ktml_header = new ktml4("header");
		$ktml_header->setModuleProperty("filebrowser", "AllowedModule", "true", false);
		$ktml_header->setModuleProperty("filebrowser", "MaxFileSize", "1024", true);
		$ktml_header->setModuleProperty("filebrowser", "RejectedFolders", "", false);
		$ktml_header->setModuleProperty("file", "UploadFolder", "../uploads/files/", false);
		$ktml_header->setModuleProperty("file", "UploadFolderUrl", "../uploads/files/", true);
		$ktml_header->setModuleProperty("file", "AllowedFileTypes", "doc, pdf, csv, xls, rtf, sxw, odt", true);
		$ktml_header->setModuleProperty("media", "UploadFolder", "../uploads/media/", false);
		$ktml_header->setModuleProperty("media", "UploadFolderUrl", "../uploads/media/", true);
		$ktml_header->setModuleProperty("media", "AllowedFileTypes", "bmp, mov, mpg, mp3, avi, mpeg, swf, wmv, jpg, jpeg, gif, png", true);
		$ktml_header->setModuleProperty("templates", "AllowedModule", "true", false);
		$ktml_header->setModuleProperty("templates", "UploadFolder", "../uploads/templates/", false);
		$ktml_header->setModuleProperty("xhtml", "AllowedModule", "true", false);
		$ktml_header->setModuleProperty("xhtml", "xhtml_view_source", "true", true);
		$ktml_header->setModuleProperty("xhtml", "xhtml_save", "true", true);
		$ktml_header->setModuleProperty("spellchecker", "AllowedModule", "true", false);
		$ktml_header->setModuleProperty("css", "PathToStyle", "../includes/ktm/styles/KT_styles.css", true);
		$ktml_header->setModuleProperty("hyperlink_browser", "ServiceProvider", "../includes/ktm/hyperlink_service.php", true);
		$ktml_header->Execute();
	?>
</script>
<script type="text/javascript">
	rodape_config = {
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
		$ktml_rodape = new ktml4("rodape");
		$ktml_rodape->setModuleProperty("filebrowser", "AllowedModule", "true", false);
		$ktml_rodape->setModuleProperty("filebrowser", "MaxFileSize", "1024", true);
		$ktml_rodape->setModuleProperty("filebrowser", "RejectedFolders", "", false);
		$ktml_rodape->setModuleProperty("file", "UploadFolder", "../uploads/files/", false);
		$ktml_rodape->setModuleProperty("file", "UploadFolderUrl", "../uploads/files/", true);
		$ktml_rodape->setModuleProperty("file", "AllowedFileTypes", "doc, pdf, csv, xls, rtf, sxw, odt", true);
		$ktml_rodape->setModuleProperty("media", "UploadFolder", "../uploads/media/", false);
		$ktml_rodape->setModuleProperty("media", "UploadFolderUrl", "../uploads/media/", true);
		$ktml_rodape->setModuleProperty("media", "AllowedFileTypes", "bmp, mov, mpg, mp3, avi, mpeg, swf, wmv, jpg, jpeg, gif, png", true);
		$ktml_rodape->setModuleProperty("templates", "AllowedModule", "true", false);
		$ktml_rodape->setModuleProperty("templates", "UploadFolder", "../uploads/templates/", false);
		$ktml_rodape->setModuleProperty("xhtml", "AllowedModule", "true", false);
		$ktml_rodape->setModuleProperty("xhtml", "xhtml_view_source", "true", true);
		$ktml_rodape->setModuleProperty("xhtml", "xhtml_save", "true", true);
		$ktml_rodape->setModuleProperty("spellchecker", "AllowedModule", "true", false);
		$ktml_rodape->setModuleProperty("css", "PathToStyle", "../includes/ktm/styles/KT_styles.css", true);
		$ktml_rodape->setModuleProperty("hyperlink_browser", "ServiceProvider", "../includes/ktm/hyperlink_service.php", true);
		$ktml_rodape->Execute();
	?>
</script>
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
            <td class="header_conteudo">Atualizar Informa&ccedil;&otilde;es do site </td>
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
                    <td><input type="text" name="titulo" id="titulo" value="<?php echo KT_escapeAttribute($row_rstemplate['titulo']); ?>" size="32" />
                        <?php echo $tNGs->displayFieldHint("titulo");?> <?php echo $tNGs->displayFieldError("template", "titulo"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="palavras">Palavras:</label></td>
                    <td><textarea name="palavras" id="palavras" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rstemplate['palavras']); ?></textarea>
                        <?php echo $tNGs->displayFieldHint("palavras");?> <?php echo $tNGs->displayFieldError("template", "palavras"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="descricao">Descricao:</label></td>
                    <td><textarea name="descricao" id="descricao" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rstemplate['descricao']); ?></textarea>
                        <?php echo $tNGs->displayFieldHint("descricao");?> <?php echo $tNGs->displayFieldError("template", "descricao"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="header">Header:</label></td>
                    <td><input type="hidden" id="header" name="header" value="<?php echo KTML4_escapeAttribute($row_rstemplate['header']); ?>" />
                      <script type="text/javascript">
  // KTML4 Object
  ktml_header = new ktml("header");
</script>
                      <?php echo $tNGs->displayFieldHint("header");?> <?php echo $tNGs->displayFieldError("template", "header"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="rodape">Rodape:</label></td>
                    <td><input type="hidden" id="rodape" name="rodape" value="<?php echo KTML4_escapeAttribute($row_rstemplate['rodape']); ?>" />
                      <script type="text/javascript">
  // KTML4 Object
  ktml_rodape = new ktml("rodape");
</script>
                      <?php echo $tNGs->displayFieldHint("rodape");?> <?php echo $tNGs->displayFieldError("template", "rodape"); ?> </td>
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
