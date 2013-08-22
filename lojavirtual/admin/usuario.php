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

//start Trigger_CheckPasswords trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckPasswords(&$tNG) {
  $myThrowError = new tNG_ThrowError($tNG);
  $myThrowError->setErrorMsg("Could not create account.");
  $myThrowError->setField("senha");
  $myThrowError->setFieldErrorMsg("The two passwords do not match.");
  return $myThrowError->Execute();
}
//end Trigger_CheckPasswords trigger

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("email", true, "text", "email", "", "", "");
$formValidation->addField("login", true, "text", "", "", "", "");
$formValidation->addField("senha", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_CheckOldPassword trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckOldPassword(&$tNG) {
  return Trigger_UpdatePassword_CheckOldPassword($tNG);
}
//end Trigger_CheckOldPassword trigger

// Make an update transaction instance
$upd_login = new tNG_update($conn_lojavirtual);
$tNGs->addTransaction($upd_login);
// Register triggers
$upd_login->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_login->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_login->registerTrigger("END", "Trigger_Default_Redirect", 99, "usuario.php?id=1");
$upd_login->registerConditionalTrigger("{POST.senha} != {POST.re_senha}", "BEFORE", "Trigger_CheckPasswords", 50);
$upd_login->registerTrigger("BEFORE", "Trigger_CheckOldPassword", 60);
// Add columns
$upd_login->setTable("login");
$upd_login->addColumn("nome", "STRING_TYPE", "POST", "nome");
$upd_login->addColumn("email", "STRING_TYPE", "POST", "email");
$upd_login->addColumn("logo", "STRING_TYPE", "POST", "logo");
$upd_login->addColumn("login", "STRING_TYPE", "POST", "login");
$upd_login->addColumn("senha", "STRING_TYPE", "POST", "senha");
$upd_login->addColumn("nivel", "STRING_TYPE", "POST", "nivel");
$upd_login->addColumn("ativo", "STRING_TYPE", "POST", "ativo");
$upd_login->addColumn("ramdom", "STRING_TYPE", "POST", "ramdom");
$upd_login->setPrimaryKey("id", "NUMERIC_TYPE", "GET", "id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rslogin = $tNGs->getRecordset("login");
$row_rslogin = mysql_fetch_assoc($rslogin);
$totalRows_rslogin = mysql_num_rows($rslogin);
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
            <td class="header_conteudo">Atualizar usuario </td>
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
                    <td class="KT_th"><label for="nome">Nome:</label></td>
                    <td><input type="text" name="nome" id="nome" value="<?php echo KT_escapeAttribute($row_rslogin['nome']); ?>" size="32" />
                        <?php echo $tNGs->displayFieldHint("nome");?> <?php echo $tNGs->displayFieldError("login", "nome"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="email">Email:</label></td>
                    <td><input type="text" name="email" id="email" value="<?php echo KT_escapeAttribute($row_rslogin['email']); ?>" size="32" />
                        <?php echo $tNGs->displayFieldHint("email");?> <?php echo $tNGs->displayFieldError("login", "email"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="login">Login:</label></td>
                    <td><input type="text" name="login" id="login" value="<?php echo KT_escapeAttribute($row_rslogin['login']); ?>" size="32" />
                        <?php echo $tNGs->displayFieldHint("login");?> <?php echo $tNGs->displayFieldError("login", "login"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="old_senha"> Senha antiga:</label></td>
                    <td><input type="password" name="old_senha" id="old_senha" value="" size="32" />
                        <?php echo $tNGs->displayFieldError("login", "old_senha"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="senha">Senha:</label></td>
                    <td><input type="password" name="senha" id="senha" value="" size="32" />
                        <?php echo $tNGs->displayFieldHint("senha");?> <?php echo $tNGs->displayFieldError("login", "senha"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="re_senha">Repetir Senha:</label></td>
                    <td><input type="password" name="re_senha" id="re_senha" value="" size="32" />
                    </td>
                  </tr>
                  <tr class="KT_buttons">
                    <td colspan="2"><input type="submit" name="KT_Update1" id="KT_Update1" value="Atualizar" />
                    </td>
                  </tr>
                </table>
                <input type="hidden" name="logo" id="logo" value="<?php echo KT_escapeAttribute($row_rslogin['logo']); ?>" />
                <input type="hidden" name="nivel" id="nivel" value="<?php echo KT_escapeAttribute($row_rslogin['nivel']); ?>" />
                <input type="hidden" name="ativo" id="ativo" value="<?php echo KT_escapeAttribute($row_rslogin['ativo']); ?>" />
                <input type="hidden" name="ramdom" id="ramdom" value="<?php echo KT_escapeAttribute($row_rslogin['ramdom']); ?>" />
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
