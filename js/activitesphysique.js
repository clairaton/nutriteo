/*GLOBAL*/
list_activites = []

/*
 * Activitée physique
 */
activitePhysique = {

	init: function(){
		console.info("activitePhysique.init")

		activitePhysique.activPhysique()
		activitePhysique.dureActivitePhysique()

		$('#duration-labels li').on('click', activitePhysique.detectElementSlider)
		$('#activites-labels li').on('click', activitePhysique.detectElementSlider)
	},

	detectElementSlider: function(e) {
		console.info('activitePhysique.detectElementSlider')

		var slider_detect = $('#' + e.target.parentElement.id)[0].previousElementSibling.id

		tab_activite_inverse = {
			"Pas d'activité" : '0%',
			"Normale" : '50%',
			"Intensive" : '100%'
		}

		tab_dureactivite_inverse = {
			"0": '0%',
			"1H": '17%',
			"2H": '33%',
			"3H": '50%',
			"4H": '67%',
			"5H": '83%',
			"6H": '100%',
		}

		tab_dureactivite_trans = {
			"0": '0',
			"1H": '1heure',
			"2H": '2heures',
			"3H": '3heures',
			"4H": '4heures',
			"5H": '5heures',
			"6H": '6heures',
		}

		$('#' + slider_detect + ' span').animate({
			left: tab_activite_inverse[e.target.innerText],
		}, 500, function(){
			if(slider_detect == 'slider_activity')
				$( "#amount" ).val(e.target.innerText)
		})		
			
		$('#' + slider_detect + ' span').animate({
			left: tab_dureactivite_inverse[e.target.innerText],
		}, 500, function(){
			if(slider_detect == 'slider_duration')
				$( "#duration" ).val(tab_dureactivite_trans[e.target.innerText])
		})	
	},

	activPhysique: function() {
		// On definit le min le mex et le nbr d'etapes du slide
		$( "#slider_activity" ).slider({
		      value: 0,
		      min: 0,
		      max: 60,
		      step: 30,
		      slide: function( event, ui ) {
		      	$( "#amount" ).val( tab_activite[ui.value] )
		      }
	    });

		// tableau pour remplacer les chiffre par des phrases
		tab_activite = {
			0 : "Pas d'activité",
			30 : "Normale",
			60 : "Intensive"
		}

		//On append chaque valeur à son etape
		$( "#amount" ).val( tab_activite[$("#slider_activity" ).slider("value")] )
	},


	/*
	 * Durée de l'activitée physique
	 */
	dureActivitePhysique: function() {
		console.info("activitePhysique.dureActivitePhysique")

		$( "#slider_duration" ).slider({
		      value: 0,
		      min: 0,
		      max: 144,
		      step: 12,
		      slide: function( event, ui ) {
		      	$( "#duration" ).val( tab_dureactivite[ui.value] );
		      }
	    });

		tab_dureactivite = {
			0 : "0",
			12 : "30min",
			24 : "1heure",
			36 : "1heure et 30min",
			48 : "2heures",
			60 : "2heures et 30min",
			72 : "3heures",
			84 : "3heures et 30min",
			96 : "4heures",
			108 : "4heures et 30min",
			120 : "5heures",
			132 : "5heures et 30min",
			144 : "6heures",
		}

		$( "#duration" ).val( tab_dureactivite[$("#slider_duration" ).slider("value")] );
	},
}

/*
 * Chargement du DOM
 */
$(function(){
	activitePhysique.init()
})