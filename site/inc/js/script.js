$('.filter-show, .filter-close').click(function(){
	$('.filter-container').toggleClass('show animated zoomIn');
})




$('.filter-btn').click(function()
{
		
	if($('.filter-container').hasClass('show'))
	{
		$('.filter-container').removeClass('show');
	}
	
	$('.loader').show();
	$('.comparison-table table').css({'opacity':'.5'});
	
	var filter = $('form').serialize();
	console.log(filter);
	
	$.ajax({
	  method: "GET",
	  url: "/api/agents",
	  data: filter,
	  dataType: "json",
	  success: function(data){
		  
		  	console.log(data);
		  
			$('table').find("tr:gt(0)").remove();
			var result = [];
			
			$.each(data, function(key, item) { 

				var source   = $("#result-template").html();
				var template = Handlebars.compile(source);
				
				var context = {id: item.id, name: item.name, link: item.link, base_price: item.base_price, base_price_london: item.base_price_london, photos_floorplans: checkValue(item.photos_floorplans), viewings: item.viewings, viewings_london: item.viewings_london, epc: checkValue(item.epc), premium_listing: checkValue(item.premium_listing), trustpilot_average: Math.round(item.trustpilot_average), trustpilot_average_raw: item.trustpilot_average, trustpilot_total: item.trustpilot_total};
				var html    = template(context);
				
				result.push(html);
				
				$('.loader').hide();
				$('.comparison-table table').css({'opacity':'1'});
				
			});
			
			$('.comparison-table table tr:last').after(result);
		}
	})
});


$(".cta").click(function()
{

	$(".reviews__noData").hide();


	var source = $('#modal-template').html();
	var template = Handlebars.compile(source);



	var id = $(this).data('id');
	var name = $(this).data('name');
	var tpRating = $(this).data('tprating');

	var context = {eAId: id, eA: name, rating: tpRating};
	var html    = template(context);

	$('.remodal').prepend(html);
	$('.reviews:last-child').remove();

});

$(document).on('closed', '.remodal', function (e)
{

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


