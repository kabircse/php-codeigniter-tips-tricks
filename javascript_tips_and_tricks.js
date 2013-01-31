// IE 8 Throws a warning if script runs slower than 1 second
// 
// Literals is faster than classic
//---------------------------------------------------+
function literals() {
    var a = [], o = {};
}

function classic() {
    var a = new Array(), o = new Object();
}
//---------------------------------------------------+
var my_integer = parseInt(1.25);
// loop while is faster than for
var i = 1000;
while (i--) {
    //do some stuff
    //when i equals to 0, expression will be false
}

// cached in js

function cached() {
    var w = window, i = 10000;
    while(i--) w.test = 'windows test';
}

// evaluated
if (true && (n=3)) {
    //do some stuf
    // n set to 3
}
if (true || (n =  4)) {
    // n not set to 4
}

var obj = { 'name': 'Sonny Nguyen', 'age': 27}

// try catch is slower than normally

(function() { return 2 * 3; }).toString();

/* --------------------------- JAVASCRIPT OBJECT ---------------------------- */
function Ninja(){} 
 
Ninja.prototype.swingSword = function(){ 
  return true; 
}; 
 
var ninjaA = Ninja(); 
assert( !ninjaA, "Is undefined, not an instance of Ninja." ); 
 
var ninjaB = new Ninja(); 
assert( ninjaB.swingSword(), "Method exists and is callable." );

//override

function Ninja(){ 
  this.swingSword = function(){ 
    return true; 
  }; 
} 
 
// Should return false, but will be overridden 
Ninja.prototype.swingSword = function(){ 
  return false; 
}; 
 
var ninja = new Ninja(); 
assert( ninja.swingSword(), "Calling the instance method, not the prototype method." );

//


function Ninja(){ 
  this.swung = true; 
} 
 
var ninjaA = new Ninja(); 
var ninjaB = new Ninja(); 
 
Ninja.prototype.swingSword = function(){ 
  return this.swung; 
}; 
 
assert( ninjaA.swingSword(), "Method exists, even out of order." ); 
assert( ninjaB.swingSword(), "and on all instantiated objects." );



//The chainable method must return this.

function Ninja(){ 
  this.swung = true; 
} 
 
var ninjaA = new Ninja(); 
var ninjaB = new Ninja(); 
 
Ninja.prototype.swing = function(){ 
  this.swung = false; 
  return this; 
}; 
 
assert( !ninjaA.swing().swung, "Verify that the swing method exists and returns an instance." ); 
assert( !ninjaB.swing().swung, "and that it works on all Ninja instances." );



//Examining the basics of an object.

function Ninja(){} 
 
var ninja = new Ninja(); 
 
assert( typeof ninja == "object", "However the type of the instance is still an object." );   
assert( ninja instanceof Ninja, "The object was instantiated properly." ); 
assert( ninja.constructor == Ninja, "The ninja object was created by the Ninja function." );

// dont understand
function Person(){} 
Person.prototype.getName = function(){ 
  return this.name; 
}; 
 
function Me(){ 
  this.name = "John Resig"; 
} 
Me.prototype = new Person(); 
 
var me = new Me(); 
assert( me.getName(), "A name was set." );



//We can also modify built-in object prototypes.

if (!Array.prototype.forEach) { 
  Array.prototype.forEach = function(fn){ 
    for ( var i = 0; i < this.length; i++ ) { 
      fn( this[i], i, this ); 
    } 
  }; 
} 
 
["a", "b", "c"].forEach(function(value, index, array){ 
  assert( value, "Is in position " + index + " out of " + (array.length - 1) ); 
});

//Beware: Extending prototypes can be dangerous.

Object.prototype.keys = function(){ 
  var keys = []; 
  for ( var i in this ) 
    keys.push( i ); 
  return keys; 
}; 
 
var obj = { a: 1, b: 2, c: 3 }; 
 
assert( obj.keys().length == 3, "We should only have 3 properties." ); 
 
delete Object.prototype.keys;

//We need to keep its context as the original object.

function bind(context, name){ 
  return function(){ 
    return context[name].apply(context, arguments); 
  }; 
} 
 
var Button = { 
  click: function(){ 
    this.clicked = true; 
  } 
}; 
 
var elem = document.createElement("li"); 
elem.innerHTML = "Click me!"; 
elem.onclick = bind(Button, "click"); 
document.getElementById("results").appendChild(elem); 
 
elem.onclick(); 
assert( Button.clicked, "The clicked property was correctly set on the object" );

//How method overloading might work, using the function length property.

function addMethod(object, name, fn){ 
  // Save a reference to the old method 
  var old = object[ name ]; 
 
  // Overwrite the method with our new one 
  object[ name ] = function(){ 
    // Check the number of incoming arguments, 
    // compared to our overloaded function 
    if ( fn.length == arguments.length ) 
      // If there was a match, run the function 
      return fn.apply( this, arguments ); 
 
    // Otherwise, fallback to the old method 
    else if ( typeof old === "function" ) 
      return old.apply( this, arguments ); 
  }; 
} 
 
function Ninjas(){ 
  var ninjas = [ "Dean Edwards", "Sam Stephenson", "Alex Russell" ]; 
  addMethod(this, "find", function(){ 
    return ninjas; 
  }); 
  addMethod(this, "find", function(name){ 
    var ret = []; 
    for ( var i = 0; i < ninjas.length; i++ ) 
      if ( ninjas[i].indexOf(name) == 0 ) 
        ret.push( ninjas[i] ); 
    return ret; 
  }); 
  addMethod(this, "find", function(first, last){ 
    var ret = []; 
    for ( var i = 0; i < ninjas.length; i++ ) 
      if ( ninjas[i] == (first + " " + last) ) 
        ret.push( ninjas[i] ); 
    return ret; 
  }); 
} 
 
var ninjas = new Ninjas(); 
assert( ninjas.find().length == 3, "Finds all ninjas" ); 
assert( ninjas.find("Sam").length == 1, "Finds ninjas by first name" ); 
assert( ninjas.find("Dean", "Edwards").length == 1, "Finds ninjas by first and last name" ); 
assert( ninjas.find("Alex", "X", "Russell") == null, "Does nothing" );

//further reading go here http://ejohn.org/apps/learn/#64
////http://stackoverflow.com/questions/572897/how-does-javascript-prototype-work
//http://net.tutsplus.com/tutorials/javascript-ajax/prototypes-in-javascript-what-you-need-to-know/

// examples
String.prototype.trim = function() {
    return this.replace(/^\s+|\s+$/g, '');
};

//Now, if it exists, it will use the native version of the trim method.
if(!String.prototype.trim) {
    String.prototype.trim = function() {
        return this.replace(/^\s+|\s+$/g, '');
    };
}

var obj = new Object(); // not a functional object
obj.prototype.test = function() { alert('Hello?'); }; // this is wrong!

function MyObject() {} // a first class functional object
MyObject.prototype.test = function() { alert('OK'); } // OK

//

//Define a functional object to hold persons in javascript
var Person = function (name) {
    this.name = name;
};

//Add dynamically to the already defined object a new getter
Person.prototype.getName = function () {
    return this.name;
};

//Create a new object of type Person
var john = new Person("John");

//Try the getter
alert(john.getName());

//If now I modify person, also John gets the updates
Person.prototype.sayMyName = function () {
    alert('Hello, my name is ' + this.getName());
};

//Call the new method on john
john.sayMyName();
//http://stackoverflow.com/questions/1986896/what-is-the-difference-between-call-and-apply

// javascript apply & call
/* min/max number in an array */
var numbers = [5, 6, 2, 3, 7];
 
/* using Math.min/Math.max apply */
var max = Math.max.apply(null, numbers); /* This about equal to Math.max(numbers[0], ...) or Math.max(5, 6, ..) */




// another example
function theFunction(name, profession) {
    alert("My name is " + name + " and I am a " + profession + ".");
}
theFunction("John", "fireman");
theFunction.apply(undefined, ["Susan", "school teacher"]);
theFunction.call(undefined, "Claude", "mathematician");

// The main difference is that apply lets you invoke the function with arguments as an array; 
// call requires the parameters be listed explicitly. 
//Also, using apply() you can specify what this would refer to within that function

//http://odetocode.com/blogs/scott/archive/2007/07/04/function-apply-and-function-call-in-javascript.aspx

/* --------------------------- JAVASCRIPT OBJECT ---------------------------- */
