<?php require_once('../Connections/db_engenho.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../index.php?admin=login";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "cadastra_usu")) {
  $insertSQL = sprintf("INSERT INTO usu_admin (usu_nome, usu_email, usu_senha, usu_data) VALUES (%s, %s, sha1(%s), %s)",
                       GetSQLValueString($_POST['nome_usu'], "text"),
                       GetSQLValueString($_POST['email_usu'], "text"),
                       GetSQLValueString($_POST['senha_usu'], "text"),
                       GetSQLValueString($_POST['data'], "date"));

  mysql_select_db($database_db_engenho, $db_engenho);
  $Result1 = mysql_query($insertSQL, $db_engenho) or die(header(sprintf("Location:index.php?cadastro=erro")));

  $insertGoTo = "index.php?admin=cadastrado";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "edita_usu")) {
  $updateSQL = sprintf("UPDATE usu_admin SET usu_email=%s, usu_senha=sha1(%s), usu_data=%s, usu_nome=%s WHERE id_usu=%s",
                       GetSQLValueString($_POST['edita_email_usu'], "text"),
                       GetSQLValueString($_POST['edita_senha_usu'], "text"),
                       GetSQLValueString($_POST['edita_data'], "date"),
                       GetSQLValueString($_POST['edita_nome_usu'], "text"),
                       GetSQLValueString($_GET['usuario'], "text"));

  mysql_select_db($database_db_engenho, $db_engenho);
  $Result1 = mysql_query($updateSQL, $db_engenho) or die(mysql_error());

  $updateGoTo = "index.php?admin=editado";
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "editar_evento")) {
  $updateSQL = sprintf("UPDATE agenda_eventos SET data_evento=%s, hora_evento=%s, descri_evento=%s, local_evento=%s, end_evento=%s, data_cadastro=%s, user_evento=%s, email_evento=%s, nome_evento=%s WHERE id_evento=%s",
                       GetSQLValueString($_POST['ed_data_evento'], "text"),
                       GetSQLValueString($_POST['ed_hora_evento'], "text"),
                       GetSQLValueString($_POST['ed_descricao'], "text"),
                       GetSQLValueString($_POST['ed_local_evento'], "text"),
                       GetSQLValueString($_POST['ed_end_evento'], "text"),
                       GetSQLValueString($_POST['data_agenda'], "date"),
                       GetSQLValueString($_POST['user_evento'], "text"),
                       GetSQLValueString($_POST['ed_email_evento'], "text"),
                       GetSQLValueString($_POST['ed_nome_evento'], "text"),
                       GetSQLValueString($_GET['evento'], "text"));

  mysql_select_db($database_db_engenho, $db_engenho);
  $Result1 = mysql_query($updateSQL, $db_engenho) or die(mysql_error());

  $updateGoTo = "index.php?agenda=editado";
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "edita_depo")) {
  $updateSQL = sprintf("UPDATE depo_cliente SET depo_categ=%s, depoimento=%s, usu_cadastro=%s, data_cadastro=%s, email_depo=%s, nome_depo=%s WHERE id_depo=%s",
                       GetSQLValueString($_POST['edit_categoria_depo'], "text"),
                       GetSQLValueString($_POST['edit_depoimento'], "text"),
                       GetSQLValueString($_POST['user_depo'], "text"),
                       GetSQLValueString($_POST['data_depo'], "date"),
                       GetSQLValueString($_POST['edit_email_depo'], "text"),
                       GetSQLValueString($_POST['edit_nome_depo'], "text"),
                       GetSQLValueString($_GET['depo'], "text"));

  mysql_select_db($database_db_engenho, $db_engenho);
  $Result1 = mysql_query($updateSQL, $db_engenho) or die(mysql_error());

  $updateGoTo = "index.php?depoimento=alterado";
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_GET['exclui'])) && ($_GET['exclui'] != "") && (isset($_GET['depo']))) {
  $deleteSQL = sprintf("DELETE FROM depo_cliente WHERE id_depo=%s",
                       GetSQLValueString($_GET['exclui'], "int"));

  mysql_select_db($database_db_engenho, $db_engenho);
  $Result1 = mysql_query($deleteSQL, $db_engenho) or die(mysql_error());

  $deleteGoTo = "index.php?depoimento=excluido";
  header(sprintf("Location: %s", $deleteGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "cadastra_depo")) {
  $insertSQL = sprintf("INSERT INTO depo_cliente (nome_depo, email_depo, depo_categ, depoimento, usu_cadastro, data_cadastro) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nome_depo'], "text"),
                       GetSQLValueString($_POST['email_depo'], "text"),
                       GetSQLValueString($_POST['categoria_depo'], "text"),
                       GetSQLValueString($_POST['depoimento'], "text"),
                       GetSQLValueString($_POST['user_depo'], "text"),
                       GetSQLValueString($_POST['data_depo'], "date"));

  mysql_select_db($database_db_engenho, $db_engenho);
  $Result1 = mysql_query($insertSQL, $db_engenho) or die(mysql_error());

  $insertGoTo = "../index.php?depoimento=publicado";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_GET['exclui'])) && ($_GET['exclui'] != "") && (isset($_GET['evento']))) {
  $deleteSQL = sprintf("DELETE FROM agenda_eventos WHERE id_evento=%s",
                       GetSQLValueString($_GET['exclui'], "int"));

  mysql_select_db($database_db_engenho, $db_engenho);
  $Result1 = mysql_query($deleteSQL, $db_engenho) or die(mysql_error());

  $deleteGoTo = "index.php?agenda=excluido";
  header(sprintf("Location: %s", $deleteGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "cadastra_evento")) {
  $insertSQL = sprintf("INSERT INTO agenda_eventos (nome_evento, email_evento, data_evento, hora_evento, descri_evento, local_evento, end_evento, data_cadastro, user_evento) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nome_evento'], "text"),
                       GetSQLValueString($_POST['email_evento'], "text"),
                       GetSQLValueString($_POST['data_evento'], "text"),
                       GetSQLValueString($_POST['hora_evento'], "text"),
                       GetSQLValueString($_POST['descricao'], "text"),
                       GetSQLValueString($_POST['local_evento'], "text"),
                       GetSQLValueString($_POST['end_evento'], "text"),
                       GetSQLValueString($_POST['data_agenda'], "date"),
					   GetSQLValueString($_POST['user_evento'], "text"));

  mysql_select_db($database_db_engenho, $db_engenho);
  $Result1 = mysql_query($insertSQL, $db_engenho) or die(header(sprintf("Location:index.php?agenda=erro")));

  $insertGoTo = "index.php?agenda=cadastrado";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_GET['exclui'])) && ($_GET['exclui'] != "") && (isset($_GET['feed']))) {
  $deleteSQL = sprintf("DELETE FROM email_feeds WHERE id_email=%s",
                       GetSQLValueString($_GET['exclui'], "int"));

  mysql_select_db($database_db_engenho, $db_engenho);
  $Result1 = mysql_query($deleteSQL, $db_engenho) or die(mysql_error());

  $deleteGoTo = "index.php?assinatura=cancelada";
  header(sprintf("Location: %s", $deleteGoTo));
}

if ((isset($_GET['exclui'])) && ($_GET['exclui'] != "") && (isset($_GET['usuario']))) {
  $deleteSQL = sprintf("DELETE FROM usu_admin WHERE id_usu=%s",
                       GetSQLValueString($_GET['exclui'], "int"));

  mysql_select_db($database_db_engenho, $db_engenho);
  $Result1 = mysql_query($deleteSQL, $db_engenho) or die(mysql_error());

  $deleteGoTo = "index.php?admin=excluido";
  header(sprintf("Location: %s", $deleteGoTo));
}

$maxRows_RsAdminFeeds = 15;
$pageNum_RsAdminFeeds = 0;
if (isset($_GET['pageNum_RsAdminFeeds'])) {
  $pageNum_RsAdminFeeds = $_GET['pageNum_RsAdminFeeds'];
}
$startRow_RsAdminFeeds = $pageNum_RsAdminFeeds * $maxRows_RsAdminFeeds;

mysql_select_db($database_db_engenho, $db_engenho);
$query_RsAdminFeeds = "SELECT * FROM email_feeds ORDER BY ass_email ASC";
$query_limit_RsAdminFeeds = sprintf("%s LIMIT %d, %d", $query_RsAdminFeeds, $startRow_RsAdminFeeds, $maxRows_RsAdminFeeds);
$RsAdminFeeds = mysql_query($query_limit_RsAdminFeeds, $db_engenho) or die(mysql_error());
$row_RsAdminFeeds = mysql_fetch_assoc($RsAdminFeeds);

if (isset($_GET['totalRows_RsAdminFeeds'])) {
  $totalRows_RsAdminFeeds = $_GET['totalRows_RsAdminFeeds'];
} else {
  $all_RsAdminFeeds = mysql_query($query_RsAdminFeeds);
  $totalRows_RsAdminFeeds = mysql_num_rows($all_RsAdminFeeds);
}
$totalPages_RsAdminFeeds = ceil($totalRows_RsAdminFeeds/$maxRows_RsAdminFeeds)-1;

$maxRows_RsAdminUser = 10;
$pageNum_RsAdminUser = 0;
if (isset($_GET['pageNum_RsAdminUser'])) {
  $pageNum_RsAdminUser = $_GET['pageNum_RsAdminUser'];
}
$startRow_RsAdminUser = $pageNum_RsAdminUser * $maxRows_RsAdminUser;

mysql_select_db($database_db_engenho, $db_engenho);
$query_RsAdminUser = "SELECT id_usu, usu_nome, usu_email, usu_data FROM usu_admin ORDER BY usu_nome ASC";
$query_limit_RsAdminUser = sprintf("%s LIMIT %d, %d", $query_RsAdminUser, $startRow_RsAdminUser, $maxRows_RsAdminUser);
$RsAdminUser = mysql_query($query_limit_RsAdminUser, $db_engenho) or die(mysql_error());
$row_RsAdminUser = mysql_fetch_assoc($RsAdminUser);

if (isset($_GET['totalRows_RsAdminUser'])) {
  $totalRows_RsAdminUser = $_GET['totalRows_RsAdminUser'];
} else {
  $all_RsAdminUser = mysql_query($query_RsAdminUser);
  $totalRows_RsAdminUser = mysql_num_rows($all_RsAdminUser);
}
$totalPages_RsAdminUser = ceil($totalRows_RsAdminUser/$maxRows_RsAdminUser)-1;

$colname_RsExcluiUser = "-1";
if (isset($_GET['usuario'])) {
  $colname_RsExcluiUser = $_GET['usuario'];
}
mysql_select_db($database_db_engenho, $db_engenho);
$query_RsExcluiUser = sprintf("SELECT * FROM usu_admin WHERE id_usu = %s ORDER BY id_usu ASC", GetSQLValueString($colname_RsExcluiUser, "int"));
$RsExcluiUser = mysql_query($query_RsExcluiUser, $db_engenho) or die(mysql_error());
$row_RsExcluiUser = mysql_fetch_assoc($RsExcluiUser);
$totalRows_RsExcluiUser = mysql_num_rows($RsExcluiUser);

$colname_RsEditaUser = "-1";
if (isset($_GET['usuario'])) {
  $colname_RsEditaUser = $_GET['usuario'];
}
mysql_select_db($database_db_engenho, $db_engenho);
$query_RsEditaUser = sprintf("SELECT * FROM usu_admin WHERE id_usu = %s", GetSQLValueString($colname_RsEditaUser, "int"));
$RsEditaUser = mysql_query($query_RsEditaUser, $db_engenho) or die(mysql_error());
$row_RsEditaUser = mysql_fetch_assoc($RsEditaUser);
$totalRows_RsEditaUser = mysql_num_rows($RsEditaUser);

$colname_RsExcluiFeed = "-1";
if (isset($_GET['feed'])) {
  $colname_RsExcluiFeed = $_GET['feed'];
}
mysql_select_db($database_db_engenho, $db_engenho);
$query_RsExcluiFeed = sprintf("SELECT * FROM email_feeds WHERE id_email = %s", GetSQLValueString($colname_RsExcluiFeed, "int"));
$RsExcluiFeed = mysql_query($query_RsExcluiFeed, $db_engenho) or die(mysql_error());
$row_RsExcluiFeed = mysql_fetch_assoc($RsExcluiFeed);
$totalRows_RsExcluiFeed = mysql_num_rows($RsExcluiFeed);

$maxRows_RsAdminEventos = 5;
$pageNum_RsAdminEventos = 0;
if (isset($_GET['pageNum_RsAdminEventos'])) {
  $pageNum_RsAdminEventos = $_GET['pageNum_RsAdminEventos'];
}
$startRow_RsAdminEventos = $pageNum_RsAdminEventos * $maxRows_RsAdminEventos;

mysql_select_db($database_db_engenho, $db_engenho);
$query_RsAdminEventos = "SELECT * FROM agenda_eventos";
$query_limit_RsAdminEventos = sprintf("%s LIMIT %d, %d", $query_RsAdminEventos, $startRow_RsAdminEventos, $maxRows_RsAdminEventos);
$RsAdminEventos = mysql_query($query_limit_RsAdminEventos, $db_engenho) or die(mysql_error());
$row_RsAdminEventos = mysql_fetch_assoc($RsAdminEventos);

if (isset($_GET['totalRows_RsAdminEventos'])) {
  $totalRows_RsAdminEventos = $_GET['totalRows_RsAdminEventos'];
} else {
  $all_RsAdminEventos = mysql_query($query_RsAdminEventos);
  $totalRows_RsAdminEventos = mysql_num_rows($all_RsAdminEventos);
}
$totalPages_RsAdminEventos = ceil($totalRows_RsAdminEventos/$maxRows_RsAdminEventos)-1;

$colname_RsEditaEvento = "-1";
if (isset($_GET['evento'])) {
  $colname_RsEditaEvento = $_GET['evento'];
}
mysql_select_db($database_db_engenho, $db_engenho);
$query_RsEditaEvento = sprintf("SELECT * FROM agenda_eventos WHERE id_evento = %s", GetSQLValueString($colname_RsEditaEvento, "int"));
$RsEditaEvento = mysql_query($query_RsEditaEvento, $db_engenho) or die(mysql_error());
$row_RsEditaEvento = mysql_fetch_assoc($RsEditaEvento);
$totalRows_RsEditaEvento = mysql_num_rows($RsEditaEvento);

$colname_RsExcluiEvento = "-1";
if (isset($_GET['evento'])) {
  $colname_RsExcluiEvento = $_GET['evento'];
}
mysql_select_db($database_db_engenho, $db_engenho);
$query_RsExcluiEvento = sprintf("SELECT * FROM agenda_eventos WHERE id_evento = %s", GetSQLValueString($colname_RsExcluiEvento, "int"));
$RsExcluiEvento = mysql_query($query_RsExcluiEvento, $db_engenho) or die(mysql_error());
$row_RsExcluiEvento = mysql_fetch_assoc($RsExcluiEvento);
$totalRows_RsExcluiEvento = mysql_num_rows($RsExcluiEvento);

$colname_RsConfirmaUsu = "-1";
if (isset($_GET['usuario'])) {
  $colname_RsConfirmaUsu = $_GET['usuario'];
}
mysql_select_db($database_db_engenho, $db_engenho);
$query_RsConfirmaUsu = sprintf("SELECT id_usu, usu_nome FROM usu_admin WHERE id_usu = %s", GetSQLValueString($colname_RsConfirmaUsu, "int"));
$RsConfirmaUsu = mysql_query($query_RsConfirmaUsu, $db_engenho) or die(mysql_error());
$row_RsConfirmaUsu = mysql_fetch_assoc($RsConfirmaUsu);
$totalRows_RsConfirmaUsu = mysql_num_rows($RsConfirmaUsu);

$colname_RsConfirmaFeed = "-1";
if (isset($_GET['feed'])) {
  $colname_RsConfirmaFeed = $_GET['feed'];
}
mysql_select_db($database_db_engenho, $db_engenho);
$query_RsConfirmaFeed = sprintf("SELECT id_email, ass_email FROM email_feeds WHERE id_email = %s", GetSQLValueString($colname_RsConfirmaFeed, "int"));
$RsConfirmaFeed = mysql_query($query_RsConfirmaFeed, $db_engenho) or die(mysql_error());
$row_RsConfirmaFeed = mysql_fetch_assoc($RsConfirmaFeed);
$totalRows_RsConfirmaFeed = mysql_num_rows($RsConfirmaFeed);

$colname_RsConfirmaEvento = "-1";
if (isset($_GET['evento'])) {
  $colname_RsConfirmaEvento = $_GET['evento'];
}
mysql_select_db($database_db_engenho, $db_engenho);
$query_RsConfirmaEvento = sprintf("SELECT id_evento, nome_evento FROM agenda_eventos WHERE id_evento = %s", GetSQLValueString($colname_RsConfirmaEvento, "int"));
$RsConfirmaEvento = mysql_query($query_RsConfirmaEvento, $db_engenho) or die(mysql_error());
$row_RsConfirmaEvento = mysql_fetch_assoc($RsConfirmaEvento);
$totalRows_RsConfirmaEvento = mysql_num_rows($RsConfirmaEvento);

$maxRows_RsAdminDepo = 8;
$pageNum_RsAdminDepo = 0;
if (isset($_GET['pageNum_RsAdminDepo'])) {
  $pageNum_RsAdminDepo = $_GET['pageNum_RsAdminDepo'];
}
$startRow_RsAdminDepo = $pageNum_RsAdminDepo * $maxRows_RsAdminDepo;

mysql_select_db($database_db_engenho, $db_engenho);
$query_RsAdminDepo = "SELECT * FROM depo_cliente ORDER BY id_depo DESC";
$query_limit_RsAdminDepo = sprintf("%s LIMIT %d, %d", $query_RsAdminDepo, $startRow_RsAdminDepo, $maxRows_RsAdminDepo);
$RsAdminDepo = mysql_query($query_limit_RsAdminDepo, $db_engenho) or die(mysql_error());
$row_RsAdminDepo = mysql_fetch_assoc($RsAdminDepo);

if (isset($_GET['totalRows_RsAdminDepo'])) {
  $totalRows_RsAdminDepo = $_GET['totalRows_RsAdminDepo'];
} else {
  $all_RsAdminDepo = mysql_query($query_RsAdminDepo);
  $totalRows_RsAdminDepo = mysql_num_rows($all_RsAdminDepo);
}
$totalPages_RsAdminDepo = ceil($totalRows_RsAdminDepo/$maxRows_RsAdminDepo)-1;

$colname_RsConfirmaDepo = "-1";
if (isset($_GET['depo'])) {
  $colname_RsConfirmaDepo = $_GET['depo'];
}
mysql_select_db($database_db_engenho, $db_engenho);
$query_RsConfirmaDepo = sprintf("SELECT id_depo, nome_depo, depo_categ FROM depo_cliente WHERE id_depo = %s", GetSQLValueString($colname_RsConfirmaDepo, "int"));
$RsConfirmaDepo = mysql_query($query_RsConfirmaDepo, $db_engenho) or die(mysql_error());
$row_RsConfirmaDepo = mysql_fetch_assoc($RsConfirmaDepo);
$totalRows_RsConfirmaDepo = mysql_num_rows($RsConfirmaDepo);

$colname_RsEditaDepo = "-1";
if (isset($_GET['depo'])) {
  $colname_RsEditaDepo = $_GET['depo'];
}
mysql_select_db($database_db_engenho, $db_engenho);
$query_RsEditaDepo = sprintf("SELECT * FROM depo_cliente WHERE id_depo = %s", GetSQLValueString($colname_RsEditaDepo, "int"));
$RsEditaDepo = mysql_query($query_RsEditaDepo, $db_engenho) or die(mysql_error());
$row_RsEditaDepo = mysql_fetch_assoc($RsEditaDepo);
$totalRows_RsEditaDepo = mysql_num_rows($RsEditaDepo);

$colname_RsExcluiDepo = "-1";
if (isset($_GET['depo'])) {
  $colname_RsExcluiDepo = $_GET['depo'];
}
mysql_select_db($database_db_engenho, $db_engenho);
$query_RsExcluiDepo = sprintf("SELECT * FROM depo_cliente WHERE id_depo = %s", GetSQLValueString($colname_RsExcluiDepo, "int"));
$RsExcluiDepo = mysql_query($query_RsExcluiDepo, $db_engenho) or die(mysql_error());
$row_RsExcluiDepo = mysql_fetch_assoc($RsExcluiDepo);
$totalRows_RsExcluiDepo = mysql_num_rows($RsExcluiDepo);

$queryString_RsAdminFeeds = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RsAdminFeeds") == false && 
        stristr($param, "totalRows_RsAdminFeeds") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RsAdminFeeds = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RsAdminFeeds = sprintf("&totalRows_RsAdminFeeds=%d%s", $totalRows_RsAdminFeeds, $queryString_RsAdminFeeds);

$queryString_RsAdminEventos = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RsAdminEventos") == false && 
        stristr($param, "totalRows_RsAdminEventos") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RsAdminEventos = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RsAdminEventos = sprintf("&totalRows_RsAdminEventos=%d%s", $totalRows_RsAdminEventos, $queryString_RsAdminEventos);

$queryString_RsAdminUser = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RsAdminUser") == false && 
        stristr($param, "totalRows_RsAdminUser") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RsAdminUser = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RsAdminUser = sprintf("&totalRows_RsAdminUser=%d%s", $totalRows_RsAdminUser, $queryString_RsAdminUser);
?>
<!-- ==============================
    Project:        Cachaças Engenho da Cana "Comercial" Frontend e Backend  André Aguiar - Responsive HTML Template Based On Twitter Bootstrap 3.3.4
    Version:        1.0
    Author:         TOP Artes
    Primary use:    Comercial.
    Email:          contato@topartes.com
    Like:           http://www.facebook.com/topartescg
    Website:        http://www.topartes.com
================================== -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script type="text/javascript">
function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
</script>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta content="Sistema de administra&ccedil;&atilde;o de conte&uacute;do do site cachacaengenhodacana.com.br &#45; Cacha&ccedil;as Engenho da Cana." name="description"/>
        <meta content="cacha&ccedil;a mineira, aguardente, alambique artesanal, pinga, bebida destilada, aperitivo, cacha&ccedil;a no atacado, onde comprar cacha&ccedil;a artesal, engenho da cana, nossa rainha, bola da vez, alambique de minas, de la vega, melhor cacha&ccedil;a mineira, cacha&ccedil;a mais famosa" name="keywords" />
        <meta content="Andr&eacute; Aguiar - TOP Artes" name="author"/>
        
        <link rel="shortcut icon" href="../imagens/favicon/favicon.png"> 
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../imagens/favicon/apple-touch-icon-144-precomposed.png"> 
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../imagens/favicon/apple-touch-icon-114-precomposed.png"> 
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../imagens/favicon/apple-touch-icon-72-precomposed.png"> 
        <link rel="apple-touch-icon-precomposed" href="../imagens/favicon/apple-touch-icon-57-precomposed.png">

        <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="../css/layout.min.css" rel="stylesheet" type="text/css"/>
		<link href="https://fonts.googleapis.com/css?family=Kaushan+Script|Philosopher" rel="stylesheet">
        <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
        <!-- PAGE LEVEL PLUGIN STYLES -->
        <link href="../css/style.css" rel="stylesheet">
        <link href="../css/admin_style.css" rel="stylesheet">
		<link rel="stylesheet" href="../css/jquery.mCustomScrollbar.css">
		<title>Cacha&ccedil;as Engenho da Cana - Administrativo</title>
<style>
html, body{
	height: 100%;
}
</style>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
</head>

<body>

  <!--.preloader-->
  <div class="preloader"><div class="logo-preload"><img src="../imagens/logo-cachacas-engenho-da-cana.png" /></div> <i class="fa fa-spinner fa-spin"></i></div>
  <!--/.preloader-->
  
  
  
	<div class="content mCustomScrollbar">
		<section id="conteudo" class="conteudo">
       
       
       <!--/*================== LISTA USUARIO =========================*/-->
       
       
      
           <div class=" col-lg-6 margin-b-50" id="cabecalho">
               <h1>Sistema administrativo de conte&uacute;do</h1>
               <hr class="divider" id="divide_gr"  style="width:98%; border-color:#333; margin-bottom:0px; margin-top:0px;"/>
               <div class="logo_top_admin">
                  <img src="../imagens/logo-cachacas-engenho-da-cana.png" />
                </div>
                <div class="text-left logo-texto">
                    
                    <p>Sr(a). <b><?php echo ($_SESSION['MM_Username'])?>, </b>seja bem vindo(a)!<br />
    Voc&ecirc; est&aacute; na &aacute;rea administrativo de conte&uacute;do do site "www.cachacaengenhodacana.com.br"</p>
                </div>
                <div class="logout"> 
                    <a class="btn-theme btn-theme-sm btn-default-bg text-uppercase" href="<?php echo $logoutAction ?>">Sair</a>
               </div>
           </div>
       
       
                
                <hr class="divider" id="divide"/>
       <!--/*================== LISTA EVENTOS =========================*/-->
       
       
      
          <div class="col-lg-6 margin-b-10" id="agenda">
              <h2>Eventos Cadastrados <a class="btn-theme btn-theme-sm btn-base-bg text-uppercase" id="cadastro" onclick="MM_showHideLayers('cadastro_evento','','show','cadastra_cadastro','','show')"> Cadastrar Novo</a></h2>
                <div class="lista evento mCustomScrollbar">
                    <?php do { ?>
                        <div class="alterna" onclick="MM_goToURL('parent','?evento=<?php echo $row_RsAdminEventos['id_evento']; ?>');return document.MM_returnValue">
                                <?php echo $row_RsAdminEventos['id_evento']; ?> &#45;
                                <b><?php echo $row_RsAdminEventos['nome_evento']; ?> &#45;
                                <?php echo $row_RsAdminEventos['email_evento']; ?> &#45;
                                <?php echo $row_RsAdminEventos['data_evento']; ?> &#45;
                                <?php echo $row_RsAdminEventos['hora_evento']; ?></b>  <br />
            
                                <p>
                                    <?php echo $row_RsAdminEventos['descri_evento']; ?> <br />
                                    <b><?php echo $row_RsAdminEventos['local_evento']; ?> &#45;
                                     <?php echo $row_RsAdminEventos['end_evento']; ?> </b><br />
                                    <?php echo $row_RsAdminEventos['data_cadastro']; ?> &#45;
                                    <?php echo $row_RsAdminEventos['user_evento']; ?>
                                </p>
                    </div>
                          <?php } while ($row_RsAdminEventos = mysql_fetch_assoc($RsAdminEventos)); ?>
                </div>
              
				  <?php if ($_GET['evento'] != '') { ?>
                            <div class="confirma">
                                Deseja alterar o evento &#147;<?php echo $row_RsConfirmaEvento['nome_evento']; ?>&#148; ?
                            </div>
                          <div class="botoes">
                                <a onclick="MM_showHideLayers('edita_evento','','show')">Editar</a> &#124; 
                                <a onclick="MM_showHideLayers('exclui_evento','','show')">Excluir</a> &#124; 
                                <a href="index.php">Cancelar</a>
                  			</div>
				 <?php } ?>
                  <table border="0">
                    <tr>
                      <td><?php if ($pageNum_RsAdminEventos > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_RsAdminEventos=%d%s", $currentPage, 0, $queryString_RsAdminEventos); ?>"> &nbsp; Primeira &nbsp; </a> &#124;
                          <?php } // Show if not first page ?></td>
                      <td><?php if ($pageNum_RsAdminEventos > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_RsAdminEventos=%d%s", $currentPage, max(0, $pageNum_RsAdminEventos - 1), $queryString_RsAdminEventos); ?>"> &nbsp; Anterior &nbsp; </a> &#124;
                          <?php } // Show if not first page ?></td>
                      <td><?php if ($pageNum_RsAdminEventos < $totalPages_RsAdminEventos) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_RsAdminEventos=%d%s", $currentPage, min($totalPages_RsAdminEventos, $pageNum_RsAdminEventos + 1), $queryString_RsAdminEventos); ?>"> &nbsp; Pr&oacute;xima &nbsp; </a> &#124;
                          <?php } // Show if not last page ?></td>
                      <td><?php if ($pageNum_RsAdminEventos < $totalPages_RsAdminEventos) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_RsAdminEventos=%d%s", $currentPage, $totalPages_RsAdminEventos, $queryString_RsAdminEventos); ?>"> &nbsp; &uacute;ltima &nbsp; </a> &#124;
                          <?php } // Show if not last page ?></td>
                    </tr>
                  </table>
                        
				<?php if ($_GET["agenda"] == "cadastrado") { ?>
                    <div class="sucesso">
                        <p>
                            O evento foi cadastrado com sucesso!
                        </p>
                      <meta http-equiv="Refresh" content="5;URL=index.php">
                    </div>
                <?php } ?>   
                        
				<?php if ($_GET["agenda"] == "erro") { ?>
            <div class="erro">
                        <p>
                            O evento j&aacute; foi cadastrado!
                        </p>
                      <meta http-equiv="Refresh" content="5;URL=index.php">
                    </div>
                <?php } ?>      
        
            <?php if ($_GET["agenda"] == "editado") { ?>
                    <div class="sucesso">
                        <p>
                            O evento foi alterado com sucesso!
                        </p>
                      <meta http-equiv="Refresh" content="5;URL=index.php">
                    </div>
                <?php } ?>
                <?php if ($_GET["agenda"] == "excluido") { ?>
                    <div class="sucesso">
                        <p>
                            O evento foi excluido com sucesso!
                        </p>
                      <meta http-equiv="Refresh" content="5;URL=index.php">
                    </div>
                <?php } ?>
                </div>
                
                <hr class="divider" id="divide_meio"  style="width:98%; border-color:#333; position:relative;"/>
       
       
                
                <hr class="divider" id="divide"/>
       
       
       <!--/*================== LISTA DEPOIMENTOS =========================*/-->
       
       
      
          <div class="col-lg-5 margin-b-50" id="mensagens">
   			<h2>Depoimentos Publicados <a class="btn-theme btn-theme-sm btn-base-bg text-uppercase" id="cadastro" onclick="MM_showHideLayers('cadastro_depo','','show')"> Cadastrar Novo</a></h2>
   				<div class="lista depoimento mCustomScrollbar">
              		<?php do { ?>
                        <div id="alterna" class="alterna" onclick="MM_goToURL('parent','?depo=<?php echo $row_RsAdminDepo['id_depo']; ?>');return document.MM_returnValue">
                            <?php echo $row_RsAdminDepo['id_depo']; ?> &#124; <b><?php echo $row_RsAdminDepo['nome_depo']; ?>, 
                            <?php echo $row_RsAdminDepo['depo_categ']; ?>&#58;</b> <br />
                            <?php echo $row_RsAdminDepo['depoimento']; ?><br /> 
                            <?php echo $row_RsAdminDepo['usu_cadastro']; ?> em 
                            <?php echo $row_RsAdminDepo['data_cadastro']; ?>&#124; 
                            <?php echo $row_RsAdminDepo['email_depo']; ?>
                       </div>
					<?php } while ($row_RsAdminDepo = mysql_fetch_assoc($RsAdminDepo)); ?>
                </div>
              
           	<?php if ($_GET['depo'] != '') { ?>
                      	<div class="confirma">
							Deseja alterar o depoimento de &#147;<?php echo $row_RsEditaDepo['nome_depo']; ?>&#58; <?php echo $row_RsEditaDepo['depo_categ']; ?>&#148; ?
			</div>
                      	<div class="botoes">
                                <a onclick="MM_showHideLayers('edita_depo','','show')">Editar</a> &#124; 
                                <a onclick="MM_showHideLayers('exclui_depo','','show')">Excluir</a> &#124; 
                                <a href="index.php">Cancelar</a>
                        </div>
                     		<?php } ?>
             
                        
							<?php if ($_GET["depoimento"] == "publicado") { ?>
                                <div class="sucesso">
                                    <p>
                                        O depoimento foi publicado com sucesso!
                                    </p>
                                  <meta http-equiv="Refresh" content="5;URL=index.php">
                                </div>
                            <?php } ?>        
                    
                            <?php if ($_GET["depoimento"] == "alterado") { ?>
                                <div class="sucesso">
                                    <p>
                                        O depoimento foi alterado com sucesso!
                                    </p>
                                  <meta http-equiv="Refresh" content="5;URL=index.php">
                                </div>
                            <?php } ?>
                            <?php if ($_GET["depoimento"] == "excluido") { ?>
                                <div class="sucesso">
                                    <p>
                                        O depoimento foi excluido com sucesso!
                                    </p>
                                  <meta http-equiv="Refresh" content="5;URL=index.php">
                                </div>
                            <?php } ?>
		  </div>
      
       
       
       <!--/*================== LISTA EMAILS =========================*/-->
       
       
       
       
                
                <hr class="divider" id="divide"/>
      
            
        <div class="col-lg-4 margin-b-50" id="feeds">
                <h2>E&#45;mails Cadastrados</h2>
                
      		<div class="lista feed mCustomScrollbar">
				<?php do { ?>
	                  <div class="alterna" onclick="MM_goToURL('parent','?feed=<?php echo $row_RsAdminFeeds['id_email']; ?>');return document.MM_returnValue">
                        <?php echo $row_RsAdminFeeds['id_email']; ?> &#45; 
                        <b><?php echo $row_RsAdminFeeds['ass_email']; ?></b> &#124;
                        <?php echo $row_RsAdminFeeds['ass_data']; ?>
 	                </div>
                  <?php } while ($row_RsAdminFeeds = mysql_fetch_assoc($RsAdminFeeds)); ?>
          	</div>
          
                      <?php if ($_GET['feed'] != ''){?>
                      	<div class="confirma">
							Deseja excluir o E&#45;mail &#147;<?php echo $row_RsConfirmaFeed['ass_email']; ?>&#148; ?
                        </div>
                            <div class="botoes"> 
                                <a onclick="MM_showHideLayers('exclui_feed','','inherit')">Excluir</a> &#124;
                                <a href="index.php">Cancelar</a>
                            </div>
                        <?php } ?>
                            <table border="0">
                                <tr>
                                  <td><?php if ($pageNum_RsAdminFeeds > 0) { // Show if not first page ?>
                                       &#124;<a href="<?php printf("%s?pageNum_RsAdminFeeds=%d%s", $currentPage, 0, $queryString_RsAdminFeeds); ?>"> &nbsp; Primeira &nbsp; </a> &#124;
                                      <?php } // Show if not first page ?></td>
                                  <td><?php if ($pageNum_RsAdminFeeds > 0) { // Show if not first page ?>
                                      <a href="<?php printf("%s?pageNum_RsAdminFeeds=%d%s", $currentPage, max(0, $pageNum_RsAdminFeeds - 1), $queryString_RsAdminFeeds); ?>"> &nbsp; Anterior &nbsp; </a> &#124; 
                                      <?php } // Show if not first page ?></td>
                                  <td> <?php if ($pageNum_RsAdminFeeds < $totalPages_RsAdminFeeds) { // Show if not last page ?>
                                      <a href="<?php printf("%s?pageNum_RsAdminFeeds=%d%s", $currentPage, min($totalPages_RsAdminFeeds, $pageNum_RsAdminFeeds + 1), $queryString_RsAdminFeeds); ?>"> &nbsp; Pr&oacute;xima &nbsp; </a> &#124;
                                      <?php } // Show if not last page ?></td>
                                  <td><?php if ($pageNum_RsAdminFeeds < $totalPages_RsAdminFeeds) { // Show if not last page ?>
                                      <a href="<?php printf("%s?pageNum_RsAdminFeeds=%d%s", $currentPage, $totalPages_RsAdminFeeds, $queryString_RsAdminFeeds); ?>"> &nbsp; &Uacute;ltima &nbsp; </a> &#124;
                                      <?php } // Show if not last page ?></td>
                                </tr>
                              </table>
                        
                                <?php if ($_GET["assinatura"] == "cancelada") { ?>
                                	<div class="sucesso">
                                        <p>
                                            O e&#45;mail foi excluido com sucesso!
                                        </p>
                                      <meta http-equiv="Refresh" content="5;URL=index.php">
                                    </div>
                                <?php } ?>
            			</div>
       
       
       <!--/*================== LISTA USUARIO =========================*/-->
       
       
                
                <hr class="divider" id="divide"/>
       
       
      
            <div class="col-lg-3 margin-b-50" id="usuario">
                <h2>Usu&aacute;rios Cadastrados <a class="btn-theme btn-theme-sm btn-base-bg text-uppercase" id="cadastro" onclick="MM_showHideLayers('cadastro_admin','','show','cadastra_usu','','show')"> Cadastrar Novo</a></h2>
                
                    <div class="lista mCustomScrollbar">
                      <?php do { ?>
                          <div class="alterna" onclick="MM_goToURL('parent','?usuario=<?php echo $row_RsAdminUser['id_usu']; ?>');return document.MM_returnValue">
                              <?php echo $row_RsAdminUser['id_usu']; ?> &#45; 
                              <b><?php echo $row_RsAdminUser['usu_nome']; ?></b> &#45;
                          <?php echo $row_RsAdminUser['usu_email']; ?> &#124;
                          <?php echo $row_RsAdminUser['usu_data']; ?>   
                      	</div>
                        <?php } while ($row_RsAdminUser = mysql_fetch_assoc($RsAdminUser)); ?>
	  				</div>
                      <?php if ($_GET['usuario'] != ''){?>
                      	<div class="confirma">
							Deseja alterar o usuário &#147;<?php echo $row_RsConfirmaUsu['usu_nome']; ?>&#148; ?
                        </div>
                      		<div class="botoes">
                                <a onclick="MM_showHideLayers('edita_usu','','show')">Editar</a> &#124; 
                                <a onclick="MM_showHideLayers('exclui_usu','','show')">Excluir</a> &#124; 
                                <a href="index.php">Cancelar</a>
                  </div>
                        <?php } ?>
                        <table border="0">
                          <tr>
                            <td><?php if ($pageNum_RsAdminUser > 0) { // Show if not first page ?>
                                 &#124;<a href="<?php printf("%s?pageNum_RsAdminUser=%d%s", $currentPage, 0, $queryString_RsAdminUser); ?>"> &nbsp; Primeira &nbsp; </a> &#124;
                            <?php } // Show if not first page ?></td>
                            <td><?php if ($pageNum_RsAdminUser > 0) { // Show if not first page ?>
                                <a href="<?php printf("%s?pageNum_RsAdminUser=%d%s", $currentPage, max(0, $pageNum_RsAdminUser - 1), $queryString_RsAdminUser); ?>"> &nbsp; Anterior &nbsp; </a> &#124;
                            <?php } // Show if not first page ?></td>
                            <td><?php if ($pageNum_RsAdminUser < $totalPages_RsAdminUser) { // Show if not last page ?>
                                <a href="<?php printf("%s?pageNum_RsAdminUser=%d%s", $currentPage, min($totalPages_RsAdminUser, $pageNum_RsAdminUser + 1), $queryString_RsAdminUser); ?>"> &nbsp; P&oacute;xima &nbsp; </a> &#124;
                            <?php } // Show if not last page ?></td>
                            <td><?php if ($pageNum_RsAdminUser < $totalPages_RsAdminUser) { // Show if not last page ?>
                                <a href="<?php printf("%s?pageNum_RsAdminUser=%d%s", $currentPage, $totalPages_RsAdminUser, $queryString_RsAdminUser); ?>"> &nbsp; &Uacute;ltima &nbsp; </a> &#124;
                            <?php } // Show if not last page ?></td>
                          </tr>
                        </table>
                                <?php if ($_GET["admin"] == "cadastrado") { ?>
                                	<div class="sucesso">
                                        <p>
                                            O novo usu&aacute;rio foi cadastrado com sucesso!
                                        </p>
                                      <meta http-equiv="Refresh" content="5;URL=index.php">
                                    </div>
                                <?php }elseif ($_GET["cadastro"] == "erro") {?>
                                	<div class="erro">
                                        <p>
                                            Este usu&aacute;rio j&aacute; est&aacute; cadastrado!
                                        </p>
                                      <meta http-equiv="Refresh" content="5;URL=index.php">
                                    </div>
                                <?php } ?>
                                
                                <?php if ($_GET["admin"] == "editado") { ?>
                                	<div class="sucesso">
                                        <p>
                                            O usu&aacute;rio foi alterado com sucesso!
                                        </p>
                                      <meta http-equiv="Refresh" content="5;URL=index.php">
                                    </div>
                                <?php } ?>
                                
                                <?php if ($_GET["admin"] == "excluido") { ?>
                                	<div class="sucesso">
                                        <p>
                                            O usu&aacute;rio foi excluido com sucesso!
                                        </p>
                                      <meta http-equiv="Refresh" content="5;URL=index.php">
                                    </div>
                                <?php } ?>
            
    				</div>
    		</section>
       <!--/*================== FORMULARIO - CADASTRA USUARIO =========================*/-->
       
       
      
        <div class="cadastro_admin" id="cadastro_admin">
                    <div class="logo-form margin-b-40">
                    	<img src="../imagens/logo-cachacas-engenho-da-cana.png" />
                        </div>
          <form action="<?php echo $editFormAction; ?>" method="POST" name="cadastra_usu" id="cadastra_usu" class=" mCustomScrollbar">
	   			<h2>Cadastrar administrador</h2>
                <label for="nome_usu">Nome</label>
                <input class="margin-b-10" name="nome_usu" type="text" required="required" />
                <label for="email_usu">E-mail</label>
                <input class="margin-b-10" name="email_usu" type="email" required="required" />
                <label for="senha_usu">Senha</label>
                <input class="margin-b-10" name="senha_usu" type="password" required="required" />
                <button type="submit" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Cadastrar</button>
                  <a class="btn-theme btn-theme-sm btn-base-bg text-uppercase" style="margin-left:2%;" onclick="MM_showHideLayers('cadastro_admin','','hide','cadastra_usu','','hide')">Cancelar</a>
                  <input type="hidden" name="data" value="<?php date_default_timezone_set('America/Sao_Paulo'); echo date('Y-m-d H:i:s', time()) ?>" />
                  <input type="hidden" name="MM_insert" value="cadastra_usu" />
          </form>
       </div>
       
       
       <!--/*================== FORMULARIO - EDITA USUARIO =========================*/-->
       
       
      <div class="edita_usu" id="edita_usu">
                    <div class="logo-form margin-b-40">
                    	<img src="../imagens/logo-cachacas-engenho-da-cana.png" />
                        </div>
   	     <form method="POST" action="<?php echo $editFormAction; ?>" name="edita_usu" class=" mCustomScrollbar">
	   			<h2>Deseja editar &#147;<?php echo $row_RsEditaUser['usu_nome']; ?>&#148; no cadastro de administradores?</h2>
           		<label for="edita_nome_usu">Nome</label>
                <input class="margin-b-10" name="edita_nome_usu" value="<?php echo $row_RsEditaUser['usu_nome']; ?>" type="text" required="required" />
                <label for="edita_email_usu">E-mail</label>
           		<input class="margin-b-10" name="edita_email_usu" value="<?php echo $row_RsEditaUser['usu_email']; ?>" type="edita_email" required="required" />
                <label for="edita_senha_usu">Senha</label>
           		<input class="margin-b-10" name="edita_senha_usu" value="<?php echo $row_RsEditaUser['usu_senha']; ?>" type="password" required="required" />
        		<button type="submit" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Editar</button>
          		<a class="btn-theme btn-theme-sm btn-base-bg text-uppercase" style="margin-left:2%;" onclick="MM_showHideLayers('edita_usu','','hide')">Cancelar</a>
          		<input type="hidden" name="edita_data" value="<?php date_default_timezone_set('America/Sao_Paulo'); echo date('Y-m-d H:i:s', time()) ?>" />
          		<input type="hidden" name="MM_update" value="edita_usu" />
         </form>
       </div>
       <div class="exclui_usu" id="exclui_usu">
                    <div class="logo-form margin-b-40">
                    	<img src="../imagens/logo-cachacas-engenho-da-cana.png" />
                        </div>
       		<form name="deleta_usu">
	   			<h2>Deseja excluir &#147;<?php echo $row_RsExcluiUser['usu_nome']; ?>&#148; do cadastro de administradores?</h2>
        		<button type="button" class="btn-theme btn-theme-sm btn-base-bg text-uppercase" onclick="MM_goToURL('parent','?usuario=<?php echo $row_RsExcluiUser['id_usu']; ?>&amp;exclui=<?php echo $row_RsExcluiUser['id_usu']; ?>');return document.MM_returnValue">Excluir</button>
		          <a class="btn-theme btn-theme-sm btn-base-bg text-uppercase" style="margin-left:2%;" onclick="MM_showHideLayers('exclui_usu','','hide','exclui_usu','','hide')">Cancelar</a>
            </form>
       		
       </div>
       
       
       <!--/*================== FORMULARIO - EXCLUI USUARIO =========================*/-->
       
       
      <div class="exclui_feed" id="exclui_feed">
                    <div class="logo-form margin-b-40">
                    	<img src="../imagens/logo-cachacas-engenho-da-cana.png" />
                        </div>
       		<form name="deleta_feed">
	   			<h2>Deseja excluir &#147;<?php echo $row_RsExcluiFeed['ass_email']; ?>&#148; do cadastro de not&iacute;cias?</h2>
        		<button type="button" class="btn-theme btn-theme-sm btn-base-bg text-uppercase" onclick="MM_goToURL('parent','?feed=<?php echo $row_RsExcluiFeed['id_email']; ?>&amp;exclui=<?php echo $row_RsExcluiFeed['id_email']; ?>');return document.MM_returnValue">Excluir</button>
		          <a class="btn-theme btn-theme-sm btn-base-bg text-uppercase" style="margin-left:2%;" onclick="MM_showHideLayers('exclui_feed','','hide','exclui_feed','','hide')">Cancelar</a>
            </form>
       		
       </div>
       
       
       <!--/*================== FORMULARIO - CADASTRA EVENTO =========================*/-->
       
       
      <div class="cadastro_evento" id="cadastro_evento">
                    <div class="logo-form margin-b-40">
                    	<img src="../imagens/logo-cachacas-engenho-da-cana.png" />
                        </div>
          <form action="<?php echo $editFormAction; ?>" method="POST" name="cadastra_evento" id="cadastra_evento" class=" mCustomScrollbar">
                <h2>Cadastrar Evento</h2>
                <label for="nome_evento" class="nome">Nome do Evento
                <input class="margin-b-10" name="nome_evento" type="text" required="required" /></label>
                <label for="email_evento" class="email">E&#45;mail de contato
                <input class="margin-b-10" name="email_evento" type="text" required="required" /></label>
                <label for="data_evento" class="data">Data do Evento
                <span id="data">
                <input class="margin-b-10" name="data_evento" type="text" required="required" />
                <span class="textfieldInvalidFormatMsg">Formato inv&aacute;lido.</span></span></label>
                <label for="hora_evento" class="hora">Hor&aacute;rio do Evento
                <input class="margin-b-10" name="hora_evento" type="time" required="required" /></label>
           		 <label for="local_evento">Local do Evento</label>
                <input class="margin-b-10" name="local_evento" type="text" required="required" />
            	<label for="end_evento">Endere&ccedil;o do Evento</label>
                <input class="margin-b-10" name="end_evento" type="text" required="required" />
            	<label for="descricao">Descri&ccedil;&atilde;o do Evento</label>
                <textarea name="descricao" required="required" class="margin-b-10"></textarea>
                <button type="submit" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Cadastrar</button>
                  <a class="btn-theme btn-theme-sm btn-base-bg text-uppercase" style="margin-left:2%;" onclick="MM_showHideLayers('cadastro_evento','','hide','cadastra_evento','','hide')">Cancelar</a>
                  <input type="hidden" name="data_agenda" value="<?php date_default_timezone_set('America/Sao_Paulo'); echo date('Y-m-d H:i:s', time()) ?>" />
                  <input type="hidden" name="user_evento" value="<?php echo ($_SESSION['MM_Username'])?>" />
                  <input type="hidden" name="MM_insert" value="cadastra_evento" />
          </form>
      </div>
       
       
       <!--/*================== FORMULARIO - EDITA EVENTO =========================*/-->
       
       
      
       <div class="edita_evento" id="edita_evento">
                    <div class="logo-form margin-b-40">
                    	<img src="../imagens/logo-cachacas-engenho-da-cana.png" />
                        </div>
       		<form name="editar_evento" method="POST" action="<?php echo $editFormAction; ?>" class=" mCustomScrollbar">
            	<h2>Deseja Editar o Evento &#147;<?php echo $row_RsEditaEvento['nome_evento']; ?>&#148;</h2>
                <label for="nome_evento" class="nome">Nome do Evento
                <input class="margin-b-10" name="ed_nome_evento" value="<?php echo $row_RsEditaEvento['nome_evento']; ?>" type="text" required="required" /></label>
                <label for="email_evento" class="email">E&#45;mail de contato
                <input class="margin-b-10" name="ed_email_evento" value="<?php echo $row_RsEditaEvento['email_evento']; ?>" type="text" required="required" /></label>
                <label for="data_evento" class="data">Data do Evento
              <input class="margin-b-10" name="ed_data_evento" value="<?php echo $row_RsEditaEvento['data_evento']; ?>" type="text" required="required" /></label>
                <label for="hora_evento" class="hora">Hor&aacute;rio do Evento
              <input class="margin-b-10" name="ed_hora_evento" value="<?php echo $row_RsEditaEvento['hora_evento']; ?>" type="time" required="required" /></label>
            	<label for="ed_local_evento">Local do Evento</label>
                <input class="margin-b-10" name="ed_local_evento" value="<?php echo $row_RsEditaEvento['local_evento']; ?>" type="text" required="required" />
            	<label for="ed_end_evento">Endere&ccedil;o do Evento</label>
                <input class="margin-b-10" name="ed_end_evento" value="<?php echo $row_RsEditaEvento['end_evento']; ?>" type="text" required="required" />
            	<label for="descricao">Descri&ccedil;&atilde;o do Evento</label>
                <textarea name="ed_descricao" required="required" class="margin-b-10"><?php echo $row_RsEditaEvento['descri_evento']; ?></textarea>
        		<button type="submit" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Editar</button>
          		<a class="btn-theme btn-theme-sm btn-base-bg text-uppercase" style="margin-left:2%;" onclick="MM_showHideLayers('edita_evento','','hide','edita_evento','','hide')">Cancelar</a>
          		<input type="hidden" name="data_agenda" value="<?php date_default_timezone_set('America/Sao_Paulo'); echo date('Y-m-d H:i:s', time()) ?>" />
          		<input type="hidden" name="user_evento" value="<?php echo ($_SESSION['MM_Username'])?>" />
          		<input type="hidden" name="MM_update" value="editar_evento" />
            </form>
       </div>
       
       
       <!--/*================== FORMULARIO - EXCLUI EVENTO =========================*/-->
       
       
      
       <div class="exclui_evento" id="exclui_evento">
                    <div class="logo-form margin-b-40">
                    	<img src="../imagens/logo-cachacas-engenho-da-cana.png" />
                        </div>
       		<form name="deleta_evento">
	   			<h2>Deseja excluir &#147;<?php echo $row_RsExcluiEvento['nome_evento']; ?>&#148; do cadastro de eventos?</h2>
        		<button type="button" class="btn-theme btn-theme-sm btn-base-bg text-uppercase" onclick="MM_goToURL('parent','?evento=<?php echo $row_RsExcluiEvento['id_evento']; ?>&amp;exclui=<?php echo $row_RsExcluiEvento['id_evento']; ?>');return document.MM_returnValue">Excluir</button>
		          <a class="btn-theme btn-theme-sm btn-base-bg text-uppercase" style="margin-left:2%;" onclick="MM_showHideLayers('exclui_evento','','hide','exclui_evento','','hide')">Cancelar</a>
            </form>
      </div>
       
       
       <!--/*================== FORMULARIO - CADASTRA DEPOIMENTO =========================*/-->
       
       
      
            <div id="cadastro_depo" class="cadastro_depo">
                    <div class="logo-form margin-b-40">
                    	<img src="../imagens/logo-cachacas-engenho-da-cana.png" />
                        </div>
                <form name="cadastra_depo" method="POST" id="cadastra_depo" action="<?php echo $editFormAction; ?>" class=" mCustomScrollbar">
	   				<h2>Publicar Depoimento</h2>
                	<label for="nome_depo" class="nome">Nome do Autor
                    <input type="text" required="required" name="nome_depo" class="margin-b-10" /></label>
                	<label for="email_depo" class="email">E&#45;mail de contato
                    <input type="text" required="required" name="nome_depo" class="margin-b-10" /></label>
                	<label for="categoria_depo">Categoria</label>
                    <select name="categoria_depo" class="margin-b-10">
                      <option value="Consumidor">Consumidor</option>
                      <option value="Distribuidor">Distribuidor</option>
                      <option value="Representante">Representante</option>
                    </select>
 	               <label for="depoimento">Depoimento</label>
                    <textarea type="text" name="depoimento"  required="required" class="margin-b-10"></textarea>
        			<button type="submit" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Cadastrar</button>
                      <a class="btn-theme btn-theme-sm btn-base-bg text-uppercase" style="margin-left:2%;" onclick="MM_showHideLayers('cadastro_depo','','hide')">Cancelar</a>
                      <input type="hidden" name="data_depo" value="<?php date_default_timezone_set('America/Sao_Paulo'); echo date('Y-m-d H:i:s', time()) ?>" />
                      <input type="hidden" name="user_depo" value="<?php echo ($_SESSION['MM_Username'])?>" />
                      <input type="hidden" name="MM_insert" value="cadastra_depo" />
                </form>
           </div>
       
       
       <!--/*================== FORMULARIO - EDITA DEPOIMENTO =========================*/-->
       
       
      
           <div class="edita_depo" id="edita_depo">
                    <div class="logo-form margin-b-40">
                    	<img src="../imagens/logo-cachacas-engenho-da-cana.png" />
                        </div>
           		<form method="POST" action="<?php echo $editFormAction; ?>" name="edita_depo" class="editar_depo mCustomScrollbar" id="edita_depo">
           			<h2>Editar depoimento de &#147;<?php echo $row_RsEditaDepo['nome_depo']; ?>&#58; <?php echo $row_RsEditaDepo['depo_categ']; ?>&#148;</h2>
                	<label for="edit_nome_depo" class="nome">Nome do Autor
                    <input name="edit_nome_depo" type="text" required="required" class="margin-b-10" value="<?php echo $row_RsEditaDepo['nome_depo']; ?>" /></label>
                	<label for="edit_email_depo" class="email">E&#45;mail de contato
                    <input name="edit_email_depo" type="text" required="required" class="margin-b-10" value="<?php echo $row_RsEditaDepo['email_depo']; ?>" /></label>
                	<label for="edit_categoria_depo">Categoria</label>
                    <select name="edit_categoria_depo" class="margin-b-10">
                      <option value="Consumidor" <?php if (!(strcmp("Consumidor", $row_RsEditaDepo['depo_categ']))) {echo "selected=\"selected\"";} ?>>Consumidor</option>
                      <option value="Distribuidor" <?php if (!(strcmp("Distribuidor", $row_RsEditaDepo['depo_categ']))) {echo "selected=\"selected\"";} ?>>Distribuidor</option>
                      <option value="Representante" <?php if (!(strcmp("Representante", $row_RsEditaDepo['depo_categ']))) {echo "selected=\"selected\"";} ?>>Representante</option>
                    </select>
                	<label for="edit_depoimento">Depoimento</label>
                    <textarea type="text" name="edit_depoimento"  required="required" class="margin-b-10"><?php echo $row_RsEditaDepo['depoimento'];?></textarea>
        			<button type="submit" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Editar</button>
		          	<a class="btn-theme btn-theme-sm btn-base-bg text-uppercase" style="margin-left:2%;" onclick="MM_showHideLayers('edita_depo','','hide')">Cancelar</a>
                  	<input type="hidden" name="data_depo" value="<?php date_default_timezone_set('America/Sao_Paulo'); echo date('Y-m-d H:i:s', time()) ?>" />
                  	<input type="hidden" name="user_depo" value="<?php echo ($_SESSION['MM_Username'])?>" />
                  	<input type="hidden" name="MM_update" value="edita_depo" />
                	
                </form>
           </div>
       
       
       <!--/*================== FORMULARIO - EXCLUI DEPOIMENTO =========================*/-->
       
       
       
       		<div class="exclui_depo" id="exclui_depo">
                    <div class="logo-form margin-b-40">
                    	<img src="../imagens/logo-cachacas-engenho-da-cana.png" />
                        </div>
            	<form id="deleta_depo" name="deleta_depo" action="" method="post">
            		<h2>Deseja excluir &#147;<?php echo $row_RsExcluiDepo['nome_depo']; ?>&#148; do cadastro de eventos?</h2>
                	<button type="button" class="btn-theme btn-theme-sm btn-base-bg text-uppercase" onclick="MM_goToURL('parent','?depo=<?php echo $row_RsExcluiDepo['id_depo']; ?>&amp;exclui=<?php echo $row_RsExcluiDepo['id_depo']; ?>');return document.MM_returnValue">Excluir</button>
		          <a class="btn-theme btn-theme-sm btn-base-bg text-uppercase" style="margin-left:2%;" onclick="MM_showHideLayers('exclui_depo','','hide')">Cancelar</a>
                </form>
            </div>
                <!-- Copyright -->
                        <div class="text-center col-lg-12 margin-b-0">
                            <p class="margin-b-0">Contato para suporte: 31 3327&#45;5397 &#124; 31 99277-0410, andre@topartes.com</small></p>
                
              		</div>
      
          <hr class="divider" id="divide_gr"  style="width:98%; border-color:#333;"/>
            <footer>
                <!-- Copyright -->
                        <div class="text-center col-lg-12 margin-b-0">
                            <p class="margin-b-0">Todos direitos reservados, Cacha&ccedil;as Engenho da Cana &copy; 2017<br />
<small> Desenvolvido por: <a class="color-base fweight-200" href="#">TOP Artes &#45; Andr&eacute; Aguiar</a></small></p>
                
              		</div>
                <!-- End Copyright -->
                </footer> 
    
    		
            </div>
           
           
        <script src="../vendor/jquery.smooth-scroll.js" type="text/javascript"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/jquery-1.11.0.min.js"><\/script>')</script>
        <!-- CloudFlare CDN mousewheel plugin with fallback to local -->
		<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.6/jquery.mousewheel.min.js"></script>
        <script>$.event.special.mousewheel || document.write('<script src="js/jquery.mousewheel.min.js"><\/script>')</script>	
         <script src="../js/jquery.mCustomScrollbar.concat.min.js"></script>
         <script src="../js/main.js"></script>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("data", "date", {useCharacterMasking:true, format:"dd/mm/yyyy", hint:"__/__/____", validateOn:["blur"]});
         </script>
</body>
</html>
<?php
mysql_free_result($RsAdminFeeds);

mysql_free_result($RsAdminUser);

mysql_free_result($RsExcluiUser);

mysql_free_result($RsEditaUser);

mysql_free_result($RsExcluiFeed);

mysql_free_result($RsAdminEventos);

mysql_free_result($RsEditaEvento);

mysql_free_result($RsExcluiEvento);

mysql_free_result($RsConfirmaUsu);

mysql_free_result($RsConfirmaFeed);

mysql_free_result($RsConfirmaEvento);

mysql_free_result($RsAdminDepo);

mysql_free_result($RsConfirmaDepo);

mysql_free_result($RsEditaDepo);

mysql_free_result($RsExcluiDepo);
?>
