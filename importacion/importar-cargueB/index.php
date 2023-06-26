<?php
include('dbconect.php');
require_once('vendor/php-excel-reader/excel_reader2.php');
require_once('vendor/SpreadsheetReader.php');

if (isset($_POST["import"]))
{
    echo 'entra';
   
$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["file"]["type"],$allowedFileType)){  

        $targetPath = 'subidas/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        
       
        //// declaración de variable
        
        
        /// end
        
        
        for($i=0;$i<$sheetCount;$i++)
        {
        
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
                if($Row[3]=='Impacto'){ continue;} //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila. 
                
                $campo1 = "";
                if(isset($Row[0])){
                    $campo1 = mysqli_real_escape_string($con,$Row[0]); 
                }
                $campo2 = "";
                if(isset($Row[1])){
                    $campo2 = mysqli_real_escape_string($con,$Row[1]); 
                }
                $campo3 = "";
                if(isset($Row[2])){
                    $campo3 = mysqli_real_escape_string($con,$Row[2]); 
                }
                $campo4 = "";
                if(isset($Row[3])){
                    $campo4 = mysqli_real_escape_string($con,$Row[3]); 
                }
                $campo5 = "";
                if(isset($Row[4])){
                    $campo5 = mysqli_real_escape_string($con,$Row[4]); 
                }
                
                $campo6 = "";
                if(isset($Row[5])){
                    $campo6 = mysqli_real_escape_string($con,$Row[5]); 
                }
                $campo7 = "";
                if(isset($Row[6])){
                    $campo7 = mysqli_real_escape_string($con,$Row[6]); 
                }
                $campo8 = "";
                if(isset($Row[7])){
                    $campo8 = mysqli_real_escape_string($con,$Row[7]); 
                }
                $campo9 = "";
                if(isset($Row[8])){
                    $campo9 = mysqli_real_escape_string($con,$Row[8]); 
                }
                $campo10 = "";
                if(isset($Row[9])){
                    $campo10 = mysqli_real_escape_string($con,$Row[9]); 
                }
                
                $campo11 = "";
                if(isset($Row[10])){
                    $campo11 = mysqli_real_escape_string($con,$Row[10]); 
                }
                $campo12 = "";
                if(isset($Row[11])){
                    $campo12 = mysqli_real_escape_string($con,$Row[11]); 
                }
                $campo13 = "";
                if(isset($Row[12])){
                    $campo13 = mysqli_real_escape_string($con,$Row[12]); 
                }
                $campo14 = "";
                if(isset($Row[13])){
                    $campo14 = mysqli_real_escape_string($con,$Row[13]); 
                }
                $campo15 = "";
                if(isset($Row[14])){
                    $campo15 = mysqli_real_escape_string($con,$Row[14]); 
                }
                
                $campo16 = "";
                if(isset($Row[15])){
                    $campo16 = mysqli_real_escape_string($con,$Row[15]); 
                }
                $campo17 = "";
                if(isset($Row[16])){
                    $campo17 = mysqli_real_escape_string($con,$Row[16]); 
                }
                $campo18 = "";
                if(isset($Row[17])){
                    $campo18 = mysqli_real_escape_string($con,$Row[17]); 
                }
                $campo19 = "";
                if(isset($Row[18])){
                    $campo19 = mysqli_real_escape_string($con,$Row[18]); 
                }
                $campo20 = "";
                if(isset($Row[19])){
                    $campo20 = mysqli_real_escape_string($con,$Row[19]); 
                }
                
                $campo21 = "";
                if(isset($Row[20])){
                    $campo21 = mysqli_real_escape_string($con,$Row[20]); 
                }
                $campo22 = "";
                if(isset($Row[21])){
                    $campo22 = mysqli_real_escape_string($con,$Row[21]); 
                }
                $campo23 = "";
                if(isset($Row[22])){
                    $campo23 = mysqli_real_escape_string($con,$Row[22]); 
                }
                $campo24 = "";
                if(isset($Row[23])){
                    $campo24 = mysqli_real_escape_string($con,$Row[23]); 
                }
                $campo25 = "";
                if(isset($Row[24])){
                    $campo25 = mysqli_real_escape_string($con,$Row[24]); 
                }
                
                $campo26 = "";
                if(isset($Row[25])){
                    $campo26 = mysqli_real_escape_string($con,$Row[25]); 
                }
                
                $campo27 = "";
                if(isset($Row[26])){
                    $campo27 = mysqli_real_escape_string($con,$Row[26]); 
                }
            }    
        }
      
        
        
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
                
                if($Row[3]=='Impacto'){ continue;  } //Aca remplazo por el nombre y posicion de la ultima columna de excel para que no me agrege la primera fila. 
          
                $campo1 = "";
                if(isset($Row[0])){
                    $campo1 = mysqli_real_escape_string($con,$Row[0]); 
                }
                $campo2 = "";
                if(isset($Row[1])){
                    $campo2 = mysqli_real_escape_string($con,$Row[1]); 
                }
                $campo3 = "";
                if(isset($Row[2])){
                    $campo3 = mysqli_real_escape_string($con,$Row[2]); 
                }
                $campo4 = "";
                if(isset($Row[3])){
                    $campo4 = mysqli_real_escape_string($con,$Row[3]); 
                }
                $campo5 = "";
                if(isset($Row[4])){
                    $campo5 = mysqli_real_escape_string($con,$Row[4]); 
                }
                
                $campo6 = "";
                if(isset($Row[5])){
                    $campo6 = mysqli_real_escape_string($con,$Row[5]); 
                }
                $campo7 = "";
                if(isset($Row[6])){
                    $campo7 = mysqli_real_escape_string($con,$Row[6]); 
                }
                $campo8 = "";
                if(isset($Row[7])){
                    $campo8 = mysqli_real_escape_string($con,$Row[7]); 
                }
                $campo9 = "";
                if(isset($Row[8])){
                    $campo9 = mysqli_real_escape_string($con,$Row[8]); 
                }
                $campo10 = "";
                if(isset($Row[9])){
                    $campo10 = mysqli_real_escape_string($con,$Row[9]); 
                }
                
                $campo11 = "";
                if(isset($Row[10])){
                    $campo11 = mysqli_real_escape_string($con,$Row[10]); 
                }
                $campo12 = "";
                if(isset($Row[11])){
                    $campo12 = mysqli_real_escape_string($con,$Row[11]); 
                }
                $campo13 = "";
                if(isset($Row[12])){
                    $campo13 = mysqli_real_escape_string($con,$Row[12]); 
                }
                $campo14 = "";
                if(isset($Row[13])){
                    $campo14 = mysqli_real_escape_string($con,$Row[13]); 
                }
                $campo15 = "";
                if(isset($Row[14])){
                    $campo15 = mysqli_real_escape_string($con,$Row[14]); 
                }
                
                $campo16 = "";
                if(isset($Row[15])){
                    $campo16 = mysqli_real_escape_string($con,$Row[15]); 
                }
                $campo17 = "";
                if(isset($Row[16])){
                    $campo17 = mysqli_real_escape_string($con,$Row[16]); 
                }
                $campo18 = "";
                if(isset($Row[17])){
                    $campo18 = mysqli_real_escape_string($con,$Row[17]); 
                }
                $campo19 = "";
                if(isset($Row[18])){
                    $campo19 = mysqli_real_escape_string($con,$Row[18]); 
                }
                $campo20 = "";
                if(isset($Row[19])){
                    $campo20 = mysqli_real_escape_string($con,$Row[19]); 
                }
                
                $campo21 = "";
                if(isset($Row[20])){
                    $campo21 = mysqli_real_escape_string($con,$Row[20]); 
                }
                $campo22 = "";
                if(isset($Row[21])){
                    $campo22 = mysqli_real_escape_string($con,$Row[21]); 
                }
                $campo23 = "";
                if(isset($Row[22])){
                    $campo23 = mysqli_real_escape_string($con,$Row[22]); 
                }
                $campo24 = "";
                if(isset($Row[23])){
                    $campo24 = mysqli_real_escape_string($con,$Row[23]); 
                }
                $campo25 = "";
                if(isset($Row[24])){
                    $campo25 = mysqli_real_escape_string($con,$Row[24]); 
                }
                
                $campo26 = "";
                if(isset($Row[25])){
                    $campo26 = mysqli_real_escape_string($con,$Row[25]); 
                }
                
                $campo27 = "";
                if(isset($Row[26])){
                    $campo27 = mysqli_real_escape_string($con,$Row[26]); 
                }
                
                
               echo "INSERT INTO carga_masiva(campo1,campo2,campo3,campo4,campo5,campo6,campo7,campo8,campo9,campo10,campo11,campo12,campo13,campo14,campo15,campo16,campo17,campo18,campo19,campo20,campo21,campo22,campo23,campo24,campo25,campo26,campo27) VALUES('$campo1','$campo2','$campo3','$campo4','$campo5','$campo6','$campo7','$campo8','$campo9','$campo10','$campo11','$campo12','$campo13','$campo14','$campo15','$campo16','$campo17','$campo18','$campo19','$campo20','$campo21','$campo22','$campo23','$campo24','$campo25','$campo26','$campo27')";
                
                
                    $con->query("INSERT INTO carga_masiva(campo1,campo2,campo3,campo4,campo5,campo6,campo7,campo8,campo9,campo10,campo11,campo12,campo13,campo14,campo15,campo16,campo17,campo18,campo19,campo20,campo21,campo22,campo23,campo24,campo25,campo26,campo27) VALUES('$campo1','$campo2','$campo3','$campo4','$campo5','$campo6','$campo7','$campo8','$campo9','$campo10','$campo11','$campo12','$campo13','$campo14','$campo15','$campo16','$campo17','$campo18','$campo19','$campo20','$campo21','$campo22','$campo23','$campo24','$campo25','$campo26','$campo27')");
                        
                    echo '<script language="javascript">alert("Cargue Exitoso");window.location.href="../../cargueB"</script>';
                           
                       
                
             }
        
         } 
         
         
         
         if($guiaExistente == FALSE){ // su función es mostrar las remisiones repetidas
            echo '<br><br><center>"Estas guías ya han sido ingresadas anteriormente".</center>';
            echo'<style type="text/css">
                  .boton_personalizado{
                    text-decoration: none;
                    padding: 10px;
                    font-weight: 600;
                    font-size: 20px;
                    color: #ffffff;
                    background-color: #1883ba;
                    border-radius: 6px;
                    border: 2px solid #0016b0;
                  }
                  .boton_personalizado:hover{
                    color: #1883ba;
                    background-color: #ffffff;
                  }
                </style>';
            echo "<br><br><center><button class='boton_personalizado' type=\"button\" onclick=\"window.location.href='../guiaMasiva'\" >Regresar</button></center>";
         }
  }
  else
  { 
      
  }
}
?>