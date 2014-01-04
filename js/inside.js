var nbreq = 0;
var title = "";

setInterval(function(){notif()},7000);

function trysearch(){
	if (document.getElementById("recherche")) {
		recherche();
	}
	else {
		// document.getElementById('form_search').submit(); // renvoie automatique vers la page rechercher
	}
}

function loading(){
	nbreq++;
	document.getElementById("loading").style.display = "block";
}

function stop_loading(){
	nbreq--;
	if (nbreq<=0) {
		nbreq = 0;
		document.getElementById("loading").style.display = "none";
	}
}

function timestamp(){
	var d = new Date();
	var m = d.getMinutes();
	if (m<10) {
		m = "0"+m;
	};
	return d.getHours()+":"+m+" "+d.getDate()+"/"+(d.getMonth()+1)+"/"+(d.getFullYear()%100);
}

function urlify(text)
{
	text = text.replace(/(https?:\/\/[^\s]+)/g, '<a href="$1" target="_blank">$1</a>').replace(/\n/g, "<br />");

	var emoticons = {
		':(' : 'triste.png',
		':)'  : 'smile.png',
		':D'  : 'heureux.png',
		'o_O'  : 'blink.gif',
		'^^'  : 'hihi.png',
		';)'  : 'clin.png',
		':p'  : 'langue.png',
		':o'  : 'huh.png'
	}, url = "../img/smiley/", patterns = [],
	metachars = /[[\]{}()*+?.\\|^$\-,&#\s]/g;

  	// build a regex pattern for each defined property
  	for (var i in emoticons) {
    	if (emoticons.hasOwnProperty(i)){ // escape metacharacters
    		patterns.push('('+i.replace(metachars, "\\$&")+')');
    	}
	}

  	// build the regular expression and replace
  	return text.replace(new RegExp(patterns.join('|'),'g'), function (match) {
  		return typeof emoticons[match] != 'undefined' ?
  			'<img src="'+url+emoticons[match]+'"/>' :
  			match;
	});
}

function addZero(nb) {
	nb = parseInt(nb);
	if (nb%10==nb) {
		return "0" + nb;
	}
	return nb;
}