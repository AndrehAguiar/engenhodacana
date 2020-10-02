
            <div class="col-md-12 text-center marb-35">
                <h1 class="header-h">Cacha&ccedil;as Premiadas</h1>
                <div class="text-center gallery-trigger">
                    <ul>
                        <li><a href="?premios=all#premios" class="filter btn-theme btn-theme-sm btn-base-bg" data-filter="all">Todas</a></li>
                        <li><a href="?premios=adm#premios" class="filter btn-theme btn-theme-sm btn-base-bg" data-filter=".adm">Alambique de Minas</a></li>
                        <li><a href="?premios=bdv#premios" class="filter btn-theme btn-theme-sm btn-base-bg" data-filter=".bdv">Bola da Vez</a></li>
                        <li><a href="?premios=edc#premios" class="filter btn-theme btn-theme-sm btn-base-bg" data-filter=".edc">Engenho da Cana</a></li>
                        <li><a  href="?premios=nr#premios"class="filter btn-theme btn-theme-sm btn-base-bg" data-filter=".nr">Nossa Rainha</a></li>
                    </ul>
                </div>
            </div>
            <div class="container mCustomScrollbar" id="premios">
                <div id="Container">
                
					<?php if  ($_GET['premios'] == '' || $_GET['premios'] == 'all' || $_GET['premios'] == 'adm'){?>
                	
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
                                <a href="<?php echo ("session/saiba_mais.php?alambique=adm_ouro&cachaca=3") ?>" class="content-wrapper-link"></a>    
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
                    <?php } if  ($_GET['premios'] == '' || $_GET['premios'] == 'all' || $_GET['premios'] == 'nr'){?>
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
                                    <h3>Expocacha&ccedil;a 2017</h3>
                                    <p class="margin-b-5">Medalha de prata no concurso nacional do Expocacha&ccedil;a.</p>
                                </div>
                                <a href="<?php echo ("session/saiba_mais.php?rainha=nr_ouro&cachaca=2") ?>" class="content-wrapper-link"></a>    
                            </div>
                        </div>
                    </div>
                    <?php } if  ($_GET['premios'] == '' || $_GET['premios'] == 'all' || $_GET['premios'] == 'bdv'){?>
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
                                <a href="
                                <a href="<?php echo ("session/saiba_mais.php?bolavez=bdv_prata&cachaca=3") ?>" class="content-wrapper-link"></a>    " class="content-wrapper-link"></a>    
                            </div>
                        </div>
                    </div>
                    <?php } if  ($_GET['premios'] == '' || $_GET['premios'] == 'all' || $_GET['premios'] == 'edc'){?>
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
                                    <p class="margin-b-5">Lorem ipsum dolor amet consectetur ut consequat siad esqudiat dolor</p>
                                </div>
                                <a href="#" class="content-wrapper-link"></a>    
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
                   <!--// end row-->
                   <?php } ?>
              </div>
           </div>    