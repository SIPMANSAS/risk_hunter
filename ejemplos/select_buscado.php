<head>
  <title>SELECT</title>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
</head>
<body>
 
<div style="width:520px;margin:0px auto;margin-top:30px;height:500px;">
  <select class="categoryName form-control" style="width:500px" name="categoryName"></select>
</div>
<script type="text/javascript">
      $('.categoryName').select2({
        placeholder: 'Selecciona un valor....',
        ajax: {
          url: 'ajax.php',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
      });
</script>
</body>
</html>

