$('.filter-show, .filter-close').click(function(){
	$('.filter-container').toggleClass('show animated zoomIn');
})

$('.filter-container input, .filter-container select').change(function()
{
		
	if($('.filter-container').hasClass('show'))
	{
		$('.filter-container').removeClass('show');
	}
	
	$('.loader').show();
	$('.comparison-table').css({'opacity':'.5'});
	
	var filter = $('form').serialize();
	console.log(filter);
	
	$.ajax({
	  method: "GET",
	  url: "/api/agents",
	  data: filter,
	  dataType: "json",
	  success: function(data){
		  
		  	console.log(data);
		  
			$('.result-item').remove();
            $('.comparison-table__error').hide();

			var result = [];
			
			$.each(data, function(key, item) { 

				var source   = $("#result-template").html();
				var template = Handlebars.compile(source);
				
				var context = {
					id: 						item.id,
					name: 						item.name,
					link: 						item.link,
					base_price: 				item.base_price,
					base_price_london: 			item.base_price_london,
					photos_floorplans: 			checkValue(item.photos_floorplans),
					viewings: 					item.viewings,
					viewings_london: 			item.viewings_london,
					epc: 						checkValue(item.epc),
					premium_listing: 			checkValue(item.premium_listing),
					trustpilot_average: 		Math.round(item.trustpilot_average),
					trustpilot_average_raw: 	item.trustpilot_average,
					trustpilot_total: 			item.trustpilot_total
				};

				var html = template(context);
				
				result.push(html);
				
				$('.loader').hide();
				$('.comparison-table').css({'opacity':'1'});
				
			});
			
			$('.results').after(result);
		},
        error: function() {
            $('.result-item').remove();
            $('.loader').hide();
            $('.comparison-table').css({'opacity':'1'});
            $('.comparison-table__error').show();

        }
	})
});

$('.filter-section__radio input').change(function(){

	var filterItem = $('#filter-expert-local-agent');

	if($(this).val() == 2) {
		filterItem.closest('.filter-section__label').css({'opacity':.25});
		filterItem.attr('disabled', true);

	} else {
		filterItem.closest('.filter-section__label').css({'opacity':1});
		filterItem.attr('disabled', false);
	}
})


$(document).on('click', '.cta', function() {

	$(".reviews__noData").hide();

	var source = $('#modal-template').html();
	var template = Handlebars.compile(source);

	var id = $(this).data('id');
	var name = $(this).data('name');
	var tpTotal = $(this).data('tptotal');
	var tpAvg = $(this).data('tpavg');

	var context = {
		eAId: id,
		eA: name,
		total: tpTotal,
		average: tpAvg
	};
	var html = template(context);

	console.log(context);

	$('.remodal').prepend(html);
	$('.reviews:last-child').remove();

});

$(document).on('closed', '.remodal', function() {
	$(".reviews").empty();
});


//Prevents 0 having 2 decimal places for currency figures
function checkValue(value)
{
	if(value == 0) {
		return false;
	} else {
		return value.toFixed(2);
	}
}


