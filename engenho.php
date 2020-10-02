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

mysql_select_db($database_db_engenho, $db_engenho);
$query_RsListaDepo = "SELECT id_depo, nome_depo, depo_categ, depoimento FROM depo_cliente ORDER BY id_depo DESC";
$RsListaDepo = mysql_query($query_RsListaDepo, $db_engenho) or die(mysql_error());
$row_RsListaDepo = mysql_fetch_assoc($RsListaDepo);
$totalRows_RsListaDepo = mysql_num_rows($RsListaDepo);
?>
<!DOCTYPE html>

<!-- ==============================
    Project:        Cachaças Engenho da Cana Frontend André Aguiar - Responsive HTML Template Based On Twitter Bootstrap 3.3.4
    Version:        1.0
    Author:         TOP Artes
    Primary use:    Comercial.
    Email:          suporte@top artes.com
    Like:           http://www.facebook.com/topartescg
    Website:        http://www.topartes.com
================================== -->

<html>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Cacha&ccedil;a de Alambique Artesanal, Aguardente, Pinga, Bebida Destilada &#124; Sobre as Cacha&ccedil;as Engenho da Cana</title>
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
        <link rel="stylesheet" type="text/css" href="<?php echo("css/swiper.min.css") ?>"> 
		<link rel="stylesheet" type="text/css" href="<?php echo("css/menu_style.css") ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo("css/engenho.css") ?>">     
        <link rel="stylesheet" type="text/css" href="<?php echo("css/animate.css") ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo("css/style.css") ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo("css/layout.min.css") ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo("css/jquery.mCustomScrollbar.css") ?>">
        <noscript><link rel="stylesheet" type="text/css" href="<?php echo("css/noJS.css") ?>"/></noscript>
        
        <style type="text/css">

			
			html{
				height: auto;
				max-height:100%;
			}		
			body{
				height:100%;
				overflow: auto;
			}			
			.loadmore {
				width:100%;
				position:relative;
				padding: 10px;
				background: #900;
				color: #fff;
				text-transform: uppercase;
				letter-spacing: 3px;
				font-weight: 700;
				text-align: center;
				cursor: pointer;
				z-index:9999;
			}			
			.loadmore:hover {
				background:#F00;
				color: #fff;
			}

			#endereco{
				visibility:hidden;
			}
		</style>          
        
</head>

<body class="mCustomScrollbar" onload="MM_preloadImages('imagens/banner_bg/alambique-artesanal_1.jpg')">
<div id="fb-root"></div>
       
  <!--.preloader-->
  <div class="preloader"><div class="logo-preload"><img src="imagens/logo-cachacas-engenho-da-cana.png" /></div> <i class="fa fa-spinner fa-spin"></i></div>
  <!--/.preloader-->    
    
    <div id="pag_engenho">
    	
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
                  <li><a href="index.php"><i class="fa fa-home"> </i> Principal</a></li>
                  <li class='has-sub'><a href='cachaca.php'>Cacha&ccedil;as Engenho da Cana</a>
                      <ul>
                         <li><a href='cachaca.php#adm'>Cacha&ccedil;a Alambique de Minas</a></li>
                         <li><a href='cachaca.php#bdv'>Cacha&ccedil;a Bola da Vez</a></li>
                         <li><a href='cachaca.php#nr'>Cacha&ccedil;a Nossa Rainha</a></li>
                         <li><a href='cachaca.php#edc'>Cacha&ccedil;a Engenho da Cana</a></li>
                      </ul>
                  </li>
                   <li class='has-sub active'><a href='engenho.php'>Engenho da Cana</a>
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
        
             <form class="busca">
				<input type="text" class="footer-input form-control" onKeyUp="showResult(this.value)" placeholder="Buscar"><i class="fa fa-search" style="position:absolute; float:right; right:15px; top:15px;"></i>
				<div id="livesearch"></div>
			</form>
           

        <!--========== PARALLAX ==========-->
        <div class="parallax-window" id="nossa-historia" data-parallax="scroll" data-image-src="imagens/banner_bg/alambique-artesanal_1.jpg">
            <div class="parallax-content container" id="bg_topo">
                <h1 style="text-align:left;">Sobre N&oacute;s</h1>
                <p>Cinco marcas e um incrível mix de sabores<br>
                    idealizados para estarem presentes em todos os momentos.</p>
            </div>
        </div>
        
        <!--========== PARALLAX ==========-->
        
        <!-- SOBRE ENGENHO DA CANA -->
          
        <div class="section-seperator">
            <div class="content-lg container">
                <div class="row">
                    <div class="col-sm-12 sm-margin-b-50">
                        <h3>Hist&oacute;ria</h3>
                        <p>As Cacha&ccedil;as Engenho da Cana s&atilde;o produzidas em &Aacute;gua Limpa, distrito de Ouro Branco&frasl;MG. S&atilde;o cinco marcas e um incrível mix de sabores idealizados para estarem presentes em todos os momentos, com linhas: Tradicional ( Engenho da Cana ), Esportiva ( Bola da Vez ), Presente ( Alambique de Minas ),  Deluxe ( Nossa Rainha ) e Premium ( De La Vega ).</p>
                        <p>Em nosso DNA est&atilde;o as caracter&iacute;sticas de uma leg&iacute;tima Cacha&ccedil;a Artesanal Mineira, onde o esmero na produ&ccedil;&atilde;o vai desde o plantio at&eacute; o engarrafamento. Trabalhamos apenas com o cora&ccedil;&atilde;o, que &eacute; a parte nobre da destila&ccedil;&atilde;o. Todos os resíduos s&atilde;o utilizados como fonte de energia ou adubo, de forma que a fabrica&ccedil;&atilde;o seja sustent&aacute;vel e ecologicamente correta. As premia&ccedil;&otilde;es na Expocacha&ccedil;a 2014, 2016 e 2017 e em Bruxelas 2015, 2016 e 2017 vieram para coroar ainda mais a excel&ecirc;ncia em nossa qualidade.
                        </p>
                    <hr id="locais" />
                    </div>
                    <div class="col-sm-4 sm-margin-b-50">
                        <div class="wow fadeInLeft" data-wow-duration=".3" data-wow-delay=".3s">
                            <h3>Miss&atilde;o</h3>
                            <p>Atuar de forma segura e rent&aacute;vel, com responsabilidade social e ambiental, nos mercados nacionais e internacionais fornecendo produtos de alta qualidade e pre&ccedil;os competitivos.</p>
                        </div>
                    </div>
                    <div class="col-sm-4 sm-margin-b-50">
                        <div class="wow fadeInLeft" data-wow-duration=".3" data-wow-delay=".2s">
                            <h3>Vis&atilde;o</h3>
                            <p>Estar entre as cinco maiores empresas de bebidas destiladas do pa&iacute;s. Mantendo a lideran&ccedil;a tecnol&oacute;gica, enss&ecirc;ncia e qualidade, sendo a preferida pelo nosso p&uacute;blico de interesse.</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="wow fadeInLeft" data-wow-duration=".3" data-wow-delay=".1s">
                            <h3>Valores</h3>
                            <p>Qualidade e melhoria cont&iacute;nua dos produtos e servi&ccedil;os para satisfa&ccedil;&atilde;o dos consumidores, comportamento &eacute;tico, aperfei&ccedil;oamento das rela&ccedil;&otilde;es com os clientes, fornecedores, fornecedores e consumidores, harmonia com equi&iacute;brio e a din&acirc;mica da natureza, percebendo o homem como parte da natureza.</p>
                        </div>
                    </div>
                </div>
                <!--// end row -->
            </div>
         </div>
        
        <!-- FIM SOBRE ENGENHO DA CANA --> 
        
        <!-- MARCAS -->
          
        <div class="bg-color-sky-light parallax-window" data-parallax="scroll">
            <div class="content-lg container marcas">
                <!-- Swiper Marcas -->
                <div class="swiper-slider swiper-clients parallax-content">
                    <!-- Swiper Wrapper -->
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <a><img class="swiper-clients-img" src="imagens/marcas/Logo-Cachaca-Engenho-da-Cana-Ouro.png" alt="Clients Logo"></a>
                        </div>
                        <div class="swiper-slide">
                            <a><img class="swiper-clients-img" src="imagens/marcas/Logo-Cachaca-Alambique-de-Minas-Ouro.png" alt="Logo Cacha&ccedil;a Alambique de Minas Ouro"></a>
                        </div>
                        <div class="swiper-slide">
                            <img class="swiper-clients-img" src="imagens/marcas/Logo-Cachaca-Nossa-Rainha-Ouro.png" alt="Logo Cachaca Nossa Rainha Ouro">
                        </div>
                        <div class="swiper-slide">
                            <img class="swiper-clients-img" src="imagens/marcas/Logo-Cachaca-Bola-da-Vez-Ouro.png" alt="Logo Cachaca Bola da Vez Ouro">
                        </div>
                        <div class="swiper-slide">
                            <img class="swiper-clients-img" src="imagens/marcas/Logo-Cachaca-Engenho-da-Cana-Prata.png" alt="Logo Cachaca Engenho da Cana Prata">
                        </div>
                        <div class="swiper-slide">
                            <img class="swiper-clients-img" src="imagens/marcas/Logo-Cachaca-Alambique-de-Minas-Prata.png" alt="Logo Cachaca Alambique de Minas Prata">
                        </div>
                        <div class="swiper-slide">
                            <img class="swiper-clients-img" src="imagens/marcas/Logo-Cachaca-Nossa-Rainha-Prata.png" alt="Logo Cachaca Nossa Rainha Prata">
                        </div>                        
                        <div class="swiper-slide">
                            <img class="swiper-clients-img" src="imagens/marcas/Logo-Cachaca-Bola-da-Vez-Prata.png" alt="Logo Cachaca Bola da Vez Prata">
                        </div>
                    </div>
                    <!-- End Swiper Wrapper -->
                </div>
                <!-- End Swiper Marcas -->
            </div>
        </div>
        
        <!-- FIM MARCAS -->  
         
        <!-- PREMIAÇÕES -->
        
        <section id="menu-list" class="section-padding">
        	<?php include ("session/premios.php") ?>
  		</section>
        
        <!-- FIM PREMIAÇÕES -->
        
        	<hr id="locais"/>
        
        <!--DEPOIMENTOS -->
        
        <div class="container depoimentos" id="depoimentos-fas">
            <div class="row">
				<div class="content-depoimentos" id="depoimentos">
                    <div class="swiper-slider swiper-testimonials-3 wow zoomIn" data-wow-duration=".5" data-wow-delay=".1s">
                    
                        <h2>Depoimentos</h2>
                        <!-- Swiper Wrapper -->
                        <div class="swiper-wrapper">
                            <?php do { ?>
                                <div class="swiper-slide">
                                    <blockquote class="blockquote">
                                        <div class="margin-b-20">
                                            <?php echo $row_RsListaDepo['depoimento']; ?>
                                        </div>
                                        <p><span class="fweight-700 color-link"><?php echo $row_RsListaDepo['nome_depo']; ?></span>, <?php echo $row_RsListaDepo['depo_categ']; ?></p>
                                    </blockquote>
                                </div>
                            <?php } while ($row_RsListaDepo = mysql_fetch_assoc($RsListaDepo)); ?>
                        </div>
                    <!-- End Swiper Wrapper -->
                    <a href="#envia_depo" class="btn-theme btn-theme-sm btn-base-bg text-uppercase" id="" onclick="MM_showHideLayers('envia_depo','','show')"> Depor</a>
                    </div>
                    <!-- Pagination -->
                    <div class="swiper-testimonials-pagination"></div>                   
				</div>
			</div>
		</div>
        
        <!-- FIM DEPOIMENTOS -->
        
        	<hr id="locais"/>
            
        <!-- GALERIA -->
        
        <div id="galeria">
        
            <h2>Galeria de Imagens</h2>
            <div class="gamma-container gamma-loading mCustomScrollbar" id="gamma-container">
  				<ul class="gamma-gallery">
                    <?php 
						if ($_GET['galeria'] == ''){					
							include ("imagens/galeria/galeria.php"); 
						}
						 if ($_GET['galeria'] == '1' || $_GET['galeria'] == '2');
						 { 
        			  		include ("imagens/galeria/galeria_1.php");
							$_i=$_GET['galeria'] + 1;
						} 
						 if ($_GET['galeria'] == '2')
						 { 
        			  		include ("imagens/galeria/galeria_2.php"); 
						}
					?>
                </ul>
                <?php if ($_i <= 2) { ?>
                	<a class="loadmore form-control btn-theme-sm" id="loadmore" onClick="MM_goToURL('parent','engenho.php?galeria=<?php echo $_i ?>#galeria');return document.MM_returnValue">Carregar mais imagens</a>
				<?php } ?>
                <div class="gamma-overlay"></div>
            </div>
       </div>
        
   	  <!-- SESSÃO RODAPE --> 
        
            <hr id="locais"/>
            <?php include("session/rodape.php") ?>
            
            <!-- FIM RODAPE -->   
            
     </div>
     <div class="envia_depo" id="envia_depo">
         <div class="logo-form margin-b-40">
            <img src="imagens/logo-cachacas-engenho-da-cana.png" />
        </div>
        <hr/>
        <form name="depoimento" id="depoimento" class="depoimento mCustomScrollbar" action="envia.php" method="post">
        
            <h2> Envie seu coment&aacute;rio e nos ajusde a extrair o melhor da cacha&ccedil;a</h2>
            
                <label for="nome" class="nome">Seu Nome
                <input type="text" required name="nomeremetente" class="form-control footer-input margin-b-10" /></label>
                
                <label for="email" class="email">E&#45;mail de contato
                <input class="form-control footer-input margin-b-10" name="emailremetente" type="email" required /></label>
                
                <label for="categoria_depo"> Categoria</label>
                <select name="categoria_depo" class="tooltip-inner" data-rule-required='true'>
                  <option class="form-control footer-input margin-b-10" value="Consumidor">Consumidor</option>
                  <option class="form-control footer-input margin-b-10" value="Distribuidor">Distribuidor</option>
                  <option class="form-control footer-input margin-b-10" value="Representante">Representante</option>
                  <option class="form-control footer-input margin-b-10" value="Especialista">Especialista</option>
                </select><br />
    		<hr />
               <label for="mensagem">Depoimento</label>
                <textarea type="text" name="mensagem"  required="required" class="form-control footer-input margin-b-10"></textarea>
                <button type="submit" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Enviar</button>
                  <a href="#depoimentos" class="btn-theme btn-theme-sm btn-base-bg text-uppercase" style="margin-left:2%;" onclick="MM_showHideLayers('envia_depo','','hide')">Cancelar</a>
              <input type="hidden" id="assunto"  name="assunto" value="DEPOIMENTO SITE" />
        </form>
    </div>
    <a href="javascript:void(0);" class="js-back-to-top back-to-top">Topo</a>
    
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script> 
    <script src="<?php echo ("js/jquery.min.js") ?>" type="text/javascript"></script>
    
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="<?php echo ("js/jquery-1.11.0.min.js") ?>" type="text/javascript"></script>
        
	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.6/jquery.mousewheel.min.js"></script>
    
		<script src="<?php echo ("js/bootstrap.min.js") ?>" type="text/javascript"></script>  
        
        <script src="<?php echo("js/main.js")?>" type="text/javascript"></script>  
        <script src="<?php echo("js/jquery.mixitup.min.js")?>" type="text/javascript"></script> 
   		 <script src="<?php echo("js/custom.js")?>" type="text/javascript"></script>         
    	<script src="<?php echo ("js/menu_script.js") ?>" type="text/javascript"></script>      
        <script src="<?php echo ("js/jquery-migrate.min.js") ?>" type="text/javascript"></script> 
    
        <script src="<?php echo ("js/jquery.easing.js") ?>" type="text/javascript"></script>  
    	<script src="<?php echo ("js/jquery.smooth-scroll.js") ?>"  type="text/javascript"></script>
    	<script src="<?php echo ("js/jquery.parallax.min.js") ?>" type="text/javascript"></script>
        
    	<script src="<?php echo ("js/jquery.back-to-top.js") ?>" type="text/javascript"></script>  
        <script src="<?php echo("js/jquery.mCustomScrollbar.js")?>" type="text/javascript"></script>
        
		<script src="<?php echo ("js/swiper.jquery.min.js") ?>"  type="text/javascript"></script>
        <script src="<?php echo ("js/swiper.min.js") ?>"  type="text/javascript"></script> 
    
    	<script src="<?php echo ("js/jquery.wow.min.js") ?>" type="text/javascript"></script>
    
    	<script src="<?php echo ("js/wow.min.js") ?>" type="text/javascript"></script>
    	<script src="<?php echo ("js/jquery.validate.min") ?>" type="text/javascript"></script>
        
	<script type="text/javascript">	
	
        (function($){
            $(window).load(function(){
                
                $("body").mCustomScrollbar({
                    theme:"minimal"
                });
                
            });
        })(jQuery);
        
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
		
		$('#depoimento').validate();
		
    </script>
     
    <script src="<?php echo ("js/modernizr.custom.70736.js") ?>" ></script>        
	<script src="<?php echo ("js/jquery.masonry.min.js") ?>" ></script>
    <script src="<?php echo ("js/gamma.js") ?>" ></script>
        
    <script type="text/javascript">	    
        $(function() {
    
            var GammaSettings = {
                    // order is important!
                    viewport : [ {
                        width : 1200,
                        columns : 5
                    }, {
                        width : 900,
                        columns : 4
                    }, {
                        width : 500,
                        columns : 3
                    }, { 
                        width : 320,
                        columns : 2
                    }, { 
                        width : 0,
                        columns : 2
                    } ]
            };
    
            Gamma.init( GammaSettings);
    
        });
        
    </script>	
</body>
</html>