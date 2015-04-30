/*
 * INSCRIPTION
 */
inscription = {

 	init: function() {
 		console.info('inscription.init')

 		$('#inscription').on('click', {id: 'popup-register'}, inscription.popup)
 		$('#login').on('click', {id: 'popup-login'}, inscription.popup)
 		//$('#action-button-header').
	 	$('body').on('click', '.choice', inscription.active)
	 			.on('submit', '#form-signup', inscription.getForm)
	 			.on('submit', '#valid-signup', inscription.getForm)
	 			.on('submit', '#form-testAlim', inscription.getForm)
	 			.on('submit', '#form-login', inscription.getForm)
	 			.on('click', '#action-button-header', inscription.popup)

	 	calender.init()
	},

	/****************************************************************
	*	fonction ajoutant la classe active sur les div				*
	*	de la question Comment jugez-vous votre activité sportive ?	*
	*	cette function donne également un valeur à l'élément		*
	*	level (input type=hidden) du formulaire 					*
	*****************************************************************/
	active: function(e) {
 		console.info('inscription.active')

 		//suppresion de la class active
		$('.active').removeClass('active')

		//ajout de la classe active sur l'élément selectionné (e)
		$(this).addClass('active')
	},

	/********************************************************
	*	checkResponse traite la réponse retourné par Ajax 	*
	*	lors du traitement des formulaires inscription 		*
	*********************************************************/
	checkResponse: function(html){
		console.info('inscription.checkResponse')

		var signupOK = $(html).filter(".validOK")
		console.log(signupOK.html())

		if(signupOK.html() != undefined){
			inscription.modifContainer(html)
			console.log("signupOK doit fermer")
			window.setTimeout(popup.fermer, 1500)
			window.location.assign("carnet.php")
		}else{
			inscription.modifContainer(html)
		}


	},

	/********************************************
	*	getForm récupère un forumlaire 			*
	*	et fait l'envoi de celui ci via Ajax 	*
	*	la réponse Ajax est ensuite traité par 	*
	*	la fonction checkResponse 				*
	*********************************************/
	getForm: function(e){
		console.info('inscription.form')

		//arrêt du submit
		e.preventDefault()

		//récupération des attributs du formulaire
		//ainsi que les données
		var url = this.action
		var type = this.method
		var data = $(this).serialize()

		//envoi des données au fichier cible via ajax
		$.ajax({
			url: url,
			type: type,
			data: data,
			success: inscription.checkResponse})
	},

	modifContainer: function(html){
		console.info("inscription.modifContainer")
		var container = $('.container-popup')
		var btFermer = $('#fermer')

		container.html(btFermer)
				.append(html)
				.fadeIn(function() {
					calender.init()
				})
	},

	popup: function(e){

		console.info("inscription.popup")

		var id = e.id
		console.log(id)

		popup.init(id)

		if(this.id == "action-button-header"){
			var url = "inscription.php"
		} else {
			var url = this.id+".php"
		}

		//recuperation de la page inscription
		$.ajax({
			url: url,
			success: popup.afficher
		})
	}
}

/*
 * popup
 */

popup = {

	/*
	 * Créer une popup
	 */
	init: function(popup_id) {


		console.info("popup.init")

		$('.overlay, .container-popup').remove();

		// Créer la popup
		this.obj = $("<div>",{
			id: "popup",
			class: 'overlay',
			css: { // On rajoute le CSS ici
				position: "fixed",
				background: "rgba(0,0,0,.8)",
				width: "100%",
				height: "100%",
				top: 0,
				left: 0,
				zIndex: 10,
				display: "none"
			},
			on: {
				click: popup.exit
			}
		})

		// On crée un container pour faire joli (centré et en blanc)
		this.container = $("<div>",{
			id: popup_id,
			class: "container-popup",
			css: {
				background: "#fff",
				padding: 30,
				margin: "auto",
				marginTop: "3%",
				width: 550,
				position: "absolute",
				top: 0,
				left: '50%',
				marginLeft: '-225px',
				display: "none",
				//width: "100%",
				overflow: 'auto',
				borderRadius: 3,
				zIndex: 11
			},
			on: {
				click: popup.exit
			}
		})

		// On crée un bouton fermer
		var fermer = $("<div>",{
			id: "fermer",
			class: "glyphicon glyphicon-remove",
			css: {
				position: "absolute",
				top: 15,
				right: 15,
				cursor: "pointer",
				padding: 15
			}
		})

		// On ajoute au container le bouton fermer
		// On ajoute container dans popup
		$("body").append(this.obj)
		$("body").append(this.container.append(fermer))
	},

	/*
	 * Afficher la popup
	 */
	afficher: function(html) {
		console.info("popup.afficher")

		// On nettoie
		popup.clean()

		// On rajoute le contenu
		popup.container.append(html)

		// On affiche la popup
		popup.obj.fadeIn(function() {
			popup.container.fadeIn(function() {

				if ($(this).attr('id') == 'popup-register') {
					inscription.init()
				}

			})
		})
	},

	/*
	 * Ferme la popup
	 */
	fermer: function() {
		console.info("popup.fermer")

		// On cache la popup
		popup.container.fadeOut(function() {
			popup.obj.remove()
			popup.container.remove()
		})
	},

	/*
	 * Handler du clic pour fermer
	 */
	exit: function(e) {
		console.info("popup.exit")

		// Si on clique sur le fond noir de la popup
		if (e.target.id == "popup" || e.target.id == "fermer") {
			popup.fermer()
		}
	},

	/*
	 * Nettoyage du popup
	 */
	clean: function() {
		popup.container.children().not("#fermer").remove()
	}

}

calender = {

		init: function() {
		console.info("calender.init")

		var d = new Date();
		var year = d.getFullYear() - 15;
		// Datepicker
		$("#birthday input").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "dd-mm-yy",
			yearRange: "1900:"+year,
			option: $.datepicker.regional["fr"]
		})
	}

}


/*
 * Chargement du DOM
 */
$(function(){
	inscription.init()
	calender.init()
})