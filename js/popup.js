
//window.onload=function(){
//	document.getElementsByTagName('body')[0].innerHTML += "<div id='pop' style='display:none;' ><div><h3><span id='pop_titre'></span><a href='#' onclick='pop_close()'><img src='../img/close.png' style='height:17px;'/></a></h3><div id='pop_cont'></div></div></div>";
//}



var isEsc = false;
var openfunc = function(){};
var closefunc = function(){};

document.onkeyup=function(e){ 
	if(e.which == 27) {
		isEsc=false; 
	}
}

document.onkeydown=function(e){
	if(e.which == 27) {
		isEsc=true;
	}
	if(e.which == 27 && isEsc == true) {
		pop_close();
	}
}

function pop_show(){
	openfunc();
	document.getElementById('pop').style.display = "block";
}

function pop_close(){
	document.getElementById('pop').style.display = "none";
	closefunc();
	pop_reset();
}

function pop_title(title){
	document.getElementById('pop_titre').innerHTML = title;
}

function pop_content(cont){
	document.getElementById('pop_cont').innerHTML = cont;
}

function pop_open_func(func){
	openfunc = func;
}

function pop_close_func(func){
	closefunc = func;
}

function pop_reset(){
	pop_open_func = function(){};
	pop_close_func = function(){};
	document.getElementById('pop_cont').innerHTML="";
    pop_title("");
	pop_set_x(400);
	pop_set_y(400);
}

function pop_set_y(size){
	document.getElementById('pop_fen').style.height = size + "px";
	document.getElementById('pop_cont').style.height = (size-27) + "px";
}

function pop_set_x(size){
	document.getElementById('pop_fen').style.width = size + "px";
}
