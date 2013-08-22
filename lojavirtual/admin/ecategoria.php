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
$tfi_listcategorias1 = new TFI_TableFilter($conn_lojavirtual, "tfi_listcategorias1");
$tfi_listcategorias1->addColumn("categorias.nome", "STRING_TYPE", "nome", "%");
$tfi_listcategorias1->addColumn("categorias.imagem", "FILE_TYPE", "imagem", "%");
$tfi_listcategorias1->Execute();

// Sorter
$tso_listcategorias1 = new TSO_TableSorter("rscategorias1", "tso_listcategorias1");
$tso_listcategorias1->addColumn("categorias.nome");
$tso_listcategorias1->addColumn("categorias.imagem");
$tso_listcategorias1->setDefault("categorias.nome DESC");
$tso_listcategorias1->Execute();

// Navigation
$nav_listcategorias1 = new NAV_Regular("nav_listcategorias1", "rscategorias1", "../", $_SERVER['PHP_SELF'], 150);

//NeXTenesio3 Special List Recordset
$maxRows_rscategorias1 = $_SESSION['max_rows_nav_listcategorias1'];
$pageNum_rscategorias1 = 0;
if (isset($_GET['pageNum_rscategorias1'])) {
  $pageNum_rscategorias1 = $_GET['pageNum_rscategorias1'];
}
$startRow_rscategorias1 = $pageNum_rscategorias1 * $maxRows_rscategorias1;

$NXTFilter_rscategorias1 = "1=1";
if (isset($_SESSION['filter_tfi_listcategorias1'])) {
  $NXTFilter_rscategorias1 = $_SESSION['filter_tfi_listcategorias1'];
}
$NXTSort_rscategorias1 = "categorias.nome DESC";
if (isset($_SESSION['sorter_tso_listcategorias1'])) {
  $NXTSort_rscategorias1 = $_SESSION['sorter_tso_listcategorias1'];
}
mysql_select_db($database_lojavirtual, $lojavirtual);

$query_rscategorias1 = sprintf("SELECT categorias.nome, categorias.imagem, categorias.id FROM categorias WHERE %s ORDER BY %s", $NXTFilter_rscategorias1, $NXTSort_rscategorias1);
$query_limit_rscategorias1 = sprintf("%s LIMIT %d, %d", $query_rscategorias1, $startRow_rscategorias1, $maxRows_rscategorias1);
$rscategorias1 = mysql_query($query_limit_rscategorias1, $lojavirtual) or die(mysql_error());
$row_rscategorias1 = mysql_fetch_assoc($rscategorias1);

if (isset($_GET['totalRows_rscategorias1'])) {
  $totalRows_rscategorias1 = $_GET['totalRows_rscategorias1'];
} else {
  $all_rscategorias1 = mysql_query($query_rscategorias1);
  $totalRows_rscategorias1 = mysql_num_rows($all_rscategorias1);
}
$totalPages_rscategorias1 = ceil($totalRows_rscategorias1/$maxRows_rscategorias1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listcategorias1->checkBoundries();
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
  .KT_col_nome {width:280px; overflow:hidden;}
  .KT_col_imagem {width:140px; overflow:hidden;}
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
            <td class="header_conteudo">Editar categorias </td>
          </tr>
          <tr>
            <td height="135"><div align="center">
              <p>

              <div class="KT_tng" id="listcategorias1">
                <h1> Categorias
                  <?php
  $nav_listcategorias1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
                </h1>
                <div class="KT_tnglist">
                  <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
                    <div class="KT_options"> <a href="<?php echo $nav_listcategorias1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
                      <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listcategorias1'] == 1) {
?>
                        <?php echo $_SESSION['default_max_rows_nav_listcategorias1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listcategorias1'] == 1) {
?>
                              <a href="<?php echo $tfi_listcategorias1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                              <?php 
  // else Conditional region2
  } else { ?>
                              <a href="<?php echo $tfi_listcategorias1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                              <?php } 
  // endif Conditional region2
?>
                    </div>
                    <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                      <thead>
                        <tr class="KT_row_order">
                          <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>                          </th>
                          <th id="nome" class="KT_sorter KT_col_nome <?php echo $tso_listcategorias1->getSortIcon('categorias.nome'); ?>"> <a href="<?php echo $tso_listcategorias1->getSortLink('categorias.nome'); ?>">Nome</a> </th>
                          <th id="imagem" class="KT_sorter KT_col_imagem <?php echo $tso_listcategorias1->getSortIcon('categorias.imagem'); ?>"> <a href="<?php echo $tso_listcategorias1->getSortLink('categorias.imagem'); ?>">Imagem</a> </th>
                          <th>&nbsp;</th>
                        </tr>
                        <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listcategorias1'] == 1) {
?>
                          <tr class="KT_row_filter">
                            <td>&nbsp;</td>
                            <td><input type="text" name="tfi_listcategorias1_nome" id="tfi_listcategorias1_nome" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listcategorias1_nome']); ?>" size="40" maxlength="255" /></td>
                            <td><input type="text" name="tfi_listcategorias1_imagem" id="tfi_listcategorias1_imagem" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listcategorias1_imagem']); ?>" size="20" maxlength="255" /></td>
                            <td><input type="submit" name="tfi_listcategorias1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
                          </tr>
                          <?php } 
  // endif Conditional region3
?>
                      </thead>
                      <tbody>
                        <?php if ($totalRows_rscategorias1 == 0) { // Show if recordset empty ?>
                          <tr>
                            <td colspan="4"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
                          </tr>
                          <?php } // Show if recordset empty ?>
                        <?php if ($totalRows_rscategorias1 > 0) { // Show if recordset not empty ?>
                          <?php do { ?>
                            <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                              <td><input type="checkbox" name="kt_pk_categorias" class="id_checkbox" value="<?php echo $row_rscategorias1['id']; ?>" />
                                  <input type="hidden" name="id" class="id_field" value="<?php echo $row_rscategorias1['id']; ?>" />                              </td>
                              <td><div class="KT_col_nome"><?php echo KT_FormatForList($row_rscategorias1['nome'], 40); ?></div></td>
                              <td><div class="KT_col_imagem"><img name="" src="imagens/categorias/<?php echo KT_FormatForList($row_rscategorias1['imagem'], 20); ?>" width="51" height="49" alt="" /></div></td>
                              <td><a class="KT_edit_link" href="acategorias.php?id=<?php echo $row_rscategorias1['id']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a> </td>
                            </tr>
                            <?php } while ($row_rscategorias1 = mysql_fetch_assoc($rscategorias1)); ?>
                          <?php } // Show if recordset not empty ?>
                      </tbody>
                    </table>
                    <div class="KT_bottomnav">
                      <div>
                        <?php
            $nav_listcategorias1->Prepare();
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
                      <a class="KT_additem_op_link" href="acategorias.php?KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
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
mysql_free_result($rscategorias1);
?>
