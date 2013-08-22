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

$maxRows_categ_produtos = 5;
$pageNum_categ_produtos = 0;
if (isset($_GET['pageNum_categ_produtos'])) {
  $pageNum_categ_produtos = $_GET['pageNum_categ_produtos'];
}
$startRow_categ_produtos = $pageNum_categ_produtos * $maxRows_categ_produtos;

$colname_categ_produtos = "-1";
if (isset($_GET['id'])) {
  $colname_categ_produtos = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_lojavirtual, $lojavirtual);
$query_categ_produtos = sprintf("SELECT * FROM produtos WHERE id_categ = %s ORDER BY id DESC", $colname_categ_produtos);
$query_limit_categ_produtos = sprintf("%s LIMIT %d, %d", $query_categ_produtos, $startRow_categ_produtos, $maxRows_categ_produtos);
$categ_produtos = mysql_query($query_limit_categ_produtos, $lojavirtual) or die(mysql_error());
$row_categ_produtos = mysql_fetch_assoc($categ_produtos);

if (isset($_GET['totalRows_categ_produtos'])) {
  $totalRows_categ_produtos = $_GET['totalRows_categ_produtos'];
} else {
  $all_categ_produtos = mysql_query($query_categ_produtos);
  $totalRows_categ_produtos = mysql_num_rows($all_categ_produtos);
}
$totalPages_categ_produtos = ceil($totalRows_categ_produtos/$maxRows_categ_produtos)-1;

$queryString_categ_produtos = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_categ_produtos") == false && 
        stristr($param, "totalRows_categ_produtos") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_categ_produtos = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_categ_produtos = sprintf("&totalRows_categ_produtos=%d%s", $totalRows_categ_produtos, $queryString_categ_produtos);
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
                <td class="header_conteudo">Categorias</td>
              </tr>
              <tr>
                <td></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><div align="center">
              <?php do { ?>
                <div class="container_produtos">
                    <table width="100%" border="0" cellspacing="2" cellpadding="0">
                      <tr>
                        <td width="31%"><div align="center"><img name="" src="admin/imagens/produtos/<?php echo $row_categ_produtos['imagem']; ?>" width="78" height="78" alt="" /></div></td>
                        <td width="38%" rowspan="2"><strong>Produto:<br />
                        </strong><?php echo $row_categ_produtos['produto']; ?></td>
                        <td width="31%" rowspan="2"><table width="100%" border="0" cellspacing="2" cellpadding="0">
                          <tr>
                            <td width="63%" class="fundo_btn_detalhes"><div align="center"><a href="detalhes.php?id=<?php echo $row_categ_produtos['id']; ?>">DETALHES</a></div></td>
                            <td width="8%">&nbsp;</td>
                            <td width="29%" class="fundo_btn_comprar"><a href="pagamento.php?id=<?php echo $row_categ_produtos['id']; ?>">COMPRAR</a></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td><div align="center"><strong>Pre&ccedil;o: <?php echo $row_categ_produtos['valor']; ?></strong></div></td>
                      </tr>
                                      </table>
                </div>
                <?php } while ($row_categ_produtos = mysql_fetch_assoc($categ_produtos)); ?></div></td>
          </tr>
        </table>
        <p>P&aacute;gina <strong><?php echo $pageNum_categ_produtos+1; ?></strong>de <strong><?php echo $totalPages_categ_produtos+1; ?></strong> <br>

        <table width="50%" border="0" align="center">
          <tr>
            <td width="50%" align="right"><?php
		$pageNum_tmp = max(0, $pageNum_categ_produtos-5);
  for ($pageNum_i=$pageNum_tmp+1;$pageNum_i<=$pageNum_categ_produtos;$pageNum_i++) { //previous pages
	?>
              <a href="<?php printf ("%s?pageNum_categ_produtos=%d%s", $HTTP_SERVER_VARS["PHP_SELF"], $pageNum_i-1, $queryString_categ_produtos); ?>"><?php echo $pageNum_i; ?></a>
              <?php
		} //end previous pages
	?>
            </td>
            <td><strong><?php echo $pageNum_categ_produtos+1; ?></strong></td>
            <td width="50%"><?php
  $pageNum_tmp = min($pageNum_categ_produtos+1+5, $totalPages_categ_produtos+1);
  for ($pageNum_i=$pageNum_categ_produtos+2;$pageNum_i<=$pageNum_tmp;$pageNum_i++) { // next pages
?>
              <a href="<?php printf ("%s?pageNum_categ_produtos=%d%s", $HTTP_SERVER_VARS["PHP_SELF"], $pageNum_i-1, $queryString_categ_produtos); ?>"><?php echo $pageNum_i; ?></a>
              <?php
  } //end next pages
?>
            </td>
          </tr>
        </table>
        </p></td>
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

mysql_free_result($categ_produtos);
?>
