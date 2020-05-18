//code editor for functions example
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
'<canvas id="canvas" width="500" height="500"></canvas>' + '\n' +
'<button type="button" id="grayscale">Gray Scale</button>' + '\n' +
'<button type="button" id="invert">Invert</button>' + '\n' +
'<img id="example" src="../images/dog.jpg" alt="dog" >')
		
$this.boxJS.val(

'var img = document.getElementById("example");' + '\n' +
'img.onload = function() {' + '\n' +
'  draw(this);' + '\n' +
'};' + '\n' + '\n' +

'function draw(img) {' + '\n' +
 'var canvas = document.getElementById("canvas");' + '\n' +
  'var ctx = canvas.getContext("2d");' + '\n' +
  'ctx.drawImage(img, 0, 0);' + '\n' +
  'img.style.display = "none";' + '\n' +
  'var imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);' + '\n' +
  'var data = imageData.data;' + '\n' + '\n' +
    
  'var invert = function() {' + '\n' +
    'for (var i = 0; i < data.length; i += 4) {' + '\n' +
      'data[i]     = 255 - data[i];     // red' + '\n' +
      'data[i + 1] = 255 - data[i + 1]; // green' + '\n' +
      'data[i + 2] = 255 - data[i + 2]; // blue' + '\n' +
    '}' + '\n' +
    'ctx.putImageData(imageData, 0, 0);' + '\n' +
  '};' + '\n' + '\n' +

  'var grayscale = function() {' + '\n' +
    'for (var i = 0; i < data.length; i += 4) {' + '\n' +
      'var avg = (data[i] + data[i + 1] + data[i + 2]) / 3;' + '\n' +
      'data[i]     = avg; // red' + '\n' +
      'data[i + 1] = avg; // green' + '\n' +
      'data[i + 2] = avg; // blue' + '\n' +
   '}' + '\n' +
    'ctx.putImageData(imageData, 0, 0);' + '\n' +
  '};' + '\n' + '\n' +

  'var invertbtn = document.getElementById("invert");' + '\n' +
  'invertbtn.addEventListener("click", invert);' + '\n' +
  'var grayscalebtn = document.getElementById("grayscale");' + '\n' +
  'grayscalebtn.addEventListener("click", grayscale);' + '\n' +
'}')

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
			this.boxJS.val('var img = document.getElementById("example");' + '\n' +
'img.onload = function() {' + '\n' +
'  draw(this);' + '\n' +
'};' + '\n' + '\n' +

'function draw(img) {' + '\n' +
 'var canvas = document.getElementById("canvas");' + '\n' +
  'var ctx = canvas.getContext("2d");' + '\n' +
  'ctx.drawImage(img, 0, 0);' + '\n' +
  'img.style.display = "none";' + '\n' +
  'var imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);' + '\n' +
  'var data = imageData.data;' + '\n' + '\n' +
    
  'var invert = function() {' + '\n' +
    'for (var i = 0; i < data.length; i += 4) {' + '\n' +
      'data[i]     = 255 - data[i];     // red' + '\n' +
      'data[i + 1] = 255 - data[i + 1]; // green' + '\n' +
      'data[i + 2] = 255 - data[i + 2]; // blue' + '\n' +
    '}' + '\n' +
    'ctx.putImageData(imageData, 0, 0);' + '\n' +
  '};' + '\n' + '\n' +

  'var grayscale = function() {' + '\n' +
    'for (var i = 0; i < data.length; i += 4) {' + '\n' +
      'var avg = (data[i] + data[i + 1] + data[i + 2]) / 3;' + '\n' +
      'data[i]     = avg; // red' + '\n' +
      'data[i + 1] = avg; // green' + '\n' +
      'data[i + 2] = avg; // blue' + '\n' +
   '}' + '\n' +
    'ctx.putImageData(imageData, 0, 0);' + '\n' +
  '};' + '\n' + '\n' +

  'var invertbtn = document.getElementById("invert");' + '\n' +
  'invertbtn.addEventListener("click", invert);' + '\n' +
  'var grayscalebtn = document.getElementById("grayscale");' + '\n' +
  'grayscalebtn.addEventListener("click", grayscale);' + '\n' +
'}');
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

