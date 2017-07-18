<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>
        <?php echo($title); ?>
    </title>
    <!-- La feuille de styles "base.css" doit être appelée en premier. -->
    <link rel="stylesheet" type="text/css" href="css\base.css" media="all" />
    <link rel="stylesheet" type="text/css" href="css\index.css" media="all" />
    <script src="js/index.js"></script>
</head>

<body onload="hideCredits(); logoClickable(); focusOnAccueil();">

<div id="global">

    <header id="entete">
        <h1>
            <img id="logo" alt=<?php echo("$logoAlt");?> src=<?php echo("$logoPath");?> />
            <?php echo("$nomSite");?>
        </h1>
        <nav id="menu" class="menu">
            <ul>
                <li><a href="index.html" onclick="newAjaxJSON(this); return false;">Accueil</a></li>
                <li><a href="liste.html" onclick="newAjaxJSON(this); return false;">Tous les gabarits</a></li>
                <li><a href="tableau.html" onclick="newAjaxJSON(this); return false;">JSON</a></li>
                <li><a href="formLogin.html" onclick="newAjaxJSON(this); return false;">Connexion</a></li>
            </ul>
        </nav>
    </header><!-- #entete -->

    <nav id="sous-menu" class="menu">
        <ul>
            <li><a href="utiliser.html" onclick="newAjaxJSON(this); return false;">Utilisation</a></li>
            <li><a href="tpSem04.html" onclick="newAjaxJSON(this); return false;">TP sem04</a></li>
            <li><a href="config.html" onclick="newAjaxJSON(this); return false;">Config</a></li>
            <li><a href="ephec.html" onclick="newAjaxJSON(this); return false;">Ephec</a></li>
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
        <span onmouseover="showCredits();" onmouseleave="hideCredits();">
            <span>crédits</span>
            <span id="credit">
                Mise en page &copy; 2008
                <a target=_blank href="http://www.elephorm.com">Elephorm</a> et
                <a target=_blank href="http://www.alsacreations.com">Alsacréations</a>
            </span>
        </span>
    </footer>

</div><!-- #global -->

</body>
</html>

