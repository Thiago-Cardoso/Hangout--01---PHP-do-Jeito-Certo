<?php require_once('../Connections/lojavirtual.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');

// Require the MXI classes
require_once ('../includes/mxi/MXI.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_lojavirtual = new KT_connection($lojavirtual, $database_lojavirtual);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("nome", true, "text", "", "", "", "");
$formValidation->addField("imagem", true, "", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_ImageUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_ImageUpload(&$tNG) {
  $uploadObj = new tNG_ImageUpload($tNG);
  $uploadObj->setFormFieldName("imagem");
  $uploadObj->setDbFieldName("imagem");
  $uploadObj->setFolder("../admin/imagens/categorias/");
  $uploadObj->setMaxSize(1500);
  $uploadObj->setAllowedExtensions("gif, jpg, jpe, jpeg, png");
  $uploadObj->setRename("auto");
  return $uploadObj->Execute();
}
//end Trigger_ImageUpload trigger

// Make an insert transaction instance
$ins_categorias = new tNG_insert($conn_lojavirtual);
$tNGs->addTransaction($ins_categorias);
// Register triggers
$ins_categorias->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_categorias->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_categorias->registerTrigger("END", "Trigger_Default_Redirect", 99, "ecategorias.php");
$ins_categorias->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$ins_categorias->setTable("categorias");
$ins_categorias->addColumn("nome", "STRING_TYPE", "POST", "nome");
$ins_categorias->addColumn("imagem", "FILE_TYPE", "FILES", "imagem");
$ins_categorias->addColumn("descricao", "STRING_TYPE", "POST", "descricao");
$ins_categorias->setPrimaryKey("id", "NUMERIC_TYPE");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscategorias = $tNGs->getRecordset("categorias");
$row_rscategorias = mysql_fetch_assoc($rscategorias);
$totalRows_rscategorias = mysql_num_rows($rscategorias);
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
            <td class="header_conteudo">Inserir categorias </td>
          </tr>
          <tr>
            <td height="135"><div align="center">
              <?php
	echo $tNGs->getErrorMsg();
?>
              <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
                <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                  <tr>
                    <td class="KT_th"><label for="nome">Nome:</label></td>
                    <td><input type="text" name="nome" id="nome" value="<?php echo KT_escapeAttribute($row_rscategorias['nome']); ?>" size="32" />
                        <?php echo $tNGs->displayFieldHint("nome");?> <?php echo $tNGs->displayFieldError("categorias", "nome"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="imagem">Imagem:</label></td>
                    <td><input type="file" name="imagem" id="imagem" size="32" />
                        <?php echo $tNGs->displayFieldError("categorias", "imagem"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="descricao">Descricao:</label></td>
                    <td><textarea name="descricao" id="descricao" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rscategorias['descricao']); ?></textarea>
                        <?php echo $tNGs->displayFieldHint("descricao");?> <?php echo $tNGs->displayFieldError("categorias", "descricao"); ?> </td>
                  </tr>
                  <tr class="KT_buttons">
                    <td colspan="2"><input type="submit" name="KT_Insert1" id="KT_Insert1" value="Inserir" />
                    </td>
                  </tr>
                </table>
              </form>
              <p>&nbsp;</p>
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
