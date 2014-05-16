_css:_
```css
#popup_content {
      width: 100%; height: 100%; position: fixed; top: 0; left: 0;
      z-index: 1000;
      background-color: transparent;
      background-color: rgba(0, 0, 0, 0.7);
    }
    #popup_wrapper {margin: 0 auto; text-align: center}
```
_javascript:_
```javascript
var pop_is_show = false;
  $('#search_popup_link').click(function(e) {
    e.preventDefault();
    var loading_image  = '<img src="/application/assets/images/thickbox_loading.gif" />';
    $('body').append('<div id="popup_content"><div id="popup_wrapper"></div></div>');
    $('#popup_wrapper').html(loading_image);
    //$('#popup_content').load(($(this).attr('href')));
    $.get($(this).attr('href'), function(content) {
	  pop_is_show = true;
      $('#popup_wrapper').html(content);
      $('#popup_wrapper').center(true);
    });
  });
  
  function tb_remove() {
    $('#popup_content').remove();
  }
	document.body.addEventListener('touchstart', function(e){
    if (pop_is_show && $( e.target ).attr('id') == 'popup_content') {
      tb_remove(); pop_is_show = false;
    }
        
 }, false);
 
 $( document ).on( "click", function( event ) {
  if ($( event.target ).attr('id') == 'popup_content' && pop_is_show) {
    tb_remove(); pop_is_show = false;
  }
});
```

