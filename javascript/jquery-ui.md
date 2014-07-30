
```javascript

$( "#birds" ).autocomplete({
            source: "search.php",
            minLength: 2,
            select: function( event, ui ) {
                log( ui.item ?
                    "Selected: " + ui.item.value + " aka " + ui.item.id :
                    "Nothing selected, input was " + this.value );
            }
        }); 
        
        
$(function() {
         $( "#tags" ).autocomplete({
            source: function(request, response) {
                $.ajax({
                  url: "<?php echo site_url('controller/getQuoteArray'); ?>",
                  data: { term: $("#tags").val()},
                  dataType: "json",
                  type: "POST",
                  success: function(data){
                  response(data);
                  }
                });
              },
            minLength: 3
        });
    }); 
```
jQuery validation
```http://jqueryvalidation.org/validate```
