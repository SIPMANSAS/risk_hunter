/*!
 *
 */

/*General Style*/


#printSection{
   color: #000;
   margin: 0 auto;
}

#ticket .modal-dialog
{
  width: 380px;
}


#modal-body{
    max-height: calc(100vh - 200px);
    overflow-y: auto;
   font-family: opensans-bold-webfont, Arial, sans-serif;
  font-weight: 700;

}
/*print styling*/

@media print{
   .modal-dialog{
      width: 100% !important;
   }
   .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12{
  float: left;
  font-family: opensans-bold-webfont, Arial, sans-serif;
  font-weight: 700;

}
.col-md-12{
  width: 100%;
}
.col-md-11{
  width: 91.66666666666666%;
}
.col-md-10{
  width: 83.33333333333334%;
}
.col-md-9{
  width: 75%;
}
.col-md-8{
  width: 66.66666666666666%;
}
.col-md-7{
  width: 58.333333333333336%;
}
.col-md-6{
  width: 50%;
}
.col-md-5{
  width: 41.66666666666667%;
}
.col-md-4{
  width: 33.33333333333333%;
 }
 .col-md-3{
   width: 25%;
 }
 .col-md-2{
   width: 16.666666666666664%;
 }
 .col-md-1{
  width: 8.333333333333332%;
 }
  body *{
    visibility:hidden;
  }
  .container-fluid{
     display: none;
 }
  #printSection, #printSection *{
    visibility:visible;
  }
  #printSectionInvoice, #printSectionInvoice *{
    visibility:visible;
  }
  #printSection{
     text-transform:uppercase;
     font-size: 79px !important;
     left: 0;
     top: 0;
     padding: 0;
     margin:0;
  }
  #printSection h4{
     font-size: 82px;
  }
  #printSection tr td{
     font-size: 79px !important;
     margin: 0;
     padding: 0;
 }
 #printSection tr td span{
    font-size: 8px !important;
    color: #aaa !important;
}
 #printSection .bg-success, #printSection .bg-danger{
    visibility:hidden;
}
  @page{
  margin: 0;
  }
  .hiddenpr{
      display: none !important;
  }
  html, body{
  zoom: 100%;
  overflow:hidden !important;
  }
}
