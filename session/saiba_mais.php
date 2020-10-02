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
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../imagens/favicon/apple-touch-icon-144-precomposed.png"> 
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../imagens/favicon/apple-touch-icon-114-precomposed.png"> 
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../imagens/favicon/apple-touch-icon-72-precomposed.png"> 
        <link rel="apple-touch-icon-precomposed" href="../imagens/favicon/apple-touch-icon-57-precomposed.png">
        
		<link href="https://fonts.googleapis.com/css?family=Kaushan+Script|Philosopher" rel="stylesheet">
        
        <link rel="stylesheet" type="text/css" href="<?php echo("../css/bootstrap.min.css") ?>"/>        
        <link rel="stylesheet" type="text/css" href="<?php echo("../simple-line-icons/simple-line-icons.min.css") ?>"/>        
        <link rel="stylesheet" type="text/css" href="<?php echo("../css/animate.css") ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo("../css/style.css") ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo("../css/layout.min.css") ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo("../font-awesome/css/font-awesome.min.css") ?>"> 
		<link rel="stylesheet" type="text/css" href="<?php echo("../css/jquery.mCustomScrollbar.css") ?>">
        <style>
			.cahcaca_card img{
				margin:5% auto;
			}
			.cahcaca_card p{
				margin:2% auto;
				text-align:justify;
			}
			.cahcaca_card ul li{
				list-style:none;
			}
			a .fa{
				color:#ccc;
				position: absolute;
				right:50px;				
				top:50px;
				padding:0px 5px;
				font-size:36px;
				border-radius:5px;
				cursor:pointer;
				border:#ccc solid 1px;
			}
			a .fa:hover{
				color:#900;
				border:#900 solid 1px;
				
			}
			.footer{
				clear:both;
			}
			.footer p{
				position:relative;
				text-align:right;
				float:right;
			}
			.footer img{
				position:relative;
				float:left;
				width:7%;
				margin-left:3%; 
			}
		</style>
</head>
<body class="mCustomScrollbar">

<a onClick="JavaScript: window.history.back();"><i class="fa fa-close"> </i></a>
<div class="cahcaca_card container mCustomScrollbar">

	<?php if(isset($_GET['alambique'])){ 
    
            include("saiba_mais_adm.php");
            
        } elseif (isset($_GET['bolavez'])){ 
        
            include("saiba_mais_bdv.php");
        
        } elseif (isset($_GET['rainha'])){
        
            include("saiba_mais_nr.php");
            
        } elseif  (isset($_GET['engenho'])) {
            
            include("saiba_mais_edc.php");
        } ?>         
    <!-- Copyright -->            
     	<div class="container">
         	<div class="footer col-sm-8" id="rodape">
				<hr id="locais">
                <img src="../imagens/logo-cachacas-engenho-da-cana.png">
                <p>Todos direitos reservados, Cacha&ccedil;as Engenho da Cana &copy; 2017<br />
                <small> Desenvolvido por: <a class="color-base fweight-200" href="#">TOP Artes &#45; Andr&eacute; Aguiar</a></small></p>
            </div>
        </div>
  </div>      
    <!-- Fim Copyright -->
</body>
</html>