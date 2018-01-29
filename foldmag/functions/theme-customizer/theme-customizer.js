/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and
 * then make any necessary changes to the page using jQuery.
 */
( function( $ ) {

//Update site global fonts in real time...
wp.customize( 'body_font', function( value ) {
value.bind( function( newval ) {
var val_strip = newval.replace(/ /g,"+");
var oLink = document.getElementById('google_body');
var gLink = '//fonts.googleapis.com/css?family='+ val_strip +'';
oLink.href = gLink;
$('body').css('font-family', newval );
} );
} );


wp.customize( 'body_font_weight', function( value ) {
value.bind( function( newval ) {
$('body').css('font-weight', newval );
} );
} );


wp.customize( 'headline_font', function( value ) {
value.bind( function( newval ) {
var val_strip = newval.replace(/ /g,"+");
var oLink = document.getElementById('google_headline');
var gLink = '//fonts.googleapis.com/css?family='+ val_strip +'';
oLink.href = gLink;

       $('#siteinfo div,h1,h2,h3,h4,h5,h6').css('font-family', newval );

		} );
	} );


	wp.customize( 'headline_font_weight', function( value ) {
		value.bind( function( newval ) {
       $('#siteinfo div,h1,h2,h3,h4,h5,h6').css('font-weight', newval );

		} );
       	} );

   	wp.customize( 'navigation_font', function( value ) {
		value.bind( function( newval ) {

    var val_strip = newval.replace(/ /g,"+");
var oLink = document.getElementById('google_nav');
var gLink = '//fonts.googleapis.com/css?family='+ val_strip +'';
oLink.href = gLink;

       $('.sf-menu').css('font-family', newval );

		} );
	} );

	wp.customize( 'navigation_font_weight', function( value ) {
		value.bind( function( newval ) {
       $('.sf-menu').css('font-weight', newval );

		} );
	} );

} )( jQuery );