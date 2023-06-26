<header> 
    <div class="logo">
    <a href="menu.php"><img src="img/logo_ies.fw.png" alt=""></a>
    </div>
     <div id="btn_admin" class="" onclick="vermenu()" > <span> Administrador</span> </div>
     <div class="usuario">
        <a href=""><i class="fa-solid fa-user"></i></a>
    </div>
      
  
    <nav class="m_admin ">
         <div id="m_ad"  class="ver" >
            <div><a href="region2.php"><i class="fa-solid fa-flag"></i>&nbsp; administrar regiones</a></div>
            <div><a href="dominios.php"><i class="fa-solid fa-spinner"></i>&nbsp;administrar dominios</a></div>
            <div><a href="listausuariosrh.php"><i class="fa-solid fa-user"></i>&nbsp;administrar usuarios</a></div>
            <div><a href="listaroles.php"><i class="fa-solid fa-user-lock"></i>&nbsp;administrar roles</a></div>
            <div><a href="firmasInspetoras/pages/listarFirmas.php">&nbsp;firmas</a></div>
            <div><a href="recordar.php"><i class="fa-solid fa-key"></i>&nbsp;cambiar contraseña</a></div>  
        </div>
    </nav>
  
    <script>
        function vermenu(){
            document.getElementById('m_ad').classList.toggle('ver');
        } 
    </script>    
  
</header>