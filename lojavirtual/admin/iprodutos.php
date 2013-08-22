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
$formValidation->addField("id_categ", true, "numeric", "", "", "", "");
$formValidation->addField("produto", true, "text", "", "", "", "");
$formValidation->addField("descricao", true, "text", "", "", "", "");
$formValidation->addField("imagem", true, "", "", "", "", "");
$formValidation->addField("valor", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_ImageUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_ImageUpload(&$tNG) {
  $uploadObj = new tNG_ImageUpload($tNG);
  $uploadObj->setFormFieldName("imagem");
  $uploadObj->setDbFieldName("imagem");
  $uploadObj->setFolder("../admin/imagens/produtos/");
  $uploadObj->setMaxSize(1500);
  $uploadObj->setAllowedExtensions("gif, jpg, jpe, jpeg, png");
  $uploadObj->setRename("auto");
  return $uploadObj->Execute();
}
//end Trigger_ImageUpload trigger

mysql_select_db($database_lojavirtual, $lojavirtual);
$query_produtos = "SELECT * FROM categorias";
$produtos = mysql_query($query_produtos, $lojavirtual) or die(mysql_error());
$row_produtos = mysql_fetch_assoc($produtos);
$totalRows_produtos = mysql_num_rows($produtos);

// Make an insert transaction instance
$ins_produtos = new tNG_insert($conn_lojavirtual);
$tNGs->addTransaction($ins_produtos);
// Register triggers
$ins_produtos->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_produtos->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_produtos->registerTrigger("END", "Trigger_Default_Redirect", 99, "eprodutos.php");
$ins_produtos->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$ins_produtos->setTable("produtos");
$ins_produtos->addColumn("id_categ", "NUMERIC_TYPE", "POST", "id_categ");
$ins_produtos->addColumn("produto", "STRING_TYPE", "POST", "produto");
$ins_produtos->addColumn("descricao", "STRING_TYPE", "POST", "descricao");
$ins_produtos->addColumn("imagem", "FILE_TYPE", "FILES", "imagem");
$ins_produtos->addColumn("valor", "STRING_TYPE", "POST", "valor");
$ins_produtos->addColumn("frete", "STRING_TYPE", "POST", "frete");
$ins_produtos->addColumn("promocao", "CHECKBOX_1_0_TYPE", "POST", "promocao", "0");
$ins_produtos->addColumn("exibir", "CHECKBOX_1_0_TYPE", "POST", "exibir", "1");
$ins_produtos->setPrimaryKey("id", "NUMERIC_TYPE");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsprodutos = $tNGs->getRecordset("produtos");
$row_rsprodutos = mysql_fetch_assoc($rsprodutos);
$totalRows_rsprodutos = mysql_num_rows($rsprodutos);
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
	descricao_config = {
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
		$ktml_descricao = new ktml4("descricao");
		$ktml_descricao->setModuleProperty("filebrowser", "AllowedModule", "true", false);
		$ktml_descricao->setModuleProperty("filebrowser", "MaxFileSize", "1024", true);
		$ktml_descricao->setModuleProperty("filebrowser", "RejectedFolders", "", false);
		$ktml_descricao->setModuleProperty("file", "UploadFolder", "../uploads/files/", false);
		$ktml_descricao->setModuleProperty("file", "UploadFolderUrl", "../uploads/files/", true);
		$ktml_descricao->setModuleProperty("file", "AllowedFileTypes", "doc, pdf, csv, xls, rtf, sxw, odt", true);
		$ktml_descricao->setModuleProperty("media", "UploadFolder", "../uploads/media/", false);
		$ktml_descricao->setModuleProperty("media", "UploadFolderUrl", "../uploads/media/", true);
		$ktml_descricao->setModuleProperty("media", "AllowedFileTypes", "bmp, mov, mpg, mp3, avi, mpeg, swf, wmv, jpg, jpeg, gif, png", true);
		$ktml_descricao->setModuleProperty("templates", "AllowedModule", "true", false);
		$ktml_descricao->setModuleProperty("templates", "UploadFolder", "../uploads/templates/", false);
		$ktml_descricao->setModuleProperty("xhtml", "AllowedModule", "true", false);
		$ktml_descricao->setModuleProperty("xhtml", "xhtml_view_source", "true", true);
		$ktml_descricao->setModuleProperty("xhtml", "xhtml_save", "true", true);
		$ktml_descricao->setModuleProperty("spellchecker", "AllowedModule", "true", false);
		$ktml_descricao->setModuleProperty("css", "PathToStyle", "../includes/ktm/styles/KT_styles.css", true);
		$ktml_descricao->setModuleProperty("hyperlink_browser", "ServiceProvider", "../includes/ktm/hyperlink_service.php", true);
		$ktml_descricao->Execute();
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
      <td width="145" valign="top"><div class="container_menu">
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
            <td class="header_conteudo">Inserir produtos </td>
          </tr>
          <tr>
            <td height="135"><div align="center">
              <p>&nbsp;
                <?php
	echo $tNGs->getErrorMsg();
?>
              <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
                <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                  <tr>
                    <td class="KT_th"><label for="id_categ">Categoria:</label></td>
                    <td><select name="id_categ" id="id_categ">
                        <?php 
do {  
?>
                        <option value="<?php echo $row_produtos['id']?>"<?php if (!(strcmp($row_produtos['id'], $row_rsprodutos['id_categ']))) {echo "SELECTED";} ?>><?php echo $row_produtos['nome']?></option>
                        <?php
} while ($row_produtos = mysql_fetch_assoc($produtos));
  $rows = mysql_num_rows($produtos);
  if($rows > 0) {
      mysql_data_seek($produtos, 0);
	  $row_produtos = mysql_fetch_assoc($produtos);
  }
?>
                      </select>
                        <?php echo $tNGs->displayFieldError("produtos", "id_categ"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="produto">Produto:</label></td>
                    <td><input type="text" name="produto" id="produto" value="<?php echo KT_escapeAttribute($row_rsprodutos['produto']); ?>" size="32" />
                        <?php echo $tNGs->displayFieldHint("produto");?> <?php echo $tNGs->displayFieldError("produtos", "produto"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="descricao">Descricao:</label></td>
                    <td><input type="hidden" id="descricao" name="descricao" value="<?php echo KTML4_escapeAttribute($row_rsprodutos['descricao']); ?>" />
                      <script type="text/javascript">
  // KTML4 Object
  ktml_descricao = new ktml("descricao");
</script>
                      <?php echo $tNGs->displayFieldHint("descricao");?> <?php echo $tNGs->displayFieldError("produtos", "descricao"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="imagem">Imagem:</label></td>
                    <td><input type="file" name="imagem" id="imagem" size="32" />
                        <?php echo $tNGs->displayFieldError("produtos", "imagem"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="valor">Valor:</label></td>
                    <td><input type="text" name="valor" id="valor" value="<?php echo KT_escapeAttribute($row_rsprodutos['valor']); ?>" size="32" />
                        <?php echo $tNGs->displayFieldHint("valor");?> <?php echo $tNGs->displayFieldError("produtos", "valor"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="frete">Frete:</label></td>
                    <td><input type="text" name="frete" id="frete" value="<?php echo KT_escapeAttribute($row_rsprodutos['frete']); ?>" size="32" />
                        <?php echo $tNGs->displayFieldHint("frete");?> <?php echo $tNGs->displayFieldError("produtos", "frete"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="promocao">Promocao:</label></td>
                    <td><input  <?php if (!(strcmp(KT_escapeAttribute($row_rsprodutos['promocao']),"1"))) {echo "checked";} ?> type="checkbox" name="promocao" id="promocao" value="1" />
                        <?php echo $tNGs->displayFieldError("produtos", "promocao"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="exibir">Exibir:</label></td>
                    <td><input  <?php if (!(strcmp(KT_escapeAttribute($row_rsprodutos['exibir']),"1"))) {echo "checked";} ?> type="checkbox" name="exibir" id="exibir" value="1" />
                        <?php echo $tNGs->displayFieldError("produtos", "exibir"); ?> </td>
                  </tr>
                  <tr class="KT_buttons">
                    <td colspan="2"><input type="submit" name="KT_Insert1" id="KT_Insert1" value="Inserir" />
                    </td>
                  </tr>
                </table>
              </form>
             
              
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
?>
      </div></td>
    </tr>
  </table>
</div>
</body>
</html>
<?php
mysql_free_result($produtos);
?>
