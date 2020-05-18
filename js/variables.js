//code editor for variables example
(function($)
{
	$.fn.JSM = function(option, settings)
	{	
		if(typeof option === 'object')
		{
			settings = option;
		}
		else if(typeof option === 'string')
		{
			var data = this.data('_JSM');

			if(data)
			{
				if(option == 'resize') { data.resize(); return true }
				else if($.fn.JSM.defaultSettings[option] !== undefined)
				{
					if(settings !== undefined){
						data.settings[option] = settings;
						return true;
					}
					else return data.settings[option];
				}
				else return false;
			}
			else return false;
		}

		settings = $.extend({}, $.fn.JSM.defaultSettings, settings || {});

		return this.each(function()
		{
			var $elem = $(this);

			var $settings = jQuery.extend(true, {}, settings);

			var jsn = new JSNova($settings);

			$elem.append(jsn.generate());
			jsn.resize();

			$elem.data('_JSM', jsn);
		});
	}

	$.fn.JSM.defaultSettings = {};

	function JSNova(settings)
	{
		this.jsn = null;
		this.settings = settings;

		this.menu = null;

		this.sidebar = null;
		this.jQueryVersion = null;
		this.jQueryUIVersion = null;
		this.jQueryUITheme = null;

		this.codeArea = null;
		this.boxHTML = null;
		this.boxCSS = null;
		this.boxEgJs = null;
		this.boxJS = null;
		this.boxResult = null;

		return this;
	}
	

	JSNova.prototype = 
	{
		init: function()
		{
			this.resize();
		},
		
		generate: function()
		{
			var $this = this;

			if($this.jsn) return $this.jsn;

			//menu
			var menuButton_run = $('<span class="_JSM_menuButton">Run</span>').click(function(){$this.run();});
			var menuButton_reset = $('<span class="_JSM_menuButton">Reset</span>').click(function(){$this.reset();});

			$this.menu = 
			$('<div class="_JSM_menu"></div>')
			.append(
				$('<div class="_JSM_menuPadding"></div>')
				.append(menuButton_run)
				.append(' <span class="_JSM_menuBullet">&bull;</span> ')
				.append(menuButton_reset)
			);

        //Code to load in boxes on page load

		window.onload = function() {

		
$this.boxJS.val(

'//Arithmetic Example' + '\n' +
'document.write("Arithmetic example <br>");' + '\n' +
'var x = 2;' +'\n' +
'var y = 3;' + '\n' +
'var z = x + y;' + '\n' +
'document.write("Z =  " + z + "<br>");' + '\n' + '\n' +

'document.write( "<br>"); ' + '\n' +
'//Assignment example' + '\n' +
'document.write("Assignment example <br> ");' + '\n' +
'x  *= y;' + '\n' +
'document.write("X = " + x + "<br>");' + '\n' + '\n' +
'document.write( "<br>"); ' + '\n' +
'//Conditional Example' + '\n' +
'document.write("Conditional example <br>");' + '\n' +
  'var age, legal;' + '\n' +
  'age = prompt("What is your age");' + '\n' +
  'legal= (age < 18) ? "Too young":"Old enough";' + '\n' +
  'document.write (legal + " to drink <br>.");' + '\n' + '\n' +
'document.write( "<br>"); ' + '\n' +
'//Comparison Example' + '\n' +
'document.write("Comparison example <br> ");' + '\n' +
'document.write(x === "6"); // note this will return false as even though x does equal 6, it is an integer and not a string like this statement is saying' + '\n' + '\n' +

'document.write( "<br>"); ' + '\n' +
'document.write( "<br>"); ' + '\n' +
'//Logical Example' + '\n' + 
'document.write("Logical example <br>");' + '\n' + '\n ' +

'document.write( x < 5 || y > 2 ); ' + '\n' + '\n' +

'document.write( "<br>"); ' + '\n' +
'document.write( "<br>"); ' + '\n' +
'//Typeof example' + '\n' +
'document.write("Typeof example <br>");' + '\n' +
'document.write("Bob is a " + typeof "Bob");' + '\n' + '\n' +


'document.write( "<br>"); ' + '\n' +
'document.write( "<br>"); ' + '\n' +
'//The following examples will include parts of JavaScript that have not been covered yet, do not worry these will be covered in due course' + '\n' + '\n' +

'document.write("Delete example <br>");' + '\n' +
'//Delete example' + '\n' +
'var car = {' + '\n' +
  'type:"Ford",' + '\n' +
  'model:"Mustang",' + '\n' +
  'price:36000,' + '\n' +
  'colour:"red"' + '\n' + '\n' +

'};' + '\n' + '\n' +

'document.write(car.type + " " + car.model + " " + car.price + " " + car.colour + "<br>");' + '\n' + '\n' +

'delete car.price;' + '\n' + '\n' +

'document.write(car.type + " " + car.model + " " + car.price + " " + car.colour + "<br>");' + '\n' + '\n' +
'document.write( "<br>"); ' + '\n' +
//In example
'document.write("In example <br>");' + '\n' +
'var people = ["Bob", "Hannah", "Jamie"];' + '\n' + '\n' +

'document.write("Hannah" in people);' + '\n' + '\n' +
'document.write( "<br>"); ' + '\n' +

'document.write(0 in people);' + '\n' + '\n' +

'document.write( "<br>"); ' + '\n' +
'document.write( "<br>"); ' + '\n' +
'//instanceof example' + '\n' +
'document.write("Instanceof example <br>");' + '\n' +
'document.write(people instanceof Array);' + '\n' + '\n' +
'document.write( "<br>"); ' + '\n' +
'document.write(people instanceof String);' 
)

}
		//code area
			$this.boxHTML = $('<textarea class="_JSM_boxEdit"></textarea>');
			$this.boxHTML.hide();
			$this.boxEgJs = $('<textarea class="_JSM_boxEdit"></textarea>');
			$this.boxCSS = $('<textarea class="_JSM_boxEdit"></textarea>');
			$this.boxJS = $('<textarea class="_JSM_boxEdit"></textarea>');
			$this.boxResult = $('<iframe id="iframe" class="_JSM_boxEdit" frameBorder="0"></iframe>');
			
			$.each([$this.boxHTML, $this.boxEgJs, $this.boxCSS, $this.boxJS, $this.boxResult], function(index, item)
			{
				item
				.focus(function(){ $(this).parent().children('._JSM_boxLabel').fadeOut(); })
				.blur(function(){ $(this).parent().children('._JSM_boxLabel').fadeIn(); });
			});
			
			$this.codeArea = 
			$('<div class="_JSM_codeArea"></div>')
			.append(
				$('<table class="_JSM_codeAreaTable" cellpadding="0" cellspacing="1"></table>')
				
				.append(
					$('<tr></tr>')
					.append(
						$('<td class="_JSM_box  _JSM_boxLeft"></td>')
						.append(
							$('<div class="_JSM_boxContainer"></div>')
							.append($this.boxJS)
							.append('<div class="_JSM_boxLabel">JavaScript</div>')
						)
					)
					.append(
						$('<td class="_JSM_box _JSM_boxRight"></td>')
						.append(
							$('<div class="_JSM_boxContainer"></div>')
							.append($this.boxResult)
							.append('<div class="_JSM_boxLabel">Result</div>')
						)
					)
				)
			)
			
			$this.jsn = 
			$('<div class="_JSM_holder"></div>')
			.append($this.menu)
			.append($this.codeArea);
			
			return $this.jsn;
		},
		
		run: function()
		{
			var html = this.boxHTML.val();
			var css = this.boxCSS.val();
			var js = this.boxJS.val();
			var egjs = this.boxEgJs.val();
			
			
			
			var result = '<html><head>' + '<style>' + css + '</style></head><body>' + html + '<script type="text/javascript">' + egjs + '</script>' + '<script type="text/javascript">' + js + '</script></body></html>';
			
			this.writeResult(result);
		},
		
		reset: function()
		{
			this.boxJS.val('//Arithmetic Example' + '\n' +
'document.write("Arithmetic example <br>");' + '\n' +
'var x = 2;' +'\n' +
'var y = 3;' + '\n' +
'var z = x + y;' + '\n' +
'document.write("Z =  " + z + "<br>");' + '\n' + '\n' +

'document.write( "<br>"); ' + '\n' +
'//Assignment example' + '\n' +
'document.write("Assignment example <br> ");' + '\n' +
'x  *= y;' + '\n' +
'document.write("X = " + x + "<br>");' + '\n' + '\n' +
'document.write( "<br>"); ' + '\n' +
'//Conditional Example' + '\n' +
'document.write("Conditional example <br>");' + '\n' +
  'var age, legal;' + '\n' +
  'age = prompt("What is your age");' + '\n' +
  'legal= (age < 18) ? "Too young":"Old enough";' + '\n' +
  'document.write (legal + " to drink <br>.");' + '\n' + '\n' +
'document.write( "<br>"); ' + '\n' +
'//Comparison Example' + '\n' +
'document.write("Comparison example <br> ");' + '\n' +
'document.write(x === "6"); // note this will return false as even though x does equal 6, it is an integer and not a string like this statement is saying' + '\n' + '\n' +

'document.write( "<br>"); ' + '\n' +
'document.write( "<br>"); ' + '\n' +
'//Logical Example' + '\n' + 
'document.write("Logical example <br>");' + '\n' + '\n ' +

'document.write( x < 5 || y > 2 ); ' + '\n' + '\n' +

'document.write( "<br>"); ' + '\n' +
'document.write( "<br>"); ' + '\n' +
'//Typeof example' + '\n' +
'document.write("Typeof example <br>");' + '\n' +
'document.write("Bob is a " + typeof "Bob");' + '\n' + '\n' +


'document.write( "<br>"); ' + '\n' +
'document.write( "<br>"); ' + '\n' +
'//The following examples will include parts of JavaScript that have not been covered yet, do not worry these will be covered in due course' + '\n' + '\n' +

'document.write("Delete example <br>");' + '\n' +
'//Delete example' + '\n' +
'var car = {' + '\n' +
  'type:"Ford",' + '\n' +
  'model:"Mustang",' + '\n' +
  'price:36000,' + '\n' +
  'colour:"red"' + '\n' + '\n' +

'};' + '\n' + '\n' +

'document.write(car.type + " " + car.model + " " + car.price + " " + car.colour + "<br>");' + '\n' + '\n' +

'delete car.price;' + '\n' + '\n' +

'document.write(car.type + " " + car.model + " " + car.price + " " + car.colour + "<br>");' + '\n' + '\n' +
'document.write( "<br>"); ' + '\n' +
//In example
'document.write("In example <br>");' + '\n' +
'var people = ["Bob", "Hannah", "Jamie"];' + '\n' + '\n' +

'document.write("Hannah" in people);' + '\n' + '\n' +
'document.write( "<br>"); ' + '\n' +

'document.write(0 in people);' + '\n' + '\n' +

'document.write( "<br>"); ' + '\n' +
'document.write( "<br>"); ' + '\n' +
'//instanceof example' + '\n' +
'document.write("Instanceof example <br>");' + '\n' +
'document.write(people instanceof Array);' + '\n' + '\n' +
'document.write( "<br>"); ' + '\n' +
'document.write(people instanceof String);' );
			this.writeResult('');
		},
		
		writeResult: function(result)
		{
			var iframe = this.boxResult[0];
		
			if(iframe.contentDocument) doc = iframe.contentDocument;
			else if(iframe.contentWindow) doc = iframe.contentWindow.document;
			else doc = iframe.document;
			
			doc.open();
			doc.writeln(result);
			doc.close();
		},
		
		resize: function()
		{
			var menuHeight = this.menu.outerHeight(true);
			var jsnHeight = this.jsn.outerHeight(true) - menuHeight;
			
			var codeAreaWidth = this.jsn.outerWidth(true);

			this.codeArea.css({top: menuHeight, height: jsnHeight, width: codeAreaWidth});
		}
	}
})(jQuery);

