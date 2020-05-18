//Code editor for the merging of images example

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
			$this.boxEgJs.val(
			'function ImageDarkMatter(params) {' + '\n' +
			'var IDM = {};' + '\n' +
			'IDM.size = {' + '\n' +
		     'width: params.width,' + '\n' +
             'height: params.height' + '\n' +
			'};' + '\n' + '\n' +
			
			 'IDM.type = params.type;' + '\n' +
 ' IDM.fn_start = params.start || function() { return; };' + '\n' +
  'IDM.fn_stop  = params.stop  || function() { return; };' + '\n' + '\n' +
  
   'IDM.urls = params.urls;' + '\n' +
  'IDM.grayscale = params.grayscale;' + '\n' + '\n' + 
  
  'IDM.pixel_di = Math.max(Math.min(Math.min(IDM.size.width, IDM.size.height), params.pixel_di || 100), 50);' + '\n' + 
  'IDM.pixel_w = IDM.size.width / Math.round(IDM.size.width / IDM.pixel_di);' + '\n' +
  'IDM.pixel_h = IDM.size.height / Math.round(IDM.size.height / IDM.pixel_di);' + '\n' +
  'IDM.pixel_count = IDM.size.width * 2 / IDM.pixel_w * IDM.size.height * 2 / IDM.pixel_h;' + '\n' + '\n' +
  
  'IDM.update = function(type) {' + '\n' + 
    'IDM.fn_start();' + '\n' +
    'IDM.$ctx_main.clearRect(0, 0, IDM.context.w, IDM.context.h);' + '\n' +
    'IDM.type = type;' + '\n' +
    'setupImages(go);' + '\n' +
  '};' + '\n' + '\n' + 
  
	  'init();' + '\n' + '\n' +

    'function go() {' + '\n' +
    'IDM.image_data = mashColors();' + '\n' +
  '}' + '\n' + '\n' +
  
    'function init() {' + '\n' +
    'IDM.fn_start();' + '\n' +
    'setupElements();' + '\n' +
    'setupContext();' + '\n' +
    'setupImages(go);' + '\n' +
  '}' + '\n' + '\n' +

  
 ' function setupImages(callback) { ' + '\n' +
    'IDM.$container.className += " loading";' + '\n' +
    'IDM.$loader_val.innerHTML = "Loading Images";' + '\n' +
    'IDM.loaded_images = 0;' + '\n' + 
    'for(var i = 0; i < IDM.urls.length; i++) {' + '\n' +
      'var img = new IDMImage(i + 1, IDM.urls[i], callback, function() {' + '\n' +
        'if(IDM.loaded_images < IDM.urls.length) {' + '\n' +
          'loaderText("Loading Images<br>" + Math.round(IDM.loaded_images / IDM.urls.length * 100) + "%");' + '\n' +
        '}' + '\n' +
      '});' + '\n' +
    '}' + '\n' +
  '}' + '\n' + '\n' +

 ' function setupElements() {' + '\n' + 
    'var main_w = IDM.size.width,' + '\n' + 
        'main_h = IDM.size.height,' + '\n' +
        'size_factor = IDM.urls.length,' + '\n' +
        'vis_w = main_w / size_factor,'+ '\n' +
        'vis_h = main_h / size_factor;' + '\n' + '\n' +
    
    'IDM.$container = generateContainer(main_w, main_h, "calc(50% - " + (vis_h / 2) + "px)", "container", "main");' + '\n' +
    'IDM.$thumbnails = generateContainer(main_w, vis_h, "calc(50% + " + (main_h / 2 + 20) + "px)", "container", "thumbnails");' + '\n' + '\n' +
    
    'IDM.$cvs_main = generateCanvas(IDM.$container, main_w, main_h, main_w, main_h, "canvas-main", true);' + '\n' +
    'IDM.$ctx_main = IDM.$cvs_main.getContext("2d");' + '\n' +
    'for(var i = 0; i < IDM.urls.length; i++) {' + '\n' +
      'var index = i + 1;' + '\n' +
      'IDM["$cvs_ref_" + index] = generateCanvas(IDM.$thumbnails, main_w, main_h, vis_w, vis_h, "canvas-ref-" + index, true);' + '\n' +
      'IDM["$ctx_ref_" + index] = IDM["$cvs_ref_" + index].getContext("2d");' + '\n' +
    '}' + '\n' + '\n' +
    
    'document.body.style.background = "#0F0F0F";' + '\n' + '\n' +
    
    'generateLoader();' + '\n' +
  '}' + '\n' + '\n' +
  
    'function setupContext() {' + '\n' +
    'IDM.context = measureCanvas();' + '\n' + 
  '}' + '\n' + '\n' +
  

  'function mashColors() {' + '\n' + '\n' +
    
    'processImages();' + '\n' + '\n' + 
    
    'function processImages() {' + '\n' + '\n' +
 
      'var w = IDM.$cvs_main.width, h = IDM.$cvs_main.height' + '\n' + '\n' +

      'var data = IDM.$ctx_main.createImageData(w, h);' + '\n' + '\n' +

      'var images = [];' + '\n' + '\n' +

      'var px_w = IDM.pixel_w;' + '\n' +
      'var px_h = IDM.pixel_h;' + '\n' + '\n' +

      'processImage(0, function() {' + '\n' +
        'blendImages(images);' + '\n' +
      '});' + '\n' + '\n' +
      

      'function processImage(i, callback) {' + '\n' +
        'var id = i + 1;' + '\n' +
        'var image = {' + '\n' +
          'id: id,' + '\n' +
          'url: IDM.urls[i],' + '\n' +
          'blocks: []' + '\n' +
        '};' + '\n' + '\n' +
        
     
        'var total_steps = (w / px_w) * (h / px_h);' + '\n' +
        'var step = 0;' + '\n' + '\n' +
        
        'var y = 0, x = 0;' + '\n' + '\n' +
        
      
        'doRow(0, function() {' + '\n' +
          'images.push(image);' + '\n' + '\n' +
  
          'i += 1;' + '\n' +
          'if(i < IDM.urls.length) {' + '\n' +
            'setTimeout(function() {' + '\n' +
              'processImage(i, callback);' + '\n' +
            '}, 10);' + '\n' +
          '} else {' + '\n' +
            'IDM.$container.className = IDM.$container.className.replace(" loading", "");' + '\n' +
            'callback();' + '\n' +
          '}' + '\n' +
        '});' + '\n' + '\n' +
		
		  'function doRow(which, cb) {' + '\n' + 
          'y = which;' + '\n' +
          'loaderText("Parsing Image " + id + "<br>" + Math.ceil(step / total_steps * 100) + "%");' + '\n' +
          'doCol(0, function() {' + '\n' + 
            'y += px_h;' + '\n' +
            'if(y < h) {' + '\n' +
              'setTimeout(function() {' + '\n' +
                'doRow(y, cb);' + '\n' +
              '});' + '\n' +
            '} else {' + '\n' +
              'cb();' + '\n' +
            '}' + '\n' +
          '});' + '\n' +
        '}' + '\n' + '\n' + 
		
		  'function doCol(which, cb) {' + '\n' +
          'x = which;' + '\n' +
          'step++;' + '\n' +  '\n' +
 
          'var pos = (px_w * px_h) * step;' + '\n' + '\n' +

          'var block = {' + '\n' +
            'w: px_w, h: px_h,' + '\n' +
            'x: x, y: y,' + '\n' +
             'data: IDM["$ctx_ref_" + id].getImageData(x, y, px_w, px_h).data' + '\n' +
          '};' + '\n' +
          'image.blocks.push(block);' + '\n' +
          'x += px_w;' + '\n' + '\n' +
          
          'if(x < w) {' + '\n' +
            'doCol(x, cb);' + '\n' +
          '} else {' + '\n' +
            'cb();' + '\n' +
          '}' + '\n' +
        '}' + '\n' +
      '}' + '\n' + '\n' +

    '}' + '\n' + '\n' +
    
  '}' + '\n' + '\n' +
  
  'function blendImages(images) {' + '\n' + '\n' +
 
    'IDM.generated = 0;' + '\n' + '\n' +

   
    'var method = averageHsl;' + '\n' +
    'switch(IDM.type) {' + '\n' +
      'case "random":' + '\n' + 
        'method = randomHsl;' + '\n' +
        'break;' + '\n' +
      'case "select":' + '\n' +
        'method = selectiveHsl;' + '\n' +
        'break;' + '\n' +
      'case "average":' + '\n' +
        'method = averageHsl;' + '\n' +
        'break;' + '\n' +
      'case "middle":' + '\n' +
        'method = middleHsl;' + '\n' +
        'break;' + '\n' +
    '}' + '\n' + '\n' +    

     'runMethodOverImages(method, images);' + '\n' +
  '}' + '\n' + '\n' +
  

  'function runMethodOverImages(method, images, b) {' + '\n' +
    'if(!b) b = 0;' + '\n' + '\n' +

    'var blocks = [];' + '\n' + '\n' +

    'for(var i = 0, loop = images.length; i < loop; i++) {' + '\n' +
      'blocks.push(images[i].blocks[b]);' + '\n' +
    '}' + '\n' + '\n' +


    'updateLoaded();' + '\n' + '\n' +

    'var d = method(blocks);' + '\n' + '\n' +
    

    'IDM.$ctx_main.putImageData(d, blocks[0].x, blocks[0].y);' + '\n' + '\n' +

    'b += 1;' + '\n' +
    'if(b < images[0].blocks.length) {' + '\n' +
      'setTimeout(function() {' + '\n' +
        'runMethodOverImages(method, images, b);' + '\n' +
      '}, 1);' + '\n' +
    '} else {' + '\n' +
      'IDM.fn_stop();' + '\n' +
    '}' + '\n' +
  '}' + '\n' + '\n' +
  
    'function randomHsl(blocks) {' + '\n' + '\n' +
   
    'var hue_obj, sat_obj, lit_obj,' + '\n' +
        'hsl, rgb, hue, sat, lit;' + '\n' + '\n' +
 
    'var block_count = blocks.length;'+ '\n' +
    'var d = IDM.$ctx_main.createImageData(blocks[0].w, blocks[0].h);' + '\n' + '\n' +
    

    'for(var i = 0, loop = d.data.length; i < loop; i++) {' + '\n' +
      'var offset = i * 4;' + '\n' + '\n' +
      
      'hue_obj = blocks[Math.floor(Math.random() * block_count)];' + '\n' +
      'sat_obj = blocks[Math.floor(Math.random() * block_count)];' + '\n' +
      'lit_obj = blocks[Math.floor(Math.random() * block_count)];' + '\n' + '\n' +
      

      'hsl = rgbToHsl(hue_obj.data[offset], sat_obj.data[offset + 1], lit_obj.data[offset + 2]);' + '\n' +
      'hue = hsl[0];' + '\n' +
      'sat = (IDM.grayscale) ? 0 : hsl[1];' + '\n' +
      'lit = hsl[2];' + '\n' + '\n' +
      
      'rgb = hslToRgb(hue, sat, lit);' + '\n' + '\n' +
      
      'd.data[offset]     = rgb[0];' + '\n' + 
      'd.data[offset + 1] = rgb[1];' + '\n' +
      'd.data[offset + 2] = rgb[2];' + '\n' +
      'd.data[offset + 3] = 255;' + '\n' +
    '}' + '\n' + '\n' +
    
    'return d;' + '\n' +
  '}' + '\n' + '\n' + '\n' +
  

  'function selectiveHsl(blocks) {' + '\n' +
    'var hsl, rgb, sat;' + '\n' +
    'var rand_obj = blocks[Math.floor(Math.random() * blocks.length)];' + '\n' +
    'var d = IDM.$ctx_main.createImageData(blocks[0].w, blocks[0].h);' + '\n' +
    'for(var i = 0, loop = rand_obj.data.length; i < loop; i++) {' + '\n' +
      'var offset = i * 4;' + '\n' +
      'hsl = rgbToHsl(rand_obj.data[offset], rand_obj.data[offset + 1], rand_obj.data[offset + 2]);' + '\n' +
      'sat = (IDM.grayscale) ? 0 : hsl[1];' + '\n' +
      'rgb = hslToRgb(hsl[0], sat, hsl[2]);' + '\n' +
      'd.data[offset]     = rgb[0];' + '\n' +
      'd.data[offset + 1] = rgb[1];' + '\n' +
      'd.data[offset + 2] = rgb[2];' + '\n' +
      'd.data[offset + 3] = 255;' + '\n' +
    '}' + '\n' +
    'return d;' + '\n' +
  '}' + '\n' + '\n' +
  
  'function averageHsl(blocks) {' + '\n' +
    'var d = IDM.$ctx_main.createImageData(blocks[0].w, blocks[0].h);' + '\n' + '\n' +
 
    'for(var i = 0, loop = d.data.length; i < loop; i++) {' + '\n' +
      'var offset = i * 4;' + '\n' +
      'var all_h = 0, all_s = 0, all_l = 0;' + '\n' + '\n' + 
      
   
      'for(var b = 0, loop_b = blocks.length; b < loop_b; b++) {' + '\n' +
        'var hsl = rgbToHsl(blocks[b].data[offset], blocks[b].data[offset + 1], blocks[b].data[offset + 2]);' + '\n' +
        'all_h += hsl[0];' + '\n' +
        'all_s += hsl[1];' + '\n' +
        'all_l += hsl[2];' + '\n' + 
      '}' + '\n' + '\n' +
      
      'var hue = all_h / blocks.length;' + '\n' +
      'var sat = (IDM.grayscale) ? 0 : all_s / blocks.length;' + '\n' +
      'var lit = all_l / blocks.length;' + '\n' + '\n' +
      
      'var rgb = hslToRgb(hue, sat, lit);' + '\n' + '\n' +
      
      'd.data[offset]     = rgb[0];' + '\n' +
      'd.data[offset + 1] = rgb[1];' + '\n' +
      'd.data[offset + 2] = rgb[2];' + '\n' +
      'd.data[offset + 3] = 255;' + '\n' +
    '}' + '\n' +
    'return d;' + '\n' +
 '}' + '\n' + '\n' +
  

  'function middleHsl(blocks) {' + '\n' +
    'var d = IDM.$ctx_main.createImageData(blocks[0].w, blocks[0].h);' + '\n' +
    'for(var i = 0, loop = d.data.length; i < loop; i++) {' + '\n' +
      'var offset = i * 4;' + '\n' +
      'var top_h = 0, top_s = 0, top_l = 0;' + '\n' +
      'var btm_h = 1000, btm_s = 1000, btm_l = 1000;' + '\n' + '\n' +

      'for(var b = 0, loop_b = blocks.length; b < loop_b; b++) {' + '\n' +
        'var hsl = rgbToHsl(blocks[b].data[offset], blocks[b].data[offset + 1], blocks[b].data[offset + 2]);' + '\n' +
        'top_h = top(hsl[0], top_h); ' + '\n' +
        'top_s = top(hsl[1], top_s); ' + '\n' +
        'top_l = top(hsl[2], top_l);' + '\n' +
        'btm_h = btm(hsl[0], btm_h);' + '\n' +
        'btm_s = btm(hsl[1], btm_s); ' + '\n' +
        'btm_l = btm(hsl[2], btm_l);' + '\n' +
      '}' + '\n' + '\n' +
      'function top(a, b) {' + '\n' +
        'return Math.max(a, b);' + '\n' +
      '}' + '\n' + '\n' +
      'function btm(a, b) {' + '\n' +
        'return Math.min(a, b);' + '\n' + 
      '}' + '\n' + '\n' +
        
      'var hue = ((top_h - btm_h) / 2) + btm_h; ' + '\n' +
      'var sat = (IDM.grayscale) ? 0 : ((top_s - btm_s) / 2) + btm_s;' + '\n' +
      'var lit = ((top_l - btm_l) / 2) + btm_l;' + '\n' + '\n' +
      
      'var rgb = hslToRgb(hue, sat, lit);'+ '\n' + '\n' +
      
      'd.data[offset]     = rgb[0];' + '\n' +
      'd.data[offset + 1] = rgb[1];' + '\n' +
      'd.data[offset + 2] = rgb[2];' + '\n' +
      'd.data[offset + 3] = 255;' + '\n' +
    '}' + '\n' +
    'return d;' + '\n' +
  '}' + '\n' + '\n' +
  

  'function updateLoaded() {' + '\n' + 
    'IDM.generated++;' + '\n' +
    'var ratio = IDM.generated / IDM.pixel_count;' + '\n' +
    'if(ratio < 1) {' + '\n' +
      'loaderText("Generating Pixels<br>" + Math.ceil(ratio * 100) + "%");' + '\n' +
    '} else {' + '\n' +
      'loaderText("");' + '\n' +
    '}' + '\n' +
  '}' + '\n' + '\n' +
  
  'function loaderText(what) {' + '\n' +
    'IDM.$loader_val.innerHTML = what;' + '\n' +
  '}' + '\n' + '\n' +
  
  

  'function IDMImage(id, url, final_callback, each_callback) {' + '\n' +
    'var IMG = {};' + '\n' +
    'var cvs_ref = IDM["$cvs_ref_" + id];' + '\n' + 
    'var ctx_ref = IDM["$ctx_ref_" + id];' + '\n' + '\n' +
    
    'IMG.id = id;' + '\n' +
    'IMG.el = null;' + '\n' +
    'IMG.final_callback = final_callback;' +
    'IMG.each_callback = each_callback;' + '\n' +
    'IMG.canvas = cvs_ref;' + '\n' +
    'IMG.context = ctx_ref;' + '\n' +
    'IMG.draw = function() {' + '\n' +
      'var img_ctx = contextualizeImage(IMG.canvas, IMG.el);' + '\n' +
      'drawImage(IMG.context, IMG.el, img_ctx);' + '\n' +
    '};' + '\n' +
    'IMG.load = function(url) {' + '\n' +
      'IMG.el = new Image();' +'\n' +
      'IMG.el.crossOrigin = "Anonymous";' + '\n' +
      'IMG.el.src = url;' + '\n' +
      'IMG.el.onload = IMG.onload;' + '\n' +
    '};' + '\n' +
    'IMG.onload = function(e) {' + '\n' +
      'IMG.draw();' + '\n' +
      'IDM.loaded_images++;' + '\n' +
      'IMG.each_callback();' + '\n' +
      'if(IMG.final_callback && IDM.loaded_images === IDM.urls.length) ' + '\n' +
        'setTimeout(function() {' + '\n' +
          'IMG.final_callback();' + '\n' +
        '}, 300);' + '\n' +
    '};' + '\n' + '\n' +
    
    'IMG.load(url);' + '\n' + '\n' +
    
    'return IMG;' + '\n' +
  '}' + '\n' + '\n' +
  
  'function generateContainer(w, h, t, class_name, id) {' + '\n' +
    'var container = document.createElement("section");' + '\n' +
    'container.className = class_name;' + '\n' +
    'container.id = id;' + '\n' +
    'container.style.position = "absolute";' + '\n' +
    'container.style.left = "50%";' + '\n' +
    'container.style.top = t;' + '\n' +
    'container.style.width = w + "px";' + '\n' + 
    'container.style.height = h + "px";' + '\n' +
    'container.style.webkitTransform = "translate(-50%, -50%)";' + '\n' +
    'container.style.transform = "translate(-50%, -50%)";' + '\n' +
    'container.style.background = "#202020";' + '\n' +
    'document.body.appendChild(container);' + '\n' +
    'return container;' + '\n' +
  '}' + '\n' + '\n' +
  
 
  'function generateCanvas(container, w, h, vis_w, vis_h, class_name, show_in_dom) {' + '\n' + 
    'var canvas = document.createElement("canvas");' + '\n' +
    'canvas.width = w * 2;' + '\n' +
    'canvas.height = h * 2;' + '\n' +
    'canvas.style.width = vis_w + "px";' + '\n' +
    'canvas.style.height = vis_h + "px";' + '\n' +
    'canvas.style.verticalAlign = "middle";' + '\n' +
    'canvas.className = class_name || "";' + '\n' +
    'if(show_in_dom) container.appendChild(canvas);' + '\n' +
    'return canvas;' + '\n' +
  '}' + '\n' + '\n' +
  

  'function generateLoader() {' + '\n' +
    'IDM.$loader = document.createElement("div");' + '\n' +
    'IDM.$loader.className = "loader";' + '\n' +
    'IDM.$loader.style.color = "white";' + '\n' +
    'IDM.$loader.style.position = "absolute";' + '\n' +
    'IDM.$loader.style.top = "calc(100% - 4rem)";' + '\n' +
    'IDM.$loader.style.left = "0";' + '\n' +
    'IDM.$loader.style.width = "100%";' + '\n' +
    'IDM.$loader.style.textAlign = "center";' + '\n' +
    'IDM.$loader.style.fontAeight = "100";' + '\n' +
    'IDM.$loader.style.lineAeight = "1.8";' + '\n' + '\n' +
    
    'IDM.$loader_val = document.createElement("span");'+ '\n' + 
    'IDM.$loader.appendChild(IDM.$loader_val);' + '\n' +
    'document.body.appendChild(IDM.$loader);' + '\n' +
  '}' + '\n' + '\n' +
  
  

  'function measureCanvas() {' + '\n' +
    'return { ' + '\n' +
      'w: IDM.$cvs_main.width, ' + '\n' +
      'h: IDM.$cvs_main.height,' + '\n' +
      'w_sm: IDM.$cvs_ref_1.width,' + '\n' +
      'h_sm: IDM.$cvs_ref_1.height' + '\n' +
    '};' + '\n' +
  '}' + '\n' + '\n' +
  

  'function drawImage(canvas, img, img_ctx) {' + '\n' +
    'canvas.drawImage(img, img_ctx.x, img_ctx.y, img_ctx.w, img_ctx.h);' + '\n' +
  '}' + '\n' + '\n' +
  

  'function contextualizeImage(canvas, img) {' + '\n' +
    'var img_w = img.width,' + '\n' +
        'img_h = img.height,' + '\n' +
        'img_rat = img_h / img_w,' + '\n' +
        'canvas_w = canvas.width,' + '\n' +
        'canvas_h = canvas.height,' + '\n' +
        'canvas_rat = canvas_h / canvas_w,' + '\n' +
        'dest_dimensions = scaledDimensions();' + '\n' + '\n' +


    'return dest_dimensions;' + '\n' + '\n' +
    

    'function scaledDimensions() {' + '\n' +
      'var w, h, x, y;' + '\n' +
      'var constrain = (img_rat < canvas_rat) ? "h" : "w";' + '\n' +
      'if(constrain === "h") {' + '\n' +
        'h = canvas_h;' + '\n' +
        'w = (img_w / img_h) * h;' + '\n' +
        'x = (w - canvas_w) / -2;' + '\n' +
        'y = 0;' + '\n' +
      '} else {' + '\n' +
        'w = canvas_w;' + '\n' +
        'h = (img_h / img_w) * w;' + '\n' +
        'x = 0;' + '\n' +
        'y = (h - canvas_h) / -2;' + '\n' +
      '}' + '\n' + '\n' +
      
      'return { x: x, y: y, w: w, h: h };' + '\n' +
    '}' + '\n' +
  '}' + '\n' + '\n' +
  

  'function hslToRgb(h, s, l){' + '\n' +
    'var r, g, b;' + '\n' + '\n' +

    'if (s == 0) {' + '\n' +
        'r = g = b = l; ' + '\n' +
    '} else {' + '\n' +
      'var hue2rgb = function hue2rgb(p, q, t){' + '\n' +
        'if(t < 0) t += 1;' + '\n' + 
        'if(t > 1) t -= 1;' + '\n' +
        'if(t < 1/6) return p + (q - p) * 6 * t;' + '\n' +
        'if(t < 1/2) return q;' + '\n' +
        'if(t < 2/3) return p + (q - p) * (2/3 - t) * 6;' + '\n' +
        'return p;' + '\n' +
      '}' + '\n' + '\n' +

      'var q = l < 0.5 ? l * (1 + s) : l + s - l * s;' + '\n' +
      'var p = 2 * l - q;' + '\n' +
      'r = hue2rgb(p, q, h + 1/3);' + '\n' +
      'g = hue2rgb(p, q, h);' + '\n' +
      'b = hue2rgb(p, q, h - 1/3);' + '\n' +
    '}' + '\n' + '\n' +

    'return [Math.round(r * 255), Math.round(g * 255), Math.round(b * 255)];' + '\n' +
  '}' + '\n' + '\n' +
  

  'function rgbToHsl(r, g, b){' + '\n' +
    'r /= 255, g /= 255, b /= 255;' + '\n' +
    'var max = Math.max(r, g, b), min = Math.min(r, g, b);' + '\n' +
    'var h, s, l = (max + min) / 2;' + '\n' + '\n' +

    'if (max == min) {' + '\n' +
        'h = s = 0; ' + '\n' +
    '} else {' + '\n' +
      'var d = max - min;' + '\n' +
      's = l > 0.5 ? d / (2 - max - min) : d / (max + min);' + '\n' +
      'switch(max){' + '\n' +
        'case r: h = (g - b) / d + (g < b ? 6 : 0); break;' + '\n' +
        'case g: h = (b - r) / d + 2; break;' + '\n' +
        'case b: h = (r - g) / d + 4; break;' + '\n' +
      '}' + '\n' + 
      'h /= 6;' + '\n' +
    '}' + '\n' + '\n' +

    'return [h, s, l];' + '\n' +
  '}' + '\n' + '\n' +
  
  'return IDM;' + '\n' + '\n' + 
  
'}')

$this.boxJS.val(

'var params = {' + '\n' +
  'width: 200,       // width of the canvas' + '\n' +
  'height: 200,      // height of the canvas' + '\n' +
  'pixel_di: 50,     // diameter of the pixel block (min 50)' + '\n' +
  'type: "select",  // pixel manipulation type: "random", "select", "average", "middle"' + '\n' +
  'grayscale: false,  // whether or not to convert to grayscale' + '\n' + '\n' +


  '// can be any image, they will be cropped and resized to fit.' + '\n' +
  'urls: ['  + '\n' + 
    '"https://ichef.bbci.co.uk/onesport/cps/320/cpsprodpb/87EF/production/_111199743_ratw.jpg",' + '\n' +
    '"https://ichef.bbci.co.uk/images/ic/272x153/p085qncz.jpg",' + '\n' +
    '"https://ichef.bbci.co.uk/onesport/cps/320/cpsprodpb/61C5/production/_111192052_rudisha_fp_getty.png",' + '\n' + '\n' +

    

  '],' + '\n' + '\n' +

  
'};' + '\n' +
'var app = new ImageDarkMatter(params);')

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
			this.boxJS.val('var params = {' + '\n' +
  'width: 200,       // width of the canvas' + '\n' +
  'height: 200,      // height of the canvas' + '\n' +
  'pixel_di: 50,     // diameter of the pixel block (min 50)' + '\n' +
  'type: "select",  // pixel manipulation type: "random", "select", "average", "middle"' + '\n' +
  'grayscale: false,  // whether or not to convert to grayscale' + '\n' + '\n' +


  '// can be any image, they will be cropped and resized to fit.' + '\n' +
  'urls: ['  + '\n' + 
    '"https://ichef.bbci.co.uk/onesport/cps/320/cpsprodpb/87EF/production/_111199743_ratw.jpg",' + '\n' +
    '"https://ichef.bbci.co.uk/images/ic/272x153/p085qncz.jpg",' + '\n' +
    '"https://ichef.bbci.co.uk/onesport/cps/320/cpsprodpb/61C5/production/_111192052_rudisha_fp_getty.png",' + '\n' + '\n' +

    

  '],' + '\n' + '\n' +

  
'};' + '\n' +
'var app = new ImageDarkMatter(params);');
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

