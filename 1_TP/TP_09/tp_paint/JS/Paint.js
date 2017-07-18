var canvas;
var context;
var contextB;
var color = "#0000ff";
var thickness = 3;
window.onload = initCanvas;

var isDrawing = false;

function startDrawing(e) {
  // Start drawing.
  isDrawing = true;

  // Create a new path (with the current stroke color and stroke thickness).
  context.beginPath();

  // Put the pen down where the mouse is positioned.
  context.moveTo(e.pageX - canvas.offsetLeft, e.pageY - canvas.offsetTop);
}

function stopDrawing() {
  isDrawing = false;
}

function draw(e) {
  if (isDrawing == true) {
    // Find the new position of the mouse.
    var x = e.pageX - canvas.offsetLeft;
    var y = e.pageY - canvas.offsetTop;

    // Draw a line to the new position.
    context.lineTo(x, y);
    context.stroke();	
  }
}

// Keep track of the previous clicked <img> element for color.
var previousColorElement;

function changeColor(color, imgElement) {
  // Change the current drawing color.
    console.log(color);
  context.strokeStyle = color;

}

// Keep track of the previous clicked <img> element for thickness.
var previousThicknessElement;

function changeThickness(thickness, imgElement) {
  // Change the current drawing thickness.
  context.lineWidth = thickness;
    var centerX = $('#CanvasSize').attr('width') / 2;
    var centerY = $('#CanvasSize').attr('height') / 2;
    var radius = thickness ;
    contextB.clearRect(0, 0, canvas.width, canvas.height);
    contextB.beginPath();
    contextB.arc(centerX, centerY, radius, 0, 2 * Math.PI, false);
    contextB.fillStyle = color;
    contextB.fill();
    contextB.lineWidth = 2;
    contextB.strokeStyle = '#003300';
    contextB.stroke();

}


function clearCanvas() {
  context.clearRect(0, 0, canvas.width, canvas.height);
}

function saveCanvas() { 
  // Find the <img> element.
  var imageCopy = document.getElementById("savedImageCopy");

  // Show the canvas data in the image.
  imageCopy.src = canvas.toDataURL();  

  // Unhide the <div> that holds the <img>, so the picture is now visible.
  var imageContainer = document.getElementById("savedCopyContainer");
  imageContainer.style.display = "block";
}

function initCanvas(){
    // Get the canvas and the drawing context.
    canvas = document.getElementById("drawingCanvas");
    context = canvas.getContext("2d");

    // Attach the events that you need for drawing.
    canvas.onmousedown = startDrawing;
    canvas.onmouseup = stopDrawing;
    canvas.onmouseout = stopDrawing;
    canvas.onmousemove = draw;

    imageObj = new Image();

    imageObj.onload = function() {
        context.drawImage(imageObj, 0, 0);
    };
    changeColor("rgb(0,0,255)",null);
}
function initCanvasCircle(){
    // Get the canvas and the drawing context.
    canvas = document.getElementById("CanvasSize");
    contextB = canvas.getContext("2d");
    changeThickness(3,null);


    imageObj = new Image();

    imageObj.onload = function() {
        context.drawImage(imageObj, 0, 0);
    };
}

$(document).ready(function(){

  initCanvas();
  initCanvasCircle();

  $('.accordeon').accordion({
    heightStyle: "content",
    animate: 250
  });

  $('#menuUpload').dialog({
      position:{my: "left top", at: "center bottom", of: $('body div:first')},
      autoOpen: false,
      show: { duration: 250 },
      hide: { duration: 500 },
      width: 400
  });
  $('body div:first').click(function(evt){
      evt.preventDefault();
      $('#menuUpload').dialog('open');
  });
  $('#formWeb').submit(function(evt){
      evt.preventDefault();
      imageObj.source = $('#iWeb').attr('value');
      $('#menuUpload').dialog('close');
  });
    $('#formAjax').submit(function(evt){
        evt.preventDefault();
        callAjax($('#iAjax').attr('value'));
        $('#menuUpload').dialog('close');
    });
    $('#imageLoader').change(function(evt){
        handleImage(evt);
        $('#menuUpload').dialog('close');
    });

    $('.sliderSize').slider({
        min:1,
        max:10,
        step: 1,
        value: 3,
        slide: function(event, ui) {
            changeThickness(ui.value,null);
            thickness = ui.value;
        }

    });

    $('#colorSelector').ColorPicker({
        color: '#0000ff',
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb) {
            $('#colorSelector div').css('backgroundColor', '#' + hex);
            changeColor("rgb("+rgb.r+","+rgb.g+","+rgb.b+")",null);
            color = "#"+hex;
            changeThickness(thickness,null);

        }
    });
    $('#CanvasSize').ColorPicker({
        color: '#0000ff',
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb) {
            $('#colorSelector div').css('backgroundColor', '#' + hex);
            changeColor("rgb("+rgb.r+","+rgb.g+","+rgb.b+")",null);
            color = "#"+hex;
            changeThickness(thickness,null);

        }
    });

    //var val = $('#slider').slider("option", "value");

});

function callAjax(elem){
    console.log(elem);
    var request = new XMLHttpRequest();
    request.open('GET', elem, true);
    request.onreadystatechange = function() {
        // Makes sure the document is ready to parse.
        if(request.readyState == 4) {
            // Makes sure it's found the file.
            if(request.status == 200) {
                imageObj.source = request.responseText;
            }
        }
    };
    request.send();

}
function handleImage(e){
    var canvas = $('#drawingCanvas')[0];;
    //canvas = $('#drawingCanvas')[0];
    var ctx = canvas.getContext('2d');
    var reader = new FileReader();
    reader.onload = function(event){
        var img = new Image();
        img.onload = function(){
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img,0,0);
        }
        img.src = event.target.result;
    }
    reader.readAsDataURL(e.target.files[0]);
}