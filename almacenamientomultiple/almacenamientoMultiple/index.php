
<?php 
//include('header.php');?>
<title>Subir archivos arrastrar y soltar con PHP, jQuery</title>
<link rel="stylesheet" type="text/css" href="css/dropzone.css" />
<script type="text/javascript" src="js/dropzone.js"></script>
<style type="text/css">
.file_upload{
	border: 4px dashed #292929;
	}
</style>

<div class="container">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Cargar Archivos</h3>
      </div>
      <div class="panel-body">
        <div class="col-lg-12">
        
        
	<div class="file_upload">
		<form action="file_upload.php" class="dropzone" method="POST">
			<div class="dz-message needsclick">
				<strong>Arrastra archivos a cualquier lugar para subirlos.</strong><br /><br />
				<span class="note needsclick">
                <span class="glyphicon glyphicon-open" aria-hidden="true" style="font-size:60px;"></span>
                </span>
			</div>
		</form>		
	</div>
    	
  </div>	
 </div>	
</div>	
    <!--	
	<div style="margin:10px 0px 0px 0px;">
		<a class="btn btn-default read-more" style="background:#3399ff;color:white" href="../registroProductos" title="">Regresar</a>			
	</div>	
	-->



  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../js/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../js/bootstrap.bundle.min.js"></script>

  
</body>
</html>
<!-- END -->
</body>
</html>


