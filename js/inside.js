var nbreq = 0;
var last = "";

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

function ajoutMsg(perso,time,msg){
	if (perso!=last) {
		document.getElementById('scrollpane').innerHTML += "<div class='msg' ><span class='dt'>" + time + "</span><span class='perso'>" + perso + "</span><span class='dire'> " + msg + "</span></div>";
	}
	else {
		document.getElementById('scrollpane').innerHTML += "<div class='msg' ><span class='dire'> " + msg + "</span></div>";
	}
	last = perso;
}

function timestamp(){
	var d = new Date();
	var m = d.getMinutes();
	if (m<10) {
		m = "0"+m;
	};
	return d.getHours()+":"+m+" "+d.getDate()+"/"+(d.getMonth()+1)+"/"+(d.getFullYear()%100);
}