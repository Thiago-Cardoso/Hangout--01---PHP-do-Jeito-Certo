<?php require_once('Connections/lojavirtual.php'); ?>
<?php
// Load the common classes
require_once('includes/common/KT_common.php');

// Require the MXI classes
require_once ('includes/mxi/MXI.php');

// Load the tNG classes
require_once('includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("");

// Make unified connection variable
$conn_lojavirtual = new KT_connection($lojavirtual, $database_lojavirtual);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("nome", true, "text", "", "", "", "");
$formValidation->addField("email", true, "text", "email", "", "", "");
$formValidation->addField("mensagem", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_SendEmail trigger
//remove this line if you want to edit the code by hand
function Trigger_SendEmail(&$tNG) {
  $emailObj = new tNG_Email($tNG);
  $emailObj->setFrom("{KT_defaultSender}");
  $emailObj->setTo("gersonnathan@yahoo.com.br");
  $emailObj->setCC("");
  $emailObj->setBCC("");
  $emailObj->setSubject("loja virtual - curso ");
  //WriteContent method
  $emailObj->setContent("Nome:{nome}<br>\nEmail:{email}<br>\nTelefone:{telefone}<br>\nMensagem:{mensagem}<br>");
  $emailObj->setEncoding("ISO-8859-1");
  $emailObj->setFormat("HTML/Text");
  $emailObj->setImportance("Normal");
  return $emailObj->Execute();
}
//end Trigger_SendEmail trigger

mysql_select_db($database_lojavirtual, $lojavirtual);
$query_banners = "SELECT * FROM geral WHERE id = 1";

$banners = mysql_query($query_banners, $lojavirtual) or die(mysql_error());
$row_banners = mysql_fetch_assoc($banners);
$totalRows_banners = mysql_num_rows($banners);

mysql_select_db($database_lojavirtual, $lojavirtual);
$query_tags = "SELECT * FROM template WHERE id = 1";
$tags = mysql_query($query_tags, $lojavirtual) or die(mysql_error());
$row_tags = mysql_fetch_assoc($tags);
$totalRows_tags = mysql_num_rows($tags);

// Make an insert transaction instance
$ins_contato = new tNG_insert($conn_lojavirtual);
$tNGs->addTransaction($ins_contato);
// Register triggers
$ins_contato->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_contato->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_contato->registerTrigger("END", "Trigger_Default_Redirect", 99, "contato_enviado.php");
$ins_contato->registerTrigger("AFTER", "Trigger_SendEmail", 98);
// Add columns
$ins_contato->setTable("contato");
$ins_contato->addColumn("nome", "STRING_TYPE", "POST", "nome");
$ins_contato->addColumn("email", "STRING_TYPE", "POST", "email");
$ins_contato->addColumn("telefone", "STRING_TYPE", "POST", "telefone");
$ins_contato->addColumn("mensagem", "STRING_TYPE", "POST", "mensagem");
$ins_contato->setPrimaryKey("id", "NUMERIC_TYPE");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscontato = $tNGs->getRecordset("contato");
$row_rscontato = mysql_fetch_assoc($rscontato);
$totalRows_rscontato = mysql_num_rows($rscontato);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $row_tags['titulo']; ?></title>
<meta name="keywords" content="<?php echo $row_tags['palavras']; ?>" />
<meta name="description" content="<?php echo $row_tags['descricao']; ?>" />





<link href="css.css" rel="stylesheet" type="text/css" />
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script src="includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
</head>

<body>
<div class="container">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="2"><div class="container_header"><?php echo $row_tags['header']; ?></div></td>
    </tr>
    <tr>
      <td width="23%" valign="top"><div class="container_menu">
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
	  <div class="container_menu">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="30" class="header_menu">Categorias</td>
          </tr>
          <tr>
            <td>
              <?php
  mxi_includes_start("new_categorias.php");
  require(basename("new_categorias.php"));
  mxi_includes_end();
?></td>
          </tr>
        </table>
       
      </div><div class="container_menu">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="30" class="header_menu">Novidades</td>
          </tr>
          <tr>
            <td>&nbsp;
              <?php
  mxi_includes_start("new_novidades.php");
  require(basename("new_novidades.php"));
  mxi_includes_end();
?></td>
          </tr>
        </table>
       
      </div><div class="container_menu">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="30" class="header_menu">Contato</td>
          </tr>
          <tr>
            <td>
              <?php
  mxi_includes_start("new_contato.php");
  require(basename("new_contato.php"));
  mxi_includes_end();
?></td>
          </tr>
        </table>
       
      </div></td>
      <td width="77%" valign="top"><div class="container_conteudo">
       
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="header_conteudo"><?php echo $row_banners['titulo']; ?></td>
          </tr>
          <tr>
            <td>
            </td>
          </tr>
        </table>
        <div align="center"><?php echo $row_banners['conteudo']; ?></div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="header_conteudo">Contato</td>
              </tr>
              <tr>
                <td></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><div align="center">
              <?php
	echo $tNGs->getErrorMsg();
?>
              <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
                <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                  <tr>
                    <td class="KT_th"><label for="nome">Nome:</label></td>
                    <td><input type="text" name="nome" id="nome" value="<?php echo KT_escapeAttribute($row_rscontato['nome']); ?>" size="32" />
                        <?php echo $tNGs->displayFieldHint("nome");?> <?php echo $tNGs->displayFieldError("contato", "nome"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="email">Email:</label></td>
                    <td><input type="text" name="email" id="email" value="<?php echo KT_escapeAttribute($row_rscontato['email']); ?>" size="32" />
                        <?php echo $tNGs->displayFieldHint("email");?> <?php echo $tNGs->displayFieldError("contato", "email"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="telefone">Telefone:</label></td>
                    <td><input type="text" name="telefone" id="telefone" value="<?php echo KT_escapeAttribute($row_rscontato['telefone']); ?>" size="32" />
                        <?php echo $tNGs->displayFieldHint("telefone");?> <?php echo $tNGs->displayFieldError("contato", "telefone"); ?> </td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="mensagem">Mensagem:</label></td>
                    <td><textarea name="mensagem" id="mensagem" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rscontato['mensagem']); ?></textarea>
                        <?php echo $tNGs->displayFieldHint("mensagem");?> <?php echo $tNGs->displayFieldError("contato", "mensagem"); ?> </td>
                  </tr>
                  <tr class="KT_buttons">
                    <td colspan="2"><input type="submit" name="KT_Insert1" id="KT_Insert1" value="Enviar" />
                    </td>
                  </tr>
                </table>
              </form>
              <p>&nbsp;</p>
            </div></td>
          </tr>
        </table>
        <p>&nbsp;</p></td>
    </tr>
    <tr>
      <td colspan="2"><div class="container_header">
        <div align="center"><?php echo $row_tags['rodape']; ?></div>
      </div></td>
    </tr>
  </table>
</div>
</body>
</html>
<?php
mysql_free_result($banners);

mysql_free_result($tags);
?>
