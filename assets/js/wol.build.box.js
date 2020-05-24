(function($) {
	
	$('input[type=radio][name=macro]').change(function() {
    	
    	$('.macro').text(this.value);
        
    });
    
    $('input[type=radio][name=style]').change(function() {
    
        $('.style').text(this.value);
        
        
    });
    
    $('input[type=radio][name=border]').change(function() {
    
        $('.border').text(this.value);
    });
    
    $('input[type=radio][name=position]').change(function() {
    
        $('.position').text(this.value);
    });
    
    
    
})( jQuery );
