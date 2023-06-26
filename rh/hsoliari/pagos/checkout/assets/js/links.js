var relpath ='';
$(function() {
//--------------------------------------------------

$(document).on("change", ".panel_calexplinks select#changetype_calexp", function(event) {	
        event.preventDefault();
		event.stopPropagation();
		  var auth = $(this).data("auth");
		  var ppttype = $(this).val();
		  
          $.ajax({
              type: "post",
			  dataType: "json",
              url: relpath+"controller/controller.php",
              data: {
				  linkExportCal: auth,
				  ppttype: ppttype ? ppttype : null
              },
              beforeSend: function () {
				showThinker(".panel_calexplinks");
              },
			  error: function() {hideThinker(".panel_calexplinks");},
              success: function (json) {
                      $("#panel_calexp").fadeIn("slow", function () {
                          $(this).html(json.content);
                      });
					  hideThinker(".panel_calexplinks");
              }
          });
          return false;
      });	  
//--------------------------------------------------
$(document).on("change", ".panel_calfeedlinks select#changetype_calfeed", function(event) {	
        event.preventDefault();
		event.stopPropagation();
		  var auth = $(this).data("auth");
		  var ppttype = $(this).val();
		  var output = $("select#changeout_calfeed").val();
		  var month = $("select#changemon_calfeed").val();
		  var year = $("select#changeyear_calfeed").val();	  
		  
          $.ajax({
              type: "post",
			  dataType: "json",
              url: relpath+"controller/controller.php",
              data: {
				  linkFeedCal: auth,
				  ppttype: ppttype ? ppttype : null,
				  output: output ? output : null,
				  month: month ? month : null,
				  year: year ? year : null
              },
              beforeSend: function () {
				showThinker(".panel_calfeedlinks");
              },
			  error: function() {hideThinker(".panel_calfeedlinks");},
              success: function (json) {
                      $("#panel_calfeed").fadeIn("slow", function () {
                          $(this).html(json.content);
                      });
					  hideThinker(".panel_calfeedlinks");
              }
          });
          return false;
      });	  
//--------------------------------------------------
$(document).on("change", ".panel_calfeedlinks select#changeout_calfeed", function(event) {	
        event.preventDefault();
		event.stopPropagation();
		  var auth = $(this).data("auth");
		  var ppttype = $("select#changetype_calfeed").val();
		  var output = $(this).val();
		  var month = $("select#changemon_calfeed").val();
		  var year = $("select#changeyear_calfeed").val(); 
		  
          $.ajax({
              type: "post",
			  dataType: "json",
              url: relpath+"controller/controller.php",
              data: {
				  linkFeedCal: auth,
				  ppttype: ppttype ? ppttype : null,
				  output: output ? output : null,
				  month: month ? month : null,
				  year: year ? year : null
              },
              beforeSend: function () {
				showThinker(".panel_calfeedlinks");
              },
			  error: function() {hideThinker(".panel_calfeedlinks");},
              success: function (json) {
                      $("#panel_calfeed").fadeIn("slow", function () {
                          $(this).html(json.content);
                      });
					  hideThinker(".panel_calfeedlinks");
              }
          });
          return false;
      });	  
//--------------------------------------------------
$(document).on("change", ".panel_calfeedlinks select#changemon_calfeed", function(event) {	
        event.preventDefault();
		event.stopPropagation();
		  var auth = $(this).data("auth");
		  var output = $("select#changeout_calfeed").val();
		  var ppttype = $("select#changetype_calfeed").val();
		  var month = $(this).val();
		  var year = $("select#changeyear_calfeed").val();		  
		  
          $.ajax({
              type: "post",
			  dataType: "json",
              url: relpath+"controller/controller.php",
              data: {
				  linkFeedCal: auth,
				  ppttype: ppttype ? ppttype : null,
				  output: output ? output : null,
				  month: month ? month : null,
				  year: year ? year : null
              },
              beforeSend: function () {
				showThinker(".panel_calfeedlinks");
              },
			  error: function() {hideThinker(".panel_calfeedlinks");},
              success: function (json) {
                      $("#panel_calfeed").fadeIn("slow", function () {
                          $(this).html(json.content);
                      });
					  hideThinker(".panel_calfeedlinks");
              }
          });
          return false;
      });	  
//--------------------------------------------------
$(document).on("change", ".panel_calfeedlinks select#changeyear_calfeed", function(event) {	
        event.preventDefault();
		event.stopPropagation();
		  var auth = $(this).data("auth");
		  var output = $("select#changeout_calfeed").val();
		  var ppttype = $("select#changetype_calfeed").val();
		  var month = $("select#changemon_calfeed").val();
		  var year = $(this).val();		  
		  
          $.ajax({
              type: "post",
			  dataType: "json",
              url: relpath+"controller/controller.php",
              data: {
				  linkFeedCal: auth,
				  ppttype: ppttype ? ppttype : null,
				  output: output ? output : null,
				  month: month ? month : null,
				  year: year ? year : null
              },
              beforeSend: function () {
				showThinker(".panel_calfeedlinks");
              },
			  error: function() {hideThinker(".panel_calfeedlinks");},
              success: function (json) {
                      $("#panel_calfeed").fadeIn("slow", function () {
                          $(this).html(json.content);
                      });
					  hideThinker(".panel_calfeedlinks");
              }
          });
          return false;
      });	  
//--------------------------------------------------








//--------------------------------------------------
$(document).on("change", ".panel_publiclinks select#changetype_publiclinks", function(event) {	
        event.preventDefault();
		event.stopPropagation();
		  var auth = $(this).data("auth");
		  var ppttype = $(this).val();
		  var calnum = $("select#changeout_publiclinks").val();
		  var month = $("select#changemon_publiclinks").val();
		  var year = $("select#changeyear_publiclinks").val();	  
		  
          $.ajax({
              type: "post",
			  dataType: "json",
              url: relpath+"controller/controller.php",
              data: {
				  linkPublicCal: auth,
				  ppttype: ppttype ? ppttype : null,
				  calnum: calnum ? calnum : null,
				  month: month ? month : null,
				  year: year ? year : null
              },
              beforeSend: function () {
				showThinker(".panel_publiclinks");
              },
			  error: function() {hideThinker(".panel_publiclinks");},
              success: function (json) {
                      $("#panel_publiclinks").fadeIn("slow", function () {
                          $(this).html(json.content);
                      });
					  hideThinker(".panel_publiclinks");
              }
          });
          return false;
      });	  
//--------------------------------------------------
$(document).on("change", ".panel_publiclinks select#changeout_publiclinks", function(event) {	
        event.preventDefault();
		event.stopPropagation();
		  var auth = $(this).data("auth");
		  var ppttype = $("select#changetype_publiclinks").val();
		  var calnum = $(this).val();
		  var month = $("select#changemon_publiclinks").val();
		  var year = $("select#changeyear_publiclinks").val(); 
		  
          $.ajax({
              type: "post",
			  dataType: "json",
              url: relpath+"controller/controller.php",
              data: {
				  linkPublicCal: auth,
				  ppttype: ppttype ? ppttype : null,
				  calnum: calnum ? calnum : null,
				  month: month ? month : null,
				  year: year ? year : null
              },
              beforeSend: function () {
				showThinker(".panel_publiclinks");
              },
			  error: function() {hideThinker(".panel_publiclinks");},
              success: function (json) {
                      $("#panel_publiclinks").fadeIn("slow", function () {
                          $(this).html(json.content);
                      });
					  hideThinker(".panel_publiclinks");
              }
          });
          return false;
      });	  
//--------------------------------------------------
$(document).on("change", ".panel_publiclinks select#changemon_publiclinks", function(event) {	
        event.preventDefault();
		event.stopPropagation();
		  var auth = $(this).data("auth");
		  var calnum = $("select#changeout_publiclinks").val();
		  var ppttype = $("select#changetype_publiclinks").val();
		  var month = $(this).val();
		  var year = $("select#changeyear_publiclinks").val();		  
		  
          $.ajax({
              type: "post",
			  dataType: "json",
              url: relpath+"controller/controller.php",
              data: {
				  linkPublicCal: auth,
				  ppttype: ppttype ? ppttype : null,
				  calnum: calnum ? calnum : null,
				  month: month ? month : null,
				  year: year ? year : null
              },
              beforeSend: function () {
				showThinker(".panel_publiclinks");
              },
			  error: function() {hideThinker(".panel_publiclinks");},
              success: function (json) {
                      $("#panel_publiclinks").fadeIn("slow", function () {
                          $(this).html(json.content);
                      });
					  hideThinker(".panel_publiclinks");
              }
          });
          return false;
      });	  
//--------------------------------------------------
$(document).on("change", ".panel_publiclinks select#changeyear_publiclinks", function(event) {	
        event.preventDefault();
		event.stopPropagation();
		  var auth = $(this).data("auth");
		  var calnum = $("select#changeout_publiclinks").val();
		  var ppttype = $("select#changetype_publiclinks").val();
		  var month = $("select#changemon_publiclinks").val();
		  var year = $(this).val();		  
		  
          $.ajax({
              type: "post",
			  dataType: "json",
              url: relpath+"controller/controller.php",
              data: {
				  linkPublicCal: auth,
				  ppttype: ppttype ? ppttype : null,
				  calnum: calnum ? calnum : null,
				  month: month ? month : null,
				  year: year ? year : null
              },
              beforeSend: function () {
				showThinker(".panel_publiclinks");
              },
			  error: function() {hideThinker(".panel_publiclinks");},
              success: function (json) {
                      $("#panel_publiclinks").fadeIn("slow", function () {
                          $(this).html(json.content);
                      });
					  hideThinker(".panel_publiclinks");
              }
          });
          return false;
      });	  
//--------------------------------------------------








}); //$(document).ready