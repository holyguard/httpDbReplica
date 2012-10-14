<?
include($_SERVER['DOCUMENT_ROOT'].'/httpDbReplica/httpDbConf.php');
include $_SERVER['DOCUMENT_ROOT'].'/httpDbReplica/Connections/homepagesdb.php';
include $_SERVER['DOCUMENT_ROOT'].'/httpDbReplica/UBclasses/class.httpDbReplica.php';

$dbRp->receive($_GET['l'],$_GET['s']);