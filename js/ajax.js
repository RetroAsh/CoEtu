function getXhr()
{
    //alert("patate");
    var xhr = null; 
 
    if(window.XMLHttpRequest){ // Firefox et autres
        xhr = new XMLHttpRequest();
    }
    else if(window.ActiveXObject){ // Internet Explorer 
        try {
            xhr = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    else { // XMLHttpRequest non supporté par le navigateur 
        alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
        xhr = false; 
    }
    return xhr;
}

function test()
{
    alert("patate de test");
}

function notif(){
    var xhr = getXhr();
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            if (parseInt(xhr.responseText)>0) {
                document.getElementById("notif_img").src = "../img/bell.gif";
                document.title = "("+xhr.responseText+") " + title;
            }
            else if (xhr.responseText==-1) {
                window.location.replace("..");
            }
            else {
                document.getElementById("notif_img").src = "../img/bell.png";
                document.title = title;
            }
            stop_loading();
        }
    }
    loading();
    xhr.open("POST","../ajax/getNbNotification.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send();    
}

function voyage(id,nom){
    pop_title(nom);
    var xhr = getXhr();
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            pop_set_x(700);
            pop_set_y(500);
            pop_content(xhr.responseText);
            infoItineraire(id);
            pop_show();
            stop_loading();
        }
    }
    loading();
    xhr.open("POST","../ajax/getVoyage.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send("id=" + id);    
}

function infoItineraire(id){
    var xhr = getXhr();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var tabInfo = xhr.responseText.split(",");
            var coordV1 = new google.maps.LatLng(tabInfo[0], tabInfo[1]);
            var coordV2 = new google.maps.LatLng(tabInfo[2], tabInfo[3]);
            afficheItineraire(coordV1, coordV2);
        }
    };
    xhr.open("POST","../ajax/getCoordItineraire.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send("id_voyage=" + id);
}

function supprVoyage(id){
    var xhr = getXhr();
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            if (xhr.responseText!="") {
                alert(xhr.responseText);
            };
            stop_loading();
            getVoyages();
        }
    }
    loading();
    xhr.open("POST","../ajax/sendSupprVoyage.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send("id="+id);
}

function ville(id,nom){
    pop_title(nom);
    var xhr = getXhr();
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            pop_set_x(473);
            pop_set_y(473);
            pop_content(xhr.responseText);
            infoVille(id);
            pop_show();
            stop_loading();
        }
    }
    loading();
    xhr.open("POST","../ajax/getVille.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send();
}

function infoVille(id){
    var xhr = getXhr();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var tabInfo = xhr.responseText.split(",");
            var coord = new google.maps.LatLng(tabInfo[0], tabInfo[1]);
            afficheVille(coord);
        }
    };
    xhr.open("POST","../ajax/getCoordVille.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send("id=" + id);
}

function recherche(){
    var r = document.getElementById('rh').value;
    var xhr = getXhr();
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            document.getElementById('recherche').innerHTML = xhr.responseText;
            stop_loading();
        }
    }
    loading();
    xhr.open("POST","../ajax/getRecherche.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send("r=" + r);
}

function peronneInfo(id,nom){
    pop_title(nom);
    var xhr = getXhr();
    xhr.onreadystatechange = function(){
        // On ne fait quelque chose que si on a tout reçu et que le serveur est ok
        if(xhr.readyState == 4 && xhr.status == 200){
            pop_content(xhr.responseText);
            pop_show();
            stop_loading();
        }
    }
    loading();
    xhr.open("POST","../ajax/getPersonneInfo.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send("id=" + id);
}

function getVoyages(){
    var xhr = getXhr();
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            var box = document.getElementById("voyages");
            var own = "";
            var contact ="";
            var all = xhr.responseText.split("#\n");
            if (xhr.responseText=="") {
                all = new Array();
            };
            for (var i = 0; i < all.length; i++) {
                var single = all[i].split(";");
                if (single[5]=="") {
                    own += voyageH(single[0],single[1],single[2],single[3],single[4],single[5]) + "\n";
                }
                else {
                    contact += voyageH(single[0],single[1],single[2],single[3],single[4],single[5]) + "\n";
                }
            };
            if (own!="") {
                box.innerHTML = "<input class='newvoy' onclick='getNewVoyageForm()' value='Nouveau' type='button' title='Créer un nouveau voyage.' /> <input class='newvoy' onclick='getVoyages()' value='Rafraîchir' type='button' title='Rafraîchir la liste des voyages.' /><h4>Mes voyages</h4>";
                box.innerHTML += own;
            }
            else {
                box.innerHTML = "<span class='welcome'>Cliquer sur \"Nouveau\" pour proposer un voyage.</span>";
                box.innerHTML += "<input class='newvoy_wel' onclick='getNewVoyageForm()' value='Nouveau' type='button' title='Créer un nouveau voyage.' />";
            }
            if (contact!="") {
                box.innerHTML += "<h4>Mes contacts</h4>";
                box.innerHTML += contact;
            };
            box.innerHTML += "<div class='tampon'></div>";
            stop_loading();
        }
    }
    loading();
    xhr.open("POST","../ajax/getVoyages.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send();
}

function getNewVoyageForm(){
    pop_title("Nouveau voyage");
    var xhr = getXhr();
    xhr.onreadystatechange = function(){
        // On ne fait quelque chose que si on a tout reçu et que le serveur est ok
        if(xhr.readyState == 4 && xhr.status == 200){
            pop_content(xhr.responseText);
            pop_set_y(470);
            pop_show();
            stop_loading();
            sugvoyageform();
            document.getElementById("v_dep").focus();
        }
    }
    loading();
    xhr.open("POST","../ajax/getVoyageForm.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send();
}

function getModVoyageForm(id){
    var xhr = getXhr();
    xhr.onreadystatechange = function(){
        // On ne fait quelque chose que si on a tout reçu et que le serveur est ok
        if(xhr.readyState == 4 && xhr.status == 200){
            pop_reset();
            pop_title("Modifier voyage");
            pop_content(xhr.responseText);
            pop_set_y(470);
            pop_show();
            stop_loading();
            sugvoyageform();
            document.getElementById("v_dep").focus();
        }
    }
    loading();
    xhr.open("POST","../ajax/getVoyageForm.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send("mod_id="+id);
}

function getNotification(){
    pop_title("Notifications");
    var xhr = getXhr();
    xhr.onreadystatechange = function(){
        // On ne fait quelque chose que si on a tout reçu et que le serveur est ok
        if(xhr.readyState == 4 && xhr.status == 200){
            pop_content(xhr.responseText);
            pop_close_func(notif);
            pop_show();
            stop_loading();
        }
    }
    loading();
    xhr.open("POST","../ajax/getNotification.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send();
}

function getNewMsg(id){
    if (id==-1) {
        return;
    }
    loading();
    var xhr = getXhr();
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            if (xhr.responseText!="") {
                var all = xhr.responseText.split('#\n');
                for (var i = 0; i < all.length; i++) {
                    var cur = all[i].split('|');
                    ajoutMsg(cur[0],cur[1],cur[2]);
                };
                document.getElementById('scrollpane').scrollTop = document.getElementById('scrollpane').scrollHeight;
            }
            stop_loading();
        }
    }
    xhr.open("POST","../ajax/getNouveauMsg.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send("id="+id);
}

function getConversation(selected){
    loading();
    var xhr = getXhr();
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            document.getElementById('liste').innerHTML = xhr.responseText;
            stop_loading();
            notif();
        }
    }
    xhr.open("POST","../ajax/getOpenConversations.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send("selected="+selected);
}

function sendMsg(id){
    if (id==-1 || /^\s*$/.test(document.getElementById('buffer').value)) {
        return;
    }
    var msg = document.getElementById('buffer').value.replace(/<(?:.|\n)*?>/gm, '');
    loading();
    var xhr = getXhr();
    document.getElementById('buffer').value = "";
    ajoutMsg("Vous",timestamp(),urlify(msg));
    document.getElementById('scrollpane').scrollTop = document.getElementById('scrollpane').scrollHeight;
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            stop_loading();
        }
    }
    xhr.open("POST","../ajax/sendNouveauMsg.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send("id="+id+"&msg="+msg);
}

function openConversation(id){
    if (id<0) {
        return;
    }
    current = id;
    loading();
    var selct = document.getElementsByClassName("selected");
    if (selct.length>0) {
        selct[0].setAttribute("class","");
    };
    if (document.getElementById("c" + id)) {
        document.getElementById("c" + id).setAttribute("class","selected");
    };
    var xhr = getXhr();
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            if (xhr.responseText!="") {
                var all = xhr.responseText.split('#\n');
                document.getElementById('scrollpane').innerHTML = "<h2>" + all[0] + "</h2>";
                last = "";
                for (var i = 1; i<all.length; i++) {
                    var courant = all[i].split('|');
                    ajoutMsg(courant[0],courant[1],urlify(courant[2]));
                    if (i==all.length-1) {
                        last = courant[0];
                    };
                };
                document.getElementById('scrollpane').scrollTop = document.getElementById('scrollpane').scrollHeight;
            }
            stop_loading();
            document.getElementById('buffer').focus();
        }
    }
    xhr.open("POST","../ajax/getConversationCourante.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send("id="+id);
}

function getInfoContact(i){
    if (i<0) {
        return;
    };
    current = i;
    var selct = document.getElementsByClassName("selected");
    if (selct.length>0) {
        selct[0].setAttribute("class","");
    };
    if (document.getElementById("c" + i)) {
        document.getElementById("c" + i).setAttribute("class","selected");
    };
    var xhr = getXhr();
    // On défini ce qu'on va faire quand on aura la réponse
    xhr.onreadystatechange = function(){
        // On ne fait quelque chose que si on a tout reçu et que le serveur est ok
        if(xhr.readyState == 4 && xhr.status == 200){
            var leselect = xhr.responseText;
            // On se sert de innerHTML pour rajouter les options a la liste
            document.getElementById('contact').innerHTML = leselect;
            stop_loading();
        }
    }
    loading();
    xhr.open("POST","../ajax/getInfoContact.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send("id_etu="+i);
}

function getContacts(current){
    var xhr = getXhr();
    // On défini ce qu'on va faire quand on aura la réponse
    xhr.onreadystatechange = function(){
        // On ne fait quelque chose que si on a tout reçu et que le serveur est ok
        if(xhr.readyState == 4 && xhr.status == 200){
            var listecontact = xhr.responseText;
            document.getElementById('liste').innerHTML = listecontact;
            stop_loading();
        }
    }
    loading();
    xhr.open("POST","../ajax/getAllContacts.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send("id="+current);
}

function supprContact(i){
    var xhr = getXhr();
    // On défini ce qu'on va faire quand on aura la réponse
    xhr.onreadystatechange = function(){
        // On ne fait quelque chose que si on a tout reçu et que le serveur est ok
        if(xhr.readyState == 4 && xhr.status == 200){
            if (xhr.responseText!=1) {
                alert(xhr.responseText);
            };
            document.getElementById('contact').innerHTML = "";
            // BUGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGG
            getContacts();
            stop_loading();
        }
    }
    loading();
    xhr.open("POST","../ajax/sendSupprContact.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send("id_contact="+i);
}

function faireDemandeAmis(i)
{
    var xhr = getXhr();
    // On défini ce qu'on va faire quand on aura la réponse
    xhr.onreadystatechange = function(){
        // On ne fait quelque chose que si on a tout reçu et que le serveur est ok
        if(xhr.readyState == 4 && xhr.status == 200){
            document.getElementById("buttonAdd").remove();
            document.getElementById("textAdd").innerHTML="Demande de contact envoyé.";
            stop_loading();
        }
    }
    loading();
    xhr.open("POST","../ajax/sendDemandeContact.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send("id_contact="+i);
}

function acceptRequest(i)
{
    var xhr = getXhr();
    // On défini ce qu'on va faire quand on aura la réponse
    xhr.onreadystatechange = function(){
        // On ne fait quelque chose que si on a tout reçu et que le serveur est ok
        if(xhr.readyState == 4 && xhr.status == 200){
            notif();
            document.getElementById("r"+i).remove();
            stop_loading();
        }
    }
    loading();
    xhr.open("POST","../ajax/sendAccepteContact.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send("id_contact="+i);
}

function deleteRequest(i)
{
    var xhr = getXhr();
    // On défini ce qu'on va faire quand on aura la réponse
    xhr.onreadystatechange = function(){
        // On ne fait quelque chose que si on a tout reçu et que le serveur est ok
        if(xhr.readyState == 4 && xhr.status == 200){
            notif();
            document.getElementById("r"+i).remove();
            stop_loading();
        }
    }
    loading();
    xhr.open("POST","../ajax/sendRefuseContact.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send("id_contact="+i);
}


function ajoutVoyage(){
    var xhr = getXhr();
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
			var leselect = xhr.responseText;
			if(leselect == "true"){
				pop_close();
			}else{
				document.getElementById("err").innerHTML = leselect;
			}
			stop_loading();
            getVoyages();
        }
    }
    loading();
    xhr.open("POST","../ajax/sendFormVoyage.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	
	v_dep = document.getElementById("v_dep").value;
	v_arr = document.getElementById("v_arr").value;
	d_dep = addZero(document.getElementById("d_dep_j").value) + "/" + addZero(document.getElementById("d_dep_m").value) + "/" + addZero(document.getElementById("d_dep_a").value);
	d_arr = addZero(document.getElementById("d_arr_j").value) + "/" + addZero(document.getElementById("d_arr_m").value) + "/" + addZero(document.getElementById("d_arr_a").value);
	rec = document.getElementById("rec").value;
	
    xhr.send("v_dep="+v_dep+"&v_arr="+v_arr+"&d_dep="+d_dep+"&d_arr="+d_arr+"&rec="+rec);
}

function modVoyage(){

    mod_id = document.getElementById("mod_id").value;
    v_dep = document.getElementById("v_dep").value;
    v_arr = document.getElementById("v_arr").value;

    var xhr = getXhr();
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            var leselect = xhr.responseText;
            if(leselect == "true"){
                pop_reset();
                voyage(mod_id,v_dep + ' → ' + v_arr);
            }else{
                document.getElementById("err").innerHTML = leselect;
            }
            stop_loading();
            getVoyages();
        }
    }
    loading();
    xhr.open("POST","../ajax/sendFormVoyage.php",true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

    d_dep = addZero(document.getElementById("d_dep_j").value) + "/" + addZero(document.getElementById("d_dep_m").value) + "/" + addZero(document.getElementById("d_dep_a").value);
    d_arr = addZero(document.getElementById("d_arr_j").value) + "/" + addZero(document.getElementById("d_arr_m").value) + "/" + addZero(document.getElementById("d_arr_a").value);
    rec = document.getElementById("rec").value;
    
    xhr.send("mod_id="+mod_id+"&v_dep="+v_dep+"&v_arr="+v_arr+"&d_dep="+d_dep+"&d_arr="+d_arr+"&rec="+rec);
}