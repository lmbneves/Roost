/* ====================================
   JS for Roost Homepage
   ==================================== */

$(document).ready(function(){
/* ====================================
   Variables
   ==================================== */
	var bedroom_button = $("#bedroom-button");
	var price_button = $("#price-button");
	var landlord_button = $("#landlord-button");
	var distance_button = $("#distance-button");

	var default_input = $("#default-input");
	var bedroom_input = $("#bedroom-input");
	var price_input = $("#price-input");
	var landlord_input = $("#landlord-input");
	var distance_input = $("#distance-input");
/* ====================================
   Switches input option
   ==================================== */

	// checks if user wants to search by number of bedrooms
	bedroom_button.click(function() {
		default_input.attr('class', 'hidden');
		price_input.attr('class', 'hidden');
		landlord_input.attr('class', 'hidden');
		distance_input.attr('class', 'hidden');

		bedroom_input.attr('class', 'show');
		bedroom_input.attr('class', 'form-control');
	});

	// checks if user wants to search by price
	price_button.click(function() {
		default_input.attr('class', 'hidden');
		bedroom_input.attr('class', 'hidden');
		landlord_input.attr('class', 'hidden');
		distance_input.attr('class', 'hidden');

		price_input.attr('class', 'show');
		price_input.attr('class', 'form-control');
	});

	// checks if user wants to search by landlord
	landlord_button.click(function() {
		default_input.attr('class', 'hidden');
		price_input.attr('class', 'hidden');
		bedroom_input.attr('class', 'hidden');
		distance_input.attr('class', 'hidden');

		landlord_input.attr('class', 'show');
		landlord_input.attr('class', 'form-control');
	});

	// checks if user wants to search by distance
	distance_button.click(function() {
		default_input.attr('class', 'hidden');
		price_input.attr('class', 'hidden');
		landlord_input.attr('class', 'hidden');
		bedroom_input.attr('class', 'hidden');

		distance_input.attr('class', 'show');
		distance_input.attr('class', 'form-control');
	});

/* ====================================
   Handles input search text
   ==================================== */
   default_input.blur(function() {
		var default_value = $(this).attr("rel");
		if ($(this).val() == "") {
			$(this).val(default_value);
		}
	}).focus(function() {
		var default_value = $(this).attr("rel");
		if ($(this).val() == default_value) {
			$(this).val("");
		}
	});

	bedroom_input.blur(function() {
		var default_value = $(this).attr("rel");
		if ($(this).val() == "") {
			$(this).val(default_value);
		}
	}).focus(function() {
		var default_value = $(this).attr("rel");
		if ($(this).val() == default_value) {
			$(this).val("");
		}
	});

	price_input.blur(function() {
		var default_value = $(this).attr("rel");
		if ($(this).val() == "") {
			$(this).val(default_value);
		}
	}).focus(function() {
		var default_value = $(this).attr("rel");
		if ($(this).val() == default_value) {
			$(this).val("");
		}
	});

	landlord_input.blur(function() {
		var default_value = $(this).attr("rel");
		if ($(this).val() == "") {
			$(this).val(default_value);
		}
	}).focus(function() {
		var default_value = $(this).attr("rel");
		if ($(this).val() == default_value) {
			$(this).val("");
		}
	});

	distance_input.blur(function() {
		var default_value = $(this).attr("rel");
		if ($(this).val() == "") {
			$(this).val(default_value);
		}
	}).focus(function() {
		var default_value = $(this).attr("rel");
		if ($(this).val() == default_value) {
			$(this).val("");
		}
	});

});