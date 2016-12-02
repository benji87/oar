<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="filter-btn__container hidden-md hidden-lg">
    <a href="#" class="btn__secondary filter-show hidden-md hidden-lg"><i class="fa fa-filter" aria-hidden="true"></i> Show filters</a>
</div>
</div>
<div class="homepage-container wrapper row ">
	<div class="col-md-3 filter-container">
		<a href="#" class="filter-close"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
		<h4 class="filter-container__heading heading-four">Filter your results</h4>
		<form class="filter">
			<div class="filter-section">
				<h4 class="heading-four filter-section__heading">Order by</h4>
				<select name="order_by" class="form-control filter-section__select">
					<option value="">Please select</option>
					<option value="trustpilot_average">Highest rated</option>
					<option value="base_price">Cheapest listing fee</option>
				</select>
			</div>
			<div class="filter-section">
				<h4 class="heading-four filter-section__heading">Agent type</h4>
				<div class="filter-section__radio">
					<label class="filter-section__label">
				    <input class="filter-option" type="radio" name="type" value="" checked>
					    Show all
				  </label>
				</div>
				<div class="filter-section__radio">
					<label class="filter-section__label">
				    <input class="filter-option" type="radio" name="type" value="1">
					    Hybrid only
				  </label>
				</div>
				<div class="filter-section__radio">
				  <label class="filter-section__label">
				    <input class="filter-option" type="radio" name="type" value="2">
					    Online only
				  </label>
				</div>
			</div>
			<div class="filter-section">
				<h4 class="heading-four filter-section__heading">Features</h4>
				<div class="filter-section__checkbox">
				  <label class="filter-section__label">
				    <input class="filter-option" id="filter-expert-local-agent" type="checkbox" name="expert_local_agent" value="1">
					   Expert Local Agent
				  </label>
				</div>
				<div class="filter-section__checkbox">
				  <label class="filter-section__label">
				    <input class="filter-option" type="checkbox" name="photos_floorplans_inc" value="1">
					   Photos & Floorplan
				  </label>
				</div>
				<div class="filter-section__checkbox">
				  <label class="filter-section__label">
				    <input class="filter-option" type="checkbox" name="viewings_package_offered" value="1">
					    Viewings package
				  </label>
				</div>
			</div>
			<a href="#" class="btn btn__primary filter-btn btn-block hidden-md hidden-lg">Update</a>
		</form>
	</div>
	<div class="comparison-table col-md-9">
		<div class="loader"><img src="inc/img/three-dots.svg" /></div>
        <div class="comparison-table__error text-center">
            <h3 class="heading-three">No results returned. Try something different?</h3>
        </div>
		<div class="results">
			<?php foreach($agents as $agent) : ?>
			<div class="result-item">
				<header class="result-item__header">
					<a href="<?=$agent['link']?>" target="_blank" class="result-item__link"><?=$agent['name']?></a>
				</header>
				<section class="result-item__body">

					<div class="result-item__feature">
						<img class="result-item__logo" src="/inc/img/logos/<?=strtolower($agent['name'])?>.png">
					</div>
					<div class="result-item__feature">
						<span class="result-item__title">Listing Fee</span>
						<span class="result-item__price--large">&pound;<?=number_format($agent['base_price'])?></span>
						<?=($agent['base_price_london'] > 0 ? '<span class="basePrice-london">&pound;' . number_format($agent['base_price_london']) . ' <br>inside London</span>' : '')?>
					</div>
					<div class="result-item__feature hidden-md hidden-xs">
						<span class="result-item__title">Photos &amp; Floorplan</span>
						<span class="result-item__price"><?=($agent['photos_floorplans'] == 0 ? 'Included' : '&pound;' . number_format($agent['photos_floorplans'], 2))?></span>
					</div>
					<div class="result-item__feature hidden-sm hidden-xs">
						<span class="result-item__title">Viewings Package</span>
						<span class="result-item__price"><?=($agent['viewings'] == 0 ? 'Not offered' : '&pound;' . number_format($agent['viewings'], 2))?></span>
						<?=($agent['viewings_london'] > 0 ? '<span class="viewings-london">&pound;' . number_format($agent['viewings_london']) . ' <br>inside London</span>' : '')?>
					</div>
					<div class="result-item__feature">
						<a href="<?=$agent['link']?>" target="_blank" class="result-item__btn btn__primary">Go to site</a>
						<a href="/details/<?=strtolower($agent['name'])?>" class="result-item__viewDetail">View detail</a>
					</div>
				</section>
				<footer class="result-item__footer">
					<span class="result-item__rating ratings-<?=round($agent['trustpilot_average'])?>"></span> Rated <?=$agent['trustpilot_total']?> on trustpilot
					<a href="#reviews" data-id="<?=$agent['id']?>" data-name="<?=$agent['name']?>" data-tpTotal="<?=$agent['trustpilot_total']?>" data-tpAvg="<?=round($agent['trustpilot_average'])?>" class="cta result-item__link result-item__cta">Read reviews</a>
				</footer>
			</div>
			<?php endforeach; ?>
		</div>

		<!--				<div class="result-item__sub-feature">-->
		<!--					<span>EPC: &pound;--><?//=number_format($agent['epc'],2)?><!--</span>-->
		<!--				</div>-->
		<!--				<div class="result-item__sub-feature">-->
		<!--					<span>Premium Listing: --><?//=($agent['premium_listing'] == 0 ? 'Not offered' : '&pound;' . number_format($agent['premium_listing'], 2))?><!--</span>-->
		<!--				</div>-->
	</div>
</div>

<!-- AJAX template -->
<script id="result-template" type="text/x-handlebars-template">
  <div class="result-item">
	  <header class="result-item__header">
		  <a href="{{link}}" target="_blank" class="result-item__link">{{name}}</a>
	  </header>
	  <section class="result-item__body">

		  <div class="result-item__feature">
			  <img class="result-item__logo" src="/inc/img/logos/{{name}}.png">
		  </div>
		  <div class="result-item__feature">
			  <span class="result-item__title">Listing Fee</span>
			  <span class="result-item__price--large">&pound;{{base_price}}</span>
			  {{#if base_price_london}}<span class="basePrice-london">&pound;{{base_price_london}} <br>inside London</span>{{/if}}
		  </div>
		  <div class="result-item__feature hidden-sm hidden-xs">
			  <span class="result-item__title">Photos &amp; Floorplan</span>
			  <span class="result-item__price">{{#if photos_floorplans}}&pound;{{photos_floorplans}}{{else}}Included{{/if}}</span>
		  </div>
		  <div class="result-item__feature hidden-sm hidden-xs">
			  <span class="result-item__title">Viewings Package</span>
			  <span class="result-item__price">{{#if viewings}}&pound;{{viewings}}{{else}}Not offered{{/if}}</span>
			  {{#if viewings_london}}<span class="basePrice-london">&pound;{{viewings_london}} inside London</span>{{/if}}
		  </div>
          <div class="result-item__feature">
              <a href="{{link}}" target="_blank" class="result-item__btn btn__primary">Go to site</a>
              <a href="/detail/{{name}}" class="result-item__viewDetail">View detail</a>
          </div>
	  </section>
	  <footer class="result-item__footer">
		  <span class="result-item__rating ratings-{{trustpilot_average}}"></span> Rated {{trustpilot_total}} on trustpilot
          <a href="#reviews" data-id="{{id}}" data-name="{{name}}" data-tpTotal="{{trustpilot_total}}" data-tpAvg="{{trustpilot_average}}" class="cta result-item__link result-item__cta">Read reviews</a>
	  </footer>
  </div>
</script>


<div class="remodal" data-remodal-id="reviews">
	<button data-remodal-action="close" class="remodal-close"></button>
	<h1 class="heading__one reviews__noData">Please close this modal and select an estate agent</h1>
</div>
<script id="modal-template" type="text/x-handlebars-template">
	<div class="reviews">
		<header class="reviews__header">
			<h2 class="heading__two reviews__title">Reviews for {{eA}}</h2>
			<span class="reviews__header__summary">Overall rating of: {{total}} <span class="ratings-{{average}}"></span></span>
			<button class="btn__primary reviews__btn">Visit {{eA}}</button>
		</header>
		<iframe class="reviews__iframe" src="/trustpilot-reviews/{{eAId}}" frameborder="0"></iframe>
<!--        <footer class="reviews__footer">-->
<!--            <span class="reviews__header__providedBy">Reviews provided by <span class="reviews-logo"></span> </span>-->
<!--        </footer>-->
	</div>
</script>