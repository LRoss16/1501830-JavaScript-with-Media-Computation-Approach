//Code edit for for loops example
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

			/************************************************
			 * Menu
			 ************************************************/
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
'<img id="example" src="../images/dog.jpg" alt="dog" width="300" height="400">' + '\n' +
'<canvas id="canvas" width="300" height="400" style="border:1px solid #d3d3d3;">')
		
$this.boxJS.val(


'document.getElementById("example").onload = function() { //run as soon as loaded' + '\n' +
' var c = document.getElementById("canvas");' + '\n' +
' var ctx = c.getContext("2d");' + '\n' +
' var img = document.getElementById("example");' + '\n' +
' ctx.drawImage(img, 0, 0);' + '\n' +
' var imgData = ctx.getImageData(0, 0, c.width, c.height);' + '\n' +
  '// invert colours' + '\n' +
  'var i;' + '\n' +
  'for (i = 0; i < imgData.data.length; i += 4) {' + '\n' +
    'imgData.data[i] = 235 - imgData.data[i];' + '\n' +
    'imgData.data[i+1] = 52 - imgData.data[i+1];' + '\n' +
    'imgData.data[i+2] = 52 - imgData.data[i+2];' + '\n' +
    'imgData.data[i+3] = 235;' + '\n' +
  '}' + '\n' +
  'ctx.putImageData(imgData, 0, 0);' + '\n' +
'};')

}
 
                   //Code area

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

			this.boxJS.val('document.getElementById("example").onload = function() { //run as soon as loaded' + '\n' +
' var c = document.getElementById("canvas");' + '\n' +
' var ctx = c.getContext("2d");' + '\n' +
' var img = document.getElementById("example");' + '\n' +
' ctx.drawImage(img, 0, 0);' + '\n' +
' var imgData = ctx.getImageData(0, 0, c.width, c.height);' + '\n' +
  '// change colours' + '\n' +
  'var i;' + '\n' +
  'for (i = 0; i < imgData.data.length; i += 4) {' + '\n' +
    'imgData.data[i] = 235 - imgData.data[i];' + '\n' +
    'imgData.data[i+1] = 52 - imgData.data[i+1];' + '\n' +
    'imgData.data[i+2] = 52 - imgData.data[i+2];' + '\n' +
    'imgData.data[i+3] = 235;' + '\n' +
  '}' + '\n' +
  'ctx.putImageData(imgData, 0, 0);' + '\n' +
'};');
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

