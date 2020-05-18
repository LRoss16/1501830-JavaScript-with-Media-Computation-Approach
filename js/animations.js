//Code editor for the animations example
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
  
  
      //Menu
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
'<canvas id="clockCanvas" width="300" height="400" style="border:1px solid #d3d3d3;">')

$this.boxJS.val(

'function clock() {' + '\n' +
  'var now = new Date();' + '\n' +
  'var ctx = document.getElementById("clockCanvas").getContext("2d");' + '\n' +
  'ctx.save();' + '\n' +
  'ctx.clearRect(0, 0, 150, 150);' + '\n' +
  'ctx.translate(75, 75);' + '\n' +
  'ctx.scale(0.4, 0.4);' + '\n' +
  'ctx.rotate(-Math.PI / 2);'+ '\n' +
  'ctx.strokeStyle = "red";' + '\n' +
  'ctx.fillStyle = "grey";' + '\n' +
  'ctx.lineWidth = 8;' + '\n' +
 'ctx.lineCap = "round";' + '\n' + '\n' +

  '// Hour marks' + '\n' +
 ' ctx.save();' + '\n' +
  'for (var i = 0; i < 12; i++) {' + '\n' +
    'ctx.beginPath();' + '\n' +
    'ctx.rotate(Math.PI / 6);' + '\n' +
    'ctx.moveTo(100, 0);' + '\n' +
    'ctx.lineTo(120, 0);' + '\n' +
    'ctx.stroke();' + '\n' +
 ' }' + '\n' +
  'ctx.restore();' + '\n' + '\n' +

  '// Minute marks' + '\n' +
  'ctx.save();' + '\n' +
  'ctx.lineWidth = 5;' + '\n' +
  'for (i = 0; i < 60; i++) {' + '\n' +
    'if (i % 5!= 0) {' + '\n' +
      'ctx.beginPath();' + '\n' +
      'ctx.moveTo(117, 0);' + '\n' +
      'ctx.lineTo(120, 0);' + '\n' +
      'ctx.stroke();' + '\n' +
    '}'+'\n' +
    'ctx.rotate(Math.PI / 30);' + '\n' +
  '}' + '\n' +
  'ctx.restore();' + '\n' + '\n' +
 
  'var sec = now.getSeconds();' + '\n' +
  'var min = now.getMinutes();' + '\n' +
  'var hr  = now.getHours();' + '\n' +
  'hr = hr >= 12 ? hr - 12 : hr;' + '\n' + '\n' +

  'ctx.fillStyle = "black";' + '\n' + '\n' +

  '// write Hours' + '\n' +
  'ctx.save();' + '\n' +
  'ctx.rotate(hr * (Math.PI / 6) + (Math.PI / 360) * min + (Math.PI / 21600) *sec);' + '\n' +
  'ctx.lineWidth = 14;' + '\n' +
  'ctx.beginPath();' + '\n' +
  'ctx.moveTo(-20, 0);' + '\n' +
  'ctx.lineTo(80, 0);' + '\n' +
  'ctx.stroke();' + '\n' +
  'ctx.restore();' + '\n' + '\n' +

  '// write Minutes' + '\n' +
  'ctx.save();' + '\n' +
  'ctx.rotate((Math.PI / 30) * min + (Math.PI / 1800) * sec);' + '\n' +
  'ctx.lineWidth = 10;' + '\n' +
  'ctx.beginPath();' + '\n' +
  'ctx.moveTo(-28, 0);' + '\n' +
  'ctx.lineTo(112, 0);' + '\n' +
  'ctx.stroke();' + '\n' +
  'ctx.restore();' + '\n' + '\n' +
 
 ' // Write seconds' + '\n' +
  'ctx.save();' + '\n' +
  'ctx.rotate(sec * Math.PI / 30);' + '\n' +
  'ctx.strokeStyle = "#D40000";' + '\n' +
  'ctx.fillStyle = "#D40000";' + '\n' +
  'ctx.lineWidth = 6;' + '\n' +
  'ctx.beginPath();' + '\n' +
  'ctx.moveTo(-30, 0);' + '\n' +
  'ctx.lineTo(83, 0);' + '\n' +
  'ctx.stroke();' + '\n' +
  'ctx.beginPath();' + '\n' +
  'ctx.arc(0, 0, 10, 0, Math.PI * 2, true);' + '\n' +
  'ctx.fill();' + '\n' +
  'ctx.beginPath();' + '\n' +
  'ctx.arc(95, 0, 10, 0, Math.PI * 2, true);' + '\n' +
  'ctx.stroke();' + '\n' +
  'ctx.fillStyle = "rgba(0, 0, 0, 0)";' + '\n' +
  'ctx.arc(0, 0, 3, 0, Math.PI * 2, true);' + '\n' +
  'ctx.fill();' + '\n' +
  'ctx.restore();' + '\n' + '\n' +

  'ctx.beginPath();' + '\n' +
  'ctx.lineWidth = 14;' + '\n' +
  'ctx.strokeStyle = "#325FA2";' + '\n' +
  'ctx.arc(0, 0, 142, 0, Math.PI * 2, true);' + '\n' +
  'ctx.stroke();' + '\n' + '\n' +

  'ctx.restore();' + '\n' + '\n' +

  'window.requestAnimationFrame(clock);' + '\n' +
'}' + '\n' + '\n' +

'window.requestAnimationFrame(clock);')
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

			this.boxJS.val('function clock() {' + '\n' +
  'var now = new Date();' + '\n' +
  'var ctx = document.getElementById("clockCanvas").getContext("2d");' + '\n' +
  'ctx.save();' + '\n' +
  'ctx.clearRect(0, 0, 150, 150);' + '\n' +
  'ctx.translate(75, 75);' + '\n' +
  'ctx.scale(0.4, 0.4);' + '\n' +
  'ctx.rotate(-Math.PI / 2);'+ '\n' +
  'ctx.strokeStyle = "red";' + '\n' +
  'ctx.fillStyle = "grey";' + '\n' +
  'ctx.lineWidth = 8;' + '\n' +
 'ctx.lineCap = "round";' + '\n' + '\n' +

  '// Hour marks' + '\n' +
 ' ctx.save();' + '\n' +
  'for (var i = 0; i < 12; i++) {' + '\n' +
    'ctx.beginPath();' + '\n' +
    'ctx.rotate(Math.PI / 6);' + '\n' +
    'ctx.moveTo(100, 0);' + '\n' +
    'ctx.lineTo(120, 0);' + '\n' +
    'ctx.stroke();' + '\n' +
 ' }' + '\n' +
  'ctx.restore();' + '\n' + '\n' +

  '// Minute marks' + '\n' +
  'ctx.save();' + '\n' +
  'ctx.lineWidth = 5;' + '\n' +
  'for (i = 0; i < 60; i++) {' + '\n' +
    'if (i % 5!= 0) {' + '\n' +
      'ctx.beginPath();' + '\n' +
      'ctx.moveTo(117, 0);' + '\n' +
      'ctx.lineTo(120, 0);' + '\n' +
      'ctx.stroke();' + '\n' +
    '}'+'\n' +
    'ctx.rotate(Math.PI / 30);' + '\n' +
  '}' + '\n' +
  'ctx.restore();' + '\n' + '\n' +
 
  'var sec = now.getSeconds();' + '\n' +
  'var min = now.getMinutes();' + '\n' +
  'var hr  = now.getHours();' + '\n' +
  'hr = hr >= 12 ? hr - 12 : hr;' + '\n' + '\n' +

  'ctx.fillStyle = "black";' + '\n' + '\n' +

  '// write Hours' + '\n' +
  'ctx.save();' + '\n' +
  'ctx.rotate(hr * (Math.PI / 6) + (Math.PI / 360) * min + (Math.PI / 21600) *sec);' + '\n' +
  'ctx.lineWidth = 14;' + '\n' +
  'ctx.beginPath();' + '\n' +
  'ctx.moveTo(-20, 0);' + '\n' +
  'ctx.lineTo(80, 0);' + '\n' +
  'ctx.stroke();' + '\n' +
  'ctx.restore();' + '\n' + '\n' +

  '// write Minutes' + '\n' +
  'ctx.save();' + '\n' +
  'ctx.rotate((Math.PI / 30) * min + (Math.PI / 1800) * sec);' + '\n' +
  'ctx.lineWidth = 10;' + '\n' +
  'ctx.beginPath();' + '\n' +
  'ctx.moveTo(-28, 0);' + '\n' +
  'ctx.lineTo(112, 0);' + '\n' +
  'ctx.stroke();' + '\n' +
  'ctx.restore();' + '\n' + '\n' +
 
 ' // Write seconds' + '\n' +
  'ctx.save();' + '\n' +
  'ctx.rotate(sec * Math.PI / 30);' + '\n' +
  'ctx.strokeStyle = "#D40000";' + '\n' +
  'ctx.fillStyle = "#D40000";' + '\n' +
  'ctx.lineWidth = 6;' + '\n' +
  'ctx.beginPath();' + '\n' +
  'ctx.moveTo(-30, 0);' + '\n' +
  'ctx.lineTo(83, 0);' + '\n' +
  'ctx.stroke();' + '\n' +
  'ctx.beginPath();' + '\n' +
  'ctx.arc(0, 0, 10, 0, Math.PI * 2, true);' + '\n' +
  'ctx.fill();' + '\n' +
  'ctx.beginPath();' + '\n' +
  'ctx.arc(95, 0, 10, 0, Math.PI * 2, true);' + '\n' +
  'ctx.stroke();' + '\n' +
  'ctx.fillStyle = "rgba(0, 0, 0, 0)";' + '\n' +
  'ctx.arc(0, 0, 3, 0, Math.PI * 2, true);' + '\n' +
  'ctx.fill();' + '\n' +
  'ctx.restore();' + '\n' + '\n' +

  'ctx.beginPath();' + '\n' +
  'ctx.lineWidth = 14;' + '\n' +
  'ctx.strokeStyle = "#325FA2";' + '\n' +
  'ctx.arc(0, 0, 142, 0, Math.PI * 2, true);' + '\n' +
  'ctx.stroke();' + '\n' + '\n' +

  'ctx.restore();' + '\n' + '\n' +

  'window.requestAnimationFrame(clock);' + '\n' +
'}' + '\n' + '\n' +

'window.requestAnimationFrame(clock);'



);

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