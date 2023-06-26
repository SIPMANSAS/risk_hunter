$(function() {

$(document).on('click', 'button[id^=save_]', function(event) {	
        event.preventDefault();
		event.stopPropagation();
        posturl = '../controller/controller.php';
		var next = $(this).data('after');
		var id = $(this).data('id');
        var funcid = $(this).attr('id').split('_');
		var suffix = funcid[1];
		var clearform = false;
		var resetform = false; 

        function showResponse(json) {
            if (json.status == "success") {
                hideThinker('#panel_'+suffix);
				if(next=='hide'){clearform=true;resetform=true;$('#form_'+suffix).slideUp();}
                $('#msg_'+suffix).html(json.message);
				if(json.content){$('.listpanel_'+suffix).html(json.content);}			
            } else {
                hideThinker('#panel_'+suffix);
                $('#msg_'+suffix).html(json.message);
            }
        }

        var options = {
            target: '#msg_'+suffix,
            beforeSubmit: showThinker('#panel_'+suffix),
			error: function() {hideThinker('#panel_'+suffix);},
            success: showResponse,
            type: "post",
            url: posturl,
            dataType: 'json',
			clearForm: clearform,
            resetForm: resetform,
			id: id ? id : null

        };

        $('#form_'+suffix).ajaxForm(options).submit();
		return false;
    });

$(document).on('click', 'a.langitem', function () {
          //var target = $(this).attr('href');
          $.cookie("LANGUAGE_VRBC", $(this).data('lang'), {
              expires: 30,
              path: '/'
          });

          $('body').fadeOut(1000, function () {
			  location.reload(true);
          });
          return false;
      });	
//-------------------------------------------------- 	  
	  
});