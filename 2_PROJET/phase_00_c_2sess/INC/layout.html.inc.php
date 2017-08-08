<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>
            <?php echo $title?>
        </title>
        <!-- La feuille de styles "base.css" doit être appelée en premier. -->
        <link rel="stylesheet" type="text/css" href="CSS/base.css" />
        <link rel="stylesheet" type="text/css" href="CSS/modele04.css" />
        <link rel="stylesheet" type="text/css" href="CSS/index.css" />
        <script type="text/javascript" src="JS/index.js"></script>
		<script type="text/javascript" src="JS/utils.js"></script>
    </head>

	<body onload="main()">
    <div id="global">

        <header id="entete">
            <h1>
                <img id="logo" alt="<?php echo $alternIMG?>" src="<?php echo $srcIMG?>"  />
                <p><?php echo $titreDePage ?></p>
            </h1>
            <nav id="menu" class="menu">
				<ul>
					<li><a href="index.html"  onclick="return ajaxHTML(this)">Accueil</a></li>
					<li><a href="liste.html"  onclick="return ajaxHTML(this)">Tous les gabarits</a></li>
					<li><a href="tableau.html"  onclick="return ajaxJSON(this)">JSON</a></li>
				</ul>
            </nav>
        </header><!-- #entete -->

        <br style="clear:left" >

        <nav id="sous-menu" class="menu">
            <ul>
                <li><a href="utiliser.html"  onclick="return ajaxHTML(this)">Utilisation</a></li>
                <li><a href="tpSem04.html"  onclick="return ajaxHTML(this)">TP sem 04</a></li>
                <li><a href="credits.html"  onclick="return ajaxHTML(this)">Crédits</a></li>
            </ul>
        </nav><!-- #navigation -->

        <section id="contenu">
            <?php echo $bienvenue ?>
        </section><!-- #contenu -->

        
            <footer id="copyright">
                <span id="auteur">
                    <a href="mailto:<?php echo $mailAdd ?>" target="_top">
                        <?php echo $auteur ?>@2017
                    </a>
                </span>
                -
                <span onmouseover="affiche('credit', true)" onmouseout="affiche('credit', false)">
					crédits
					<span id="credit">
					Mise en page &copy; 2008
					<a href="http://www.elephorm.com" target="_blank" onclick="return ajaxHTML(this)">Elephorm</a> et
					<a href="http://www.alsacreations.com" target="_blank" onclick="return ajaxHTML(this)">Alsacréations</a>
					</span>
				</span>
            </footer>
        
    </div><!-- #global -->

    </body>
</html>

