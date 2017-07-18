/**
 * Created by eminjan on 2/19/17.
 */

function affiche(id, b)  // afficher et cacher le crédit
{
	document.getElementById(id).style.display = b ? '' : 'none';
}

function ajaxHTML(a)
{
	// piste 1 ... il y a moyen d'écrire moins de lignes pour avoir le nom
	var lien    = a.href; // un attribut est comme une clé --> accès direct avec .
	var explose = lien.split("/");
	var dernier = explose[explose.length - 1];
	var nom     = dernier.split(".")[0];
	//piste 2 ... beaucoup plus courte
	//var nom = a.attributes.href.value.split(".")[0];
	var xhttp                = new XMLHttpRequest();
	xhttp.onreadystatechange = function ()
	{
		if (xhttp.status == 200 && xhttp.readyState == 4)
		{
			document.getElementById("contenu").innerHTML = this.responseText;
		}
	}
	xhttp.open("GET", "INC/appelHTML.php?rq=" + nom, true);
	xhttp.send();
	return false;
}

function ajaxJSON(a)
{
	var lien = a.attributes.href;
	var action;
	if (!lien) action = a.attributes.action;
	var nom = (lien ? lien : action).value.split(".")[0];

	var inputs = [];   // un tableau ASSOCIATIF vide
	if (action)
	{
		var ch = a.children; // <input type="text" name="groupe" placehosler...value....>

		for (i in ch)
		{
			if (ch.hasOwnProperty(i) && ch[i].name)
			{
				inputs[ch[i].name] = ch[i].value;

			}
		}
	}

	inputs = Object.keys(inputs).map(function (x) { return x + '=' + inputs[x]}) // inputs = groupe=1TL2 genre chose
				   .join(';');


	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function ()
	{
		if (xhttp.status == 200 && xhttp.readyState == 4)
		{console.log(this.responseText);
			document.getElementById("contenu").innerHTML = createTableOrderByTitle(this.responseText);
		}
	}

	xhttp.open("GET", "INC/appelJSON.php?rq=" + nom + "&" + inputs, true);
	xhttp.send();
	return false;
}

function createTableOrderByTitle(json)
{
	var t = JSON.parse(json);
	var k = Object.keys(t);
	k.sort(function (x, y)
	{
		if (t[x].titre == t[y].titre) return 0;
		return t[x].titre > t[y].titre ? 1 : -1;
	});
	var l = Object.keys(t[k[0]]);
	l.unshift('ref');
	var out = '';
	var z   = k.map(function (x)
	{
		var v = Object.keys(t[x]).map(function (y) { return t[x][y];})
		v.unshift(x);
		out = v.join('</td>\n<td>');
		return '<tr><td>' + out + '</td>\n</tr>\n';
	})

	var html = '<table class=tableau>\n<thead><tr><th>'
		+ l.join('</th>\n<th>')
		+ '</th></tr>\n</thead>\n<tbody><tr><td>'
		+ z.join('')
		+ '</td></tr></tbody></table>';
	return html;
}

