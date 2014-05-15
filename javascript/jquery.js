// trim, rtrim, ltrim
function trim(str, chr) {
  var rgxtrim = (!chr) ? new RegExp('^\\s+|\\s+$', 'g') : new RegExp('^'+chr+'+|'+chr+'+$', 'g');
  return str.replace(rgxtrim, '');
}
function rtrim(str, chr) {
  var rgxtrim = (!chr) ? new RegExp('\\s+$') : new RegExp(chr+'+$');
  return str.replace(rgxtrim, '');
}
function ltrim(str, chr) {
  var rgxtrim = (!chr) ? new RegExp('^\\s+') : new RegExp('^'+chr+'+');
  return str.replace(rgxtrim, '');
}

var rgxtrim = new RegExp('/'+'+$');
jQuery('img[src*="?q="]').each(function(i,e) { 
  var src = jQuery(e).attr('src');
  var new_src = src.replace(rgxtrim, '').replace('?q=', 'stores/');
  jQuery(e).attr('src', new_src);
});
