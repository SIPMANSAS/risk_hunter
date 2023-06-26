var relpath ='';
$(function() {

$(document).on("click", "a.bkiavanae", function(event) {	
        event.preventDefault();
		event.stopPropagation();
		var datadate = $(this).data("dn");
		var datacheck = $(this).data("ct");
		var funcid = datacheck.split('-');
		var avail = funcid[0];var chektype = funcid[1];	
		avail=ljsBlockStats[avail];	
		if(chektype=='i'){chektype=ljsChkin;}
		if(chektype=='o'){chektype=ljsChkout;}
		if(chektype=='a'){chektype='';}
		$("#popbkiavanae").html(datadate+"<br />"+chektype+" "+avail);
  
if(!Wenpopover.visible()){
	
  Wenpopover.create(this, $("#popbkiavanae")[0], {
    showOn: false,
	inline: true,
    hideOn: [
  { element: this, event: "click" },
  { element: "tooltip", event: "mouseleave" }
],
    hideOnBeyondClick: true,
    style: "tipfo",
	zIndex: 1018
  });	
	
	Wenpopover.show(this);}else{Wenpopover.hide(this);}

		
return false;
});

//-------------------------------------------------- 

$(document).on("click", ".yearcalendar a.changeyear", function(event) {	
        event.preventDefault();
		event.stopPropagation();
          var year = $(this).data("year");
		  var auth = $(this).data("auth");
		  var vmode = $(this).data('vmode');
		  var view = $(this).data('view');
		  var hab = $(this).data('hab');
          var ppttype = $('select[name=changetype]').val();
          $.ajax({
              type: "post",
			  dataType: "json",
              url: relpath+"controller/controller.php",
              data: {
                  year: year,
				  calNavigateYear: auth,
				  ppttype: ppttype,
				  hab: hab,
				  vmode: vmode,
				  view: view
              },
              beforeSend: function () {
				showThinker(".panel_yearcalendar");
              },
			  target: "#yearcalendar",
			  error: function() {hideThinker(".panel_yearcalendar");},
              success: function (json) {
                      $("#yearcalendar").fadeIn("slow", function () {
                          $(this).html(json.content);
                      });
					  hideThinker(".panel_yearcalendar");
              }
          });
          return false;
      });
	  
//--------------------------------------------------

$(document).on("click", ".yearcalendar a.changehab", function(event) {
        event.preventDefault();
		event.stopPropagation();
          var year = $(this).data("year");
		  var auth = "administrator";
		  var vmode = $(this).data('vmode');
		  var view = $(this).data('view');
		  var hab = $(this).data("hab");
		  var ppttype = $('select[name=changetype]').val();
          $.ajax({
              type: "post",
			  dataType: "json",
              url: relpath+"controller/controller.php",
              data: {
                  year: year,
				  calNavigatehab: auth,
				  ppttype: ppttype,
				  vmode: vmode,
				  hab: hab,
				  view: view
              },
              beforeSend: function () {
				showThinker(".panel_yearcalendar");
              },
			  target: "#yearcalendar",
			  error: function() {hideThinker(".panel_yearcalendar");},
              success: function (json) {
                      $("#yearcalendar").fadeIn("slow", function () {
                          $(this).html(json.content);
                      });
					  hideThinker(".panel_yearcalendar");
              }
          });
          return false;
      });


//-------------------------------------------------- 

$(document).on("change", ".yearcalendar select.changetype", function(event) {	
        event.preventDefault();
		event.stopPropagation();
          var year = $(this).data("year");
		  var auth = $(this).data("auth");
		  var vmode = $(this).data('vmode');
		  var view = $(this).data('view');
          var hab = $(this).data('hab');
          var ppttype = $(this).val();
		  
          $.ajax({
              type: "post",
			  dataType: "json",
              url: relpath+"controller/controller.php",
              data: {
                  year: year,
				  calNavigateYear: auth,
				  ppttype: ppttype ? ppttype : null,
				  vmode: vmode,
				  hab: hab,
				  view: view
              },
              beforeSend: function () {
				showThinker(".panel_yearcalendar");
              },
			  target: "#yearcalendar",
			  error: function() {hideThinker(".panel_yearcalendar");},
              success: function (json) {
                      $("#yearcalendar").fadeIn("slow", function () {
                          $(this).html(json.content);
                      });
					  hideThinker(".panel_yearcalendar");
              }
          });
          return false;
      });	  
//-------------------------------------------------- 



//-------------------------------------------------- 

$(document).on("click", ".yearcalendar a.changeyearview", function(event) {	
        event.preventDefault();
		event.stopPropagation();
          var year = $(this).data("year");
		  var auth = $(this).data("auth");
		  var vmode = $(this).data('vmode');
		  var view = $(this).data('view');
		  var psview = '';
		   var hab = $(this).data('hab');
		  var ppttype = $(this).data('ppttype');
		  //var ppttype = $('select[name=changetype]').val();
		  
		  var uri = $(location).attr('href');
		  if(uri){
			if(getUrlParameter('p', uri)){var psview = getUrlParameter('p', uri);}
			if(!psview){psview='';}
		  }
		  
          $.ajax({
              type: "post",
			  dataType: "json",
              url: relpath+"controller/controller.php",
              data: {
                  year: year,
				  calNavigateYearView: auth,
				  ppttype: ppttype ? ppttype : null,
				  psview: psview,
				  vmode: vmode,
				  hab: hab,
				  view: view
              },
              beforeSend: function () {
				showThinker(".panel_yearcalendar");
              },
			  target: "#yearcalendar",
			  error: function() {hideThinker(".panel_yearcalendar");},
              success: function (json) {
                      $("#yearcalendar").fadeIn("slow", function () {
                          $(this).html(json.content);
                      });
					  hideThinker(".panel_yearcalendar");
              }
          });
          return false;
      });
	  
//-------------------------------------------------- 

$(document).on("change", ".yearcalendar select.changetypeyear", function(event) {	
        event.preventDefault();
		event.stopPropagation();
          var year = $(this).data("year");
		  var auth = $(this).data("auth");
		  var vmode = $(this).data('vmode');
		  var view = $(this).data('view');
		  var ppttype = $(this).val();
		   var hab = $(this).data('hab');
		  var psview = '';
		  
          $.ajax({
              type: "post",
			  dataType: "json",
              url: relpath+"controller/controller.php",
              data: {
                  year: year,
				  calNavigateYearView: auth,
				  ppttype: ppttype,
				  psview: psview,
				  hab: hab,
				  view: view
              },
              beforeSend: function () {
				showThinker(".panel_yearcalendar");
              },
			  target: "#yearcalendar",
			  error: function() {hideThinker(".panel_yearcalendar");},
              success: function (json) {
                      $("#yearcalendar").fadeIn("slow", function () {
                          $(this).html(json.content);
                      });
					  hideThinker(".panel_yearcalendar");
              }
          });
          return false;
      });	  
//-------------------------------------------------- 


//-------------------------------------------------- 

$(document).on("click", ".yearcalendar a.changemonthyear", function(event) {	
        event.preventDefault();
		event.stopPropagation();
		  var month = $(this).data("month");
          var year = $(this).data("year");
		  var auth = $(this).data("auth");
		  var vmode = $(this).data('vmode');
		  var months = $(this).data("months");
		  var ppttype = $(this).data('ppttype');
	      var hab = $(this).data('hab');
		  var psview = '';
		  
		  //var ppttype = $('select[name=changetype]').val();
		  var uri = $(location).attr('href');
		  if(uri){
			if(getUrlParameter('p', uri)){var psview = getUrlParameter('p', uri);}
			if(!psview){psview='';}
		  }
          $.ajax({
              type: "post",
			  dataType: "json",
              url: relpath+"controller/controller.php",
              data: {
				  month: month,
                  year: year,
				  calNavigateMonth: auth,
				  ppttype: ppttype ? ppttype : null,
				  psview: psview,
				  months: months,
				  hab: hab,
				  vmode: vmode
              },
              beforeSend: function () {
				showThinker(".panel_yearcalendar");
              },
			  target: "#yearcalendar",
			  error: function() {hideThinker(".panel_yearcalendar");},
              success: function (json) {
                      $("#yearcalendar").fadeIn("slow", function () {
                          $(this).html(json.content);
                      });
					  hideThinker(".panel_yearcalendar");
              }
          });
          return false;
      });
	  
//-------------------------------------------------- 

$(document).on("change", ".yearcalendar select.changetypemonth", function(event) {	
        event.preventDefault();
		event.stopPropagation();
		  var month = $(this).data("month");
          var year = $(this).data("year");
		  var auth = $(this).data("auth");
		  var vmode = $(this).data('vmode');
		  var months = $(this).data("months");
		  var ppttype = $(this).val();
	      var hab = $(this).data('hab');
		  var psview = '';
		  
          $.ajax({
              type: "post",
			  dataType: "json",
              url: relpath+"controller/controller.php",
              data: {
				  month: month,
                  year: year,
				  calNavigateMonth: auth,
				  ppttype: ppttype,
				  psview: psview,
				  months: months,
				  hab: hab,
				  vmode: vmode
              },
              beforeSend: function () {
				showThinker(".panel_yearcalendar");
              },
			  target: "#yearcalendar",
			  error: function() {hideThinker(".panel_yearcalendar");},
              success: function (json) {
                      $("#yearcalendar").fadeIn("slow", function () {
                          $(this).html(json.content);
                      });
					  hideThinker(".panel_yearcalendar");
              }
          });
          return false;
      });	  
//-------------------------------------------------- 	  

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
/*$.cookie("LANGUAGE_VRBC", 'en', {
              expires: 120,
              path: '/'
          });
*/

if(!isInIframe()){
	 $('body').addClass('loggedin');
	 $('.loggedin-bar').fadeIn('200');
	 }

$(document).on('click', 'a.logoutpublic', function (event) {
        event.preventDefault();
		event.stopPropagation();
var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1);
var qrstr ;
if(hashes){qrstr='&'+hashes;}else{qrstr='&';}
$('body').fadeOut(1000, function () {
window.location.href = relpath+"login/?logout=public"+qrstr;
});
return false;
});

});
