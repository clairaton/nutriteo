activ_header = '#carnet'
next_header = ''

/*
 * FAQ MODULE PAGE
 */
faq = {
	init: function() {
		console.info("faq.init")

		$( ".accordion" ).accordion({
			collapsible: true
		})
	},
}

/*
 * Sidebare
 */

sidebar = {

	init: function(){
		console.info("sidebar.init")

		// On ecoute le click sur le burger pour afficher
		$("#burger").on("click", sidebar.afficher)


		//$(document).on("click", sidebar.cacher)
	},

	afficher: function(){
		console.info("sidebar.afficher")

		// Le burger disparait
		//$("#burger").hide()

		// On rajoute un peu de css
		$(".sidebar").css({
			top: 45,
			position: "fixed"
		})

			$(".sidebar").slideToggle()
		// On affiche la sidebar
		/*if(this.id == "sidebar-gloss"){
			$("#sidebar-gloss").slideToggle()
		}else{

		}*/


	},

/*
	cacher: function(e){
		console.info("sidebar.cacher")

		if (e.target.id != 'burger') {
			// On affiche la sidebar
			$(".sidebar").slideUp()
		}
	}*/
}

/*
 * profil
 */

 profil = {

	init: function(){
		console.info("profil.init")

		$(document).ready(profil.modifier)
		$(".edit").on("click", profil.modifier)
		$('#upload_avatar').on('change', profil.submit);
		$('#user-submit').on('click', profil.submitGlobale);
	},

	modifier: function(e){
		console.info("profil.modifier")
		console.log($(this).next().attr("id"))


		if($(this).next().attr("id") == "size-profil"){
			$("#size-profil").css({
				display: "inline-block",
			})
		}else if($(this).next().attr("id") == "weight-profil"){
			$("#weight-profil").css({
				display: "inline-block",
			})
		}else{
			// ecouter le click sur le stylot
			$('.edit').click(function() {
				$(this).next('input').attr('type', 'text');
			})

			// ecouter le click pour la date
			$('.edit-date').click(function() {
				$(this).next('input').attr('type', 'date');
			})
		}
	},

	submit: function() {
		console.info("profil.submit")

		$('#form-profil').submit();

	},

	submitGlobale: function() {
		console.info("profil.submitGlobale")

		$('<p>').text("Votre modification a été enregistré").appendTo($("#bloc-submit-profil"))
	}
}


app = {
	/*
	 * Fonction appelée au chargement du DOM
	 */
	init: function() {
		console.info("app.init")

		$('.collapse').collapse()
	},
}

/*
 * Chargement du DOM
 */
$(function(){

	app.init()
	faq.init()
	sidebar.init()
	profil.init()
})