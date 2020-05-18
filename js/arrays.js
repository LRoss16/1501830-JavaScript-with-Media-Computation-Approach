//code editor for arrays example

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

$this.boxHTML.val(
'<canvas id="canvas" width="500" height="500"></canvas>')
		
$this.boxJS.val(

'var canvas = document.getElementById("canvas");' + '\n' +
'var ctx = canvas.getContext("2d");' + '\n' +
'var bRowCount = 5; //number of rows of bricks' + '\n' +
'var bColCount = 10; //number of columns of bricks' + '\n' + 
'var bHeight = 30;  //height of bricks' + '\n' +
'var bWidth = 60;  //width of bricks' + '\n' + 
'var bPadding = 3; //space before next brick' + '\n' +
'var bTopOffset = 10;  //space at top of brick' + '\n' +
'var bLeftOffset = 10; //space to left of brick' + '\n' + '\n' +

'var bricks = {};  //bricks array' + '\n' + '\n' +

'for (c = 0; c < bColCount; c++) { ' + '\n' +
'bricks [c] = {}; //array of bricks with column values ' + '\n' +
'for (r = 0; r<bRowCount; r++) { ' + '\n' +
'bricks [c][r] = {x:0, y:0, status:1}; //array of bricks with column and row values, each value has x and y value for its position, having a status of 1 makes the brick visible' + '\n' +
'//if we were to make this into a full brick breaker game then we could change the status of the brick to 2 so that it would disappear when the brick was hit' + '\n' + 
'}' + '\n' +
'}' + '\n' + '\n' +

'function drawBricks() { //function to create the bricks' + '\n' +
'for (c = 0; c < bColCount; c++) {' + '\n' +
'for (r = 0; r < bRowCount; r++) {' + '\n' +
'if (bricks[c][r].status == 1){ //if the brick has a status of 1 then carry on' + '\n' +
'var bX = (c * (bWidth + bPadding)) + bLeftOffset; ' + '\n' +
'var bY = (r * (bHeight + bPadding)) + bTopOffset; ' + '\n' +
'bricks[c][r].x = 0;' + '\n' +
'bricks[c][r].y = 0;' + '\n' +
'ctx.beginPath();  //begins path for drawing shapes' + '\n' +
'ctx.rect(bX, bY, bWidth, bHeight);' + '\n' +
'ctx.fillStyle = "rgb(" + (Math.floor(Math.random() * 156) + 100) + "," + (Math.floor(Math.random() * 156) + 100) + "," + (Math.floor(Math.random() * 156) + 100) + ")";  ' + '\n' +
'//this will colour the bricks, the colours are selected at random so each time the code is run the colours will change' + '\n' +
'ctx.fill(); ' + '\n' +
'ctx.closePath(); ' + '\n' + 
'}' + '\n' +
'}' + '\n' +
'}' + '\n' +
'}' + '\n' +
'drawBricks(); //call the function')

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
			this.boxJS.val('var canvas = document.getElementById("canvas");' + '\n' +
'var ctx = canvas.getContext("2d");' + '\n' +
'var bRowCount = 5; //number of rows of bricks' + '\n' +
'var bColCount = 10; //number of columns of bricks' + '\n' + 
'var bHeight = 30;  //height of bricks' + '\n' +
'var bWidth = 60;  //width of bricks' + '\n' + 
'var bPadding = 3; //space before next brick' + '\n' +
'var bTopOffset = 10;  //space at top of brick' + '\n' +
'var bLeftOffset = 10; //space to left of brick' + '\n' + '\n' +

'var bricks = {};  //bricks array' + '\n' + '\n' +

'for (c = 0; c < bColCount; c++) { ' + '\n' +
'bricks [c] = {}; //array of bricks with column values ' + '\n' +
'for (r = 0; r<bRowCount; r++) { ' + '\n' +
'bricks [c][r] = {x:0, y:0, status:1}; //array of bricks with column and row values, each value has x and y value for its position, having a status of 1 makes the brick visible' + '\n' +
'//if we were to make this into a full brick breaker game then we could change the status of the brick to 2 so that it would disappear when the brick was hit' + '\n' + 
'}' + '\n' +
'}' + '\n' + '\n' +

'function drawBricks() { //function to create the bricks' + '\n' +
'for (c = 0; c < bColCount; c++) {' + '\n' +
'for (r = 0; r < bRowCount; r++) {' + '\n' +
'if (bricks[c][r].status == 1){ //if the brick has a status of 1 then carry on' + '\n' +
'var bX = (c * (bWidth + bPadding)) + bLeftOffset; ' + '\n' +
'var bY = (r * (bHeight + bPadding)) + bTopOffset; ' + '\n' +
'bricks[c][r].x = 0;' + '\n' +
'bricks[c][r].y = 0;' + '\n' +
'ctx.beginPath();  //begins path for drawing shapes' + '\n' +
'ctx.rect(bX, bY, bWidth, bHeight);' + '\n' +
'ctx.fillStyle = "rgb(" + (Math.floor(Math.random() * 156) + 100) + "," + (Math.floor(Math.random() * 156) + 100) + "," + (Math.floor(Math.random() * 156) + 100) + ")";  ' + '\n' +
'//this will colour the bricks, the colours are selected at random so each time the code is run the colours will change' + '\n' +
'ctx.fill(); ' + '\n' +
'ctx.closePath(); ' + '\n' + 
'}' + '\n' +
'}' + '\n' +
'}' + '\n' +
'}' + '\n' +
'drawBricks(); //call the function');
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

