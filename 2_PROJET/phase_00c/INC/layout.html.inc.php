<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>
            <?php echo $title?>
        </title>
        <!-- La feuille de styles "base.css" doit être appelée en premier. -->
        <link rel="stylesheet" type="text/css" href="CSS/base.css" media="all" />
        <link rel="stylesheet" type="text/css" href="CSS/modele04.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="CSS/index.css" media="screen" />
        <script type="text/javascript" src="JS/index.js"></script>
        <script type="text/javascript" src="JS/utils.js"></script>
    </head>

    <body>
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
           <!-- <h2>À propos du gabarit 04</h2>
            <h3>Code HTML et CSS</h3>
            <p>Ce gabarit est structuré de la manière suivante:</p>
    <pre><code>&lt;div id="global"&gt;
            &lt;div id="entete"&gt;...&lt;/div&gt;
            &lt;div id="navigation"&gt;...&lt;/div&gt;
            &lt;div id="contenu"&gt;...&lt;/div&gt;
            &lt;/div&gt;</code></pre>
            <p>Il est mis en forme par deux feuilles de styles:</p>
            <ol>
                <li><a href="styles/base.css" target="_blank">base.css</a> (mise en forme minimale
                    du texte, commune à tous les gabarits)</li>
                <li><strong><a href="styles/modele04.css" target="_blank">modele04.css</a></strong>,
                    qui contient tous les styles propres à ce gabarit, et que je vous
                    invite à consulter.</li>
            </ol>
            <p>Pour voir le détail du code HTML de cette page, utilisez la fonction
                d'affichage de la source de votre navigateur web (ex: «Affichage &gt;
                Code source de la page»).</p>
            <h3>À noter</h3>
            <ol>
                <li><p>Dans ce gabarit, nous utilisons la propriété CSS
                        <code>float</code> pour placer deux blocs à la même hauteur plutôt
                        que l'un en dessous de l'autre. Voir les notes de la feuille de
                        style du gabarit pour en savoir plus.</p></li>
                <li><p>Le bloc de droite n'utilise pas la propriété
                        <code>float</code>, mais une simple marge à gauche
                        (<code>margin-left</code>).</p>
                    <p>Pour mieux comprendre le fonctionnement du positionnement
                        flottant, vous pouvez, avec un outil tel que
                        <a href="https://addons.mozilla.org/fr/firefox/addon/1843" target="_blank">Firebug</a>,
                        désactiver la marge de gauche de <code>div#contenu</code>.</p></li>
            </ol>        -->
        </section><!-- #contenu -->

        <span id="credit">
            <footer id="copyright">
                <span id="auteur">
                    <a href="mailto:<?php echo $mailAdd ?>" target="_top">
                        <?php echo $auteur ?>@2017
                    </a>
                </span>
                <span> - </span>
                <span onmouseover="affiche('disparait', true)" onmouseout="affiche('disparait', false)">crédits</span>
                <br style="clear: none">
                <p id="disparait" style="display: none">
                Mise en page &copy; 2008
                <a href="http://www.elephorm.com"  onclick="return ajaxHTML(this)">Elephorm</a> et
                <a href="http://www.alsacreations.com"  onclick="return ajaxHTML(this)">Alsacréations</a>
                </p>
            </footer>
        </span>
    </div><!-- #global -->

    </body>
</html>

