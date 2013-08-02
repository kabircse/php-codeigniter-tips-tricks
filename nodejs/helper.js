/*
 * JavaScript Pretty Date
 * Copyright (c) 2011 John Resig (ejohn.org)
 * Licensed under the MIT and GPL licenses.
 */

// Takes an ISO time and returns a string representing how
// long ago the date represents.
function prettyDate(time){
	var date = new Date((time || "").replace(/-/g,"/").replace(/[TZ]/g," ")),
		diff = (((new Date()).getTime() - date.getTime()) / 1000),
		day_diff = Math.floor(diff / 86400);
			
	if ( isNaN(day_diff) || day_diff < 0 || day_diff >= 31 )
		return;
			
	return day_diff == 0 && (
			diff < 60 && "just now" ||
			diff < 120 && "1 minute ago" ||
			diff < 3600 && Math.floor( diff / 60 ) + " minutes ago" ||
			diff < 7200 && "1 hour ago" ||
			diff < 86400 && Math.floor( diff / 3600 ) + " hours ago") ||
		day_diff == 1 && "Yesterday" ||
		day_diff < 7 && day_diff + " days ago" ||
		day_diff < 31 && Math.ceil( day_diff / 7 ) + " weeks ago";
}

// If jQuery is included in the page, adds a jQuery plugin to handle it as well
if ( typeof jQuery != "undefined" )
	jQuery.fn.prettyDate = function(){
		return this.each(function(){
			var date = prettyDate(this.title);
			if ( date )
				jQuery(this).text( date );
		});
	};
    
    
    // USAGE EXAMPLE
    	

    function prettyLinks(){
        var links = document.getElementsByTagName("a");
        for ( var i = 0; i < links.length; i++ )
            if ( links[i].title ) {
                var date = prettyDate(links[i].title);
                if ( date )
                    links[i].innerHTML = date;
            }
    }
    prettyLinks();
    setInterval(prettyLinks, 5000);
    
    
    	
    // jQuery
    $("a").prettyDate();
    setInterval(function(){ $("a").prettyDate(); }, 5000);
    
    
    function timeDifference(dateStr) {
    var time = ('' + dateStr).replace(/-/g, "/").replace(/[TZ]/g, " ");
    var seconds = (new Date - new Date(time)) / 1000;
    var i = 0,
        format;
    while (format = timeDifference.formats[i++])
        if (seconds < format[0]) return format[2] ? Math.floor(seconds / format[2]) + ' ' + format[1] + ' ago' : format[1];
    return time;
};
timeDifference.formats = [
    [60, 'seconds', 1],
    [120, '1 minute ago'],
    [3600, 'minutes', 60],
    [7200, '1 hour ago'],
    [86400, 'hours', 3600],
    [172800, 'Yesterday'],
    [604800, 'days', 86400],
    [1209600, '1 week ago'],
    [2678400, 'weeks', 604800]
];



