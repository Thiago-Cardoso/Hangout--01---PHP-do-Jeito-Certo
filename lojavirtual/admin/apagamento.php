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
$formValidation->addField("email_cobranca", true, "text", "", "", "", "");
$formValidation->addField("tipo", true, "text", "", "", "", "");
$formValidation->addField("moeda", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

// Make an update transaction instance
$upd_pagseguro = new tNG_update($conn_lojavirtual);
$tNGs->addTransaction($upd_pagseguro);
// Register triggers
$upd_pagseguro->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_pagseguro->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_pagseguro->registerTrigger("END", "Trigger_Default_Redirect", 99, "apagamento.php?id=1");
// Add columns
$upd_pagseguro->setTable("pagseguro");
$upd_pagseguro->addColumn("email_cobranca", "STRING_TYPE", "POST", "email_cobranca");
$upd_pagseguro->addColumn("tipo", "STRING_TYPE", "POST", "tipo");
$upd_pagseguro->addColumn("moeda", "STRING_TYPE", "POST", "moeda");
$upd_pagseguro->setPrimaryKey("id", "NUMERIC_TYPE", "GET", "id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rspagseguro = $tNGs->getRecordset("pagseguro");
$row_rspagseguro = mysql_fetch_assoc($rspagseguro);
$totalRows_rspagseguro = mysql_num_rows($rspagseguro);
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
            <td class="header_conteudo">Atualizar pagamento </td>
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
                    <td class="KT_th"><label for="email_cobranca">Email cobranca:</label></td>
                    <td><input type="text" name="email_cobranca" id="email_cobranca" value="<?php echo KT_escapeAttribute($row_rspagseguro['email_cobranca']); ?>" size="32" />
                        <?php echo $tNGs->displayFieldHint("email_cobranca");?> <?php echo $tNGs->displayFieldError("pagseguro", "email_cobranca"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="tipo">Tipo:</label></td>
                    <td><input type="text" name="tipo" id="tipo" value="<?php echo KT_escapeAttribute($row_rspagseguro['tipo']); ?>" size="32" />
                        <?php echo $tNGs->displayFieldHint("tipo");?> <?php echo $tNGs->displayFieldError("pagseguro", "tipo"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="moeda">Moeda:</label></td>
                    <td><input type="text" name="moeda" id="moeda" value="<?php echo KT_escapeAttribute($row_rspagseguro['moeda']); ?>" size="32" />
                        <?php echo $tNGs->displayFieldHint("moeda");?> <?php echo $tNGs->displayFieldError("pagseguro", "moeda"); ?> </td>
                  </tr>
                  <tr class="KT_buttons">
                    <td colspan="2"><input type="submit" name="KT_Update1" id="KT_Update1" value="atualizar" />
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
