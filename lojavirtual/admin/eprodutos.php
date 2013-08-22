<?php require_once('../Connections/lojavirtual.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');

// Require the MXI classes
require_once ('../includes/mxi/MXI.php');

// Load the required classes
require_once('../includes/tfi/TFI.php');
require_once('../includes/tso/TSO.php');
require_once('../includes/nav/NAV.php');

// Make unified connection variable
$conn_lojavirtual = new KT_connection($lojavirtual, $database_lojavirtual);

// Filter
$tfi_listprodutos1 = new TFI_TableFilter($conn_lojavirtual, "tfi_listprodutos1");
$tfi_listprodutos1->addColumn("categorias.id", "NUMERIC_TYPE", "id_categ", "=");
$tfi_listprodutos1->addColumn("produtos.produto", "STRING_TYPE", "produto", "%");
$tfi_listprodutos1->addColumn("produtos.imagem", "FILE_TYPE", "imagem", "%");
$tfi_listprodutos1->addColumn("produtos.valor", "STRING_TYPE", "valor", "%");
$tfi_listprodutos1->addColumn("produtos.promocao", "CHECKBOX_1_0_TYPE", "promocao", "%");
$tfi_listprodutos1->addColumn("produtos.exibir", "CHECKBOX_1_0_TYPE", "exibir", "%");
$tfi_listprodutos1->Execute();

// Sorter
$tso_listprodutos1 = new TSO_TableSorter("rsprodutos1", "tso_listprodutos1");
$tso_listprodutos1->addColumn("categorias.nome");
$tso_listprodutos1->addColumn("produtos.produto");
$tso_listprodutos1->addColumn("produtos.imagem");
$tso_listprodutos1->addColumn("produtos.valor");
$tso_listprodutos1->addColumn("produtos.promocao");
$tso_listprodutos1->addColumn("produtos.exibir");
$tso_listprodutos1->setDefault("produtos.id_categ DESC");
$tso_listprodutos1->Execute();

// Navigation
$nav_listprodutos1 = new NAV_Regular("nav_listprodutos1", "rsprodutos1", "../", $_SERVER['PHP_SELF'], 150);

mysql_select_db($database_lojavirtual, $lojavirtual);
$query_Recordset1 = "SELECT nome, id FROM categorias ORDER BY nome";
$Recordset1 = mysql_query($query_Recordset1, $lojavirtual) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

//NeXTenesio3 Special List Recordset
$maxRows_rsprodutos1 = $_SESSION['max_rows_nav_listprodutos1'];
$pageNum_rsprodutos1 = 0;
if (isset($_GET['pageNum_rsprodutos1'])) {
  $pageNum_rsprodutos1 = $_GET['pageNum_rsprodutos1'];
}
$startRow_rsprodutos1 = $pageNum_rsprodutos1 * $maxRows_rsprodutos1;

$NXTFilter_rsprodutos1 = "1=1";
if (isset($_SESSION['filter_tfi_listprodutos1'])) {
  $NXTFilter_rsprodutos1 = $_SESSION['filter_tfi_listprodutos1'];
}
$NXTSort_rsprodutos1 = "produtos.id_categ DESC";
if (isset($_SESSION['sorter_tso_listprodutos1'])) {
  $NXTSort_rsprodutos1 = $_SESSION['sorter_tso_listprodutos1'];
}
mysql_select_db($database_lojavirtual, $lojavirtual);

$query_rsprodutos1 = sprintf("SELECT categorias.nome AS id_categ, produtos.produto, produtos.imagem, produtos.valor, produtos.promocao, produtos.exibir, produtos.id FROM produtos LEFT JOIN categorias ON produtos.id_categ = categorias.id WHERE %s ORDER BY %s", $NXTFilter_rsprodutos1, $NXTSort_rsprodutos1);
$query_limit_rsprodutos1 = sprintf("%s LIMIT %d, %d", $query_rsprodutos1, $startRow_rsprodutos1, $maxRows_rsprodutos1);
$rsprodutos1 = mysql_query($query_limit_rsprodutos1, $lojavirtual) or die(mysql_error());
$row_rsprodutos1 = mysql_fetch_assoc($rsprodutos1);

if (isset($_GET['totalRows_rsprodutos1'])) {
  $totalRows_rsprodutos1 = $_GET['totalRows_rsprodutos1'];
} else {
  $all_rsprodutos1 = mysql_query($query_rsprodutos1);
  $totalRows_rsprodutos1 = mysql_num_rows($all_rsprodutos1);
}
$totalPages_rsprodutos1 = ceil($totalRows_rsprodutos1/$maxRows_rsprodutos1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listprodutos1->checkBoundries();
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
<script src="../includes/nxt/scripts/list.js" type="text/javascript"></script>
<script src="../includes/nxt/scripts/list.js.php" type="text/javascript"></script>
<script type="text/javascript">
$NXT_LIST_SETTINGS = {
  duplicate_buttons: true,
  duplicate_navigation: true,
  row_effects: true,
  show_as_buttons: true,
  record_counter: true
}
</script>
<style type="text/css">
  /* NeXTensio3 List row settings */
  .KT_col_id_categ {width:70px; overflow:hidden;}
  .KT_col_produto {width:140px; overflow:hidden;}
  .KT_col_imagem {width:140px; overflow:hidden;}
  .KT_col_valor {width:70px; overflow:hidden;}
  .KT_col_promocao {width:70px; overflow:hidden;}
  .KT_col_exibir {width:70px; overflow:hidden;}
</style>
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
            <td class="header_conteudo">Editar produtos </td>
          </tr>
          <tr>
            <td height="135"><div align="center">
              <p> 
              <div class="KT_tng" id="listprodutos1">
                <h1> Produtos
                  <?php
  $nav_listprodutos1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
                </h1>
                <div class="KT_tnglist">
                  <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
                    <div class="KT_options"> <a href="<?php echo $nav_listprodutos1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
                          <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listprodutos1'] == 1) {
?>
                            <?php echo $_SESSION['default_max_rows_nav_listprodutos1']; ?>
                            <?php 
  // else Conditional region1
  } else { ?>
                            <?php echo NXT_getResource("all"); ?>
                            <?php } 
  // endif Conditional region1
?>
                          <?php echo NXT_getResource("records"); ?></a> &nbsp;
                      &nbsp;
                            <?php 
  // Show IF Conditional region2
  if (@$_SESSION['has_filter_tfi_listprodutos1'] == 1) {
?>
                              <a href="<?php echo $tfi_listprodutos1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                              <?php 
  // else Conditional region2
  } else { ?>
                              <a href="<?php echo $tfi_listprodutos1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                              <?php } 
  // endif Conditional region2
?>
                    </div>
                    <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                      <thead>
                        <tr class="KT_row_order">
                          <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
                          </th>
                          <th id="id_categ" class="KT_sorter KT_col_id_categ <?php echo $tso_listprodutos1->getSortIcon('categorias.nome'); ?>"> <a href="<?php echo $tso_listprodutos1->getSortLink('categorias.nome'); ?>">Categorias</a></th>
                          <th id="produto" class="KT_sorter KT_col_produto <?php echo $tso_listprodutos1->getSortIcon('produtos.produto'); ?>"> <a href="<?php echo $tso_listprodutos1->getSortLink('produtos.produto'); ?>">Produto</a> </th>
                          <th id="imagem" class="KT_sorter KT_col_imagem <?php echo $tso_listprodutos1->getSortIcon('produtos.imagem'); ?>"> <a href="<?php echo $tso_listprodutos1->getSortLink('produtos.imagem'); ?>">Imagem</a> </th>
                          <th id="valor" class="KT_sorter KT_col_valor <?php echo $tso_listprodutos1->getSortIcon('produtos.valor'); ?>"> <a href="<?php echo $tso_listprodutos1->getSortLink('produtos.valor'); ?>">Valor</a> </th>
                          <th id="promocao" class="KT_sorter KT_col_promocao <?php echo $tso_listprodutos1->getSortIcon('produtos.promocao'); ?>"> <a href="<?php echo $tso_listprodutos1->getSortLink('produtos.promocao'); ?>">Promocao</a> </th>
                          <th id="exibir" class="KT_sorter KT_col_exibir <?php echo $tso_listprodutos1->getSortIcon('produtos.exibir'); ?>"> <a href="<?php echo $tso_listprodutos1->getSortLink('produtos.exibir'); ?>">Exibir</a> </th>
                          <th>&nbsp;</th>
                        </tr>
                        <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listprodutos1'] == 1) {
?>
                          <tr class="KT_row_filter">
                            <td>&nbsp;</td>
                            <td><select name="tfi_listprodutos1_id_categ" id="tfi_listprodutos1_id_categ">
                                <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listprodutos1_id_categ']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
                                <?php
do {  
?>
                                <option value="<?php echo $row_Recordset1['id']?>"<?php if (!(strcmp($row_Recordset1['id'], @$_SESSION['tfi_listprodutos1_id_categ']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nome']?></option>
                                <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
                              </select>
                            </td>
                            <td><input type="text" name="tfi_listprodutos1_produto" id="tfi_listprodutos1_produto" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listprodutos1_produto']); ?>" size="20" maxlength="100" /></td>
                            <td><input type="text" name="tfi_listprodutos1_imagem" id="tfi_listprodutos1_imagem" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listprodutos1_imagem']); ?>" size="20" maxlength="255" /></td>
                            <td><input type="text" name="tfi_listprodutos1_valor" id="tfi_listprodutos1_valor" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listprodutos1_valor']); ?>" size="10" maxlength="100" /></td>
                            <td><input  <?php if (!(strcmp(KT_escapeAttribute(@$_SESSION['tfi_listprodutos1_promocao']),"1"))) {echo "checked";} ?> type="checkbox" name="tfi_listprodutos1_promocao" id="tfi_listprodutos1_promocao" value="1" /></td>
                            <td><input  <?php if (!(strcmp(KT_escapeAttribute(@$_SESSION['tfi_listprodutos1_exibir']),"1"))) {echo "checked";} ?> type="checkbox" name="tfi_listprodutos1_exibir" id="tfi_listprodutos1_exibir" value="1" /></td>
                            <td><input type="submit" name="tfi_listprodutos1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
                          </tr>
                          <?php } 
  // endif Conditional region3
?>
                      </thead>
                      <tbody>
                        <?php if ($totalRows_rsprodutos1 == 0) { // Show if recordset empty ?>
                          <tr>
                            <td colspan="8"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
                          </tr>
                          <?php } // Show if recordset empty ?>
                        <?php if ($totalRows_rsprodutos1 > 0) { // Show if recordset not empty ?>
                          <?php do { ?>
                            <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                              <td><input type="checkbox" name="kt_pk_produtos" class="id_checkbox" value="<?php echo $row_rsprodutos1['id']; ?>" />
                                  <input type="hidden" name="id" class="id_field" value="<?php echo $row_rsprodutos1['id']; ?>" />
                              </td>
                              <td><div class="KT_col_id_categ"><?php echo KT_FormatForList($row_rsprodutos1['id_categ'], 10); ?></div></td>
                              <td><div class="KT_col_produto"><?php echo KT_FormatForList($row_rsprodutos1['produto'], 20); ?></div></td>
                              <td><div class="KT_col_imagem"><img src="imagens/produtos/<?php echo KT_FormatForList($row_rsprodutos1['imagem'], 20); ?>" width="50" height="50" alt="" /></div></td>
                              <td><div class="KT_col_valor"><?php echo KT_FormatForList($row_rsprodutos1['valor'], 10); ?></div></td>
                              <td><div class="KT_col_promocao"><?php echo KT_FormatForList($row_rsprodutos1['promocao'], 10); ?></div></td>
                              <td><div class="KT_col_exibir"><?php echo KT_FormatForList($row_rsprodutos1['exibir'], 10); ?></div></td>
                              <td><a class="KT_edit_link" href="aprodutos.php?id=<?php echo $row_rsprodutos1['id']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a> </td>
                            </tr>
                            <?php } while ($row_rsprodutos1 = mysql_fetch_assoc($rsprodutos1)); ?>
                          <?php } // Show if recordset not empty ?>
                      </tbody>
                    </table>
                    <div class="KT_bottomnav">
                      <div>
                        <?php
            $nav_listprodutos1->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
                      </div>
                    </div>
                    <div class="KT_bottombuttons">
                      <div class="KT_operations"> <a class="KT_edit_op_link" href="#" onclick="nxt_list_edit_link_form(this); return false;"><?php echo NXT_getResource("edit_all"); ?></a> <a class="KT_delete_op_link" href="#" onclick="nxt_list_delete_link_form(this); return false;"><?php echo NXT_getResource("delete_all"); ?></a> </div>
                      <span>&nbsp;</span>
                      <select name="no_new" id="no_new">
                        <option value="1">1</option>
                        <option value="3">3</option>
                        <option value="6">6</option>
                      </select>
                      <a class="KT_additem_op_link" href="aprodutos.php?KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
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
<?php
mysql_free_result($Recordset1);

mysql_free_result($rsprodutos1);
?>
