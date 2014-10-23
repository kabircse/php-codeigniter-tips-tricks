
Assuming you have a button with the id 'button', try this example:
```javascript
$("#button").click(function() {
    $('html, body').animate({
        scrollTop: $("#elementtoScrollToID").offset().top
    }, 2000);
});
```
I got the code from the article Smoothly scroll to an element without a jQuery plugin. And I have tested it on the example below.
```html
<html>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function (){
            $("#click").click(function (){
                //$(this).animate(function(){
                    $('html, body').animate({
                        scrollTop: $("#div1").offset().top
                    }, 2000);
                //});
            });
        });
    </script>
    <div id="div1" style="height: 1000px; width 100px">
        Test
    </div>
    <br/>
    <div id="div2" style="height: 1000px; width 100px">
        Test 2
    </div>
    <button id="click">Click me</button>
</html>
```
