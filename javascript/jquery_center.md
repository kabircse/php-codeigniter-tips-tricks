### jQuery Center Box
------
```css
div.container{
    width:300px;
    height:300px;
    border:1px solid #555;
    position:relative;
    top:10px;
    left:10px;
}

div.target{
    width:50px;
    height:50px;
    color:white;
    background:rgba(30,30,30,.7);
    border-radius: 10px;
    text-align:center;
}
```

```html
<div class="container">
    <div class="target">1<br>parent</div>
    <div class="target">2<br>window</div>
</div>
```

```javascript
jQuery.fn.center = function(parent) {
    if (parent) {
        parent = this.parent();
    } else {
        parent = window;
    }
    this.css({
        "position": "absolute",
        "top": ((($(parent).height() - this.outerHeight()) / 2) + $(parent).scrollTop() + "px"),
        "left": ((($(parent).width() - this.outerWidth()) / 2) + $(parent).scrollLeft() + "px")
    });
return this;
}
$("div.target:nth-child(1)").center(true);
$("div.target:nth-child(2)").center(false);

$( window ).resize(function() {
$( "#log" ).center();
});
```
------
[Live demo](http://jsfiddle.net/DerekL/GbDw9/), 
[github makedown cheat sheet](https://github.com/adam-p/markdown-here/wiki/Markdown-Here-Cheatsheet)