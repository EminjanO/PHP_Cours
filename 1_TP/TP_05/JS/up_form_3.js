/**
 * Created by eminjan on 24/04/17.
 */
function verif(fileId)
{
	var extention = ['jpg', 'jpeg', 'gif', 'png'];
	var x = refElem(fileId.id);
	var txt = "";
	//console.log(id.files[0]['name']);
	if ('files' in x )
	{
		if (x.files.length == 0)
		{
			txt = "Selectoinnez vous une ou plusieurs fichier";
		}
		else
		{
			for(var i = 0; i < x.files.length; i++)
			{
				var upFileExtention = x.files[i]['name'].split('.')[1];
				if(!(inArray(upFileExtention, extention)))
				{
					txt += " Fichier n'adapte pas !!!";
					fileId.form.submit.disabled = true;
					setElem("afficheInfo", txt);
				}
				else
				{
					txt += "images : " + (x.files[i]['size']/1024/1024).toFixed(2) + " MO.";
					fileId.form.submit.disabled = false;
					setElem("afficheInfo", txt);
				}
			}
		}
	}
	
	function inArray(needle, haystack)
	{
		var length = extention.length;
		for(var i = 0; i < length; i++)
		{
			if(haystack[i] == needle)
				return true
		}
		return false;
	}
}