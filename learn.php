<!--This was the original way the learning content was displayed before I changed it -->
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="js/image.js"></script>
<link rel="stylesheet" href="style/chapters.css">
<style>
.tab-content,
.topic-content {
  display: none;
  width: 100%;
}

p {
  line-height: 1.6;
}
.chapters li {
  text-decoration: none;
  list-style: none;
  display: inline-block;
  margin: 0 20px 0 0;
}
.chapters a {
  color: #0094cd;
  text-decoration: none;
  list-style: none;
}
.chapters li.current a {
  color: #4c565c;
}
.chapter-list a.current {
  color: #4c565c;
}
.topicTabs {
  width: 100%;
  background-color: #fff;
  margin-top: 11px;
}
.openTopic li {
  text-decoration: none;
  list-style: none;
  display: inline-block;
  margin: 0;

}
.openTopic a {
  display: block;
  background-color: inherit;
  color: black;
  padding: 22px 16px;
  width: 100%;
  border: none;
  outline: none;
  cursor: pointer;
  transition: 0.3s;
  font-size: 17px;
}

.openTopic a:hover {
  background-color: #ddd;
}

.button {
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
margin-left: 50px;
}

textarea  
{  
resize: none;
float: left;
  margin-top: 10px;
  margin-left: 50px;
  -moz-border-bottom-colors: none;
  -moz-border-left-colors: none;
  -moz-border-right-colors: none;
  -moz-border-top-colors: none;
  background: none repeat scroll 0 0 rgba(0, 0, 0, 0.07);
  border-color: -moz-use-text-color #FFFFFF #FFFFFF -moz-use-text-color;
  border-image: none;
  border-radius: 6px 6px 6px 6px;
  border-style: none solid solid none;
  border-width: medium 1px 1px medium;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.12) inset;
  color: #555555;
  font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
  font-size: 1em;
  line-height: 1.4em;
  padding: 5px 8px;
  transition: background-color 0.2s ease 0s;
}

#explanation {
float:none;
padding: 20px;
}


</style>
</head>
<body>

<h2>Learn JavaScript</h2>
<p>Click on the tab of the chapter that you are currently on</p>
<p>Return <a href="index.php">Home</a></p>



<div class="chapters">
  <ul class="chapter-list">
    <li class="current"><a href="#intro">Getting Started</a></li>
    <li class=""><a href="#chaptertabs1">The Basics</a></li>
    <li class=""><a href="#chaptertabs2">Getting into the nitty-gritty </a></li>
    <li class=""><a href="#chaptertabs3">More advanced examples</a></li>
  </ul>
</div> 

<div class="topicTabs">
  <div class="openTopic">
    <div id="intro" class="tab-content">
      <ul class="topicContent">
       <li class="current"><a href="#content1">Introduction</a></li>
         <li><a href="#chapter1Content-2">What is Javascript?</a></li>
      </ul>
    </div>

    <div id="chaptertabs1" class="tab-content">
      <ul class="topicContent">
        <li class=""><a href="#strings">Strings</a></li>
        <li><a href="#concatenation">Concatenation</a></li>
        <li><a href="#controlCharacters">Control Characters</a></li>
        <li><a href="#prompting">Prompting</a></li>
        <li><a href="#variables">Variables & Operators</a></li>
      </ul>
    </div>

    <div id="chaptertabs2" class="tab-content">
      <ul class="topicContent">
        <li><a href="#forLoops">For Loops</a></li>
         <li><a href="#arrays">Arrays</a></li>
        <li><a href="#functions">Functions</a></li>
        <li><a href="#moreFunctions">More Functions</a></li>
        <li><a href="#content5">Animations</a></li>
      </ul>
    </div>
     <div id="chaptertabs3" class="tab-content">
      <ul class="topicContent">
        <li><a href="#combine">Combining Image Data</a></li>
         <li><a href="#average">Average</a></li>
        <li><a href="#middle">Middle</a></li>
        <li><a href="#select">Select</a></li>
        <li><a href="#random">Random</a></li>
      </ul>
    </div>
  </div> 
  
  <div class="topic-content-all">
    <div id="content1" class="topic-content">
      <div class="content"><p>JavaScript has become a widely used programming language. So it's important for any programmer to know how to use it. Why is it important you might ask? Well you just need to look at any website and you will find that JavaScript plays a part in the running of it in one way or another.  At the top left corner of the home page you will find a greeting message. JavaScript is being used here and the message will change depending on what time of day it is. This is a simple example and more advanced examples will be looked but these sort of functions will help give any website you develop a more personal feel to it. 
The aim of the coming chapters is to give you all the knowledge you will need in order to solve any programming task you may be presented with.
Over the course you will learn how to do things such as drawing on a canvas as shown below. You will get the opportunity to try these things out for yourself and see what changes you can make.
The layout of the course will be as follows: 
<ul> 
<li>Strings</li>
<li>Variables</li>
</i>Concatenation</li>
<li>Control Characters</li>
<li>Operators</li>
<li>Conditional Statements</li>
<li>Loops</li>
<li>Arrays</li>
<li>Functions</li>
<li>Bringing it all together</li>
</ul>
Everything is broken down into sections to ensure that a clear understanding is achieved before looking at the more advanced problems
</div>
<canvas id="exampleCanvas" width="500" height="200" style="border:1px solid #d3d3d3;">
 </p>   </div>
        <div id="chapter1Content-2" class="topic-content">
      <div class="content"><p>JavaScript is a client scripting language which is used for the development of web pages. It is used to make the website dynamic.
Whenever you visit a website and it does more than just display information, e.g information displayed at the click of the button, interactive maps etc, it would be a safe bet to say that JavaScript is involved. By looking at the developer tools in a browser you will be able to see the scripts being used, these are inside the script headers, this tells the browser that the code is for a script. You can also save your script in a js file and then call it on the page you're wanting it to be used. Keeping your scripts saved in separate files could help keep your pages less clustered and easier to follow. JavaScript could also be used for tasks such as storing passwords but as the code is accessible to everyone this is not good security practise, for things like that a server side language like PHP is used. You can think of the browser viewing JavaScript like a recipe book, following it step by step in order to complete the meal. It is important to think how a computer would when creating your scripts, a computer will not assume what you mean, it needs specific step by step instructions so it knows what you want it to do.</p> </div>
    </div>
    <div id="strings" class="topic-content">
      <div class="content"><p>Before going on to the media computation approach it is important to make sure an understanding of what everything means. If you already know this, feel free to skip this chapter, however, a refresher never hurts anyone. <br>
 The first thing we are going to look at is strings. What strings are is a group of characters enclosed between speech marks. That's it.
 For our first example we are going to look at getting the browser to output some string. Remember, this has to be enclosed within the script headers but to output the string we are going to use the command <b>alert</b>. <br>
What this does is tell the browser to pop up an alert box, this is where our string message is going to be contained. 
You will see the example below, click on the "Run Code" button to see the result. Feel free to change the message but remember the code has to be contained within the script headers.<br>
After having a go with that try changing the <b>alert</b> command to <b>document.write</b> and see what happens. Everything else stays the same but you will see the changes with how the string is outputted. What you will notice is that the message will appear on the web page rather than a pop up box. What is happening is: 
<ul>
<li>The <b>document</b> object represents the entire web page. This is used by giving its name. It has several methods and properties. These are members of the object</li>
<li>Before stating which method or property you want to use you much place a dot between the object and method (eg document.write).</li>
<li>The <b>write</b> lets new content to be written onto the page</li>
</ul>
The other methods can be found <a href="https://www.w3schools.com/jsref/dom_obj_document.asp">here</a>
</p>
</div>
<button class="button" onclick="putcode(code.value)">Run Code</button>
  <textarea id="code"rows="20"  cols="50" align="left" >
   <script>
alert("I love JavaScript");
</script>
  </textarea>
  <iframe frameborder="0" width="200" height="200" align="right" ></iframe>

  <script>
    var studentCode;
    function putcode(studentCode){
      document.querySelector("iframe").srcdoc=studentCode;
    }
  </script>
    </div>
    <div id="concatenation" class="topic-content">
      <div class="content">
<p>Now we have been looking at displaying a single string but we can add strings together using the concatenation (+) operator, we will learn more about operators soon.
<br>The + operator can also be used for adding integers together which we will look at later. For now look at the example below of concatenation in action, notice how for integers there is no need to surround them in speech marks. The browser knows what to do with them, the speech marks are only required when strings are involved. 
You will notice that in between the two strings in the first example there is no space but on the second example there is. This is because with concatenation you have to tell the browser that you want a 
space between the things you are joining together. This is done by simply doing " ", it's important to remember to have a space between the speech marks otherwise a space will not be implemented.
You will also notice the <b>br</b> tag at the end of the first example, this tells the browser to move onto a new line before displaying the next bit of data to be outputted. You will learn more about this 
and other control characters shortly. </p>
</div>
<button class="button" onclick="putConcatCode(concatCode.value)">Run Code</button>
  <textarea id="concatCode"rows="50"  cols="100" align="left" >
   <script>
document.write("Hello" + "fellow coder<br>");
document.write(42 + " " + "is the meaning of life");
</script>
  </textarea>
  <iframe id="concatExample" frameborder="0" width="200" height="200" align="right" ></iframe>

  <script>
    var studentCode;
    function putConcatCode(studentCode){
      document.querySelector("#concatExample").srcdoc=studentCode;
    }
  </script>
    </div>
    <div id="controlCharacters" class="topic-content">
      <div class="content">
<p>This part is to explain the different type of control characters that you can use to add something to whatever you are outputting. For some of the examples <b>alert</b> will be used
as the browser will not recognise some characters such as \n and \t.  The reason it will work using the alert method is because it is not html and is purely JavaScript. In HTML, all white space (including newlines) is collapsed and treated as a single space. <br>
The different type of control characters are listed below: 
<ul>
<li><b>\n</b> - Move on to a new line</li>
<li><b>br</b> - Move on to a new line (Use this when doing web design, remember the br must be surrounded by <> as well</li>
<li><b>\t</b> - Gives a tab space (This may not work on all browsers)</li>
<li><b>\"</b> - Displays as "</li>
<li><b>\'</b> - Displays as '</li>
<li><b>\\</b> - Displays as \</li>
</ul>
<b>Take note of where these characters are placed, they can't be positioned anywhere, they must be within speech marks otherwise your code will not run</b>
</p>
</div>
<button class="button" onclick="putControlCode(controlCode.value)">Run Code</button>
  <textarea id="controlCode"rows="50"  cols="100" align="left" >
   <script>
alert("Hello \nstudent");
alert("JavaScript\t is fun");
document.write("Hello <br>" + "fellow coder<br>");
document.write("Red is my \'favourite\' colour<br>");
document.write("I said \"Hello\"<br>");
document.write("I can't decide between pizza\\burger");
</script>
  </textarea>
  <iframe id="controlExample" frameborder="0" width="200" height="200" align="right" ></iframe>

  <script>
    var studentCode;
    function putControlCode(studentCode){
      document.querySelector("#controlExample").srcdoc=studentCode;
    }
  </script>
    </div>
    <div id="prompting" class="topic-content">
      <div class="content">
<p>Sometimes you will need to prompt a response from a user or get them to confirm. This is extremely simple to do and can be done using the following keywords:
<ul>
<li><b>prompt</b></li>
<li><b>confirm</b></li>
</ul>
Make sure that your parentheses are matching, this can be an easy mistake to make. <br>
Play about with the examples below and make sure you understand what is happening
</p>
</div>
<button class="button" onclick="putPromptCode(promptCode.value)">Run Code</button>
  <textarea id="promptCode"rows="50"  cols="100" align="left" >
   <script>
alert("Hello " + prompt("What is your name?"));
document.write("Hello " + prompt("What is your name?"));
alert(confirm("Are you enjoying this website?"));
document.write("<br> Answer: " + confirm("JavaScript is the best?"));
</script>
  </textarea>
  <iframe id="promptExample" frameborder="0" width="200" height="200" align="right" ></iframe>

  <script>
    var studentCode;
    function putPromptCode(studentCode){
      document.querySelector("#promptExample").srcdoc=studentCode;
    }
  </script>
    </div>
     <div id="variables" class="topic-content">
     <div class="content">
<h3>Variables</h3>
<p>This part requires a bit of explanation so pay attention and review whenever you need a reminder. We will first look at variables<br>
Sometimes a script will need to temporarily store bits of information required for the task. It stores this data in <b>variables</b>. Remember, in JavaScript
you need to tell the interpreter every single step required to perform the task you want done. This may require more detail than you might first think.<br>
For example, in maths c &#178 = a &#178 + b &#178. To do this you will need the script to do a few things: 
<ol>
<li>Remember the value for a &#178</li>
<li>Remember the value for b &#178</li>
<li>Calculate c &#178 by multiplying a &#178 and b &#178</li>
<li>Return the result to the user</li>
</ol>

In this scenario you would use variables to store the values of a &#178 and b &#178. The example also demonstrates how you need to tell the script precisely what you need it to do.<br>
Variables can be seen as short-term memory as once you leave the page, the browser will forget all the information it holds. A variable's value can change throughout the script, for example, in an order page the variable delivery could be initially set to false but after the customer selects the delivery option it will change to true.<br>

<h4>Rules For Naming</h4>
When it comes to naming variables, there are few rules that developers follow, these are outlined below:

<ul>
<li>The name must begin with a letter, dollar sign($) or an underscore(_), never a number</li>
<li>The name can contain letters, dollar sign($), numbers or an underscore(_). Do not use a dash (-) or period(.) in your variable names</li>
<li>You cannot use any reserved words. These tell the interpreter to do something. Eg, if, var, while, do etc.<li>
<li>Variables are case sensitive, so you could have test and Test as two separate variables, however, this would be bad practise and is highly advised you do not do this.</li>
<li>Use a name which goes with the information that it is storing, such as firstName for storing someone's first name, email for someone's email address etc.</li>
<li>It is conventional to use camel case if your variable is made up of more than one word, this is when every word proceeding the first one starts with a capital letter, eg. lastName. 
An underscore(_) could also be used but never a dash</li>
</ul>

<h4>Operators</h4>

There are a number of different operators, we have already come across one with the concatenation section. The other operators include: arithmetic; assignment; conditional; comparison; logical; typeof; delete; in; instanceof and void. <br> 
Now this may seem quite daunting but don't worry, we will go through each type and hopefully you will be able to obtain an understanding.

<h5>Arithmetic Operators</h5>
We will first look at the simplest type of operators, arithmetic. These are used to perform calculations between variables or values.
<ul>
<li> Addition (+) - Example x = 5 + 2 </li>
<li>Subtraction (-) - Example x = 5 - 2  </li>
<li>Divide (/) - Example x = 8 /2 </li>
<li>Multiplication - Example  x = 5 *2 </li>
<li>Modulus (%) - Example x = 10 % 2. In this instance the answer would be 0 are there are no remainders when 10 is divided by 2</li>
<li>Increment (++) - Example var x; var y=5; x = y++; x would equal 6 in this scenario</li>
<li>Decrement (--) - Example var x = 4; var y; y = x--; y would equal 3 in this scenario</li>
</ul>

<h5>Assignment Operators</h5>
These operators are used for assigning a value to a variable. For example x = 5;<br>
Apart from the the increment and decrement operators you can add the = operator to the arithmetic operators as a shortcut. Examples:
<ul>
<li> x += y is the same as x = x + y</li>
<li>x -= y is the same as x = x - y</li>
<li>x /= y is the same as x = x / y</li>
<li>x *= y is the same as x = x * y</li>
<li>x %= y is the same as x = x % y</li>
</ul>

<h5>Conditional Operators</h5>
This operator assigns a value to a variable based on a condition. The syntax can look something like: <br>
<b>variableName = (condition) ? value1:value2</b> <br>

This could be anything like the drinking age. The variable legal would be determined based on what age the user is, eg using the UK drinking age, if someone is 18 or over legal would be set to True but under 18 it would be set to False. 

<h5>Comparison Operators</h5>
Comparison Operators are used in logical statements that see whether variables or values are equal or different.
The different comparison operators are:

<ul>
<li> == - Equal value</li>
<li> === - Equal value and equal type</li>
<li> != - Not equal value</li>
<li> !== - Not equal value or not equal type</li>
<li> > - Greater than</li>
<li> >= - Greater than or equal to</li>
<li>< - Less than</li>
<li> <= - Less than or equal to</li>
</ul>

<h5>Logical Operators</h5>
These operators are used to determine the logic between values or variables

<ul>
<li> && - and</li>
<li> || - Or </li>
<li> ! - does not</li>
</ul>

<h5>Typeof Operator</h5>
This is used when you are wanting to know the type of variable, function etc. For example<br>
typeof "bob" would return string


<h5>Delete Operator</h5>
The delete operator deletes a property from an object. This can only be used on object properties, it has no affect on variables or functions.

<h5>In Operator</h5>
This operator will return a true or false value if the property is in the specified object or not.

<h5>Instanceof Operator</h5>
This operator will return a true or false value if the object is an instance of a specified object or not. 

<h5>Void Operator</h5>
The void operator evaluates an expression and will return undefined. This is used to obtain the undefined primitive value by using "void(0)". This can be useful to use when evaluating an expression when you are not using the return value. Try the example below which will affect a part of the page <br><br>

<a href="javascript:void(document.body.style.backgroundColor='red');">
  Click me to change the background colour of body to red. <br><br>

<a href="javascript:void(document.body.style.backgroundColor='white');">
  Click me to change the colour back.
</a>
<br><br>

The code that does this is as follows: <br><br>
javascript:void(document.body.style.backgroundColor='red'); <br><br>

Now there are quite a few example to look through, go through each one carefully and see the affects they are having. Play about with them and try different operators and see the result of each one.
</p>
</div>
<button class="button" onclick="putVariableCode(variableCode.value)">Run Code</button>
  <textarea id="variableCode"rows="50"  cols="100" align="left" >
   <script>
//Arithmetic Example
document.write("Arithmetic example <br>");
var x = 2;
var y = 3;
var z = x + y;
document.write("Z =  " + z + "<br>");

//Assignment example
document.write("Assignment example <br>");
x  *= y;
document.write("X = " + x + "<br>");

//Conditional Example
document.write("Conditional example <br>");
  var age, legal;
  age = prompt("What is your age");
  legal= (age < 18) ? "Too young":"Old enough";
  document.write (legal + " to drink. <br>");

//Comparison Example
document.write("Comparison example <br>");
document.write(x === "6"); // note this will return false as even though x does equal 6, it is an integer and not a string like this statement is saying

document.write( "<br>"); 
//Logical Example

document.write( x < 5 || y > 2 ); 

document.write( "<br>"); 

//Typeof example
document.write("Typeof example <br>");
document.write("Bob is a " + typeof "Bob");

document.write( "<br>"); 

//The following examples will include parts of JavaScript that have not been covered yet, don't worry these will be covered in due course

document.write("Delete example <br>");
//Delete example
var car = {
  type:"Ford",
  model:"Mustang",
  price:36000,
  colour:"red"

};

document.write(car.type + " " + car.model + " " + car.price + " " + car.colour + "<br>");

delete car.price;

document.write(car.type + " " + car.model + " " + car.price + " " + car.colour + "<br>");

//In example
document.write("In example <br>");
var people = ["Bob", "Hannah", "Jamie"];

document.write("Hannah" in people);
document.write( "<br>"); 
document.write(0 in people);
document.write( "<br>"); 

//instanceof example

document.write("Instanceof example <br>");
document.write(people instanceof Array);
document.write( "<br>"); 
document.write(people instanceof String);



</script>
  
  </textarea>
  <iframe id="variableExample" frameborder="0" width="300" height="500" align="right" ></iframe>

  <script>
    var studentCode;
    function putVariableCode(studentCode){
      document.querySelector("#variableExample").srcdoc=studentCode;
    }
  </script>
    </div>
    <div id="forLoops" class="topic-content">
      <div class="content">
<p>
For loops are for looping through a block of code a number of times. The syntax can look something like the following: <br>
<textarea rows="10" cols="100" style="border: none" id="explanation" readonly>
for (statement1; statement2; statement3) {
    //code to be executed
}

A full example could be something like:

for (var i = 0; i < 10; i ++) {
document.write(i);
}
 </textarea>   
<br>
In the example shown above it is a counter that counts to 10. Numbers will keep printing until it reaches the 10th number. The result of this would be: <br>
0123456789<br>
This is due to numbers starting from 0 in programming. <br><br>
For loops use a counter as a condition . It constructs the code to run a specified a number of times, the condition is made up of 3 statements. We will break down the simple example to explain fully.<br>

<h3>Initialisation</h3>
The first step of a for loop is to initialise the loop, this involves creating a variable and setting it to 0. Most examples will call it i, although you can name it whatever you want, and it acts as the counter. <b>Var i = 0; </b> This variable is created the first time the loop is run. Sometimes you may see the variable being declared before the condition and it could look like: <br>
var i; <br>
for (i = 0 .........) <br>
Both ways are correct and is just down to the preference of the coder.

<h3>Condition</h3>
The loop will continue to run until the counter reaches the specified number. <br>
<b>i < 10;</b> <br>
In this example i started off at 0, so the loop will run 10 times and finish at number 9. If i had been set to 4 then the output would be: 456789. <br>
If you so desired you could also set a variable to hold a number and use that in the condition. Instead of i < 10; you could set a variable such as: <br>
var number = 5; then the condition would look like: <br>
i < (rounds);

<h3>Update</h3>

<b>i++</b> In the example every time the loop has run it adds one to the counter, you can also do things such as i-- which will take one away from i each time the loop has run. Another example could see something such as: i +=4. Here each the loop has run it would add 4 to i. 
<br><br>
We are now going to look at a more advanced example of a for loop.  The example will be using a canvas so if you have not worked with them before it is recommended to read about it <a href="canvas.php">here</a> <br>

The following examples will now be using the <b>Media Computation</b> approach.  We will be looking at taking the pixels of an image and manipulating them using a for loop.  The RGB colours values will be getting used which is why you will be seeing numbers such as 235 and 52. Feel free to play about with these numbers and see the affects it has on the picture.<br><br>

You can change the image if you wish, to do this you will need to copy an image address from a website (such as google) and put it in the image source (replaces images/dog.jpg  with whatever image address you want). However, you will need to convert this image into a base64 image otherwise the canvas will become tainted and you will not see the affects of the for loop take place. You can convert the image <a href = "https://www.base64-image.de/" target="_blank">here</a>.

</p>
</div>

<button class="button" onclick="putForCode(forCode.value)">Run Code</button>
  <textarea id="forCode"rows="30"  cols="80" align="left" >

<img id="example" src="images/dog.jpg" alt="dog" width="220" height="277">
<canvas id="canvas" width="300" height="400" style="border:1px solid #d3d3d3;">
</canvas>

<script>

document.getElementById("example").onload = function() { //run as soon as loaded
  var c = document.getElementById("canvas");
  var ctx = c.getContext("2d");
  var img = document.getElementById("example");
  ctx.drawImage(img, 0, 0);
  var imgData = ctx.getImageData(0, 0, c.width, c.height);
  // invert colors
  var i;
  for (i = 0; i < imgData.data.length; i += 4) {
    imgData.data[i] = 235 - imgData.data[i];
    imgData.data[i+1] = 52 - imgData.data[i+1];
    imgData.data[i+2] = 52 - imgData.data[i+2];
    imgData.data[i+3] = 235;
  }
  ctx.putImageData(imgData, 0, 0);
};
</script>
  </textarea>
<iframe id="forExample" frameborder="0" width="500" height="500" align="center" ></iframe>
  <script>
    var studentCode;
    function putForCode(studentCode){
      document.querySelector("#forExample").srcdoc=studentCode;
    }
  </script>
    </div> 
    <div id="arrays" class="topic-content">
      <div class="content">
<p>
Arrays are a special type of a variable that can store multiple values 
</p>
</div>
<button class="button" onclick="putArrayCode(arrayCode.value)">Run Code</button>
  <textarea id="arrayCode"rows="30"  cols="80" align="left" >


<canvas id="canvas" width="500" height="500"></canvas>


<script>
var canvas = document.getElementById('canvas');
var ctx = canvas.getContext('2d');
var bRowCount = 5; //number of rows of bricks
var bColCount = 10; //number of columns of bricks
var bHeight = 30;  //height of bricks
var bWidth = 60;  //width of bricks
var bPadding = 3; //space before next brick
var bTopOffset = 10;  //space at top of brick
var bLeftOffset = 10; //space to left of brick

var bricks = {};  //bricks array

for (c = 0; c < bColCount; c++) { 
bricks [c] = {}; //array of bricks with column values 
for (r = 0; r<bRowCount; r++) { 
bricks [c][r] = {x:0, y:0, status:1}; //array of bricks with column and row values, each value has x and y value for its position, having a status of 1 makes the brick visible
//if we were to make this into a full brick breaker game then we could change the status of the brick to 2 so that it would disappear when the brick was hit
}
}

function drawBricks() { //function to create the bricks
for (c = 0; c < bColCount; c++) {
for (r = 0; r < bRowCount; r++) {
if (bricks[c][r].status == 1){ //if the brick has a status of 1 then carry on
var bX = (c * (bWidth + bPadding)) + bLeftOffset; 
var bY = (r * (bHeight + bPadding)) + bTopOffset; 
bricks[c][r].x = 0;
bricks[c][r].y = 0;
ctx.beginPath();  //begins path for drawing shapes
ctx.rect(bX, bY, bWidth, bHeight);
ctx.fillStyle = 'rgb(' + (Math.floor(Math.random() * 156) + 100) + ',' + (Math.floor(Math.random() * 156) + 100) + ',' + (Math.floor(Math.random() * 156) + 100) + ')';  
//this will colour the bricks, the colours are selected at random so each time the code is run the colours will change
ctx.fill(); 
ctx.closePath(); 
}
}
}
}
drawBricks(); //call the function

</script>

  
  </textarea>
<iframe id="arrayExample" frameborder="0" width="400" height="400" align="center" ></iframe>
  <script>
    var studentCode;
    function putArrayCode(studentCode){
      document.querySelector("#arrayExample").srcdoc=studentCode;
    }
  </script>
    </div>
    <div id="functions" class="topic-content">
      <div class="content">
<p>
Functions are a group of statements joined together in order to perform a specific task. You can set these to run as soon as the page is loaded or to be triggered after an event has occurred,
such as when a button is clicked. A function is what is in place for the "try it yourself editors" you have been seeing. The function is activated when you press the "Run Code" button.<br>


</p>
</div>

<button class="button" onclick="putFunctionCode(functionCode.value)">Run Code</button>
  <textarea id="functionCode"rows="30"  cols="80" align="left" >

<canvas id="canvas" width="500" height="500"></canvas>
<button type="button" id="grayscale">Gray Scale</button>
<button type="button" id="invert">Invert</button>
</canvas>

<script>
var img = new Image();
img.src = 'images/dog.jpg';
img.onload = function() {
  draw(this);
};

function draw(img) {
  var canvas = document.getElementById('canvas');
  var ctx = canvas.getContext('2d');
  ctx.drawImage(img, 0, 0);
  img.style.display = 'none';
  var imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
  var data = imageData.data;
    
  var invert = function() {
    for (var i = 0; i < data.length; i += 4) {
      data[i]     = 255 - data[i];     // red
      data[i + 1] = 255 - data[i + 1]; // green
      data[i + 2] = 255 - data[i + 2]; // blue
    }
    ctx.putImageData(imageData, 0, 0);
  };

  var grayscale = function() {
    for (var i = 0; i < data.length; i += 4) {
      var avg = (data[i] + data[i + 1] + data[i + 2]) / 3;
      data[i]     = avg; // red
      data[i + 1] = avg; // green
      data[i + 2] = avg; // blue
    }
    ctx.putImageData(imageData, 0, 0);
  };

  var invertbtn = document.getElementById('invert');
  invertbtn.addEventListener('click', invert);
  var grayscalebtn = document.getElementById('grayscale');
  grayscalebtn.addEventListener('click', grayscale);
}


</script>
  </textarea>
<iframe id="functionExample" frameborder="0" width="400" height="700" align="center" ></iframe>
  <script>
    var studentCode;
    function putFunctionCode(studentCode){
      document.querySelector("#functionExample").srcdoc=studentCode;
    }
  </script>
    </div>
    <div id="moreFunctions" class="topic-content">
      <div class="content">
<p>
We are going to look at another example of functions being used. This time we are going to be looking at how to use JavaScript to flip a picture both vertically and horizontally. 
</p>
</div>

<button class="button" onclick="putMoreFunctionCode(moreFunctionCode.value)">Run Code</button>
  <textarea id="moreFunctionCode"rows="30"  cols="80" align="left" >


    <input type="checkbox" id="horizontalCheckbox" />Flip horizontal</label>
    <input type="checkbox" id="verticalCheckbox" />Flip vertical</label>
    <button id="flipButton">Flip the picutre</button>


<canvas id="canvas" width="500" height="500"></canvas>
<script>
var canvas = document.getElementById('canvas'),
    ctx = canvas.getContext('2d'),
    flipButton = document.getElementById('flipButton'),
    img = new Image(),
    width = 500,
    height = 500;

function flipImage(image, ctx, flipHoriz, flipVert) {
    var scaleHoriz = flipHoriz ? -1 : 1, // Set horizontal scale to -1 if flip horizontal
        scaleVert = flipVert ? -1 : 1, // Set vertical scale to -1 if flip vertical
        posX = flipHoriz ? width * -1 : 0, // Set x position to -100% if flip horizontal 
        posY = flipVert ? height * -1 : 0; // Set y position to -100% if flip vertical
    
    ctx.save(); // Save the current state
    ctx.scale(scaleHoriz, scaleVert); // Set scale to flip the image
    ctx.drawImage(img, posX, posY, width, height); // draw the image
    ctx.restore(); // Restore the last saved state
};

function flipCanvas() {
    var flipHoriz = document.getElementById('horizontalCheckbox').checked,
        flipVert = document.getElementById('verticalCheckbox').checked;
    
    flipImage(img, ctx, flipHoriz, flipVert);
    
    return false;
}

flipButton.onclick = flipCanvas;
img.onload = flipCanvas;

img.src = 'images/dog.jpg';


</script>
  
  </textarea>
<iframe id="moreFunctionExample" frameborder="0" width="400" height="700" align="center" ></iframe>
  <script>
    var studentCode;
    function putMoreFunctionCode(studentCode){
      document.querySelector("#moreFunctionExample").srcdoc=studentCode;
    }
  </script>
    </div>
    <div id="content5" class="topic-content">
      <div class="content"><canvas id="clockCanvas" width="500" height="200" style="border:1px solid #d3d3d3;"></div>
    </div>
  </div> 

  <div id="combine" class="topic-content">
      <div class="content">
<p>

</p>

    </div>

<script>
//script for displaying the content of the tab chosen
$(".chapters li:first").addClass("current");
$(".topic-content:first").fadeIn();
$(".tab-content:first").fadeIn();

$(".chapter-list a").click(function(event) {
  event.preventDefault();
  $(this).parent().addClass("current");
  $(this).parent().siblings().removeClass("current");
  var tab = $(this).attr("href");
  $(".tab-content").not(tab).css("display", "none");
  $(tab).fadeIn();
  $("li:first a",tab).click();
});

$(".topicContent a").click(function(event) {
  event.preventDefault();
  $(this).parent().addClass("current");
  $(this).parent().siblings().removeClass("current");
  var tab = $(this).attr("href");
  $(".topic-content").not(tab).css("display", "none");
  $(tab).fadeIn();
});
</script>

<script>
var c = document.getElementById("exampleCanvas");
var ctx = c.getContext("2d");
ctx.font = "90px Arial";
ctx.strokeText("Hello World",20,70);
</script>

<script>
function clock() {
  var now = new Date();
  var ctx = document.getElementById('clockCanvas').getContext('2d');
  ctx.save();
  ctx.clearRect(0, 0, 150, 150);
  ctx.translate(75, 75);
  ctx.scale(0.4, 0.4);
  ctx.rotate(-Math.PI / 2);
  ctx.strokeStyle = 'red';
  ctx.fillStyle = 'grey';
  ctx.lineWidth = 8;
  ctx.lineCap = 'round';

  // Hour marks
  ctx.save();
  for (var i = 0; i < 12; i++) {
    ctx.beginPath();
    ctx.rotate(Math.PI / 6);
    ctx.moveTo(100, 0);
    ctx.lineTo(120, 0);
    ctx.stroke();
  }
  ctx.restore();

  // Minute marks
  ctx.save();
  ctx.lineWidth = 5;
  for (i = 0; i < 60; i++) {
    if (i % 5!= 0) {
      ctx.beginPath();
      ctx.moveTo(117, 0);
      ctx.lineTo(120, 0);
      ctx.stroke();
    }
    ctx.rotate(Math.PI / 30);
  }
  ctx.restore();
 
  var sec = now.getSeconds();
  var min = now.getMinutes();
  var hr  = now.getHours();
  hr = hr >= 12 ? hr - 12 : hr;

  ctx.fillStyle = 'black';

  // write Hours
  ctx.save();
  ctx.rotate(hr * (Math.PI / 6) + (Math.PI / 360) * min + (Math.PI / 21600) *sec);
  ctx.lineWidth = 14;
  ctx.beginPath();
  ctx.moveTo(-20, 0);
  ctx.lineTo(80, 0);
  ctx.stroke();
  ctx.restore();

  // write Minutes
  ctx.save();
  ctx.rotate((Math.PI / 30) * min + (Math.PI / 1800) * sec);
  ctx.lineWidth = 10;
  ctx.beginPath();
  ctx.moveTo(-28, 0);
  ctx.lineTo(112, 0);
  ctx.stroke();
  ctx.restore();
 
  // Write seconds
  ctx.save();
  ctx.rotate(sec * Math.PI / 30);
  ctx.strokeStyle = '#D40000';
  ctx.fillStyle = '#D40000';
  ctx.lineWidth = 6;
  ctx.beginPath();
  ctx.moveTo(-30, 0);
  ctx.lineTo(83, 0);
  ctx.stroke();
  ctx.beginPath();
  ctx.arc(0, 0, 10, 0, Math.PI * 2, true);
  ctx.fill();
  ctx.beginPath();
  ctx.arc(95, 0, 10, 0, Math.PI * 2, true);
  ctx.stroke();
  ctx.fillStyle = 'rgba(0, 0, 0, 0)';
  ctx.arc(0, 0, 3, 0, Math.PI * 2, true);
  ctx.fill();
  ctx.restore();

  ctx.beginPath();
  ctx.lineWidth = 14;
  ctx.strokeStyle = '#325FA2';
  ctx.arc(0, 0, 142, 0, Math.PI * 2, true);
  ctx.stroke();

  ctx.restore();

  window.requestAnimationFrame(clock);
}

window.requestAnimationFrame(clock);
</script>



</body>
</html> 
