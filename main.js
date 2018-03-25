
// DOC.READY: Mostly hides all modal windows
$(document).ready (function(){
  $("#delete-alert").hide();
  $("#success-alert").hide();
  $("#logout-alert").hide();
  $("#timeout-alert").hide();
  $("#duplicate-alert").hide();
})//.DOC.READY


// DISPLAYS LOGOUT MODAL WINDOW
$(document).on('click', '#btnLogout', function(e){
  e.preventDefault();
  console.log('Opening Modal Confirmation');
  $("#modalLogout").height(400);
  $("#modalLogout").width(530);
});


// -- DISPLAYS DELETE CONFIRMATION MODAL WINDOW
$(document).on('click', '#btnDelete', function(e){
  e.preventDefault();
  console.log('Opening Modal Confirmation');
  $("#modalDelete").height(400);
  $("#modalDelete").width(530);
});


// Redirects user to logout php page. Clears session user.
function logOutUser()
{
    document.location.href='/eCoordinator/a_logout.php';
}
