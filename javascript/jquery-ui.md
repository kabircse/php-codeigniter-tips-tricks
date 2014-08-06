
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
```
http://jqueryvalidation.org/validate
```

jQuery get user selected option text
```javascript
var select_box = $('select#my_select_box');
var selected_text = $(":selected", select_box).text();
```
