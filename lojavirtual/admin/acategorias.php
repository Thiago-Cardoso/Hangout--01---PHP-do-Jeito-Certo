<?php require_once('../Connections/lojavirtual.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');

// Require the MXI classes
require_once ('../includes/mxi/MXI.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Load the KT_back class
require_once('../includes/nxt/KT_back.php');

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

// Make an insert transaction instance
$ins_categorias = new tNG_multipleInsert($conn_lojavirtual);
$tNGs->addTransaction($ins_categorias);
// Register triggers
$ins_categorias->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_categorias->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_categorias->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$ins_categorias->setTable("categorias");
$ins_categorias->addColumn("nome", "STRING_TYPE", "POST", "nome");
$ins_categorias->addColumn("imagem", "FILE_TYPE", "FILES", "imagem");
$ins_categorias->addColumn("descricao", "STRING_TYPE", "POST", "descricao");
$ins_categorias->setPrimaryKey("id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_categorias = new tNG_multipleUpdate($conn_lojavirtual);
$tNGs->addTransaction($upd_categorias);
// Register triggers
$upd_categorias->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_categorias->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_categorias->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$upd_categorias->setTable("categorias");
$upd_categorias->addColumn("nome", "STRING_TYPE", "POST", "nome");
$upd_categorias->addColumn("imagem", "FILE_TYPE", "FILES", "imagem");
$upd_categorias->addColumn("descricao", "STRING_TYPE", "POST", "descricao");
$upd_categorias->setPrimaryKey("id", "NUMERIC_TYPE", "GET", "id");

// Make an instance of the transaction object
$del_categorias = new tNG_multipleDelete($conn_lojavirtual);
$tNGs->addTransaction($del_categorias);
// Register triggers
$del_categorias->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_categorias->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_categorias->setTable("categorias");
$del_categorias->setPrimaryKey("id", "NUMERIC_TYPE", "GET", "id");

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
<script src="../includes/nxt/scripts/form.js" type="text/javascript"></script>
<script src="../includes/nxt/scripts/form.js.php" type="text/javascript"></script>
<script type="text/javascript">
$NXT_FORM_SETTINGS = {
  duplicate_buttons: true,
  show_as_grid: true,
  merge_down_value: true
}
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
            <td class="header_conteudo">Atualizar categorias </td>
          </tr>
          <tr>
            <td height="135"><div align="center">
              <p>&nbsp;
                <?php
	echo $tNGs->getErrorMsg();
?>
              <div class="KT_tng">
                <h1>&nbsp;</h1>
                <div class="KT_tngform">
                  <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
                    <?php $cnt1 = 0; ?>
                    <?php do { ?>
                      <?php $cnt1++; ?>
                      <?php 
// Show IF Conditional region1 
if (@$totalRows_rscategorias > 1) {
?>
                        <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
                        <?php } 
// endif Conditional region1
?>
                      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                        <tr>
                          <td class="KT_th"><label for="nome_<?php echo $cnt1; ?>">Nome:</label></td>
                          <td><input type="text" name="nome_<?php echo $cnt1; ?>" id="nome_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscategorias['nome']); ?>" size="32" maxlength="255" />
                              <?php echo $tNGs->displayFieldHint("nome");?> <?php echo $tNGs->displayFieldError("categorias", "nome", $cnt1); ?> </td>
                        </tr>
                        <tr>
                          <td class="KT_th"><label for="imagem_<?php echo $cnt1; ?>">Imagem:</label></td>
                          <td><input type="file" name="imagem_<?php echo $cnt1; ?>" id="imagem_<?php echo $cnt1; ?>" size="32" />
                              <?php echo $tNGs->displayFieldError("categorias", "imagem", $cnt1); ?> </td>
                        </tr>
                        <tr>
                          <td class="KT_th"><label for="descricao_<?php echo $cnt1; ?>">Descricao:</label></td>
                          <td><textarea name="descricao_<?php echo $cnt1; ?>" id="descricao_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rscategorias['descricao']); ?></textarea>
                              <?php echo $tNGs->displayFieldHint("descricao");?> <?php echo $tNGs->displayFieldError("categorias", "descricao", $cnt1); ?> </td>
                        </tr>
                      </table>
                      <input type="hidden" name="kt_pk_categorias_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rscategorias['kt_pk_categorias']); ?>" />
                      <?php } while ($row_rscategorias = mysql_fetch_assoc($rscategorias)); ?>
                    <div class="KT_bottombuttons">
                      <div>
                        <?php 
      // Show IF Conditional region1
      if (@$_GET['id'] == "") {
      ?>
                          <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
                          <?php 
      // else Conditional region1
      } else { ?>
                          <div class="KT_operations">
                            <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'id')" />
                          </div>
                          <input type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" />
                          <input type="submit" name="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" onclick="return confirm('<?php echo NXT_getResource("Are you sure?"); ?>');" />
                          <?php }
      // endif Conditional region1
      ?>
                        <input type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onclick="return UNI_navigateCancel(event, '../includes/nxt/back.php')" />
                      </div>
                    </div>
                  </form>
                </div>
                <br class="clearfixplain" />
              </div>
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
