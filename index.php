<?php require_once('Connections/db_engenho.php'); ?>
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
	
	$maxRows_RsListaEventos = 5;
	$pageNum_RsListaEventos = 0;
	if (isset($_GET['pageNum_RsListaEventos'])) {
	  $pageNum_RsListaEventos = $_GET['pageNum_RsListaEventos'];
	}
	$startRow_RsListaEventos = $pageNum_RsListaEventos * $maxRows_RsListaEventos;
	
	mysql_select_db($database_db_engenho, $db_engenho);
	$query_RsListaEventos = "SELECT nome_evento, data_evento, hora_evento, descri_evento, local_evento, end_evento FROM agenda_eventos ORDER BY id_evento DESC";
	$query_limit_RsListaEventos = sprintf("%s LIMIT %d, %d", $query_RsListaEventos, $startRow_RsListaEventos, $maxRows_RsListaEventos);
	$RsListaEventos = mysql_query($query_limit_RsListaEventos, $db_engenho) or die(mysql_error());
	$row_RsListaEventos = mysql_fetch_assoc($RsListaEventos);
	
	if (isset($_GET['totalRows_RsListaEventos'])) {
	  $totalRows_RsListaEventos = $_GET['totalRows_RsListaEventos'];
	} else {
	  $all_RsListaEventos = mysql_query($query_RsListaEventos);
	  $totalRows_RsListaEventos = mysql_num_rows($all_RsListaEventos);
	}
	$totalPages_RsListaEventos = ceil($totalRows_RsListaEventos/$maxRows_RsListaEventos)-1;
	
	mysql_select_db($database_db_engenho, $db_engenho);
	$query_RsListaDepo = "SELECT id_depo, nome_depo, depo_categ, depoimento FROM depo_cliente ORDER BY id_depo DESC";
	$RsListaDepo = mysql_query($query_RsListaDepo, $db_engenho) or die(mysql_error());
	$row_RsListaDepo = mysql_fetch_assoc($RsListaDepo);
	$totalRows_RsListaDepo = mysql_num_rows($RsListaDepo);
	
	$queryString_RsListaEventos = "";
	if (!empty($_SERVER['QUERY_STRING'])) {
	  $params = explode("&", $_SERVER['QUERY_STRING']);
	  $newParams = array();
	  foreach ($params as $param) {
		if (stristr($param, "pageNum_RsListaEventos") == false && 
			stristr($param, "totalRows_RsListaEventos") == false) {
		  array_push($newParams, $param);
		}
	  }
	  if (count($newParams) != 0) {
		$queryString_RsListaEventos = "&" . htmlentities(implode("&", $newParams));
	  }
	}
	$queryString_RsListaEventos = sprintf("&totalRows_RsListaEventos=%d%s", $totalRows_RsListaEventos, $queryString_RsListaEventos);
	
	$editFormAction = $_SERVER['PHP_SELF'];
	if (isset($_SERVER['QUERY_STRING'])) {
	  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
	}
	
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "feed-news")) {
	  $insertSQL = sprintf("INSERT INTO email_feeds (ass_email, ass_data) VALUES (%s, %s)",
						   GetSQLValueString($_POST['feeds_email'], "text"),
						   GetSQLValueString($_POST['feeds_data'], "date"));
	
	  mysql_select_db($database_db_engenho, $db_engenho);
	  $Result1 = mysql_query($insertSQL, $db_engenho) or die(header(sprintf("Location:index.php?assinatura=erro#eventos")));
	
	  $insertGoTo = "index.php?assinatura=sucesso#eventos";
	  if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "" : "?";
		$insertGoTo .= $_SERVER['QUERY_STRING'];
	  }
	  header(sprintf("Location: %s", $insertGoTo));
	}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['login_nome'])) {
  $loginUsername=$_POST['login_nome'];
  $password=$_POST['login_senha'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "admin/index.php";
  $MM_redirectLoginFailed = "index.php?admin=login&login=erro";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_db_engenho, $db_engenho);
  
  $LoginRS__query=sprintf("SELECT usu_nome, usu_senha FROM usu_admin WHERE usu_nome=%s AND usu_senha=sha1(%s)",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $db_engenho) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>

<!DOCTYPE html>

<!-- ==============================
    Project:        Cachaças Engenho da Cana "Comercial" Frontend André Aguiar - Responsive HTML Template Based On Twitter Bootstrap 3.3.4
    Version:        1.0
    Author:         TOP Artes
    Primary use:    Comercial.
    Email:          suporte@topartes.com
    Like:           http://www.facebook.com/topartescg
    Website:        http://www.topartes.com
================================== -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Cacha&ccedil;a de Alambique Artesanal, Aguardente, Pinga, Bebida Destilada &#124; Cacha&ccedil;as Engenho da Cana</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta content="Cachaça mineira de alambique artesanal, Engenho da Cana, Alambique de Minas, Nossa Rainha, Bola da Vez e De La Vega. Produzido e engarrafado por Cacha&ccedil;as Engenho da Cana." name="description"/>
        <meta content="cacha&ccedil;a mineira, aguardente, alambique artesanal, pinga, bebida destilada, aperitivo, cacha&ccedil;a no atacado, onde comprar cacha&ccedil;a artesal, engenho da cana, nossa rainha, bola da vez, alambique de minas, de la vega, melhor cacha&ccedil;a mineira, cacha&ccedil;a mais famosa" name="keywords" />
        <meta content="Andr&eacute; Aguiar - TOP Artes" name="author"/>
        
        <link rel="shortcut icon" href="imagens/favicon/favicon.png"> 
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="imagens/favicon/apple-touch-icon-144-precomposed.png"> 
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="imagens/favicon/apple-touch-icon-114-precomposed.png"> 
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="imagens/favicon/apple-touch-icon-72-precomposed.png"> 
        <link rel="apple-touch-icon-precomposed" href="imagens/favicon/apple-touch-icon-57-precomposed.png">
        
		<link href="https://fonts.googleapis.com/css?family=Kaushan+Script|Philosopher" rel="stylesheet">
        
        <link rel="stylesheet" type="text/css" href="<?php echo("css/bootstrap.min.css") ?>"/>        
        <link rel="stylesheet" type="text/css" href="<?php echo("simple-line-icons/simple-line-icons.min.css") ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo("font-awesome/css/font-awesome.min.css") ?>">        
		<link rel="stylesheet" type="text/css" href="<?php echo("css/menu_style.css") ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo("css/animate.css") ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo("css/style.css") ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo("css/layout.min.css") ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo("css/swiper.min.css") ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo("css/jquery.mCustomScrollbar.css") ?>">
  		<link rel="stylesheet" type="text/css" media="all" href="<?php echo("css/carousel_styles.css") ?>">
        
<style type="text/css">

			
			html{
				height: auto;
				max-height:100%;
			}		
			body{
				height:100%;
				overflow: auto;
			}	
	.alterna{
		width: auto;
		min-width:100%;
		min-height:40px;	
		padding:10px 0px 5px 5px;
		word-break:break-all;
		color:#fff;
	}
	.alterna:nth-child(odd) {
		background-color:rgba(150,150,150,.05);
		width:100%;
		color:#fff;
	}
	.alterna:nth-child(even) {
		background-color:rgba(55,55,55,.05);
		width:100%;
		color:#fff;
	}

	#endereco{
		visibility:hidden;
	}
</style>
</head>

<body class="mCustomScrollbar" onload="MM_preloadImages('imagens/banner_bg/Cachaca-Bola-da-Vez-Premiada.jpg')">

    <!-- TELA LOGIN -->
    <?php if ($_GET['admin'] == 'login'){ ?>
        <div class="login" id="login">
                <div class="logo">
                    <img src="imagens/logo-cachacas-engenho-da-cana.png" />
                </div>
            <form action="<?php echo $loginFormAction; ?>" id="admin_login" method="POST">
                <label for="login_nome"> Nome: </label><br />

              <input name="login_nome" placeholder="Login" type="text" class="form-control footer-input margin-b-10" id="login_nome" required /><br />
                <label for="login_senha"> Senha: </label><br />

              <input name="login_senha" placeholder="Senha" type="password" class="form-control footer-input margin-b-20"  id="login_senha" required  />
                <?php if ($_GET['login'] == 'erro') { ?>
                <div>Usu&aacute;rio ou senha inv&aacute;lidos</div>
                <?php } ?>
                
              <button type="submit" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Logar</button>
                
                <button type="reset" class="btn-theme btn-theme-sm btn-base-bg text-uppercase" onClick="MM_goToURL('parent','?');return document.MM_returnValue">Cancelar</button>
            </form>
        </div>
    <?php }else{ ?>
    <!-- FIM LOGIN -->
    
        <div id="fb-root"></div>
          <!--.preloader-->
          <div class="preloader"><div class="logo-preload"><img src="imagens/logo-cachacas-engenho-da-cana.png" /></div> <i class="fa fa-spinner fa-spin"></i></div>
          <!--/.preloader-->    
            
            <div id="geral">
               <div class="topo">
                    <div class="logo">
                        <a href="index.php">
                        <img src="imagens/logo-cachacas-engenho-da-cana.png" /></a>
                    </div>
                </div>
                <div class="menu-logo">
                    <a href="index.php">
                        <img src="imagens/logo-menu-cachacas-engenho-da-cana.png" /></a>
				</div>
                <header class="header">
                    <div class="logo_top">                	
                        <a href="index.php">
                            <img src="imagens/logo-cachacas-engenho-da-cana.png" /></a>
                    </div>
                    <!-- Menu -->
                    <div id='cssmenu'>
                        <ul>
                          <li class='active'><a href="index.php"><i class="fa fa-home"> </i> Principal</a></li>
                          <li class='has-sub'><a href='cachaca.php'>Cacha&ccedil;as Engenho da Cana</a>
                              <ul>
                                 <li><a href='cachaca.php#engenho-da-cana'>Cacha&ccedil;a Engenho da Cana</a></li>
                                 <li><a href='cachaca.php#alambique-de-minas'>Cacha&ccedil;a Alambique de Minas</a></li>
                                 <li><a href='cachaca.php#nossa-rainha'>Cacha&ccedil;a Nossa Rainha</a></li>
                                 <li><a href='cachaca.php#bola-da-vez'>Cacha&ccedil;a Bola da Vez</a></li>
                              </ul>
                          </li>
                           <li class="has-sub"><a href='engenho.php'>Engenho da Cana</a>
                                <ul>
                                    <li><a href="engenho.php#nossa-historia">Hist&oacute;ria da Engenho da Cana</a></li>
                                    <li><a href="engenho.php#menu-list">Pr&ecirc;mios e Qualidade</a></li>
                                    <li><a href="engenho.php#depoimentos-fas">Depoimentos dos F&atilde;s</a></li>
                                    <li><a href="engenho.php#galeria">Galeria de Fotos e V&iacute;deos</a></li>
                                </ul>
                           </li>
                           <li class="has-sub"><a href='#'>Onde Comprar</a>
                                <ul>
                                    <li><a href="#lojas-varejo">Lojas e Varejo</a></li>
                                    <li><a href="#distribuidores-atacado">Distribuidores e Atacado</a></li>
                                    <li><a href="#distribuidor">Seja um Distribuidor</a></li>
                                </ul>
                           </li>
                           <li class="has-sub"><a href='#'>Cacha&ccedil;a News</a>
                                <ul>
                                    <li><a href="#eventos">Eventos</a></li>
                                    <li><a href="#expocachaca">Expocacha&ccedil;a</a></li>
                                    <li><a href="#receitas">Receitas</a></li>
                                    <li><a href="#imprensa">Imprensa</a></li>
                                </ul>
                           </li>
                           <li><a href='contato.php'>Contato</a></li>
                        </ul>
                    </div>
                    <!-- FIM Menu -->
                </header>
                <!-- FIM HEADER -->
                <!-- SLIDER -->
             <form class="busca">
				<input type="text" class="footer-input form-control" onKeyUp="showResult(this.value)" placeholder="Buscar"><i class="fa fa-search" style="position:absolute; float:right; right:15px; top:15px;"></i>
				<div id="livesearch"></div>
			</form>
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel"> 
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">  
        
               <div class="container">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                    </ol>
                </div>                 
                <div class="item active wow fadeInRight" data-wow-duration=".25" data-wow-delay=".5s">
                    <img class="img-responsive" src="imagens/banner_bg/Cachaca-Bola-da-Vez-Premiada.jpg" alt="Pr&ecirc;mios Cacha&ccedil;a Bola da Vez 2017"> 
                    <div class="anterior btn" data-target="#carousel-example-generic" data-slide-to="3">
                        <i class="fa fa-angle-left"></i>
                    </div>
                    <div class="proximo btn" data-target="#carousel-example-generic" data-slide-to="1">
                        <i class="fa fa-angle-right"></i>
                    </div>                   
                </div>
                <div class="item wow fadeInRight" data-wow-duration=".25" data-wow-delay=".5s">
                    <img class="img-responsive" src="imagens/banner_bg/Cachaca-Engenho-da-Cana-Premiada.jpg" alt="Pr&ecirc;mios Cacha&ccedil;a Engenho da Cana 2017">
                    <div class="anterior btn" data-target="#carousel-example-generic" data-slide-to="0">
                        <i class="fa fa-angle-left"></i>
                    </div>
                    <div class="proximo btn" data-target="#carousel-example-generic" data-slide-to="2">
						<i class="fa fa-angle-right"></i>
                    </div>
                </div>
                <div class="item wow fadeInRight" data-wow-duration=".25" data-wow-delay=".5s">
                    <img class="img-responsive" src="imagens/banner_bg/Cachaca-Nossa-Rainha-Premiada.jpg" alt="Pr&ecirc;mios Cacha&ccedil;a Nossa Rainha 2017">
                    <div class="anterior btn" data-target="#carousel-example-generic" data-slide-to="1">
                        <i class="fa fa-angle-left"></i>
                    </div>
                	<div class="proximo btn" data-target="#carousel-example-generic" data-slide-to="3">
                        <i class="fa fa-angle-right"></i>
                    </div>
                </div>
                <div class="item wow fadeInRight" data-wow-duration=".25" data-wow-delay=".5s">
                    <img class="img-responsive" src="imagens/banner_bg/Cachaca-Alambique-de-Minas-Premiada.jpg" alt="Pr&ecirc;mios Cacha&ccedil;a Alambique de Minas 2017">
                    <div class="anterior btn" data-target="#carousel-example-generic" data-slide-to="2">
                        <i class="fa fa-angle-left"></i>
                    </div>
                	<div class="proximo btn" data-target="#carousel-example-generic" data-slide-to="0">
                        <i class="fa fa-angle-right"></i>
                    </div>
                </div>
            </div>      
            <!-- Fim Wrapper for slides --> 
		</div>
    
        <!--========== FIM SLIDER ==========--> 
            
        <?php include ("session/marcas.php") ?>
        
            <hr id="locais"/>
        
        <!-- DEPOIMENTOS / MAPA / MIDIA -->
        
        <div class="container" id="depoimentos">
            <div class="row">
        
        		<!-- DEPOIMENTOS -->
                
                <div class="content-depoimentos zoomIn" data-wow-duration=".5" data-wow-delay=".3s">
                    <div class="swiper-slider swiper-testimonials">
                        <h2>Depoimentos</h2>
                        <!-- Swiper Wrapper -->
                        <div class="swiper-wrapper">
                            <?php do { ?>
                                <div class="swiper-slide">
                                  <blockquote class="blockquote">
                                    <div class="margin-b-40">
                                      <?php echo $row_RsListaDepo['depoimento']; ?>
                                    </div>
                                    <p><span class="fweight-700 color-link"><?php echo $row_RsListaDepo['nome_depo']; ?></span>, <?php echo $row_RsListaDepo['depo_categ']; ?></p>
                                  </blockquote>
                                </div>
                            <?php } while ($row_RsListaDepo = mysql_fetch_assoc($RsListaDepo)); ?>
                        </div>
                        <!-- End Swiper Wrapper -->
                    </div>
                    <a href="#envia_depo" class="btn-theme btn-theme-sm btn-base-bg text-uppercase" id="cadastro" onclick="MM_showHideLayers('envia_depo','','show')"> Depor</a>
                    <!-- Pagination -->
                    <div class="swiper-testimonials-pagination"></div>
                </div>         
                
                <!-- MAPA ONDE COMPRAR -->
                
                <div class="onde-comprar wow zoomIn" data-wow-duration=".3" data-wow-delay=".2s">
                    <h2>Onde comprar</h2>
                    <div class="margin-b-40 mapa">
                        <iframe src="https://www.google.com/maps/d/embed?mid=1lbIOwpZIVNfpGFYkxD4e8G8g3jQ"></iframe>
                    </div>
                </div>    
                
                <!-- FIM MAPA ONDE COMPRAR -->            
                
                <!-- CANAL YOUTUBE -->
                
                <div class="canal">
                    <h2>Canal Engenho da Cana</h2>
                    <div class="margin-b-40 video wow zoomIn" data-wow-duration=".1" data-wow-delay=".3s">
                        <iframe src="https://www.youtube.com/embed/Gfl8hug4aOM" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>           
                
                <!-- FIM CANAL YOUTUBE -->
            </div>
        </div>
        
        <!-- DEPOIMENTOS / MAPA / MIDIA -->   
        
            <hr id="locais"/>   
        
        <!-- PREMIOS -->
        
        <div class="premios bg-color-black" id="premios" data-auto-height="true">
            <div class="content-lg container">
                <h2 class="wow fadeInDown" data-wow-duration=".3" data-wow-delay=".3s">Cacha&ccedil;as Premiadas </h2>
                <div class="row-space-1 margin-b-2 mCustomScrollbar">
                    <div class="col-sm-4 sm-margin-b-2 mix adm" data-myorder="1">
                        <div class="wow fadeInLeft" data-wow-duration=".30" data-wow-delay=".30s">
                            <div class="service" data-height="height" style="background-image:url(imagens/premios/Premio-Expocachaca-2017-Cachaca-Alambique-de-Minas-Ouro-Amburana.png); background-position:right; background-repeat:no-repeat;" >
                                 <div class="service-element">
                                    <i class="service-icon  icon-badge"></i>
                                </div>
                                <div class="service-info">
                                    <h3>Expocacha&ccedil;a 2017</h3>
                                    <p class="margin-b-5">Medalha de prata no concurso nacional do Expocacha&ccedil;a.</p>
                                </div>
                                <a href="<?php echo ("session/saiba_mais.php?alambique=adm_ouro&cachaca=1") ?>" class="content-wrapper-link"></a>    
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 sm-margin-b-2 mix adm" data-myorder="2">
                        <div class="wow fadeInLeft" data-wow-duration=".30" data-wow-delay=".20s">
                            <div class="service" data-height="height" style="background-image:url(imagens/premios/Premio-Bruxelas-2017-Cachaca-Alambique-de-Minas-Ouro-Balsamo.png); background-position:right; background-repeat:no-repeat;">
                                <div class="service-element">
                                    <i class="service-icon  icon-badge"></i>
                                </div>
                                <div class="service-info">
                                    <h3>Bruxelas 2017</h3>
                                    <p class="margin-b-5">Medalha de prata no concurso mundial de Bruxelas.</p>
                                </div>
                                <a href="<?php echo ("session/saiba_mais.php?alambique=adm_ouro&cachaca=2") ?>" class="content-wrapper-link"></a>    
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 sm-margin-b-2 mix adm" data-myorder="3">
                        <div class="wow fadeInLeft" data-wow-duration=".30" data-wow-delay=".10s">
                            <div class="service" data-height="height" style="background-image:url(imagens/premios/Premio-Bruxelas-2016-Cachaca-Alambique-de-Minas-Ouro-Amburana.png); background-position:right; background-repeat:no-repeat;">
                                <div class="service-element">
                                    <i class="service-icon  icon-badge"></i>
                                </div>
                                <div class="service-info">
                                    <h3>Bruxelas 2016</h3>
                                    <p class="margin-b-5">Medalha de ouro no concurso mundial de Bruxelas.</p>
                                </div>
                                <a href="<?php echo ("session/saiba_mais.php?alambique=adm_ouro&cachaca=1") ?>" class="content-wrapper-link"></a>    
                            </div>
                        </div>
                    </div>   
                    <div class="col-sm-4 sm-margin-b-2 mix nr" data-myorder="1">
                        <div class="wow fadeInLeft" data-wow-duration=".30" data-wow-delay=".1s">
                            <div class="service" data-height="height" style="background-image:url(imagens/premios/Premio-Bruxelas-2017-Cachaca-Nossa-Rainha-Ouro-Amburana.png); background-position:right; background-repeat:no-repeat;">
                                
                                <div class="service-element">
                                    <i class="service-icon icon-badge"></i>
                                </div>
                                <div class="service-info">
                                    <h3>Bruxelas 2017</h3>
                                    <p class="margin-b-5">Medalha de ouro no concurso mundial de Bruxelas.</p>
                                </div>
                                <a href="<?php echo ("session/saiba_mais.php?rainha=nr_ouro&cachaca=2") ?>" class="content-wrapper-link"></a>    
                            </div>
                        </div>
                    </div>             
                    <div class="col-sm-4 sm-margin-b-2 mix nr" data-myorder="2">
                        <div class="wow fadeInLeft" data-wow-duration=".30" data-wow-delay=".4s">
                            <div class="service" data-height="height" style="background-image:url(imagens/premios/Premio-Expocachaca-2017-Cachaca-Nossa-Rainha-Ouro-Balsamo.png); background-position:right; background-repeat:no-repeat;">
                                <div class="service-element">
                                    <i class="service-icon  icon-badge"></i>
                                </div>
                                <div class="service-info">
                                    <h3>Expocacha&ccedil;a 2016</h3>
                                    <p class="margin-b-5">Medalha de prata no concurso nacional do Expocacha&ccedil;a.</p>
                                </div>
                                <a href="<?php echo ("session/saiba_mais.php?rainha=nr_ouro&cachaca=2") ?>" class="content-wrapper-link"></a>    
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 sm-margin-b-2 mix edc" data-myorder="1">
                        <div class="wow fadeInLeft" data-wow-duration=".3" data-wow-delay=".6s">
                            <div class="service" data-height="height" style="background-image:url(imagens/premios/Premio-Expocachaca-2017-Cachaca-Engenho-da-Cana-Prata-Inox.png); background-position:right; background-repeat:no-repeat;">
                                <div class="service-element">
                                    <i class="service-icon icon-badge"></i>
                                </div>
                                <div class="service-info">
                                    <h3>Expocacha&ccedil;a 2017</h3>
                                    <p class="margin-b-5">Medalha de prata no concurso nacional do Expocacha&ccedil;a.</p>
                                </div>
                                <a href="<?php echo ("session/saiba_mais.php?engenho=edc_prata&cachaca=3") ?>" class="content-wrapper-link"></a>    
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 sm-margin-b-2 mix edc" data-myorder="2">
                        <div class="wow fadeInLeft" data-wow-duration=".3" data-wow-delay=".6s">
                            <div class="service" data-height="height" style="background-image:url(imagens/premios/Premio-Expocachaca-2016-Cachaca-Engenho-da-Cana-Prata-Inox.png); background-position:right; background-repeat:no-repeat;">
                                <div class="service-element">
                                    <i class="service-icon icon-badge"></i>
                                </div>
                                <div class="service-info">
                                    <h3>Expocacha&ccedil;a 2016</h3>
                                    <p class="margin-b-5">Medalha de bronze no concurso nacional do Expocacha&ccedil;a.</p>
                                </div>
                                <a href="<?php echo ("session/saiba_mais.php?engenho=edc_prata&cachaca=3") ?>" class="content-wrapper-link"></a>    
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 sm-margin-b-2 mix edc" data-myorder="4">
                        <div class="wow fadeInLeft" data-wow-duration=".3" data-wow-delay=".6s">
                            <div class="service" data-height="height" style="background-image:url(imagens/premios/Premio-Bruxelas-2015-Cachaca-Engenho-da-Cana-Prata-Inox.png); background-position:right; background-repeat:no-repeat;">
                                <div class="service-element">
                                    <i class="service-icon icon-badge"></i>
                                </div>
                                <div class="service-info">
                                    <h3>Bruxelas 2015</h3>
                                    <p class="margin-b-5">Medalha de prata no concurso mundial de Bruxelas.</p>
                                </div>
                                <a href="<?php echo ("session/saiba_mais.php?rainha=nr_ouro&cachaca=3") ?>" class="content-wrapper-link"></a>    
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 sm-margin-b-2 mix edc" data-myorder="3">
                        <div class="wow fadeInLeft" data-wow-duration=".3" data-wow-delay=".6s">
                            <div class="service" data-height="height" style="background-image:url(imagens/premios/Premio-Expocachaca-2014-Cachaca-Engenho-da-Cana-Prata-Inox.png); background-position:right; background-repeat:no-repeat;">
                                <div class="service-element">
                                    <i class="service-icon icon-badge"></i>
                                </div>
                                <div class="service-info">
                                    <h3>Expocacha&ccedil;a 2014</h3>
                                    <p class="margin-b-5">Medalha de bronze no concurso nacional do Expocacha&ccedil;a.</p>
                                </div>
                                <a href="<?php echo ("session/saiba_mais.php?engenho=edc_prata&cachaca=3") ?>" class="content-wrapper-link"></a>    
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 sm-margin-b-2 mix bdv" data-myorder="1">
                        <div class="wow fadeInLeft" data-wow-duration=".30" data-wow-delay=".5s">
                            <div class="service" data-height="height" style="background-image:url(imagens/premios/Premio-Bruxelas-2017-Bola-da-Vez-Prata-Amendoim.png); background-position:right; background-repeat:no-repeat;">
                                <div class="service-element">
                                    <i class="service-icon  icon-badge"></i>
                                </div>
                                <div class="service-info">
                                    <h3>Bruxelas 2017</h3>
                                    <p class="margin-b-5">Medalha de ouro no concurso mundial de Bruxelas.</p>
                                </div>
                                <a href="<?php echo ("session/saiba_mais.php?bolavez=bdv_prata&cachaca=3") ?>" class="content-wrapper-link"></a>    
                            </div>
                        </div>
                    </div>
                </div>
                <!--// end row-->
            </div>
        </div>
        
        <!-- FIM PREMIACOES -->
        
            <hr id="locais"/>
            
		<!-- DESTAQUES -->
        
		<div class="container destaques" id="destaques">
        <!-- row -->
        <div class="row">
            <div class="row margin-b-40 wow fadeInDown" data-wow-duration=".5" data-wow-delay=".3s">
                <h2>Cacha&ccedil;as em Destaque </h2>
            </div>
            <!-- Latest Products -->
              <div class="container wow zoomIn" data-wow-duration=".3" data-wow-delay=".1s">
                 <div class="crsl-items" data-navigation="navbtns">
                     <div class="crsl-wrap">
                        <div class="crsl-item">
                            <div class="thumbnail">
                                <img src="imagens/destaques/cachacas-alambique-de-minas.jpg" alt="Latest Products Image">
                            </div>
                            <h4><a href="#">Alambique de Minas</a> <span class="text-uppercase margin-l-20">Ouro</span></h4>
                            <p>Trata&#45;se de um Blend de Amburana com um leve toque de Carvalho,  envelhecida por pelo menos tr&ecirc;s anos, possui  colora&ccedil;&atilde;o amarelada e  paladar  inconfund&iacute;vel. Ideal para presentear&hellip;</p>
                            <a class="link" href="<?php echo ("cachaca.php#adm") ?>">Saiba Mais</a>
                        </div>
                            <!-- End Latest Products -->            
                            <!-- Latest Products -->
                        <div class="crsl-item">
                            <div class="thumbnail">
                                <img src="imagens/destaques/cachacas-nossa-rainha.jpg" alt="Latest Products Image">
                            </div>
                            <h4><a href="<?php echo ("cachaca.php#nr") ?>">Nossa Rainha</a> <span class="text-uppercase margin-l-20">Ouro</span></h4>
                            <p>De cor amarelada, envelhecida por pelo menos tr&ecirc;s anos, seu paladar &eacute; inconfund&iacute;vel, com um aroma marcante, com sabor adocicado e frutado, associando &agrave; baunilha e ameixa, permite o melhor buqu&ecirc; &agrave; cacha&ccedil;a&hellip;</p>
                            <a class="link" href="<?php echo ("cachaca.php#nr") ?>">Saiba Mais</a>
                        </div>
                            <!-- End Latest Products -->            
                            <!-- Latest Products -->
                        <div class="crsl-item">
                            <div class="thumbnail">
                                <img src="imagens/destaques/cachacas-bola-da-vez.jpg" alt="Latest Products Image">
                            </div>
                            <h4><a href="<?php echo ("cachaca.php#bdv") ?>">Bola da Vez</a> <span class="text-uppercase margin-l-20">Ouro</span></h4>
                            <p>Leva em seu r&oacute;tulo as bandeiras de Minas e do Brasil. &Eacute; um blend de madeiras brasileiras, com enfoque ao sabor da Amburana, o que permite o melhor buqu&ecirc; &agrave; cachaça, seu paladar inconfund&iacute;vel&hellip;</p>
                            <a class="link" href="<?php echo ("cachaca.php#bdv") ?>">Saiba Mais</a>
						</div>
                            <!-- End Latest Products -->            
                            <!-- Latest Products -->
                        <div class="crsl-item">
                            <div class="thumbnail">
                                <img src="imagens/destaques/cachacas-engenho-da-cana.jpg" alt="Latest Products Image">
                            </div>
                            <h4><a href="<?php echo ("cachaca.php#edc") ?>">Bola da Vez</a> <span class="text-uppercase margin-l-20">Ouro</span></h4>
                            <p>Possui uma cor dourada, esverdeada, brilhante. &Eacute; uma cacha&ccedil;a arom&aacute;tica em sua ess&ecirc;ncia, com notas de anis e am&ecirc;ndoa, sabor adocicado lembrando a baunilha e coco, com aroma bastante intenso. Descansa por at&eacute; dois anos em madeira nobre de B&aacute;lsamo&hellip;</p>
                            <a class="link" href="<?php echo ("cachaca.php#edc") ?>">Saiba Mais</a>
						</div>
                      <!-- End Latest Products -->
                    </div>
                 </div>
              </div> 
              <!--// end row -->
         </div>                   
        <nav class="slidernav">
          <div id="navbtns" class="clearfix">
            <a href="#" class="previous"><i class="fa fa-arrow-circle-left"></i></a>
            <a href="#" class="next"><i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </nav>
     </div>
            
	<!-- FIM DESTAQUES -->
    
                
     <!-- SESSÃO DE EVENTOS -->
     
    <div class="promo-section eventos" id="eventos">
        <div class="container">
            <div class="promo-section-col sm-margin-b-30 wow fadeInLeft" data-wow-duration=".3" data-wow-delay=".3s" id="agenda_list">
                <h3 class="color-white">Nossos Eventos</h3>
                <div class="mCustomScrollbar lista">
                    <?php do { ?>
                    <div class="alterna">
                        <b><?php echo $row_RsListaEventos['nome_evento']; ?> dia
                        <?php echo $row_RsListaEventos['data_evento']; ?> &agrave;s 
                        <?php echo $row_RsListaEventos['hora_evento']; ?></b>
                        <p><?php echo $row_RsListaEventos['descri_evento']; ?></p>
                        <?php echo $row_RsListaEventos['local_evento']; ?><br />
                        <?php echo $row_RsListaEventos['end_evento']; ?>
                    </div>
                    <?php } while ($row_RsListaEventos = mysql_fetch_assoc($RsListaEventos)); ?>
                    <table border="0">
                      <tr>
                        <td><?php if ($pageNum_RsListaEventos > 0) { // Show if not first page ?>
                            <a href="<?php printf("%s?pageNum_RsListaEventos=%d%s", $currentPage, 0, $queryString_RsListaEventos); ?>"> &nbsp; Atuais &nbsp; </a> &#124;
                            <?php } // Show if not first page ?></td>
                        <td><?php if ($pageNum_RsListaEventos > 0) { // Show if not first page ?>
                            <a href="<?php printf("%s?pageNum_RsListaEventos=%d%s", $currentPage, max(0, $pageNum_RsListaEventos - 1), $queryString_RsListaEventos); ?>"> &nbsp; Recentes &nbsp; </a> &#124;
                            <?php } // Show if not first page ?></td>
                        <td><?php if ($pageNum_RsListaEventos < $totalPages_RsListaEventos) { // Show if not last page ?>
                            <a href="<?php printf("%s?pageNum_RsListaEventos=%d%s", $currentPage, min($totalPages_RsListaEventos, $pageNum_RsListaEventos + 1), $queryString_RsListaEventos); ?>"> &nbsp; Passados &nbsp; </a> &#124;
                            <?php } // Show if not last page ?></td>
                        <td><?php if ($pageNum_RsListaEventos < $totalPages_RsListaEventos) { // Show if not last page ?>
                            <a href="<?php printf("%s?pageNum_RsListaEventos=%d%s", $currentPage, $totalPages_RsListaEventos, $queryString_RsListaEventos); ?>"> &nbsp; Antigos &nbsp; </a> &#124;
                            <?php } // Show if not last page ?></td>
                      </tr>
                    </table>
                  </div>
                 <a href="#envia_evento" class="btn-theme btn-theme-sm btn-base-bg text-uppercase" id="cadastro" onclick="MM_showHideLayers('envia_evento','','show')"> Agendar</a>
                </div>
                
                <!-- FIM SESSÃO DE EVENTOS -->
                
                <!--CONTATO EVENTOS -->
                
                <div class="promo-section-img-right">
                     <div class="sm-margin-b-30 wow zoomIn" data-wow-duration=".3" data-wow-delay=".3s" id="contato">
                        <h3 class="color-white">Contato</h3>
                        <ul class="list-unstyled footer-list wow fadeInRight" data-wow-duration=".3" data-wow-delay=".3s">
                            <li><i class="fa fa-phone" style="margin-right:2px;"></i> &#43;55 &#40;31&#41; 3654&#45;2172
                            </li>
    
                            <li>&nbsp;<i class="fa fa-whatsapp" style="margin-right:2px;"> </i> &nbsp;&#43;55 &#40;31&#41; 99428&#45;5225 <small>&#40;Vivo&#41;</small>
                            </li>
                            <li><i class="fa fa-envelope-o" style="margin-right:3px;"> </i> daniel@engenhodacana.com.br
                            </li>
                            <li><i class="fa fa-facebook" style="margin-right:7px;"> </i> cachacaengenhodacana
                            </li>
                            <li><i class="fa fa-instagram" style="margin-right:7px;"> </i> cachaca_engenho_da_cana
                            </li>
                            <li id="endereco"><i class="fa fa-map-marker" style="margin-left:4px; margin-right:8px; margin-bottom:-50px; clear:both;"> </i> Av. Olinto Meireles, 2595 &#45; Milion&aacute;rios
                            </li>
                            <li id="endereco">Belo horizonte &frasl; Minas Gerais &#45; Brasil
                            </li>
                            <li id="endereco"> CEP&#58; 30.620&#45;330
                            </li>
                        </ul>
					</div>
            	</div>
                
                <!-- FIM CONTATO EVENTO -->
                
                <!-- ASSINATURA FEEDS -->
                
                <div class="assinatura wow fadeInUp margin-b-40" data-wow-duration=".3" data-wow-delay=".3s">
                      <h2 class="color-white"> Assine nossa Cacha&ccedil;a News <i class="fa fa-feed"> </i> </h2>
                    <form action="<?php echo $editFormAction; ?>" name="feed-news" method="POST" id="feed-news">                       
                        <input name="feeds_email" type="email" class="form-control footer-input margin-b-20 feeds_email" id="feeds_email" placeholder="Email" data-rule-email="true" required>
                        <button type="submit" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Assinar</button>
                        <input type="hidden" name="feeds_data" value="<?php date_default_timezone_set('America/Sao_Paulo'); echo date('Y-m-d H:i:s', time()) ?>" />
                        <input type="hidden" name="MM_insert" value="feed-news" />
                    </form>
                    <?php if ($_GET["assinatura"] == "sucesso") { ?>
                        <div class="sucesso">
                            <p>
                                Seu e&#45;mail foi cadastrado com sucesso!<br />
                                Agradecemos sua assinatura!
                            </p>
                            <meta http-equiv="Refresh" content="5;URL=index.php#eventos">
                        </div>
                    <?php }elseif ($_GET["assinatura"] == "erro") {?>
                        <div class="sucesso">
                            <p>
                                Este e&#45;mail j&aacute; est&aacute; cadastrado!
                            </p>
                           
                        </div>
                    <?php } ?>
               </div>
               
               <!-- FIM SSINATURA FEEDS -->
               
    	</div>
    </div>
     
     <!-- FIM EVENTOS -->
        
            <hr id="locais"/>
            <?php include("session/rodape.php") ?>
            
            <!-- FIM RODAPE -->   
 	</div>    
    
    <!-- FINAL DIV GERAL --> 
      
    <!-- FORMULARIO ENVIA DEPOIMENTO -->
    
    <div class="envia_depo" id="envia_depo">
        <div class="logo-form margin-b-40">
            <img src="imagens/logo-cachacas-engenho-da-cana.png" />
        </div>
        <form name="depoimento" id="depoimento" class="depoimento mCustomScrollbar" action="envia.php" method="post">                
            <h2> Envie seu coment&aacute;rio e nos ajusde a extrair o melhor da cacha&ccedil;a</h2>                    
            <label for="nome" class="nome">Seu Nome
            <input type="text" required name="nomeremetente" class="form-control footer-input margin-b-10" /></label>                    
            <label for="email" class="email">E&#45;mail de contato
            <input class="form-control footer-input margin-b-10" name="emailremetente" type="email" required /></label>                    
            <label for="categoria_depo"> Categoria</label>
            <select name="categoria_depo" class="tooltip-inner">
                  <option class="form-control footer-input margin-b-10" value="Consumidor">Consumidor</option>
                  <option class="form-control footer-input margin-b-10" value="Distribuidor">Distribuidor</option>
                  <option class="form-control footer-input margin-b-10" value="Representante">Representante</option>
                  <option class="form-control footer-input margin-b-10" value="Especialista">Especialista</option>
            </select><br />
            <hr />
            <label for="mensagem">Depoimento</label>
            <textarea type="text" name="mensagem"  required="required" class="form-control footer-input margin-b-10"></textarea>
            <button type="submit" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Enviar</button>
             <a href="#depoimentos" class="btn-theme btn-theme-sm btn-base-bg text-uppercase" id="cancelar_depo" onclick="MM_showHideLayers('envia_depo','','hide')">Cancelar</a>
            <input type="hidden" id="assunto"  name="assunto" value="DEPOIMENTO SITE" />
        </form>
    </div>
    
    <!-- FIM FORMULARIO ENVIA DEPOIMENTO --> 
    
    <!-- FORMULARIO ENVIA EVENTO -->  
    <div class="envia_evento" id="envia_evento">
      <div class="logo-form margin-b-40">
              <p><img src="imagens/logo-cachacas-engenho-da-cana.png" /></p>
        </div>
          <form action="envia.php" method="post" enctype="multipart/form-data" class="depoimento mCustomScrollbar" id="depoimento">
            
                <h2>Todas as datas est&atilde;o sujeitas &agrave; confima&ccedil;&atilde;o de disponibilidade.</h2>
                
                <label for="nomeremetente" class="nome">Nome do Evento
                  <input class="form-control footer-input margin-b-10" name="nomeremetente" placeholder="Seu Nome &frasl; Evento" type="text" required />
                  </label>
                
                <label for="emailremetente" class="email">E&#45;mail de contato
                  <input class="form-control footer-input margin-b-10" name="emailremetente" placeholder="E&#45;mail de Contato" type="email" required />
                  </label>
                
                <label for="data_evento" class="data">Data do Evento
                  <input class="form-control footer-input margin-b-10" id="data" name="data_evento" placeholder="Data do Evento" type="date" />
                  </label>
                
                <label for="hora_evento" class="hora">Hor&aacute;rio do Evento
                  <input class="form-control footer-input margin-b-10" id="hora" name="hora_evento" placeholder="Hor&aacute;rio do Evento" type="time" />
                  </label>
                
                <label for="local_evento">Local do Evento</label>
                <input class="form-control footer-input margin-b-10" name="local_evento" type="text" placeholder="Local do Evento" required />
                
                <label for="end_evento">Endere&ccedil;o do Evento</label>
                <input class="form-control footer-input margin-b-10" name="end_evento" placeholder="Rua, N&ordm;, Compl., Bairro, Cidade, Estado" type="text" required />
                
                <label for="mensagem">Descri&ccedil;&atilde;o do Evento</label>
                <textarea name="mensagem" required class="form-control footer-input margin-b-10" placeholder="Descreva o Evento"></textarea>
                
                <button type="submit" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Enviar</button>
                
                <a href="#eventos" class="btn-theme btn-theme-sm btn-base-bg text-uppercase" id="cancelar_evento" onclick="MM_showHideLayers('envia_evento','','hide')">Cancelar</a>
                
                <input type="hidden" name="assunto" value="AGENDAMENTO DE EVENTO SITE" />
         </form>
    </div>  
    
    <!-- FIM FORMULARIO ENVIA EVENTO -->
    
    <?php } ?>
    
    <a href="javascript:void(0);" class="js-back-to-top back-to-top">Topo</a>
    
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script> 
    <script src="<?php echo ("js/jquery.min.js") ?>" type="text/javascript"></script>
    
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="<?php echo ("js/jquery-1.11.0.min.js") ?>" type="text/javascript"></script>
        
	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.6/jquery.mousewheel.min.js"></script>
    	
    <script src="<?php echo ("js/jquery-migrate.min.js") ?>" type="text/javascript"></script>   
    <script src="<?php echo ("js/bootstrap.min.js") ?>" type="text/javascript"></script>
    
    <script src="<?php echo ("js/jquery.wow.min.js") ?>" type="text/javascript"></script>
    
    <script src="<?php echo ("js/jquery.easing.js") ?>" type="text/javascript"></script>   
    <script src="<?php echo ("js/jquery.smooth-scroll.js") ?>"  type="text/javascript"></script>
    <script src="<?php echo ("js/jquery.parallax.min.js") ?>" type="text/javascript"></script> 
    <script src="<?php echo ("js/jquery.back-to-top.js") ?>" type="text/javascript"></script> 
    <script src="<?php echo ("js/wow.min.js") ?>" type="text/javascript"></script>
    
    <script src="<?php echo ("js/main.js") ?>" type="text/javascript"></script> 
    <script src="<?php echo ("js/menu_script.js") ?>" type="text/javascript"></script> 
    <script src="<?php echo ("js/swiper.jquery.min.js") ?>" type="text/javascript"></script>
    <script src="<?php echo ("js/swiper.min.js") ?>" type="text/javascript"></script>
    <script src="<?php echo ("js/responsiveCarousel.min.js") ?>" type="text/javascript"></script>
    <script src="<?php echo ("js/jquery.mCustomScrollbar.js") ?>" type="text/javascript"></script>
    <script src="<?php echo ("js/jquery.validate.min") ?>" type="text/javascript"></script>
    <script type="text/javascript">
	
        (function($){
            $(window).load(function(){
                
                $("body").mCustomScrollbar({
                    theme:"minimal"
                });
                
            });
        })(jQuery);
		
		$(function(){
		  $('.crsl-items').carousel({
			visible: 3,
			itemMinWidth: 300,
			itemEqualHeight: 300,
			itemMargin: 9,
		  });
		 
		  $("a[href=#]").on('click', function(e) {
			e.preventDefault();
		  });
		});
		
		(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.9&appId=1791762227800699";
		  fjs.parentNode.insertBefore(js, fjs);
		}
		(document, 'script', 'facebook-jssdk'));	
		
		function showResult(str) {
		  if (str.length==0) { 
			document.getElementById("livesearch").innerHTML="";
			document.getElementById("livesearch").style.border="0px";
			return;
		  }
		  if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		  } else {  // code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  xmlhttp.onreadystatechange=function() {
			if (this.readyState==4 && this.status==200) {
			  document.getElementById("livesearch").innerHTML=this.responseText;
			  document.getElementById("livesearch").style.border="1px solid #A5ACB2";
			}
		  }
		  xmlhttp.open("GET","livesearch.php?q="+str,true);
		  xmlhttp.send();
		}
		function MM_swapImgRestore() { //v3.0
		  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
		}
		function MM_preloadImages() { //v3.0
		  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
			var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
			if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
		}		
		function MM_findObj(n, d) { //v4.01
		  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
			d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
		  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
		  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
		  if(!x && d.getElementById) x=d.getElementById(n); return x;
		}
		
		function MM_swapImage() { //v3.0
		  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
		   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
		}
		
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
		
		$('#feed-news').validate();
		$('#admin_login').validate();
    </script>
</body>
</html>
<?php
mysql_free_result($RsListaEventos);

mysql_free_result($RsListaDepo);
?>