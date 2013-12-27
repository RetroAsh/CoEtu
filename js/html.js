
var last = "";

function voyageH (id,depart,arrive,aller,retour,conduc) {
	var ret = "<div class='voyage' onclick=\"voyage(" + id + ",'" + depart + " &rarr; " + arrive + "')\" >";
	ret += "<img src='../img/car.png' /><h5>" + depart + " &rarr; " + arrive + "</h5><span class='date'>" + aller;
	if (retour!=0) {
		ret += " / " + retour;
	};
    ret += "</span>"
    if (conduc!="") {
    	ret += "<br /><span class='conduc'>" + conduc + "</span>";	
    };     
    ret += "</div>"
    return ret;
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