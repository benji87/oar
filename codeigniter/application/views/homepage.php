<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="wrapper">
	<div class="filter-container">
		<a href="#" class="filter-close"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
		<h3 class="heading-three">Filters</h3>
		<form class="filter">
			<div class="filter-section">
				<label>Order by:</label>
				<select class="form-control">
					<option>Highest rated</option>
					<option>Cheapest listing fee</option>
				</select>
			</div>
			<div class="filter-section">
				<h4 class="heading-four">Agent type</h4>
				<div class="radio">
				  <label>
				    <input class="filter-option" type="radio" name="type" value="" checked>
					    Show all
				  </label>
				</div>
				<div class="radio">
				  <label>
				    <input class="filter-option" type="radio" name="type" value="1">
					    Hybrid only
				  </label>
				</div>
				<div class="radio">
				  <label>
				    <input class="filter-option" type="radio" name="type" value="2">
					    Online only
				  </label>
				</div>
			</div>
			<div class="filter-section">
				<h4 class="heading-four">Features</h4>
				<div class="checkbox">
				  <label>
				    <input class="filter-option" type="checkbox" name="photos_floorplans_inc" value="1">
					   Photos &amp; Floorplans Included
				  </label>
				</div>
				<div class="checkbox">
				  <label>
				    <input class="filter-option" type="checkbox" name="viewings_package_offered" value="1">
					    Viewings package available
				  </label>
				</div>
			</div>
			<a href="#" class="btn btn-primary btn-block filter-btn">Update</a>
		</form>
	</div>
	<div class="comparison-table">
		<div class="loader"><img src="inc/img/three-dots.svg" /></div>	
		<table class="table table-responsive table-striped">
			<thead>
				<tr>
					<th>image</th>
					<th>Listing Fee</th>
					<th>Photos &amp; Floorplans</tg>
					<th>Viewings Package</tg>
					<th>EPC</th>
					<th>Premium Listings</th>
					<th>Trust Pilot Rating</th>
				</tr>			
			</thead>
			<tbody>
				<?php foreach($agents as $agent) : ?>
				<tr>
					<td><a href="<?=$agent['link']?>" target="_blank"><?=$agent['name']?></a></td>
					<td>
						&pound;<?=number_format($agent['base_price'])?>
						<?=($agent['base_price_london'] > 0 ? '<span class="basePrice-london">&pound;' . number_format($agent['base_price_london']) . ' inside London</span>' : '')?>
					</td>
					<td><?=($agent['photos_floorplans'] == 0 ? 'Included' : '&pound;' . number_format($agent['photos_floorplans'], 2))?></td>
					<td>
						<?=($agent['viewings'] == 0 ? 'Not offered' : '&pound;' . number_format($agent['viewings'], 2))?>
						<?=($agent['viewings_london'] > 0 ? '<span class="viewings-london">&pound;' . number_format($agent['viewings_london']) . ' inside London</span>' : '')?>
					</td>
					<td>&pound;<?=number_format($agent['epc'],2)?></td>
					<td><?=($agent['premium_listing'] == 0 ? 'Not offered' : '&pound;' . number_format($agent['premium_listing'], 2))?></td>
					<td>trust score</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<a href="#" class="btn btn-primary btn-block filter-show hidden-md hidden-lg">Show filter</a>
		</div>
	</div>
	</div>
</div>

<!-- AJAX template -->
<script id="result-template" type="text/x-handlebars-template">
  <tr>
	  <td><a href="{{link}}">{{name}}</a></td>
	  <td>
		  &pound;{{base_price}}
		  {{#if base_price_london}}<span class="basePrice-london">&pound;{{base_price_london}} inside London</span>{{/if}}
	  </td>
	  <td>{{#if photos_floorplans}}&pound;{{photos_floorplans}}{{else}}Included{{/if}}</td>
	  <td>
		  {{#if viewings}}&pound;{{viewings}}{{else}}Not offered{{/if}}
		  {{#if viewings_london}}<span class="basePrice-london">&pound;{{viewings_london}} inside London</span>{{/if}}
	  </td>
	  <td>&pound;{{epc}}</td>
	  <td>{{#if premium_listing}}&pound;{{premium_listing}}{{else}}Not offered{{/if}}</td>
	  <td>trust rating</td>
  </tr>
</script>