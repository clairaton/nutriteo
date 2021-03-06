/*
 * GLOBALE VARIABLE
 */
cible_tem = ""
nextCible_tem = ""
i = 0
j = 0
list_consom = [];
quanti_globale_portion = 0.3

/*
 * ADDFOOD MODULE PAGE
 */
addfood = {
	init: function() {
		console.info("addfood.init")
		$('.element-tab-addfood').on("click", addfood.openTabChoix)

		//Ecouter sur les boutons + et - pour ajouter ou enlever les portions
		$('.btnPlusAli').on("click", addfood.choixAliments)
		$('.btnMoinsAli').on("click", addfood.choixAliments)

		//Ajouter un bouton + pour diriger vers la page suggestion
		$('.caseAddFoodPlus').on("click", function(){
			document.location.href="suggestion.php";
		})

		//Ecouter le bouton de submit
		$('#tableau-aliments').on('submit', function(e){

			e.preventDefault()

			$('html, body').animate({
	        	scrollTop: 0,
	    	}, 500);

			console.log(this.id)
			$.ajax({
				method: "POST",
				url: 'addfood.php',
				/*dataType: "JSON",*/
				data: 'list_consom='+JSON.stringify(list_consom),
				success: addfood.AddFoodToAddPhysique
			})
			/*.done(function( msg ) {

				if (msg.result == '1') {
					location.href = 'carnet.php';
				}
			});*/
		})
		$('body').on("click", "#bt-oui", function(){document.location.href="activites.php"})
		$('body').on("click", "#bt-non", function(){document.location.href="carnet.php"})

		//Ecouter le bouton addFoof .btn-addFood
		$("body").on("click", ".btn-addFood", addfood.addFoodBox)
		$("body").on("click", "#annuler", addfood.addFoodBoxClose)
		//initialisation de la variable add_food_box_html
		$.ajax({
			url: "searchFoodContent.php",
			success: addfood.addFoodBoxContent
		})

		//Autocompletion
		$("body").on("click", "#search-food", addfood.searchAutoComplet)
		$("body").on("autocompleteselect", "#search-food", addfood.foodSelected)

	},

	searchAutoComplet: function(e){
		console.info("addfood.searchAutoComplet")
		$(this).autocomplete({source: addfood.list_food})
	},

	list_food: [],

	foodSelected: function(e, ui){
		console.info("addfood.foodSelected")
		console.log($(this).val())
		console.log(ui.item.value)
		var div = $("<div>", {class: "food-select"})
		var span = $("<span>", {class: "glyphicon glyphicon-star-empty", ariaHidden: "true"})
		var checkbox = $("<input>", {type: "checkbox"})
		var p = $("<p>").html(ui.item.value)
		var div_portion = $("<div>", {class: "portion-form"})
		var portion = $("select", {class: "form-control", name: "portion"})
		var portion_option = $("option").text("1 Portion")

		portion.append(portion_option)

		div_portion.append(portion)
					.append(" / 70g")

		div.append(span)
			.append(checkbox)
			.append(p)
			.append(div_portion)

		$("#result-search").append(div)
	}, 
	
	addFoodBox: function(e){
		console.info("addfood.addFoodBox")
		var repas = $(this).parent().prev()
		var add_food_box = repas.next()
		add_food_box.html("")
					.removeClass('add_item')
					.addClass('item-adding', 800)
		add_food_box.html(addfood.add_food_box_html)
	},

	addFoodBoxClose: function(e){
		console.info("addfood.addFoodBoxClose")
		var repas = $(this).parent().parent().parent().prev()
		var add_food_box = repas.next()

		console.log(add_food_box.attr("class"))
		add_food_box.html("")
					.removeClass('item-adding')
					.addClass('add_item', 800)

		var btn_addFood = $('<button>')
		btn_addFood.addClass("btn-addFood")
		var span = $("<span>")
		span.addClass("glyphicon glyphicon-plus")
		
		btn_addFood.html(span)
					.append(" Ajouter un aliment")

		add_food_box.html(btn_addFood)
	},

	addFoodBoxContent: function(html){
		console.info("addfood.addFoodBoxContent")
		addfood.add_food_box_html = html
	},

	add_food_box_html: "",

	AddFoodToAddPhysique: function(html){
		console.info("addfood.responseAddFood")
		popup.init("AddFoodToAddPhysique")

		//recuperation de la page inscription
		$.ajax({
			url: "html/food_to_physique.html",
			success: popup.afficher
		})
	},

	openTabChoix: function(e) {
		console.info("addfood.opentabchoix")

		e.preventDefault()

		//Récupérer id
		var cible = "#" + e.currentTarget.id + " .tab-choix"

		if($("#" + e.currentTarget.id).next().length == 1)
			var nextCible = "#" + ($("#" + e.currentTarget.id).next())[0].id
		else nextCible = ""

		//Fermer le récent tableau
		if(cible_tem != "" && cible_tem != cible && e.target.className != 'caseAddFood' && e.target.className != 'btnPlusAli' && e.target.className != 'btnMoinsAli' && e.target.localName != 'img')
			addfood.fermerTab(cible_tem, nextCible_tem)
		if(cible == cible_tem && i%2 != 0 && e.target.className != 'caseAddFood' && e.target.className != 'btnPlusAli' && e.target.className != 'btnMoinsAli' && e.target.localName != 'img')
			addfood.fermerTab(cible_tem, nextCible_tem)

		//Afficher le tableau de choix en cours
		if(e.target.className != 'caseAddFood' && e.target.className != 'btnPlusAli' && e.target.className != 'btnMoinsAli' && e.target.className != 'tabchoix' && i%2 == 0)
			addfood.afficherTab(cible, nextCible)

		if(e.target.className != 'caseAddFood' && e.target.className != 'btnPlusAli' && e.target.className != 'btnMoinsAli' && e.target.className != 'tabchoix' && cible_tem != cible && i%2 != 0)
			addfood.afficherTab(cible, nextCible)

		cible_tem = cible
		nextCible_tem = nextCible
		if(cible == cible_tem && e.target.className != 'caseAddFood' && e.target.className != 'btnPlusAli' && e.target.className != 'btnMoinsAli' && e.target.localName != 'img')
			i++
	},

	afficherTab: function(cible, nextCible) {
		console.info("addfood.afficherTab")

		var tar = cible.split(" ")
		var rotateIcon = tar[0] + " span"
		var bouton = tar[0] + ' .btn'
		var case_id = tar[0].substring(1) + '-c'

		if(nextCible.length != 0) {
			//Mettre une espace entre 2 onglets
			$(nextCible).animate({
				marginTop: 710,
			}, 500)

			$('html, body').animate({
	        	scrollTop: $(tar[0]).offset()
	    	}, 500);

			//Ouvrir le tableau
			$(cible).show().animate({
				height: 700,
			}, 500, function(){

				//Mettre en place le bouton submit
				$(bouton).show()

				//Rotation de l'icon
				$(rotateIcon).addClass("active")
			})
		}
		else {
			//Ouvrir le tableau
			$(cible).show().animate({
				height: 700,
			}, 500)

			$('html, body').animate({
	        	scrollTop: $(tar[0]).offset()
	    	}, 500);

			//Mettre une espace entre 2 onglets
			$("#subm").animate({
				marginTop: 710,
			}, 500, function(){

				//Mettre en place le bouton submit
				$(bouton).show()

				//Rotation de l'icon
				$(rotateIcon).addClass("active")
			})
		}
	},

	fermerTab: function(cible, nextCible) {
		console.info("addfood.fermerTab")

		var tar = cible.split(" ")
		var rotateIcon = tar[0] + " span"
		var bouton = tar[0] + ' .btn'

		if(nextCible != "") {
			//Cacher le bouton submit
			$(bouton).hide()

			//Monter l'espace entre 2 onglets
			$(nextCible).animate({
				marginTop: 0,
			}, 500)

			$(cible).fadeOut().animate({
				height: 0,
			}, 500, function(){
				$(cible).hide()

				//Rotation de l'icon
				$(rotateIcon).removeClass("active")
			})
		}
		else {

			//Cacher le bouton submit
			$(bouton).hide()

			//Monter l'espace entre 2 onglets
			$("#subm").animate({
				marginTop: 0,
			}, 500)

			$(cible).fadeOut().animate({
				height: 0,
			}, 500, function(){
				$(cible).hide()


				//Rotation de l'icon
				$(rotateIcon).removeClass("active")
			})
		}
	},

	choixAliments: function(e) {
		console.info('addfood.choixAliments')

		// Arreter le rechargement du page
		e.preventDefault()
		var incre = 0

		// Detecter le bouton plus ou moins
		if(e.target.className == 'btnMoinsAli') {
			incre = 0
		}
		else if(e.target.className == 'btnPlusAli') {
			incre = 1
		}

		var find_case = 0

		//Recuperer l'id de la case
		var case_incre = e.target.parentElement.id

		//Comparer avec le tableau qui contient des portions
		for(var j = 0; j < list_consom.length; j++) {
			if(list_consom[j].nom == '#' + case_incre) {
				find_case = 1
				break
			}
		}

		//Dans le cas qu'il n'y a pas encore dans le tableau
		if(find_case == 0) {
			//Creer un nouveau objet
			var elem = {
				nom: '#' + case_incre,
				quantite: 0,
			}

			//Ajouter dans le tableau global
			list_consom.push(elem)

			//Click sur le bouton +, le notification affiche le chiffre augmenté
			if(incre == 1)
			{
				elem.quantite += quanti_globale_portion
				$(elem.nom + ' .notiAli').text(addfood.arrondi(elem.quantite, 10))
			}

			//Click sur le bouton -, le notification affiche le chiffre diminué
			if(incre == 0)
				if($(elem.nom + ' .notiAli').text() <= 0){
					elem.quantite = 0
					$(elem.nom + ' .notiAli').text(addfood.arrondi(elem.quantite, 10))
				}
				else
				{
					elem.quantite -= quanti_globale_portion
					$(elem.nom + ' .notiAli').text(addfood.arrondi(elem.quantite, 10))
				}
		}

		// Dans le cas qu'il existe deja
		if(find_case == 1) {
			if(incre == 1)
			{
				list_consom[j].quantite += quanti_globale_portion
				$(list_consom[j].nom + ' .notiAli').text(addfood.arrondi(list_consom[j].quantite, 10))
			}
			if(incre == 0)
				if($(list_consom[j].nom + ' .notiAli').text() <= 0) {
					list_consom[j].quantite = 0
					$(list_consom[j].nom + ' .notiAli').text(addfood.arrondi(list_consom[j].quantite, 10))
				}
				else
				{
					list_consom[j].quantite -= quanti_globale_portion
					$(list_consom[j].nom + ' .notiAli').text(addfood.arrondi(list_consom[j].quantite, 10))
				}
		}

	},

	arrondi: function(nbr, limit){
		console.info("addfood.arrondi")
		var nombre =nbr
		arrondi = nombre*limit
		arrondi = Math.round(arrondi)
		arrondi = arrondi/limit
		return arrondi
	}
}

/*addfoodNew = {
	
	init: function() {
		console.info("addfoodNew.init")
		$(".addfood button").on("click", addfoodNew.open)
	},

	open: function(e) {
		console.info("addfoodNew.open")
		$(this).hide()
	}
}*/

/*
 * Chargement du DOM
 */
$(function(){
	addfood.init()
	/*addfoodNew.init()*/
})