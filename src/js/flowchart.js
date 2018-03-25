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
});
