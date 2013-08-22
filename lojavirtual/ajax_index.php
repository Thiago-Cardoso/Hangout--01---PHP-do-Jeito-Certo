<?php require_once('Connections/lojavirtual.php'); ?>
<?php
mysql_select_db($database_lojavirtual, $lojavirtual);
$query_categ = "SELECT * FROM categorias";
$categ = mysql_query($query_categ, $lojavirtual) or die(mysql_error());
$row_categ = mysql_fetch_assoc($categ);
$totalRows_categ = mysql_num_rows($categ);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
#corpo {
	margin: 0 auto;
	height: 600px;
	width: 600px;
	background-color: #FCFCFD;
	border: 1px solid #E0DFE3;
	}
#corpo #menu {
	float: left;
	width: 180px;
	margin: 10px;
	border: 1px solid #E0DFE3;
}
#corpo #conteudo {
	float: left;
	width: 360px;
	margin: 10px;
	border: 1px solid #E0DFE3;
}
#corpo #menu li {
	margin-left: -25px;
	list-style-type: none;
	background-color: #0099FF;
	display: block;
	float: left;
	width: 150px;
	height: 25px;
	margin-bottom: 2px;
	padding-left: 5px;
	cursor: hand;
}



-->
</style>
<script type="text/javascript">
  function criaXMLHttp() {
  
       if (typeof XMLHttpRequest != "undefined")
   
          return new XMLHttpRequest();
   
       else if (window.ActiveXObject){
   
          var versoes = ["MSXML2.XMLHttp.5.0",
   
          "MSXML2.XMLHttp.4.0", "MSXML2.XMLHttp.3.0",
   
          "MSXML2.XMLHttp", "Microsoft.XMLHttp"
   
          ];
       }
  
      for (var i = 0; i < versoes.length; i++){
 
          try{
  
              return new ActiveXObject(versoes[i]);
 
          }catch (e) {}
 
       }
 
       throw new Error("Seu browser nao suporta AJAX");
  
      }


      function envia() {          
   
   document.getElementById("conteudo").innerHTML="lendo";
   
          var divInfo = document.getElementById("conteudo");   
     
		  var XMLHttp = criaXMLHttp();   
          XMLHttp.open("get", "ajax_produtos.php?id=" + id_cat, true);   
		 
          XMLHttp.onreadystatechange = function () {   
              if (XMLHttp.readyState == 4)   
                  if (XMLHttp.status == 200){   
                      divInfo.innerHTML = XMLHttp.responseText;  
                  } else {  
                      divInfo.innerHTML = "Um erro ocorreu" + XMLHttp.statusText;  
                  }
           };  
          XMLHttp.send(null);  
      }




</script>
</head>

<body>
<div id="corpo">
  <div id="menu">
    <ul>
      <?php do { ?>
        <li onmouseover="envia(id_cat='<?php echo $row_categ['id']; ?>')"><?php echo $row_categ['nome']; ?></li>
        <?php } while ($row_categ = mysql_fetch_assoc($categ)); ?></ul>
  </div>
   <div id="conteudo">Content for  id "menu" Goes Here</div>
</div>
</body>
</html>
<?php
mysql_free_result($categ);
?>
