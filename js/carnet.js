
/*
 * CARNET les bares de progression
 */
carnet = {
	init: function() {
		console.info("carnet.init")

		$( ".accordion" ).accordion({
			collapsible: true
		})
	},
}

/*
 * CARNET le diagramme de la moyenne
 */
moyenne = {

	init: function(){

		 var gaugeOptions = {

		        chart: {
		            type: 'solidgauge',
		            width: 150,
		            height: 170,
		            spacing: [0,0,0,0]
		        },

		        title: null,

		        pane: {
		            size: '70%',
		            center: ['50%', '35%'],
		            startAngle: 0,
		            endAngle: 360,
		            background: {
		                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
		                innerRadius: '60%',
		                outerRadius: '100%',
		                shape: 'circle'
		            }
		        },

		        tooltip: {
		            enabled: false
		        },

		         // the value axis
		        yAxis: {
		            stops: [
		            	[0.1, '#C70000'],
		            	[0.2, '#D53600'],
		            	[0.3, '#E36C01'],
		            	[0.4, '#F1A202'],
		            	[0.5, '#FFD903'],
		            	[0.6, '#a8d102'],
		            	[0.7, '#8EBF05'],
		            	[0.8, '#56B206'],
		            	[0.9, '#1EA607']
		            ],
		            lineWidth: 0,
		            minorTickInterval: null,
		            tickPixelInterval: 400,
		            tickWidth: 0,
		            title: {
		                y: 100
		            },
		            labels: {
		                y: 16
		            }
		        },

		        plotOptions: {
		            solidgauge: {
		                dataLabels: {
		                    y: 5,
		                    borderWidth: 0,
		                    useHTML: true
		                }
		            }
		        }
		    }; //fin gaugeOptions

		    // The speed gauge


		    $('#container-speed').highcharts(Highcharts.merge(gaugeOptions, {
		        yAxis: {
		            min: 0,
		            max: 100,
		            title: {
		                text: 'Nutriscore',
		                style: {'fontSize': '18px'}
		            },
		            labels: {
		                enabled: false
		            }
		        },

		        credits: {
		            enabled: false
		        },

		        series: [{
		            data: [nutriscore],
		            dataLabels: {
		                format: '<div style="text-align:center"><span style="font-size:15px;color:' +
		                    ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}%</span>',
		                verticalAlign: 'middle'
		            },
		            tooltip: {
		                valueSuffix: ' %'
		            }
		        }]

		    }));
	}
}

/*
 * infoBull
 */
infoBull = {
	init: function() {
		console.info("infoBull.init")

		$('.question').on("click", infoBull.afficherBull)
	},

	ctrlbull: 0,

	afficherBull: function(e) {

		console.info("infoBull.afficherBull")

		if(infoBull.ctrlbull == 0){

			$(document).on("click", infoBull.cacherBull)

			//var target = $('.question').parents()[1].id + ' .info'

			var target = $(e.target);
			var targetPos = target.offset()
			var id = $(e.target).parents('.nutriement').attr('id');

			// Effacer l'ancien
			$('.info').hide()

			// Creer une bulle d'info
			/*var info = $('<div>',{
				class: "info"
			})*/
			var info = $('#info-'+id);

			// Ajouter dans la div content
			$('body').append(info)

	        // Ajuster les coordonnées de l'infoBulle
	        $(info).css('top', targetPos.top - info.height() + 15)
	        $(info).css('left', targetPos.left - info.width() - 65)

	        // Faire apparaitre l'infoBulle avec un effet fadeIn
	        $(info).fadeIn('500')
	        $(info).fadeTo('10',0.8)

	        e.stopPropagation()
	        infoBull.ctrlbull++

		} else{
			infoBull.cacherBull()

		}
	},

	ajusterBull: function(e){
		console.info("infoBull.ajusterBull")

		// Ajuster la position de l'infoBulle au déplacement de la souris
        $('.info').css('top', e.pageY + 0 );
        $('.info').css('left', e.pageX + 0 );
	},

	cacherBull: function(e){
		console.info("infoBull.cacherBull")

		// Réaffecter la valeur de l'attribut title
        //$(this).attr('title',$('.info').html());

        // Supprimer notre infoBulle
       // $(this).children('div.info').remove();

       $('.info').hide();

       infoBull.ctrlbull=0
	}
}

$(function(){
	carnet.init()
	moyenne.init()
	infoBull.init()
})