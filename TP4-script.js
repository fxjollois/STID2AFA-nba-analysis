var teamColors = {
    "Celtics": "#009933",
    "Knicks": "#f36f21",
    "Trail Blazers": "#000000",
    "Cavaliers": "#C40012",
    "Hawks": "#C50000",
    "Kings": "#724c9f",
    "Mavericks": "#0E57A7",
    "Pistons": "#F0174A",
    "Timberwolves": "#005083",
    "Heat": "#B22432",
    "Nets": "#464646",
    "Raptors": "#DE2129",
    "Spurs": "#BABDC6",
    "Warriors": "#FEC547",
    "Bucks": "#BD303A",
    "Clippers": "#01326C",
    "Hornets": "#008CA8",
    "Lakers": "#AD4A84",
    "Nuggets": "#FCB216",
    "Rockets": "#E3072E",
    "Suns": "#D45A0A",
    "Wizards": "#004273",
    "Bulls": "#A40808",
    "Grizzlies": "#444868",
    "Jazz": "#091965",
    "Magic": "#0099F0",
    "Pacers": "#FDBB33",
    "76ers": "#ED174C",
    "Thunder": "#007DC3",
    "Pelicans": "#002B5C"
    };
          
function recupDate() {
    'use strict';
	var date = document.getElementById("inpDate").value,
        jour = date.substring(0, 2),
        mois = date.substring(3, 5),
        annee = date.substring(6, 10);
	if ((date === "") || (isNaN(jour)) || (jour === "") || (isNaN(mois)) || (mois === "") || (isNaN(annee)) || (annee === "")) {
		date = new Date(new Date().getTime() - (24 * 60 * 60 * 1000));
		jour = ('0' + date.getDate()).slice(-2);
		mois = ('0' + (date.getMonth() + 1)).slice(-2);
		annee = date.getFullYear();
		document.getElementById("inpDate").value = jour + "/" + mois + "/" + annee;
	}
	date = annee + mois + jour;
	return (date);
}

function infoMatch(dirMatch) {
    'use strict';
    function addRows(table, info, visi, home, vcol, hcol) {
        visi = parseFloat(visi);
        home = parseFloat(home);
        var row = table.insertRow(table.rows.length),
            valv = row.insertCell(0),
            vali = row.insertCell(1),
            valh = row.insertCell(2),
            max = (info.indexOf('%') == -1) ? Math.max(visi, home) : 100;
        valv.innerHTML = '<div style="float:right;background-color:' + vcol + ';width:'+Math.round(visi/max*200)+'px;">&nbsp;</div>';
        vali.innerHTML = info;
        valh.innerHTML = '<div style="float:left;background-color:' + hcol + ';width:'+Math.round(home/max*200)+'px;">&nbsp;</div>';
    }
    function totalRebounds(e) {
        var off = parseInt(e.stats.rebounds_offensive, 10),
            def = parseInt(e.stats.rebounds_defensive, 10),
            tot = off + def;
        return (tot);
    }
    $.getJSON('games/'+dirMatch+'/boxscore.json',
		function(data) {
			var v = data.sports_content.game.visitor,
                vcol = teamColors[v.nickname],
                h = data.sports_content.game.home,
                hcol = teamColors[h.nickname],
                tab = document.createElement('table');
            tab.insertRow(0).innerHTML = '<tr><th>' + v.city + ' ' + v.nickname + '</th><th>@</th><th>' + h.city + ' ' + h.nickname + '</th></tr>';
            addRows(tab, 'Pts', v.score, h.score, vcol, hcol);
            addRows(tab, '% tirs', v.stats.field_goals_percentage, h.stats.field_goals_percentage, vcol, hcol);
            addRows(tab, '% 3pts', v.stats.three_pointers_percentage, h.stats.three_pointers_percentage, vcol, hcol);
            addRows(tab, '% LF', v.stats.free_throws_percentage, h.stats.free_throws_percentage, vcol, hcol);
            addRows(tab, 'Reb Off', v.stats.rebounds_offensive, h.stats.rebounds_offensive, vcol, hcol);
            addRows(tab, 'Reb Def', v.stats.rebounds_defensive, h.stats.rebounds_defensive, vcol, hcol);
            addRows(tab, 'Rebonds', totalRebounds(v), totalRebounds(h), vcol, hcol);
            addRows(tab, 'Passes', v.stats.assists, h.stats.assists, vcol, hcol);
            addRows(tab, 'Contres', v.stats.blocks, h.stats.blocks, vcol, hcol);
            addRows(tab, 'Inter.', v.stats.steals, h.stats.steals, vcol, hcol);
            addRows(tab, 'Bal. perdus', v.stats.turnovers, h.stats.turnovers, vcol, hcol);
            $('#contenu').html(tab);
		});
}

function chargeDate() {
    'use strict';
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
      	var allBoxscore = [];
      	var allGet = [];
        $.each(data.sports_content.games.game, 
          function(i, m) {
            $('nav:first ul')
              .append($(document.createElement('li'))
                    .click(function() { infoMatch(date + '/' + m.id); })
                    .html(m.visitor.nickname+'@'+m.home.nickname)
              )
            allGet.push($.getJSON('games/'+date+'/'+m.id+'/boxscore.json').done(function(e) {
            		allBoxscore.push(e.sports_content.game);
            	}));
            });
								
				$.when.apply(null, allGet)
					.done(function () { 
						var maxPlScore = allBoxscore.map(function(e) {
								return e.visitor.players.player.concat(e.home.players.player)
									.reduce(function(o, n) {
										if (parseInt(n.points) > parseInt(o.points)) return n;
										return o;
									});
							})
							.reduce(function(o, n) {
								if (parseInt(n.points) > parseInt(o.points)) return n;
								return o;
							});
		        $('#contenu').append($(document.createElement('div'))
                .addClass("resume")
                .append($(document.createElement('h2')).html('Résumé de la soirée'))
                .append($(document.createElement('p'))
                      .html(data.sports_content.games.game.length + ' matchs, ' + 
                          $.map(data.sports_content.games.game, 
                              function(m) { return (parseInt(m.visitor.score)+parseInt(m.home.score)) })
                            .reduce(function(a, b) { return (a+b) }) + ' points marqués')
                    ))
                .append($(document.createElement('p'))
                	.html('Meilleur marqueur : ' + maxPlScore.first_name + ' ' + maxPlScore.last_name + ' (' + maxPlScore.points + ' points)'));
        });

      }
      else {
                $('#contenu').html("Il n'y a pas eu de match pour la date indiquée.");
            }
		})
		.fail(function(e) { $('#contenu').html("Cette date ne fait pas partie de la saison régulière 2014-2015."); });
}