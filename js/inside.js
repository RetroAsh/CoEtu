var nbreq = 0;
var title = "";

setInterval(function(){notif()},7000);

var isEnter = false;

document.onkeyup=function(e){ 
	if(e.which == 13 && isEnter == true && document.getElementById("buffer")) {
		sendMsg(current);
	}
	if(e.which == 13) {
		isEnter=false; 
	}
}

document.onkeydown=function(e){
	if(e.which == 13) {
		isEnter=true;
	}
}

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

function urlify(text) {
    var urlRegex = /(https?:\/\/[^\s]+)/g;
    return text.replace(urlRegex, '<a href="$1" target="_blank">$1</a>')
}