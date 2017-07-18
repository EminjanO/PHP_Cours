<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>
        <?php echo($title); ?>
    </title>
    <!-- La feuille de styles "base.css" doit être appelée en premier. -->
    <link rel="stylesheet" type="text/css" href="css\base.css" media="all" />
    <link rel="stylesheet" type="text/css" href="css\index.css" media="all" />
    <script src="/ALL/jQ/jquery-3.1.1.min.js"></script>
    <script src="js/index.js"></script>
</head>

<body <!--onload="hideCredits(); logoClickable(); focusOnAccueil();-->">

<div id="global">

    <header id="entete">
        <h1>
            <img id="logo" alt=<?php echo("$logoAlt");?> src=<?php echo("$logoPath");?> />
            <span id="titre"><?php echo("$nomSite");?></span>
        </h1>
        <nav id="menu" class="menu">
            <ul>
                <li><a href="index.html">Accueil</a></li>
                <li><a href="liste.html">Tous les gabarits</a></li>
                <li><a href="tableau.html">JSON</a></li>
                <li><a href="formLogin.html">Connexion</a></li>
            </ul>
        </nav>
    </header><!-- #entete -->

    <nav id="sous-menu" class="menu">
        <ul>
            <li><a href="utiliser.html">Utilisation</a></li>
            <li><a href="tpSem04.html">TP sem04</a></li>
            <li><a href="config.html">Config</a></li>
            <li><a href="ephec.html">Ephec</a></li>
        </ul>
    </nav><!-- #navigation -->

    <main id="contenu">
        <?php echo($contenu);
        ?>
    </main><!-- #contenu -->

    <footer id="copyright">
        <span id="auteur">
            <?php echo ($auteur);?>
        </span>
        -
        <span id="allCredit">
            <span>crédits</span>
            <span id="credit">
                Mise en page &copy; 2008
                <a href="http://www.elephorm.com">Elephorm</a> et
                <a href="http://www.alsacreations.com">Alsacréations</a>
            </span>
        </span>
    </footer>

</div><!-- #global -->

</body>
</html>

