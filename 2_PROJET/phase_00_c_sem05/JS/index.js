/**
 * Created by eminjan on 2/19/17.
 */

var data = new Object();

function affiche(id, b)  // afficher et cacher le crédit
{
    document.getElementById(id).style.display = b ? '' : 'none';
}

function ajaxHTML(a)
{
    // piste 1 ... il y a moyen d'écrire moins de lignes pour avoir le nom
    var lien=a.href; // un attribut est comme une clé --> accès direct avec .
    var explose = lien.split("/");
    var dernier=explose[explose.length-1];
    var nom = dernier.split(".")[0];
    //piste 2 ... beaucoup plus courte
    //var nom = a.attributes.href.value.split(".")[0];
    var xhttp= new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if(xhttp.status == 200 && xhttp.readyState == 4)
        {
            document.getElementById("contenu").innerHTML=this.responseText;
            var script = document.getElementById('monScript'); // sem04_TP
            if(script)
            {
                data[script.title]=JSON.parse(script.text); /* récupérer la valeur de son title 'x' et le contenu textuel
                                                                de 'monScript' 'y' et aficher la variable var data['x']
                                                                avec le décodge JSON de 'y'
                                                              */
                script.parentNode.removeChild(script); // supprimer la balise <script> et son contenu
            }
        }
    }
    xhttp.open("GET","INC/appelHTML.php?rq="+nom,true);
    xhttp.send();
    return false;
}

function ajaxJSON(a)
{

    var lien = a.attributes.href;
    var action;
    if(!lien) action = a.attributes.action;
    nom = (lien?lien : action).value.split(".")[0];

    var inputs = [];
    if(action)
    {
        var ch = a.children; // <input type="text" name="groupe" placehosler...value....>

        for(i in ch)
        {
            if(ch.hasOwnProperty(i) && ch[i].name)
            {
                inputs[ch[i].name] = ch[i].value;

            }
        }
    }

    inputs = Object.keys(inputs).map(function(x){ return x + '=' + inputs[x]}) // inputs = groupe=1TL2 genre chose
        .join('&');


    var xhttp= new XMLHttpRequest();

    xhttp.onreadystatechange = function ()
    {
        if(xhttp.status == 200 && xhttp.readyState == 4)
        {
            document.getElementById("contenu").innerHTML = this.responseText;
        }
    }

    xhttp.open("GET","INC/appelJSON.php?rq=" + nom +"&"+ inputs, true);
    xhttp.send();
    return false;
}

function createTableOrderByTitle(json){
    var t = JSON.parse(json);
    var k = Object.keys(t);/*
     k.sort(function(x,y){
     if (t[x].titre == t[y].titre) return 0;
     return t[x].titre > t[y].titre ? 1 : -1;
     });*/
    var l = Object.keys(t[k[0]]);
    l.unshift('ref');
    var out ='' ;
    var z = k.map(function(x){
        var v= Object.keys(t[x]).map(function(y) { return t[x][y];})
        v.unshift(x);
        out = v.join('</td>\n<td>');
        return '<tr><td>'+out +'</td>\n</tr>\n';
    })

    var html ='<table class=tableau>\n<thead><tr><th>'
        + l.join('</th>\n<th>')
        +'</th></tr>\n</thead>\n<tbody><tr><td>'
        + z.join('')
        +'</td></tr></tbody></table>';
    return html;
}

function affDebut() //pour afficher le zone recherder
{
    var affiche = data['listeGroupes']
        .map(function (x)
        {
            return x.nom
        })
        .join(', ');

    setElem('visu', affiche);
}


/*
 function filtre(el) //pour filtrer le zone recherder  ////////un autre méthode - << propre >> (?>
{
    var elMaj= el.value.toUpperCase();
    var liste = data['listeGroupes']
        .filter(function (x)
        {
            switch (el.form.part.value)
            {
                case 'I' : return x.nom.indexOf(elMaj) > -1;
                case 'B' : return x.nom.indexOf(elMaj) == 0;
                case 'E' : var p = x.nom.lastIndexOf(elMaj);
                            return (p != -1) && ( p == x.nom.length - elMaj.length );
            }
        })
        .map(function (x)
        {
            return x.nom
        })
        .join(', ');

    setElem('visu', liste);
    // setElem('visu',el.value);
}
 */
var filters =
    {
        I : function(x,y){ return x.nom.indexOf(y) > -1},
        B : function(x,y){ return x.nom.indexOf(y) == 0},
        E : function(x,y){ return ( p = x.nom.lastIndexOf(y)) != -1 && p == x.nom.length - y.length }
    };
function old_filtre_v2(el) // original filtrage!!!!!!!!!
{
    var elMaj= el.value.toUpperCase();
    var liste = '';
    var value = el.form.part.value;
    liste = data['listeGroupes']
        .filter(function (x)
        {
            return filters[value](x,elMaj)
        })
        .map(function(x){ return x.nom});
    var listeOptions = liste
        .map(function (x) { return '<option value =' + x + '>' + x + '</option>'});

    //setElem('visu', liste.join(', '));
    //refElem('pDSuggestion').style.display='none';
    if(listeOptions.length<10)
    {
        refElem("sem04Select").size=listeOptions.length;
    }
    if(listeOptions.length>10)
    {
        refElem('sem04Select').style.overflowY="scroll";
    }
    refElem('sem04Select').style.overflowY="hidden";
    refElem('sem04Select').style.overflowX="hidden";

    setElem('sem04Select', listeOptions.join('\n'))
}

function filtre_v2(el)
{
    var elMaj= el.value.toUpperCase();
    var liste = '';
    var value = el.form.part.value;
    liste = data['listeGroupes']
        .filter(function (x)
        {
            return filters[value](x,elMaj)
        })
        .map(function(x){ return x});
    var listeOptions = liste
        .map(function (x) { return '<option value =' + x.id + '>' + x.nom + '</option>'});

    //setElem('visu', liste.join(', '));
    //refElem('pDSuggestion').style.display='none';
    if(listeOptions.length<10)
    {
        refElem("sem04Select").size=listeOptions.length;
    }
    if(listeOptions.length>10)
    {
        refElem('sem04Select').style.overflowY="scroll";
    }
    refElem('sem04Select').style.overflowY="hidden";
    refElem('sem04Select').style.overflowX="hidden";

    setElem('sem04Select', listeOptions.join('\n'))
    setElem('bLegend','Suggestion ('+ listeOptions.length + ')');
}

function monChoix(el)
{
    /* //it's for affichage la liste de cours préparation 1.2
    var sel=refElem('sem04Select');
    var opt=sel.options[sel.selectedIndex];
    alert("je suis dans monChoix() \n" +
        opt.text );
    */
    el.dataset.groupe=el.value; // ajouter la valeur de l'<<option choisie>> dans une variable supplémentaire du dataset
                                    // équivalente à <<data-groupe>>

    /*
     alert("je suis dans monChoix() \n"

        + 'data:{"url":"' + el.dataset.url + '","dest":"' + el.dataset.dest + '","groupe":"' + el.dataset.groupe+'"}' )
    */

    newAjaxJSON(el);
}

function gereRetour(json)
{
    var retour = JSON.parse(json);
    var action = Object.keys(retour);
    switch (action[0])
    {
        case 'creeTableau':
            var data = retour.creeTableau;
            refElem(data.destination).innerHTML = createTableOrderByTitle(JSON.stringify(data.tableau));
            break;
        case 'contenu':
            refElem('contenu').innerHTML = retour['contenu'];
            break;
    case 'changeLogo':
            console.log(retour);
            refElem("logo").src = retour.changeLogo + '?' + (new Date()).getTime();
            break;
    }
    //refElem("affiche").innerHTML = createTableOrderByTitle(json);
}

function newAjaxJSON(a)
{
	if(a.action) a.dataset.url = a.attributes.action.value; //existance de l'attribut action, auquel cas on récupère
                                                            // sa valeur pour la mettre dans le dataset-url
    if(a.href) a.dataset.url = a.attributes.href.value;   // si on vien d'un lien
    var lien = a.dataset.url;                        //On recupère l'url de la fausse page
    var nom = lien.split('.')[0];                   //On ne retient que son nom; pas besoin de value cette fois
    var inputs = Object.assign({},a.dataset);  //On crée dans un objet vide une copie du dataset
    delete inputs.url;                                 //On supprime la propriété url inutile à présent


    inputs = Object.keys(inputs)            // On prend les clés (noms des champs)
        .map(function(x)                    // On itère pour chaune de ces clés --> Array
        {
            return x + '=' + inputs[x]      // On y joint les valeurs
        })                                      /////butunqisi bu// inputs = groupe=1TL2 genre chose
        .join('&');                         // On kie tous les morceaux avec le bon caractère


    var xhttp= new XMLHttpRequest();

    xhttp.onreadystatechange = function ()
    {
        if(this.status == 200 && this.readyState == 4)
        {
            gereRetour(this.responseText);
        }
    }
    //if(inputs)
    xhttp.open("POST","INC/newAppelJSON.php?rq=" + nom +"&"+ inputs, true);
	//xhttp.open("GET","INC/newAppelJSON.php?rq=" + nom, true);
    if(a.action)    xhttp.send(new FormData(a));
    else    xhttp.send(new FormData() );
    return false;
}

function sendForm(el)
{
    return newAjaxJSON(el);
}

function initialisation()
{
    var logo = document.querySelector('#logo');
    logo.dataset.url = "formLogo.html";
    logo.setAttribute('onclick', "newAjaxJSON(this);");
    logo.title = "Chargement du logo";
}
