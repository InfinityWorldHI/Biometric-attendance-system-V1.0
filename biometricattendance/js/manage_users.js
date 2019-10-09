$(document).ready(function(){
  // Add user
  $(document).on('click', '.user_add', function(){
    //user Info
    var name = $('#name').val();
    var number = $('#number').val();
    var email = $('#email').val();
    //Additional Info
    var timein = $('#timein').val();
    var gender = $(".gender:checked").val();
    
    $.ajax({
      url: 'manage_users_conf.php',
      type: 'POST',
      data: {
        'Add': 1,
        'name': name,
        'number': number,
        'email': email,
        'timein': timein,
        'gender': gender,
      },
      success: function(response){
        $('#name').val('');
        $('#number').val('');
        $('#email').val('');

        $('#timein').val('');
        $('#gender').val('');
        
        $('#alert').fadeIn(500);
        $('#alert').text(response);
        
        setTimeout(function () {
            $('#alert').fadeOut(500);
        }, 5000);
        
        $.ajax({
          url: "manage_users_up.php"
          }).done(function(data) {
          $('#manage_users').html(data);
        });
      }
    });
  });
  // Add user Fingerprint
  $(document).on('click', '.fingerid_add', function(){

    var fingerid = $('#fingerid').val();
    
    $.ajax({
      url: 'manage_users_conf.php',
      type: 'POST',
      data: {
        'Add_fingerID': 1,
        'fingerid': fingerid,
      },
      success: function(response){
        $('#fingerid').val('');
        
        $('#alert').fadeIn(500);
        $('#alert').text(response);
        
        setTimeout(function () {
            $('#alert').fadeOut(500);
        }, 5000);
        
        $.ajax({
          url: "manage_users_up.php"
          }).done(function(data) {
          $('#manage_users').html(data);
        });
      }
    });
  });
  // Update user
  $(document).on('click', '.user_upd', function(){
    //user Info
    var name = $('#name').val();
    var number = $('#number').val();
    var email = $('#email').val();
    //Additional Info
    var timein = $('#timein').val();
    var gender = $(".gender:checked").val();

    $.ajax({
      url: 'manage_users_conf.php',
      type: 'POST',
      data: {
        'Update': 1,
        'name': name,
        'number': number,
        'email': email,
        'timein': timein,
        'gender': gender,
      },
      success: function(response){
        $('#name').val('');
        $('#number').val('');
        $('#email').val('');

        $('#timein').val('');
        $('#gender').val('');

        $('#alert').fadeIn(500);
        $('#alert').text(response);
        
        setTimeout(function () {
            $('#alert').fadeOut(500);
        }, 5000);
        
        $.ajax({
          url: "manage_users_up.php"
          }).done(function(data) {
          $('#manage_users').html(data);
        });
      }
    });   
  });
  // delete user
  $(document).on('click', '.user_rmo', function(){
  	$.ajax({
  	  url: 'manage_users_conf.php',
  	  type: 'POST',
  	  data: {
    	'delete': 1,
      },
      success: function(response){
        $('#name').val('');
        $('#number').val('');
        $('#email').val('');

        $('#timein').val('');
        $('#gender').val('');

        $('#alert').fadeIn(500);
        $('#alert').text(response);
        
        setTimeout(function () {
            $('#alert').fadeOut(500);
        }, 5000);
        
        $.ajax({
          url: "manage_users_up.php"
          }).done(function(data) {
          $('#manage_users').html(data);
        });
      }
  	});
  });
  // select user
  $(document).on('click', '.select_btn', function(){
    var Finger_id = $(this).attr("id");
    $.ajax({
      url: 'manage_users_conf.php',
      type: 'GET',
      data: {
      'select': 1,
      'Finger_id': Finger_id,
      },
      success: function(response){

        $('#alert').fadeIn(500);
        $('#alert').text(response);
        
        setTimeout(function () {
            $('#alert').fadeOut(500);
        }, 5000);

        $.ajax({
          url: "manage_users_up.php"
          }).done(function(data) {
          $('#manage_users').html(data);
        });
      }
    });
  });
});
