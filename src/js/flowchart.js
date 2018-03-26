// -- OPEN STUDENT EDIT WINDOW
$(document).on('click', '#btnOpenModal', function(e){
    e.preventDefault();
    var stuId = $(this).data('id');   // Gets student ID from box
    var couKey = $(this).data('key'); // Gets course key from box
    $('#dynamic-content').html(''); // leave it blank before ajax call
    $('#modal-loader').show();      // load ajax loader
    $("#view-modal").height(700); // Sets window size
    $("#view-modal").width(1000);
    $.ajax({
            url: 'f_studentcoursemodal.php',
            type: 'POST',
            data: {id: stuId, coursekey: couKey},
            dataType: 'html'
    })
    .done(function(data){
            console.log('Loaded student course information window');
            $('#dynamic-content').html('');
            $('#dynamic-content').html(data);       // load response
            $('#modal-loader').hide();              // hide ajax loader
    })
    .fail(function(){
            console.log('Theres an issue with the student course information modal window');
            $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Oooops! \n Maybe the data for this user and course has not been imported yet');
            $('#modal-loader').hide();
    });
});

$(document).ready (function(){

  $("#success-alert").hide();

  // -- SHOWS SAVE CONFIRMATION MODAL
  if (window.location.hash === "#saveConfirmation") {
    console.log('Showing save confirmation');
    history.pushState("", document.title, window.location.pathname + window.location.search);
    $("#success-alert").alert();
    $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
      $("#success-alert").slideUp(700);
    });
  };


  var canvas=document.getElementById("myCanvas");
  var ctx=canvas.getContext("2d");
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
  ctx.lineWidth = 3;
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  var $canvas = $("#myCanvas");
  var canvasOffset = $canvas.offset();
  var offsetX = canvasOffset.right;
  var offsetY = canvasOffset.top;

  var colors = [
    '#808080',
    '#FF0000',
    '#800000',
    '#FFFF00',
    '#808000',
    '#00FF00',
    '#008000',
    '#00FFFF',
    '#008080',
    '#0000FF',
    '#000080',
    '#FF00FF',
    '#000000',
    '#800080'
  ];

  for (var d = 0; d <= $("#totDep").val(); d++) {
    for (var i = 0; i <= 5; i++) {
      var $str_a = "a" + d + "-" + i;
      var $str_b = "b" + d + "-" + i;

      if ($("#" + $str_a).length > 0) {
        var $var_a = $('#' + $str_a).val();
        var $var_b = $('#' + $str_b).val();

        var $a = $('#' + $var_a);
        var $b = $('#' + $var_b);

        var connectors = [];
        connectors.push({
            from: $a,
            to: $b
        });

      } else {
        console.log("No dependencies found");
      }

    connect(colors[d]);

    }
  };
  function connect(line_color) {
      for (var i = 0; i < connectors.length; i++) {
          var c = connectors[i];
          var cFrom = c.from;
          var cTo = c.to;

          // Tries to get center of first box
          var box1 = cFrom.offset();
          var box1w = cFrom.width();
          var box1h = cFrom.height();
          var box1cX = box1.left + box1w / 2;
          var box1cY = box1.top;

          // Tries to get center of second box
          var box2 = cTo.offset();
          var box2w = cTo.width();
          var box2h = cTo.height();
          var box2cX = box2.left + box2w / 2;
          var box2cY = box2.top;

          // Draws out line
          ctx.beginPath();
          ctx.moveTo(box1cX, box1cY);
          ctx.lineTo(box2cX, box2cY);
          ctx.strokeStyle=line_color;
          ctx.stroke();
      }
  }
});
