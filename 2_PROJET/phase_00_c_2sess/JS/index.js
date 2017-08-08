/**
 * Created by eminjan on 2/19/17. */
var data = new Object();

function main(){
	affiche("credit", false);
	document.querySelector('a').focus();
}
function affiche(id, b)  // afficher et cacher le crédit
{
    document.getElementById(id).style.display = b ? "block" : "none";
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
                                                                avec le décodge JSON de 'y'*/
				var parent = script.parentNode;
				parent.removeChild(parent.childNodes[parent.childNodes.length-1]); // supprimer la balise <script> et son contenu
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
    if(!lien)
        var action = a.attributes.action;
    var nom = (lien?lien : action).value.split(".")[0];

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
	inputs = Object.keys(inputs)
                   .map(function(x){ return x + '=' + inputs[x]}) // inputs = groupe=1TL2 genre chose
				   .join('&');

	var xhttp= new XMLHttpRequest();
    xhttp.onreadystatechange = function ()
    {
        if(xhttp.status == 200 && xhttp.readyState == 4)
        {
            document.getElementById("contenu").innerHTML=createTableOrderByTitle(this.responseText);
        }
    }
    xhttp.open("GET","INC/appelJSON.php?rq="+nom + '&' + inputs,true);
    xhttp.send();
    return false;
}

function createTableOrderByTitle(json){
    var t = JSON.parse(json);
    var k = Object.keys(t);
    /*k.sort(function(x,y){
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
/*
function filtre (el)
{
	var elMaj = el.value.toUpperCase();
	var liste = data['listeGroup'].filter(function (x)
										{
											//return x.nom.indexOf(elMaj) > -1;
											switch (el.form.posFiltre.value)
											{
												case 'I' : return x.nom.indexOf(elMaj) > -1;
												case 'B' : return x.nom.indexOf(elMaj) == 0;
												case 'E' : var p = x.nom.lastIndexOf(elMaj);
													return (p != -1) && ( p == x.nom.length - elMaj.length );
											}
										}).map(function (x) { return x.nom }).join(', ');
	if(elMaj!= '')setElem('visu', liste);
	else setElem('visu','');
	//setElem('visu', el.value);
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
	value = el.form.posFiltre.value;
	liste = data['listeGroup'].filter(function (x)
								{
									return filters[value](x,elMaj)
								}).map(function(x) { return x.nom}).join(', ');
	if(elMaj!= '')setElem('visu', liste);
	else setElem('visu','');
}