<?php require_once('Connections/lojavirtual.php'); ?>
<?php
mysql_select_db($database_lojavirtual, $lojavirtual);
$query_categorias = "SELECT categorias.id, categorias.nome, categorias.descricao, categorias.imagem, count(produtos.id_categ) AS count_id_categ_1 FROM (produtos LEFT JOIN categorias ON categorias.id=produtos.id_categ) GROUP BY categorias.id, categorias.nome, categorias.descricao, categorias.imagem";
$categorias = mysql_query($query_categorias, $lojavirtual) or die(mysql_error());
$row_categorias = mysql_fetch_assoc($categorias);
$totalRows_categorias = mysql_num_rows($categorias);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script src="includes/cssmenus2/js/cssmenus.js" type="text/javascript"></script>
<script src="includes/cssmenus2/js/animation.js" type="text/javascript"></script>
<link href="includes/cssmenus2/skins/loja_170/vertical.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="cssMenu1" class="vertical">
  <?php do { ?>
  <ul class="arktic_blue_2">
    <li> <a href="categorias.php?id=<?php echo $row_categorias['id']; ?>" title="<?php echo $row_categorias['nome']; ?>"><?php echo $row_categorias['nome']; ?>(<?php echo $row_categorias['count_id_categ_1']; ?>)</a> </li>
  </ul>
  <?php } while ($row_categorias = mysql_fetch_assoc($categorias)); ?>
  <br />
  <script type="text/javascript">
   <!--
    var obj_cssMenu1 = new CSSMenu("cssMenu1");
    obj_cssMenu1.setTimeouts(400, 200, 800);
    obj_cssMenu1.setSubMenuOffset(0, 0, 0, 0);
    obj_cssMenu1.setHighliteCurrent(true);
    obj_cssMenu1.setAnimation('fade');
    obj_cssMenu1.show();
   //-->
 </script>
</div>
</body>
</html>
<?php
mysql_free_result($categorias);
?>
