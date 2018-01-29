jQuery( function($) {

$(document).ready(function(){
jQuery("ul.sf-menu").supersubs({
            minWidth:    18,
            maxWidth:    18,
            extraWidth:  1
        }).superfish();
});

 jQuery("#mobile-nav ul").hide('fast');
 jQuery(".mobile-open-click").click(function(){
 jQuery("#mobile-nav ul").toggle('fast');
 }
 );

});