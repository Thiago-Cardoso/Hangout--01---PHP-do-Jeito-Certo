<?php
require_once('../../ktml4.php');
clearstatcache();
$sp = new ktml4_sp();
echo $sp->execute();
?>