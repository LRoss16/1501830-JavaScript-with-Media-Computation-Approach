//Code for the greetins message that is displayed on the homepage
//The message displayed will depend on what time it is 
var today = new Date();
var hourNow = today.getHours();
var greeting;

if (hourNow > 17) {
    greeting = 'Good evening!';
} else if (hourNow > 11) {
    greeting = 'Good afternoon!';
} else if (hourNow > 0) {
    greeting = 'Good morning!';
} else {
    greeting = 'Welcome!';
}

document.write('<h3>' + greeting + '</h3>');