<?php require_once('Connections/lojavirtual.php'); ?>
<?php
mysql_select_db($database_lojavirtual, $lojavirtual);
$query_categorias = "SELECT * FROM categorias ORDER BY id DESC";
$categorias = mysql_query($query_categorias, $lojavirtual) or die(mysql_error());
$row_categorias = mysql_fetch_assoc($categorias);
$totalRows_categorias = mysql_num_rows($categorias);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="css.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="182" height="142" border="0">
  <tr>
    <?php
  do { // horizontal looper
?>
    <td width="176"><table width="146" height="112" border="0" cellpadding="0" cellspacing="2">
      <tr>
        <td class="novidade_header"><div align="center"><?php echo $row_categorias['nome']; ?></div></td>
      </tr>
      <tr>
        <td><div align="center"><a href="categorias.php?id=<?php echo $row_categorias['id']; ?>"><img src="admin/imagens/categorias/<?php echo $row_categorias['imagem']; ?>" alt="" name="" width="78" height="78" border="0" /></a></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <?php
    $row_categorias = mysql_fetch_assoc($categorias);
    if (!isset($nested_categorias)) {
      $nested_categorias= 1;
    }
    if (isset($row_categorias) && is_array($row_categorias) && $nested_categorias++%3==0) {
      echo "</tr><tr>";
    }
  } while ($row_categorias); //end horizontal looper 
?>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($categorias);
?>
