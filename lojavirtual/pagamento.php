<?php require_once('Connections/lojavirtual.php'); ?>
<?php
// Require the MXI classes
require_once ('includes/mxi/MXI.php');

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

$colname_detalhes = "-1";
if (isset($_GET['id'])) {
  $colname_detalhes = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_lojavirtual, $lojavirtual);
$query_detalhes = sprintf("SELECT * FROM produtos WHERE id = %s", $colname_detalhes);
$detalhes = mysql_query($query_detalhes, $lojavirtual) or die(mysql_error());
$row_detalhes = mysql_fetch_assoc($detalhes);
$totalRows_detalhes = mysql_num_rows($detalhes);

mysql_select_db($database_lojavirtual, $lojavirtual);
$query_pagamento = "SELECT * FROM pagseguro WHERE id = 1";
$pagamento = mysql_query($query_pagamento, $lojavirtual) or die(mysql_error());
$row_pagamento = mysql_fetch_assoc($pagamento);
$totalRows_pagamento = mysql_num_rows($pagamento);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $row_tags['titulo']; ?></title>
<meta name="keywords" content="<?php echo $row_tags['palavras']; ?>" />
<meta name="description" content="<?php echo $row_tags['descricao']; ?>" />





<link href="css.css" rel="stylesheet" type="text/css" />
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
                <td class="header_conteudo"><?php echo $row_detalhes['produto']; ?></td>
              </tr>
              <tr>
                <td></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><div align="center">
              <table width="100" border="0" cellspacing="2" cellpadding="0">
                <tr>
                  <td><div align="center"><img name="" src="admin/imagens/produtos/<?php echo $row_detalhes['imagem']; ?>" width="78" height="78" alt="" /></div></td>
                </tr>
                <tr>
                  <td><div align="center"><strong>Pre&ccedil;o:</strong><?php echo $row_detalhes['valor']; ?></div></td>
                </tr>
              </table>
              <p>&nbsp;</p>
              <form target="pagseguro" action="https://pagseguro.uol.com.br/security/webpagamentos/webpagto.aspx" method="post">
<input type="hidden" name="email_cobranca" value="<?php echo $row_pagamento['email_cobranca']; ?>" />
<input type="hidden" name="tipo" value="CP" />
<input type="hidden" name="moeda" value="BRL" />
<input type="hidden" name="item_id_1" value="<?php echo $row_detalhes['id']; ?>" />
<input type="hidden" name="item_descr_1" value="<?php echo $row_detalhes['produto']; ?>" />
<input type="hidden" name="item_quant_1" value="1" />
<input type="hidden" name="item_valor_1" value="<?php echo $row_detalhes['valor']; ?>" />
<input type="hidden" name="item_frete_1" value="0<?php echo $row_detalhes['frete']; ?>" />
<input type="hidden" name="item_peso_1" value="0" />
<input type="image" src="https://pagseguro.uol.com.br/Security/Imagens/btnPagar.jpg" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
</form>
              <p><img src="imagens/pagseguro.gif" width="171" height="119" /></p>
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

mysql_free_result($detalhes);

mysql_free_result($pagamento);
?>
