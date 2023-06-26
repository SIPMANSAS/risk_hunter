<html>
  <head>
    <title>Ajax Search Box using PHP and MySQL</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js">        </script>
     <script src="typeahead.min.js"></script>
    </head>
    <body>
     <input type="text" name="typeahead">
    </body>
    </html>
    
    
     <script>
    $(document).ready(function(){
    $('input.typeahead').typeahead({
        name: 'typeahead',
        remote:'buscador.php?key=%QUERY',
        limit : 10
    });
});
    script>
    
    
    <?php
    
    $key=$_GET['key'];
    $array = array();
    $con=mysqli_connect("localhost","risk_hunter","Kaliman01*","sipman_risk_hunter");
    $query=mysqli_query($con, "select * from ter_terceros where nombres LIKE '%{$key}%'");
    while($row=mysqli_fetch_assoc($query))
    {
      $array[] = $row['nombres'];
    }
    echo json_encode($array);
    mysqli_close($con);
    ?>