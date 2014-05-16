### Create you owner popup with jQuery

-------------
**HTML:**
```html
		<a href="/test/popup/" id="popup_link" title="">Show popup</a>
```
**_css:_**
```css
#popup_content {
	width: 100%; height: 100%; position: fixed; top: 0; left: 0;
	z-index: 1000;
	background-color: transparent;
	background-color: rgba(0, 0, 0, 0.7);
}
#popup_wrapper {margin: 0 auto; text-align: center}
.loading_div {
    width: 100%; height: 13px;
    background: transparent url('thickbox_loading.gif') no-repeat center center;
  }
```
**_javascript:_**
```javascript
var pop_is_show = false;
  $('#popup_link').click(function(e) {
    e.preventDefault();
    $('body').append('<div id="popup_content"><div id="popup_wrapper"></div></div>');
    $('#popup_wrapper').html('<div class="loading_div"></div>').center(true);
    $.get($(this).attr('href'), function(content) {
	  	pop_is_show = true;
      $('#popup_wrapper').html(content).center(true);
    });
  });
  
  function popup_close() {
    $('#popup_content').remove();
  }
  
	document.body.addEventListener('touchstart', function(e){
    if (pop_is_show && $( e.target ).attr('id') == 'popup_content') {
      popup_close(); pop_is_show = false;
    }
        
 }, false);
 
 $( document ).on( "click", function( event ) {
  if ($( event.target ).attr('id') == 'popup_content' && pop_is_show) {
    popup_close(); pop_is_show = false;
  }
});
```

