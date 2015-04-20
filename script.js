function recupDate() {
	var date = document.getElementById("inpDate").value;
	var jour = date.substring(0, 2);
	var mois = date.substring(3, 5);
	var annee = date.substring(6, 10);
	if (date === "" | isNaN(jour) | jour==="" | isNaN(mois) | mois==="" | isNaN(annee) | annee==="") {
		var hier = new Date(new Date().getTime()-(24*60*60*1000));
		var jour = ('0'+hier.getDate()).slice(-2);
		var mois = ('0'+(hier.getMonth()+1)).slice(-2);
		var annee = hier.getFullYear();
		document.getElementById("inpDate").value = jour + "/" + mois + "/" + annee ;
	}
	date = annee + mois + jour;
	return (date);
}

function infoMatch (dirMatch) {
	$.getJSON('games/'+dirMatch+'/boxscore.json',
		function(data) {
			var v = data.sports_content.game.visitor;
			var h = data.sports_content.game.home;
			$('#contenu').html(v.city + ' ' + v.nickname + ' (' + v.score + ') @ ' + h.city + ' ' + h.nickname + ' (' + h.score + ')');
		});
}

function chargeDate() {
	// fonction lancé lorsque la page est chargée
	var date = recupDate();
	$('nav:first').html('');
	$('#contenu').html('');
	$.getJSON('games/'+date+'/games.json',
		function(data) {
			// on va faire un menu
			$('nav:first')
				.append($(document.createElement('div'))
							.addClass("date")
							.click(function() { chargeDate() })
							.html($('#inpDate').val())
						)
				.append($(document.createElement('ul')));
            if (data.sports_content.games !== "") {
                $.each(data.sports_content.games.game, 
                    function(i, m) {
                        $('nav:first ul')
                            .append($(document.createElement('li'))
                                        .click(function() { infoMatch(date + '/' + m.id); })
                                        .html(m.visitor.nickname+'@'+m.home.nickname)
                            )
                        });

                $('#contenu')
                    .append($(document.createElement('div'))
                                .addClass("resume")
                                .append($(document.createElement('h2')).html('Résumé de la soirée'))
                                .append($(document.createElement('p'))
                                            .html(data.sports_content.games.game.length + ' matchs, ' + 
                                                    $.map(data.sports_content.games.game, 
                                                            function(m) { return (parseInt(m.visitor.score)+parseInt(m.home.score)) })
                                                        .reduce(function(a, b) { return (a+b) }) + ' points marqués')
                                        )
                            );
            }
            else {
                $('#contenu').html("Il n'y a pas eu de match pour la date indiquée.");
            }
		})
		.fail(function(e) { $('#contenu').html("Cette date ne fait pas partie de la saison régulière 2014-2015."); });
}