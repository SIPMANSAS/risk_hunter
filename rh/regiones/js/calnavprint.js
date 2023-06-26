var relpath ='';
$(function() {



//-------------------------------------------------- 

$(document).on("click", ".yearcalendar a.changeyear", function(event) {	
        event.preventDefault();
		event.stopPropagation();
          var year = $(this).data("year");
		  var auth = $(this).data("auth");
		  var vmode = $(this).data('vmode');
		  var view = $(this).data('view');
		  var ppttype = $('select[name=changetype]').val();
          $.ajax({
              type: "post",
			  dataType: "json",
              url: relpath+"controller/controller.php",
              data: {
                  year: year,
				  calNavigateYear: auth,
				  ppttype: ppttype,
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

$(document).on("change", ".yearcalendar select.changetype", function(event) {	
        event.preventDefault();
		event.stopPropagation();
          var year = $(this).data("year");
		  var auth = $(this).data("auth");
		  var vmode = $(this).data('vmode');
		  var view = $(this).data('view');
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


});