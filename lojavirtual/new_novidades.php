<?php require_once('Connections/lojavirtual.php'); ?>
<?php
mysql_select_db($database_lojavirtual, $lojavirtual);
$query_novidades = "SELECT *  FROM produtos ORDER BY id DESC  limit 3";
$novidades = mysql_query($query_novidades, $lojavirtual) or die(mysql_error());
$row_novidades = mysql_fetch_assoc($novidades);
$totalRows_novidades = mysql_num_rows($novidades);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="css.css" rel="stylesheet" type="text/css" />
</head>

<body><marquee direction="up" scrollamount="3" height="170">
<?php do { ?>
  <table width="100%" border="0" cellspacing="2" cellpadding="0">
    <tr>
      <td class="novidade_header"><div align="center"><?php echo $row_novidades['produto']; ?></div></td>
    </tr>
    <tr>
      <td><div align="center"><a href="produtos.php?id=<?php echo $row_novidades['id']; ?>"><img src="admin/imagens/produtos/<?php echo $row_novidades['imagem']; ?>" alt="" width="78" height="78" border="0" /></a></div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
      </table>
  <?php } while ($row_novidades = mysql_fetch_assoc($novidades)); ?>
  
  </marquee>
  </body>
</html>
<?php
mysql_free_result($novidades);
?>
