	

    /*
    ---------------------- JavaScript Micro-Templating ----------------------
    I’ve had a little utility that I’ve been kicking around for some time now that I’ve found to be quite useful in my JavaScript application-building endeavors. It’s a super-simple templating function that is fast, caches quickly, and is easy to use. I have a couple tricks that I use to make it real fun to mess with.
     
    Here’s the source code to the templating function (a more-refined version of this code will be in my upcoming book Secrets of the JavaScript Ninja):
    */
     
        // Simple JavaScript Templating
        // John Resig - http://ejohn.org/ - MIT Licensed
        (function(){
          var cache = {};
         
          this.tmpl = function tmpl(str, data){
            // Figure out if we're getting a template, or if we need to
            // load the template - and be sure to cache the result.
            var fn = !/\W/.test(str) ?
              cache[str] = cache[str] ||
                tmpl(document.getElementById(str).innerHTML) :
             
              // Generate a reusable function that will serve as a template
              // generator (and which will be cached).
              new Function("obj",
                "var p=[],print=function(){p.push.apply(p,arguments);};" +
               
                // Introduce the data as local variables using with(){}
                "with(obj){p.push('" +
               
                // Convert the template into pure JavaScript
                str
                  .replace(/[\r\t\n]/g, " ")
                  .split("<%").join("\t")
                  .replace(/((^|%>)[^\t]*)'/g, "$1\r")
                  .replace(/\t=(.*?)%>/g, "',$1,'")
                  .split("\t").join("');")
                  .split("%>").join("p.push('")
                  .split("\r").join("\\'")
              + "');}return p.join('');");
           
            // Provide some basic currying to the user
            return data ? fn( data ) : fn;
          };
        })();
    /*
    You would use it against templates written like this (it doesn’t have to be in this particular manner – but it’s a style that I enjoy):
    */
     
/*        <script type="text/html" id="item_tmpl">
          <div id="<%=id%>" class="<%=(i % 2 == 1 ? " even" : "")%>">
            <div class="grid_1 alpha right">
              <img class="righted" src="<%=profile_image_url%>"/>
            </div>
            <div class="grid_6 omega contents">
              <p><b><a href="/<%=from_user%>"><%=from_user%></a>:</b> <%=text%></p>
            </div>
          </div>
        </script>
*/     
    //You can also inline script:
     
/*        <script type="text/html" id="user_tmpl">
          <% for ( var i = 0; i < users.length; i++ ) { %>
            <li><a href="<%=users[i].url%>"><%=users[i].name%></a></li>
          <% } %>
        </script>
*/
    /*
     
    Quick tip: Embedding scripts in your page that have a unknown content-type (such is the case here – the browser doesn’t know how to execute a text/html script) are simply ignored by the browser – and by search engines and screenreaders. It’s a perfect cloaking device for sneaking templates into your page. I like to use this technique for quick-and-dirty cases where I just need a little template or two on the page and want something light and fast.
     
    and you would use it from script like so:
     
    */
     
        var results = document.getElementById("results");
        results.innerHTML = tmpl("item_tmpl", dataObject);
    /*
     
    You could pre-compile the results for later use. If you call the templating function with only an ID (or a template code) then it’ll return a pre-compiled function that you can execute later:
    */
     
        var show_user = tmpl("item_tmpl"), html = "";
        for ( var i = 0; i < users.length; i++ ) {
          html += show_user( users[i] );
        }
    /*
    The biggest falling-down of the method, at this point, is the parsing/conversion code – it could probably use a little love. It does use one technique that I enjoy, though: If you’re searching and replacing through a string with a static search and a static replace it’s faster to perform the action with .split("match").join("replace") – which seems counter-intuitive but it manages to work that way in most modern browsers. (There are changes going in place to grossly improve the performance of .replace(/match/g, "replace") in the next version of Firefox – so the previous statement won’t be the case for long.)
     
    Feel free to have fun with it – I’d be very curious to see what mutations occur with the script. Since it’s so simple it seems like there’s a lot that can still be done with it.
     
    */

