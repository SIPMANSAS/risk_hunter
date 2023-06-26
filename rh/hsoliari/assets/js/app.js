var relpath ='';
$(function() {


var matched, browser;

jQuery.uaMatch = function( ua ) {
    ua = ua.toLowerCase();

    var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
        /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
        /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
        /(msie) ([\w.]+)/.exec( ua ) ||
        ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
        [];

    return {
        browser: match[ 1 ] || "",
        version: match[ 2 ] || "0"
    };
};

matched = jQuery.uaMatch( navigator.userAgent );
browser = {};

if ( matched.browser ) {
    browser[ matched.browser ] = true;
    browser.version = matched.version;
}

// Chrome is Webkit, but Webkit is also Safari.
if ( browser.chrome ) {
    browser.webkit = true;
} else if ( browser.webkit ) {
    browser.safari = true;
}

jQuery.browser = browser;

//============================================================================================


$(document).on('click', "[id^=showmodaldlg_]", function(event) {
 event.preventDefault();
 event.stopPropagation();
	var TheTitle = $(this).attr("txdata");
	if(!TheTitle){var TheTitle = $(this).attr("title");}
	var funcid = $(this).attr("id").split("_");
	var suffix = funcid[1];
		$('#msg_'+suffix).html('');
		$('#form_'+suffix).show();
		resetForm($('#form_'+suffix));
	
$('#modaldlg_'+suffix).modal({backdrop: 'static', keyboard: false,show:true});
$('#modaldlg_'+suffix).draggable({handle: ".modal-header"});

if($('#langdirection1').length){
$('#langdirection1').prop('checked', true);}



  }); 


//-------------------------------------------------- 


$(document).on('click', 'button[id^=save_]', function(event) {	
        event.preventDefault();
		event.stopPropagation();
        posturl = relpath+'controller/controller.php';
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
				if(suffix=='langadd' || suffix=='langedit' || suffix=='langdel'){
					$('body').fadeOut(1000, function () { location.reload(true); });
					}
					else if(suffix=='bookingedit'){
						$(":file").filestyle("clear");
						if(json.filelist){$('.listfilepanel_'+suffix).html(json.filelist);}
						if(json.content){$('.listpanel_'+suffix).html(json.content);}
						}else{
				if(json.content){$('.listpanel_'+suffix).html(json.content);}
				}
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
	
//--------------------------------------------------


/* == generateakey Item == */
$(document).on('click', 'a.generateakey', function(event) {	
        event.preventDefault();
		event.stopPropagation();
                var id = $(this).data('id');
                var auth = $(this).data('auth');
                var listcont = $(this).data('listcont');
                new Messi("<div class=\"warning\"><p>"+ljsChKeyConfirm+"</p></div><div class=\"text-center\"><label class=\"checkbox-inline\"><input name=\"confirm_dlgsuredel\" type=\"checkbox\" value=\"1\"> <i></i><strong>"+ljsDelConfirmCk+"</strong></label></div>", {
                    title: '<span class="glyphicon glyphicon-exclamation-sign"></span> '+ljsConfirm,
					center:true,
                    modal: true,
					animate: false,
                    closeButton: true,
                    buttons: [
					{id: 0, label: '<span class="glyphicon glyphicon-remove"></span> '+ljsNo, val: 'N', class: 'btn-default'},
					{
                        id: 1,
                        label: '<span class="glyphicon glyphicon-ok"></span> '+ljsYes,
                        class: 'btn-primary',
                        val: 'Y'
                    }
					
					],
                    callback: function (val) {
					if(val=='Y'){
var confirm_dlgsuredel = $('[name=confirm_dlgsuredel]:checked').val();	
if(confirm_dlgsuredel){					
                        $.ajax({
                            type: 'post',
                            url: relpath+'controller/controller.php',
                            dataType: 'json',
                            data: {
                                id: id,
                                regenerateakey: auth
                            },
                            beforeSend: function () {
								showThinker('.panel_'+listcont);
                            },

            target: '.msg_'+listcont,
			error: function() {hideThinker('.panel_'+listcont);},
            success: function(json){
            if (json.status == "success") {
                hideThinker('.panel_'+listcont);
                if(json.message){$('.listpanelexp_'+listcont).html(json.message);}	
				if(json.content){$('.listpanel_'+listcont).html(json.content);}		
				if(json.extra){$('.listpanelplnk_'+listcont).html(json.extra);}
            } else {
                hideThinker('.panel_'+listcont);
                $('.msg_'+listcont).html(json.message);
            }
        }

                        });
}//suredel
else {alert(ljsDelNoConfirm);}
					}//if Y
                    }
                });
				
				return false;
            });
	
//--------------------------------------------------


$(document).on("click", "a.bkiavae", function(event) {	
        event.preventDefault();
		event.stopPropagation();
		var dataopt = $(this).data("opt");
		var datacont = $(this).data("cont");
		var dataid = $(this).data("id");
		var datadate = $(this).data("dn");
		var datacheck = $(this).data("ct");
		var funcid = datacheck.split('-');
		var avail = funcid[0];var chektype = funcid[1];	
		avail=ljsBlockStats[avail];	
		if(chektype=='i'){chektype=ljsChkin;}
		if(chektype=='o'){chektype=ljsChkout;}
		if(chektype=='a'){chektype='';}
		$("#popbkiavanae").html(datadate+"<br />"+chektype+" "+avail+"<div class='wpop_actionbuttons'>"
		+"<a class='bked btn btn-success btn-sm' href='#' data-cont='bookingedit' data-id='"+dataid+"' data-option='editBoking'><span class='glyphicon glyphicon-pencil'></span></a> "
		+"<a class='bkinf btn btn-info btn-sm' href='#' data-cont='bookinginfo' data-id='"+dataid+"' data-option='infoBoking'><span class='glyphicon glyphicon-info-sign'></span></a> "
		+"<a class='bkdel btn btn-danger btn-sm itemdelete' href='#' data-listcont='bookingdel' data-id='"+dataid+"' data-option='deleteBooking' data-name='"+datadate+", "+avail+"'><span class='glyphicon glyphicon-remove'></span></a></div>");
  
if(!Wenpopover.visible()){	
  Wenpopover.create(this, $("#popbkiavanae")[0], {
    showOn: false,
	inline: true,
    hideOn: [
  { element: this, event: "click" },
  { element: $(".btn"), event: "click" },
],
    hideOnBeyondClick: true,
    style: "white",
	closeBtn:false,
	closeBtnStyle:"white",
	zIndex: 1018
  });	
	
	Wenpopover.show(this);}else{Wenpopover.hide(this);}

		
return false;
});

//--------------------------------------------------


$(document).on("click", "a.bkiavai", function(event) {	
        event.preventDefault();
		event.stopPropagation();
		var dataopt = $(this).data("opt");
		var datacont = $(this).data("cont");
		var dataid = $(this).data("id");
		var datadate = $(this).data("dn");
		var datacheck = $(this).data("ct");
		var funcid = datacheck.split('-');
		var avail = funcid[0];var chektype = funcid[1];	
		avail=ljsBlockStats[avail];	
		if(chektype=='i'){chektype=ljsChkin;}
		if(chektype=='o'){chektype=ljsChkout;}
		if(chektype=='a'){chektype='';}
		$("#popbkiavanae").html(datadate+"<br />"+chektype+" "+avail+"<div class='wpop_actionbuttons'>"
		+"<a class='bkinf btn btn-info btn-sm' href='#' data-cont='bookinginfo' data-id='"+dataid+"' data-option='infoBoking'><span class='glyphicon glyphicon-info-sign'></span></a></div> "
		);
  
if(!Wenpopover.visible()){
	
  Wenpopover.create(this, $("#popbkiavanae")[0], {
    showOn: false,
	inline: true,
    hideOn: [
  { element: this, event: "click" },
  { element: $(".btn"), event: "click" },
],
    hideOnBeyondClick: true,
    style: "white",
	closeBtn:false,
	closeBtnStyle:"white",
	zIndex: 1018
  });	
	
	Wenpopover.show(this);}else{Wenpopover.hide(this);}

		
return false;
});


//--------------------------------------------------

/* == Delete Item == */
$(document).on('click', 'a.itemdelete', function(event) {	
        event.preventDefault();
		event.stopPropagation();
                var id = $(this).data('id');
                var name = $(this).data('name');
                var title = $(this).data('title');
                var option = $(this).data('option');
				var page = $(this).data('page');
				var vmode = $(this).data('vmode');
                var listcont = $(this).data('listcont');
				var auth = $(this).data('auth');
				var keyword = $(this).data('keyword');
                new Messi("<div class=\"warning\"><p><strong>"+name+"</strong><br />"+ljsDelConfirm+"</strong></p></div><div class=\"text-center\"><label class=\"checkbox-inline\"><input name=\"confirm_dlgsuredel\" type=\"checkbox\" value=\"1\"> <i></i><strong>"+ljsDelConfirmCk+"</strong></label></div>", {
                    title: '<span class="glyphicon glyphicon-exclamation-sign"></span> '+ljsConfirm,
					center:true,
                    modal: true,
					animate: false,
                    closeButton: true,
                    buttons: [
					{id: 0, label: '<span class="glyphicon glyphicon-remove"></span> '+ljsCancel, val: 'N', class: 'btn-default'},
					{
                        id: 1,
                        label: '<span class="glyphicon glyphicon-ok"></span> '+ljsDelete,
                        class: 'btn-danger',
                        val: 'Y'
                    }
					
					],
                    callback: function (val) {
					if(val=='Y'){
var confirm_dlgsuredel = $('[name=confirm_dlgsuredel]:checked').val();	
if(confirm_dlgsuredel){					
                        $.ajax({
                            type: 'post',
                            url: relpath+'controller/controller.php',
                            dataType: 'json',
                            data: {
                                id: id,
                                deleteitem: option,
								vmode: vmode,
								page: page ? page : null,
								auth: auth ? auth : null,
								keyword: keyword ? keyword : null
                            },
                            beforeSend: function () {
								showThinker('.panel_'+listcont);
                            },

            target: '.msg_'+listcont,
			error: function() {hideThinker('.panel_'+listcont);},
            success: function(json){
            if (json.status == "success") {
                hideThinker('.panel_'+listcont);
                $('.msg_'+listcont).html(json.message);
				if(json.content){$('.listpanel_'+listcont).html(json.content);}		
            } else {
                hideThinker('.panel_'+listcont);
                $('.msg_'+listcont).html(json.message);
				
            }
        }

                        });
}//suredel
else {alert(ljsDelNoConfirm);}
					}//if Y
                    }
                });
				
				return false;
            });

//--------------------------------------------------
/* == Edit Item == */
$(document).on('click', 'a.itemedit', function(event) {	
        event.preventDefault();
		event.stopPropagation();
                var id = $(this).data('id');
                var name = $(this).data('name');
                var title = $(this).data('title');
                var option = $(this).data('option');
				var page = $(this).data('page');
				var extra = $(this).data('extra');
                var listcont = $(this).data('listcont');

                        $.ajax({
                            type: 'post',
                            url: relpath+'controller/controller.php',
                            dataType: 'json',
                            data: {
                                id: id,
                                edititem: option,
								extra: extra ? extra : null,
								page: page ? page : null
                            },
                            beforeSend: function () {
								showThinker('.panel_'+listcont);
                            },

            target: '.msg_'+listcont,
			error: function() {hideThinker('.panel_'+listcont);},
            success: function(json){
            if (json.status == "success") {
                hideThinker('.panel_'+listcont);
                //$('.msg_'+listcont).html(json.message);
				if(json.content){$('#panel_'+listcont).html(json.content);
				$('#modaldlg_'+listcont).modal({backdrop: 'static', keyboard: false,show:true});
				$('#modaldlg_'+listcont).draggable({handle: ".modal-header"});
				}	
				
            } else {
                hideThinker('.panel_'+listcont);
                $('.msg_'+listcont).html(json.message);
            }
        }

                        });
				return false;
            });
			


//-----------------------------------------------------------
    $(document).on('click', '#pagination ul > li > a', function(event) { //#livepaging 
        event.preventDefault();
		event.stopPropagation();
        var uri = $(this).attr("href");
		var parentid = $(this).parent().parent().attr('id');
		var option = $(this).parent().parent().data('option');
		var auth = $(this).parent().parent().data('auth');
        var funcid = parentid.split('_');
		var suffix = funcid[1];		
		if(uri){
        var pagenum = getUrlParameter('pg', uri);

                        $.ajax({
                            type: 'post',
                            url: relpath+'controller/controller.php',
                            dataType: 'json',
                            data: {
                                auth: auth,
                                navigate: option,
								page: pagenum ? pagenum : null
                            },
                            beforeSend: function () {
								showThinker('.panel_'+suffix);
                            },

            target: '.msg_'+suffix,
			error: function() {hideThinker('.panel_'+suffix);},
            success: function(json){
            if (json.status == "success") {
                hideThinker('.panel_'+suffix);
				if(json.content){$('.listpanel_'+suffix).html(json.content);
				}	
				
            } else {
                hideThinker('.panel_'+suffix);
                $('.msg_'+suffix).html(json.message);
            }
        }

                        });

		}//if uri
        return false;
    })
//-------------------------------------------------- 			

$(document).on("change", '.setbookingdate', function(event) {	
        event.preventDefault();
		event.stopPropagation();
		  var auth = $(this).data("auth");
		  var listcont = $(this).data('listcont');
		  var id = $('#form_'+listcont+' input[name=id]').val();
          var checkin = $('#form_'+listcont+' input[name=checkin_submit]').val();
		  var checkout = $('#form_'+listcont+' input[name=checkout_submit]').val();		  
		  var ppttype = $('#form_'+listcont+' input[name='+listcont+'_ppttype]').val();		  
		  if(checkin && checkout){
var datab = [];
datab.push({ name: "checkAvailDate", value: auth });
datab.push({ name: "checkin_submit", value: checkin });
datab.push({ name: "checkout_submit", value: checkout });
datab.push({ name: "ppttype", value: ppttype });
if(id){
datab.push({ name: "id", value: id });	  
}
          $.ajax({
              type: "post",
			  dataType: "json",
              url: relpath+"controller/controller.php",
              data: datab,
              beforeSend: function () {
				showThinker("#panel_"+listcont);
              },
			  error: function() {hideThinker("#panel_"+listcont);},
              success: function (json) {
                      $("#msg_"+listcont).html(json.message);
					  hideThinker("#panel_"+listcont);
              }
          });
		  }

          return false;
      });	  
	  

//-------------------------------------------------- 

/* == Add Block == */
$(document).on('click', ".bkad", function(event) {
 event.preventDefault();
 event.stopPropagation();
                var option = $(this).data('option');
				var year = $(this).data('y');
				var date = $(this).data('date');
				var ppttype = $(this).data('ppttype');
				var vmode = $(this).data('vmode');
                var suffix = $(this).data('cont');

                        $.ajax({
                            type: 'post',
                            url: relpath+'controller/controller.php',
                            dataType: 'json',
                            data: {
                                addbooking: 'option',
								ppttype: ppttype ? ppttype : null,
								vmode: vmode ? vmode : null,
								date: date ? date : null,
								year: year ? year : null
                            },
                            beforeSend: function () {
								showThinker('.listpanel_'+suffix);
                            },

            target: '.msg_'+suffix,
			error: function() {hideThinker('.listpanel_'+suffix);},
            success: function(json){
            if (json.status == "success") {
                hideThinker('.listpanel_'+suffix);
				if(json.content){$('#panel_'+suffix).html(json.content);
				$('#modaldlg_'+suffix).modal({backdrop: 'static', keyboard: false,show:true});
				$('#modaldlg_'+suffix).draggable({handle: ".modal-header"});
				}	
				
            } else {
                hideThinker('.listpanel_'+suffix);
                $('.msg_'+suffix).html(json.message);
            }
        }

                        });
				return false;
            });
//--------------------------------------------------

/* == Edit Block == */
$(document).on('click', "a.bked", function(event) {
 event.preventDefault();
 event.stopPropagation();
                var id = $(this).data('id');
                var name = $(this).data('name');
                var title = $(this).data('title');
                var option = $(this).data('option');
				var page = $(this).data('page');
				var vmode = $(this).data('vmode');
                var suffix = $(this).data('cont');
				var keyword = $(this).data('keyword');

                        $.ajax({
                            type: 'post',
                            url: relpath+'controller/controller.php',
                            dataType: 'json',
                            data: {
                                id: id,
                                editbooking: option,
								vmode: vmode,
								page: page ? page : null,
								keyword: keyword ? keyword : null
                            },
                            beforeSend: function () {
								showThinker('.listpanel_'+suffix);
                            },

            target: '.msg_'+suffix,
			error: function() {hideThinker('.listpanel_'+suffix);},
            success: function(json){
            if (json.status == "success") {
                hideThinker('.listpanel_'+suffix);
				if(json.content){$('#panel_'+suffix).html(json.content);
				$('#modaldlg_'+suffix).modal({backdrop: 'static', keyboard: false,show:true});
				$('#modaldlg_'+suffix).draggable({handle: ".modal-header"});
				}	
				
            } else {
                hideThinker('.listpanel_'+suffix);
                $('.msg_'+suffix).html(json.message);
            }
        }

                        });
				return false;
            });
//-------------------------------------------------- 

/* == Details Block == */
$(document).on('click', "a.bkinf", function(event) {
 event.preventDefault();
 event.stopPropagation();
                var id = $(this).data('id');
                var name = $(this).data('name');
                var title = $(this).data('title');
                var option = $(this).data('option');
				var vmode = $(this).data('vmode');
                var suffix = $(this).data('cont');

                        $.ajax({
                            type: 'post',
                            url: relpath+'controller/controller.php',
                            dataType: 'json',
                            data: {
                                id: id,
                                infobooking: option,
								vmode: vmode
                            },
                            beforeSend: function () {
								showThinker('.listpanel_'+suffix);
                            },

            target: '.msg_'+suffix,
			error: function() {hideThinker('.listpanel_'+suffix);},
            success: function(json){
            if (json.status == "success") {
                hideThinker('.listpanel_'+suffix);
				if(json.content){$('#panel_'+suffix).html(json.content);
				$('#modaldlg_'+suffix).modal({backdrop: 'static', keyboard: false,show:true});
				$('#modaldlg_'+suffix).draggable({handle: ".modal-header"});
				}	
				
            } else {
                hideThinker('.listpanel_'+suffix);
                $('.msg_'+suffix).html(json.message);
            }
        }

                        });
				return false;
            });
//-------------------------------------------------- 


/* == aKey Info == */
$(document).on('click', "a.akeyinf", function(event) {
 event.preventDefault();
 event.stopPropagation();
                var id = $(this).data('id');
                var auth = $(this).data('auth');
                var suffix = $(this).data('listcont');

                        $.ajax({
                            type: 'post',
                            url: relpath+'controller/controller.php',
                            dataType: 'json',
                            data: {
                                id: id,
                                regenerateakey: auth
                            },
                            beforeSend: function () {
								showThinker('.listpanel_'+suffix);
                            },

            target: '.msg_'+suffix,
			error: function() {hideThinker('.listpanel_'+suffix);},
            success: function(json){
            if (json.status == "success") {
                hideThinker('.listpanel_'+suffix);
				if(json.content){$('#panel_'+suffix).html(json.content);
				$('#modaldlg_'+suffix).modal({backdrop: 'static', keyboard: false,show:true});
				$('#modaldlg_'+suffix).draggable({handle: ".modal-header"});
				}	
				
            } else {
                hideThinker('.listpanel_'+suffix);
                $('.msg_'+suffix).html(json.message);
            }
        }

                        });
				return false;
            });
//--------------------------------------------------

$(document).on("change", "select.setcolorprev", function(event) {	
        event.preventDefault();
		event.stopPropagation();
          var clr = $(this).find(':selected').data('hex')
		  $('.colorprev').css('background-color',clr);
          return false;
      });	  


$(document).on("click", ".copyable-btn", function(event) {
	    var id = $(this).data('id');
		$(".copyable.i"+id)[0].focus();
        var selectedText = getSelectedText($(".copyable.i"+id)[0]);		
        if(getSelectedText($(".copyable.i"+id)[0]) != '') {          
            copyToClipboard(selectedText);
        } else {
            $(".copyable.i"+id).focus().select();
        }
        document.execCommand('copy');
		new Messi('<div class="alert alert-success"><span class="glyphicon glyphicon-copy"></span> '+ljsCopiedToClipbrd+'</div>',
    {autoclose: 1500,center:true,
                    modal: true,
					animate: false
	});
    });



            /* == Inline Edit == */
            $(document).on('focus', 'div[contenteditable=true]', function () {
                $(this).data("initialText", $(this).text());
                $('div[contenteditable=true]').not(this).removeClass('active');
                $(this).toggleClass("active");
            }).on('blur', 'div[contenteditable=true]', function () {
				var initText = $(this).data("initialText");
                if ($(this).data("initialText") !== $(this).text()) {
                    title = $(this).text();
					lang = $(this).data("abbr");
                    type = $(this).data("edit-type");
                    id = $(this).data("id")
                    key = $(this).data("key")
                    auth = $(this).data("auth")
                    $this = $(this);
                    $.ajax({
                        type: "POST",
                        url: relpath+'controller/controller.php',
                        data: ({
                            'title': title,
                            'type': type,
                            'key': key,
                            'auth': auth,
                            'id': id,
							'lang': lang
                        }),
                        beforeSend: function () {
                            $this.text(ljsWorking).animate({
                                opacity: 0.2
                            }, 800);
                        },
                        success: function (res) {//
                            $this.animate({
                                opacity: 1
                            }, 800);
                            setTimeout(function () {
								if(res=='--- emptystring ---'){$this.html(initText).fadeIn("slow");}
								else{
                                $this.html(res).fadeIn("slow");}
                            }, 1000);
                        }
                    })
                }
            }); 	  



$(document).on("keypress keyup blur", ".ti-ifnumdec", function(event) {		
		$(this).val($(this).val().replace(/[^0-9,]+/g, ''));
        if ((event.which != 8) && (event.which != 48) && (event.which != 49) && (event.which != 50) && (event.which != 51) && (event.which != 52) && (event.which != 53) && (event.which != 54) && (event.which != 55) && (event.which != 56) && (event.which != 57) && ($(this).val().indexOf(',') != -1)) {
            event.preventDefault();
        }
    });
$(document).on("keypress keyup blur", ".ti-ifnumdep", function(event) {		
		$(this).val($(this).val().replace(/[^0-9.]+/g, ''));
        if ((event.which != 8) && (event.which != 48) && (event.which != 49) && (event.which != 50) && (event.which != 51) && (event.which != 52) && (event.which != 53) && (event.which != 54) && (event.which != 55) && (event.which != 56) && (event.which != 57) && ($(this).val().indexOf('.') != -1)) {
            event.preventDefault();
        }
    });
	$(document).on("keypress keyup blur", ".ti-ifnumber", function(event) {
		$(this).val($(this).val().replace(/[^0-9,]+/g, ''));
        if ((event.which != 8) && (event.which != 48) && (event.which != 49) && (event.which != 50) && (event.which != 51) && (event.which != 52) && (event.which != 53) && (event.which != 54) && (event.which != 55) && (event.which != 56) && (event.which != 57)) {
            event.preventDefault();
        }		
    });

	  

//--------------------------------------------------
$(document).on("keyup", "#panel_blocksearch #searchterm", function(event) {
event.stopPropagation();
          var srch_string = $(this).val();
		  var auth = $(this).data('auth');
          if (srch_string.length > 3) {
              $.ajax({
                 type: 'post',
                 url: relpath+'controller/controller.php',
                 dataType: 'json',
                            data: {
                                blockSearch: srch_string,
                                auth: auth
                            },				 
             beforeSend: function () {
				 $('#yearcalendar').html('');
			showThinker('#yearcalendar');
             },

            target: '#yearcalendar',
			error: function() {hideThinker('#yearcalendar');},
            success: function(json){
            if (json.status == "success") {
                hideThinker('#yearcalendar');
				if(json.content){$('#yearcalendar').html(json.content);
				}	
				
            } else {
                hideThinker('#yearcalendar');
                $('#yearcalendar').html(json.message);
            }}
              });
          }else{$('#yearcalendar').html('');}
          
      });

//--------------------------------------------------

}); //$(document).ready