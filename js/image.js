function ImageDarkMatter(params) {
  
  var IDM = {};
  
  /******************
  localized params
  ******************/
  
  IDM.size = {
    width: params.width,
    height: params.height
  };
  
  IDM.type = params.type;
  IDM.fn_start = params.start || function() { return; };
  IDM.fn_stop  = params.stop  || function() { return; };
  
  IDM.urls = params.urls;
  IDM.grayscale = params.grayscale;
  
  IDM.pixel_di = Math.max(Math.min(Math.min(IDM.size.width, IDM.size.height), params.pixel_di || 100), 50);
  // pixels maintain aspect ratio
  IDM.pixel_w = IDM.size.width / Math.round(IDM.size.width / IDM.pixel_di);
  IDM.pixel_h = IDM.size.height / Math.round(IDM.size.height / IDM.pixel_di);
  IDM.pixel_count = IDM.size.width * 2 / IDM.pixel_w * IDM.size.height * 2 / IDM.pixel_h;
  
  IDM.update = function(type) {
    IDM.fn_start();
    IDM.$ctx_main.clearRect(0, 0, IDM.context.w, IDM.context.h);
    IDM.type = type;
    setupImages(go);
  };
  
  
  
  /******************
  initialize
  ******************/
  
  init();
  
  function init() {
    IDM.fn_start();
    setupElements();
    setupContext();
    setupImages(go);
  }
  
  // all the nonsense
  function go() {
    IDM.image_data = mashColors();
  }
  
  
  
  /******************
  setup methods
  ******************/
  
  function setupImages(callback) {
    IDM.$container.className += " loading";
    IDM.$loader_val.innerHTML = "Loading Images";
    IDM.loaded_images = 0;
    for(var i = 0; i < IDM.urls.length; i++) {
      var img = new IDMImage(i + 1, IDM.urls[i], callback, function() {
        if(IDM.loaded_images < IDM.urls.length) {
          loaderText("Loading Images<br>" + Math.round(IDM.loaded_images / IDM.urls.length * 100) + "%");
        }
      });
    }
  }

  function setupElements() {
    var main_w = IDM.size.width, 
        main_h = IDM.size.height,
        size_factor = IDM.urls.length,
        vis_w = main_w / size_factor,
        vis_h = main_h / size_factor;
    
    IDM.$container = generateContainer(main_w, main_h, "calc(50% - " + (vis_h / 2) + "px)", "container", "main");
    IDM.$thumbnails = generateContainer(main_w, vis_h, "calc(50% + " + (main_h / 2 + 20) + "px)", "container", "thumbnails");
    
    IDM.$cvs_main = generateCanvas(IDM.$container, main_w, main_h, main_w, main_h, "canvas-main", true);
    IDM.$ctx_main = IDM.$cvs_main.getContext("2d");
    for(var i = 0; i < IDM.urls.length; i++) {
      var index = i + 1;
      IDM["$cvs_ref_" + index] = generateCanvas(IDM.$thumbnails, main_w, main_h, vis_w, vis_h, "canvas-ref-" + index, true);
      IDM["$ctx_ref_" + index] = IDM["$cvs_ref_" + index].getContext("2d");
    }
    
    document.body.style.background = "#0F0F0F";
    
    generateLoader();
  }
  
  function setupContext() {
    IDM.context = measureCanvas();
  }
  
  // generate blocks of pixels for each image, then mash and merge into main ctx data
  function mashColors() {
    
    processImages();
    
    function processImages() {
      // get canvas size (same for all canvases)
      var w = IDM.$cvs_main.width, h = IDM.$cvs_main.height
      // get blank data on main canvas
      var data = IDM.$ctx_main.createImageData(w, h);
      // images contains blocks of rgba data for each source image
      var images = [];
      // pixel dimensions
      var px_w = IDM.pixel_w;
      var px_h = IDM.pixel_h;

      processImage(0, function() {
        blendImages(images);
      });
      
      // for each image url, get pixel blocks
      function processImage(i, callback) {
        var id = i + 1;
        var image = {
          id: id,
          url: IDM.urls[i],
          blocks: []
        };
        
        // counting steps
        var total_steps = (w / px_w) * (h / px_h);
        var step = 0;
        
        var y = 0, x = 0;
        
        // instantiate row and callback when complete
        doRow(0, function() {
          images.push(image);
          // better loops
          i += 1;
          if(i < IDM.urls.length) {
            setTimeout(function() {
              processImage(i, callback);
            }, 10);
          } else {
            IDM.$container.className = IDM.$container.className.replace(" loading", "");
            callback();
          }
        });
        
        // do a row of pixels
        function doRow(which, cb) {
          y = which;
          loaderText("Parsing Image " + id + "<br>" + Math.ceil(step / total_steps * 100) + "%");
          doCol(0, function() {
            y += px_h;
            if(y < h) {
              setTimeout(function() {
                doRow(y, cb);
              });
            } else {
              cb();
            }
          });
        }
        
        // do a column in a row
        function doCol(which, cb) {
          x = which;
          step++;
          // pos = starting position of pixel in main data rgba array
          var pos = (px_w * px_h) * step;
          // create the block
          var block = {
            w: px_w, h: px_h,
            x: x, y: y,
            data: IDM["$ctx_ref_" + id].getImageData(x, y, px_w, px_h).data
          };
          image.blocks.push(block);
          x += px_w;
          
          if(x < w) {
            doCol(x, cb);
          } else {
            cb();
          }
        }
      }

    }
    
  }
  
  // blend images by iterating over whatever method we running
  function blendImages(images) {
    // reset generated
    IDM.generated = 0;

    // second loop to retrieve pixels and compare data
    var method = averageHsl;
    switch(IDM.type) {
      case "random":
        method = randomHsl;
        break;
      case "select":
        method = selectiveHsl;
        break;
      case "average":
        method = averageHsl;
        break;
      case "middle":
        method = middleHsl;
        break;
    }    

    // for each block
    runMethodOverImages(method, images);      
  }
  
  // throttled looping
  function runMethodOverImages(method, images, b) {
    if(!b) b = 0;
    // get current block for each img
    var blocks = [];
    // for each image, add appropriate block
    for(var i = 0, loop = images.length; i < loop; i++) {
      blocks.push(images[i].blocks[b]);
    }

    // update counter
    updateLoaded();
    
    // get the "pixel" block
    var d = method(blocks);
    
    // put the pixel block in the dom
    IDM.$ctx_main.putImageData(d, blocks[0].x, blocks[0].y);

    b += 1;
    if(b < images[0].blocks.length) {
      setTimeout(function() {
        runMethodOverImages(method, images, b);
      }, 1);
    } else {
      IDM.fn_stop();
    }
  }
  
  
  /******************
  pixel manipulation methods
  ******************/
  
  // get truly random hsl data based on a "pixel"
  function randomHsl(blocks) {
    // this will give us random values for each h s and l
    var hue_obj, sat_obj, lit_obj, 
        hsl, rgb, hue, sat, lit;
    // store this once
    var block_count = blocks.length;
    var d = IDM.$ctx_main.createImageData(blocks[0].w, blocks[0].h);
    
    // for each pixel in the pixel block
    for(var i = 0, loop = d.data.length; i < loop; i++) {
      var offset = i * 4;
      
      hue_obj = blocks[Math.floor(Math.random() * block_count)];
      sat_obj = blocks[Math.floor(Math.random() * block_count)]; 
      lit_obj = blocks[Math.floor(Math.random() * block_count)]; 
      
      // get the hsl for the selected blocks
      hsl = rgbToHsl(hue_obj.data[offset], sat_obj.data[offset + 1], lit_obj.data[offset + 2]);
      hue = hsl[0];
      sat = (IDM.grayscale) ? 0 : hsl[1];
      lit = hsl[2];
      
      rgb = hslToRgb(hue, sat, lit);
      
      d.data[offset]     = rgb[0];
      d.data[offset + 1] = rgb[1];
      d.data[offset + 2] = rgb[2];
      d.data[offset + 3] = 255;
    }
    
    return d;
  }
  
  // get selective hsl values randomly
  function selectiveHsl(blocks) {
    var hsl, rgb, sat;
    // randomly select a "pixel"
    var rand_obj = blocks[Math.floor(Math.random() * blocks.length)];
    var d = IDM.$ctx_main.createImageData(blocks[0].w, blocks[0].h);
    for(var i = 0, loop = rand_obj.data.length; i < loop; i++) {
      var offset = i * 4;
      hsl = rgbToHsl(rand_obj.data[offset], rand_obj.data[offset + 1], rand_obj.data[offset + 2]);
      sat = (IDM.grayscale) ? 0 : hsl[1];
      rgb = hslToRgb(hsl[0], sat, hsl[2]);
      d.data[offset]     = rgb[0];
      d.data[offset + 1] = rgb[1];
      d.data[offset + 2] = rgb[2];
      d.data[offset + 3] = 255;
    }
    return d;
  }
  
  // get average hsl
  function averageHsl(blocks) {
    var d = IDM.$ctx_main.createImageData(blocks[0].w, blocks[0].h);
    // for each pixel in the pixel block
    for(var i = 0, loop = d.data.length; i < loop; i++) {
      var offset = i * 4;
      var all_h = 0, all_s = 0, all_l = 0;
      
      // for each block, get the average value
      for(var b = 0, loop_b = blocks.length; b < loop_b; b++) {
        var hsl = rgbToHsl(blocks[b].data[offset], blocks[b].data[offset + 1], blocks[b].data[offset + 2]);
        all_h += hsl[0];
        all_s += hsl[1];
        all_l += hsl[2];
      }
      
      var hue = all_h / blocks.length; 
      var sat = (IDM.grayscale) ? 0 : all_s / blocks.length; 
      var lit = all_l / blocks.length; 
      
      var rgb = hslToRgb(hue, sat, lit);
      
      d.data[offset]     = rgb[0];
      d.data[offset + 1] = rgb[1];
      d.data[offset + 2] = rgb[2];
      d.data[offset + 3] = 255;
    }
    return d;
  }
  
  // get middle ground hsl
  function middleHsl(blocks) {
    var d = IDM.$ctx_main.createImageData(blocks[0].w, blocks[0].h);
    for(var i = 0, loop = d.data.length; i < loop; i++) {
      var offset = i * 4;
      var top_h = 0, top_s = 0, top_l = 0;
      var btm_h = 1000, btm_s = 1000, btm_l = 1000;
      // for each block, get the average value
      for(var b = 0, loop_b = blocks.length; b < loop_b; b++) {
        var hsl = rgbToHsl(blocks[b].data[offset], blocks[b].data[offset + 1], blocks[b].data[offset + 2]);
        top_h = top(hsl[0], top_h); 
        top_s = top(hsl[1], top_s); 
        top_l = top(hsl[2], top_l);
        btm_h = btm(hsl[0], btm_h); 
        btm_s = btm(hsl[1], btm_s); 
        btm_l = btm(hsl[2], btm_l);
      }
      function top(a, b) {
        return Math.max(a, b);
      }
      function btm(a, b) {
        return Math.min(a, b);
      }
      
      var hue = ((top_h - btm_h) / 2) + btm_h; 
      var sat = (IDM.grayscale) ? 0 : ((top_s - btm_s) / 2) + btm_s; 
      var lit = ((top_l - btm_l) / 2) + btm_l;
      
      var rgb = hslToRgb(hue, sat, lit);
      
      d.data[offset]     = rgb[0];
      d.data[offset + 1] = rgb[1];
      d.data[offset + 2] = rgb[2];
      d.data[offset + 3] = 255;
    }
    return d;
  }
  
  
  
  /******************
  ui
  ******************/
  
  // show progress
  function updateLoaded() {
    IDM.generated++;
    var ratio = IDM.generated / IDM.pixel_count;
    if(ratio < 1) {
      loaderText("Generating Pixels<br>" + Math.ceil(ratio * 100) + "%");
    } else {
      loaderText("");
    }
  }
  
  function loaderText(what) {
    IDM.$loader_val.innerHTML = what;
  }
  
  
  
  /******************
  generators
  ******************/
  
  // everything an image could ever ask for
  function IDMImage(id, url, final_callback, each_callback) {
    var IMG = {};
    var cvs_ref = IDM["$cvs_ref_" + id];
    var ctx_ref = IDM["$ctx_ref_" + id];
    
    IMG.id = id;
    IMG.el = null;
    IMG.final_callback = final_callback;
    IMG.each_callback = each_callback;
    IMG.canvas = cvs_ref;
    IMG.context = ctx_ref;
    IMG.draw = function() {
      var img_ctx = contextualizeImage(IMG.canvas, IMG.el);
      drawImage(IMG.context, IMG.el, img_ctx);
    };
    IMG.load = function(url) {
      IMG.el = new Image();
      IMG.el.crossOrigin = "Anonymous";    
      IMG.el.src = url;
      IMG.el.onload = IMG.onload;
    };
    IMG.onload = function(e) {
      IMG.draw();
      IDM.loaded_images++;
      IMG.each_callback();
      if(IMG.final_callback && IDM.loaded_images === IDM.urls.length) 
        setTimeout(function() {
          IMG.final_callback();
        }, 300);
    };
    
    IMG.load(url);
    
    return IMG;
  }
  
  // generate, append, and return a container
  function generateContainer(w, h, t, class_name, id) {
    var container = document.createElement("section");
    container.className = class_name;
    container.id = id;
    container.style.position = "absolute";
    container.style.left = "50%";
    container.style.top = t;
    container.style.width = w + "px";
    container.style.height = h + "px";
    container.style.webkitTransform = "translate(-50%, -50%)";
    container.style.transform = "translate(-50%, -50%)";
    container.style.background = "#202020";
    document.body.appendChild(container);
    return container;
  }
  
  // generate, append, and return a canvas
  function generateCanvas(container, w, h, vis_w, vis_h, class_name, show_in_dom) {
    var canvas = document.createElement("canvas");
    canvas.width = w * 2;
    canvas.height = h * 2;
    canvas.style.width = vis_w + "px";
    canvas.style.height = vis_h + "px";
    canvas.style.verticalAlign = "middle";
    canvas.className = class_name || "";
    if(show_in_dom) container.appendChild(canvas);
    return canvas;
  }
  
  // generate a loader and styles for it
  function generateLoader() {
    IDM.$loader = document.createElement("div");
    IDM.$loader.className = "loader";
    IDM.$loader.style.color = "white";
    IDM.$loader.style.position = "absolute";
    IDM.$loader.style.top = "calc(100% - 4rem)";
    IDM.$loader.style.left = "0";
    IDM.$loader.style.width = "100%";
    IDM.$loader.style.textAlign = "center";
    IDM.$loader.style.fontAeight = "100";
    IDM.$loader.style.lineAeight = "1.8";
    
    IDM.$loader_val = document.createElement("span");
    IDM.$loader.appendChild(IDM.$loader_val);
    document.body.appendChild(IDM.$loader);
  }
  
  
  /******************
  util functions
  ******************/
  
  // return theoretical dimensions of the canvas element
  function measureCanvas() {
    return { 
      w: IDM.$cvs_main.width, 
      h: IDM.$cvs_main.height,
      w_sm: IDM.$cvs_ref_1.width,
      h_sm: IDM.$cvs_ref_1.height
    };
  }
  
  // draw an image to the canvas
  // img_ctx = { x:, y:, w:, h: }
  function drawImage(canvas, img, img_ctx) {
    canvas.drawImage(img, img_ctx.x, img_ctx.y, img_ctx.w, img_ctx.h);
  }
  
  // get canvas-relative position / size for an image
  // assumes image is bigger than canvas w and canvas h
  function contextualizeImage(canvas, img) {
    var img_w = img.width,
        img_h = img.height,
        img_rat = img_h / img_w,
        canvas_w = canvas.width,
        canvas_h = canvas.height,
        canvas_rat = canvas_h / canvas_w,
        dest_dimensions = scaledDimensions();

    // this should be proportionally scaled to cover canvas area
    return dest_dimensions;
    
    // getting scaled dimensions for image, relative to canvas
    function scaledDimensions() {
      var w, h, x, y;
      var constrain = (img_rat < canvas_rat) ? 'h' : 'w';
      if(constrain === 'h') {
        h = canvas_h;
        w = (img_w / img_h) * h;
        x = (w - canvas_w) / -2; // centering horizontally
        y = 0;
      } else {
        w = canvas_w;
        h = (img_h / img_w) * w;
        x = 0;
        y = (h - canvas_h) / -2; // centering vertically
      }
      
      return { x: x, y: y, w: w, h: h };
    }
  }
  
  /**
  * http://stackoverflow.com/questions/2353211/hsl-to-rgb-color-conversion
  * SOURCE: http://axonflux.com/handy-rgb-to-hsl-and-rgb-to-hsv-color-model-c
  * Converts an HSL color value to RGB. Conversion formula
  * adapted from http://en.wikipedia.org/wiki/HSL_color_space.
  * Assumes h, s, and l are contained in the set [0, 1] and
  * returns r, g, and b in the set [0, 255].
  *
  * @param   Number  h       The hue
  * @param   Number  s       The saturation
  * @param   Number  l       The lightness
  * @return  Array           The RGB representation
  */
  function hslToRgb(h, s, l){
    var r, g, b;

    if (s == 0) {
        r = g = b = l; // achromatic
    } else {
      var hue2rgb = function hue2rgb(p, q, t){
        if(t < 0) t += 1;
        if(t > 1) t -= 1;
        if(t < 1/6) return p + (q - p) * 6 * t;
        if(t < 1/2) return q;
        if(t < 2/3) return p + (q - p) * (2/3 - t) * 6;
        return p;
      }

      var q = l < 0.5 ? l * (1 + s) : l + s - l * s;
      var p = 2 * l - q;
      r = hue2rgb(p, q, h + 1/3);
      g = hue2rgb(p, q, h);
      b = hue2rgb(p, q, h - 1/3);
    }

    return [Math.round(r * 255), Math.round(g * 255), Math.round(b * 255)];
  }
  
  /**
  * http://stackoverflow.com/questions/2353211/hsl-to-rgb-color-conversion
  * SOURCE: http://axonflux.com/handy-rgb-to-hsl-and-rgb-to-hsv-color-model-c  
  * Converts an RGB color value to HSL. Conversion formula
  * adapted from http://en.wikipedia.org/wiki/HSL_color_space.
  * Assumes r, g, and b are contained in the set [0, 255] and
  * returns h, s, and l in the set [0, 1].
  *
  * @param   Number  r       The red color value
  * @param   Number  g       The green color value
  * @param   Number  b       The blue color value
  * @return  Array           The HSL representation
  */
  function rgbToHsl(r, g, b){
    r /= 255, g /= 255, b /= 255;
    var max = Math.max(r, g, b), min = Math.min(r, g, b);
    var h, s, l = (max + min) / 2;

    if (max == min) {
        h = s = 0; // achromatic
    } else {
      var d = max - min;
      s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
      switch(max){
        case r: h = (g - b) / d + (g < b ? 6 : 0); break;
        case g: h = (b - r) / d + 2; break;
        case b: h = (r - g) / d + 4; break;
      }
      h /= 6;
    }

    return [h, s, l];
  }
  
  return IDM;
  
}