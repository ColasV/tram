$(function(){
	//"Surveillance du champ "Recherche" avec la méthode jQuery "keyup"
	$("#champ_recherche").keyup(function(){
		//on efface le champ résultat
		$("#resultat").html('');
		var loc = window.location;
		//Si le champ "Recherche" contient plus d'un caractère, l'appel Ajax est déclenché
		if ($("#champ_recherche").val().length>1){
			console.log
			$.ajax({
				type:'GET',
				url:'/api' + window.location.pathname,
				//on envoi ici des informations au script php "rechercheajaxphp.php",
				//le script php va recevoir l'info (data) sous la forme $_POST['recherche']
				//comme si la variable avait été envoyée par le formulaire directement
				//(utile en l'absence de JavaScript)
				data: {
					"search":$("#champ_recherche").val()
				},
				//Avant d'envoyer les infos, on fait apparaître le loader
				beforeSend:function(){$("img[alt='loader']").css("display","inline");},
				//Le script php nous a renvoyé du HTML (paramètre "code_html"
				//contenant le fruit de la recherche dans la base de données)
				success:function(code_html){
					//on fait disparaître le loader
					$("img[alt='loader']").css("display","none");
					//on fait apparaître le résultat dans la div d'id "resultat"
					//console.log(code_html);
                                        var out = "";
                                        for(i = 0; i<code_html.length; i++) {
                                            out += '<li class="list-group-item">'
                                            + '<a href="' + window.location.pathname + '/' + code_html[i].code + '">' + code_html[i].name + '</a>';
                                           if(code_html[i].agent) {
                                            out += '<a href="#" rel="popover" id="' + code_html[i].code + '"class="pull-right pop">'
                                              +  '<img src="/images/red-dot.png" />'
                                            + '</a>';
                                           }
                                           out += '</li>';
                                        }
                                        //console.log(out);
					$("#resultat").html(out);
				}
			});
		}
		else {
			$.ajax({
				type:'GET',
				url:'/api' + window.location.pathname,
				//on envoi ici des informations au script php "rechercheajaxphp.php",
				//le script php va recevoir l'info (data) sous la forme $_POST['recherche']
				//comme si la variable avait été envoyée par le formulaire directement
				//(utile en l'absence de JavaScript)
				data: {
					"search":$("#champ_recherche").val()
				},
				//Avant d'envoyer les infos, on fait apparaître le loader
				beforeSend:function(){$("img[alt='loader']").css("display","inline");},
				//Le script php nous a renvoyé du HTML (paramètre "code_html"
				//contenant le fruit de la recherche dans la base de données)
				success:function(code_html){
					//on fait disparaître le loader
					$("img[alt='loader']").css("display","none");
					//on fait apparaître le résultat dans la div d'id "resultat"

					$("#resultat").html(code_html);
				}
			});
		}
	});
});
