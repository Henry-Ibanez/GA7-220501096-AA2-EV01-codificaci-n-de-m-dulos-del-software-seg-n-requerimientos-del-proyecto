<?php 
    include("../../bd.php");

    if(isset($_GET['txtID'])){
        $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

        $sentencia=$conexion->prepare("SELECT * FROM `tbl_banners` WHERE ID=:ID");
        $sentencia->bindParam(":ID",$txtID);
        $sentencia->execute();

        $registro=$sentencia->fetch(PDO::FETCH_LAZY);
        $titulo=$registro['titulo'];
        $descripcion=$registro['descripcion'];
        $link=$registro['link'];
    }

        if($_POST){

            $titulo= (isset($_POST["titulo"]))?$_POST["titulo"]:"";
            $descripcion= (isset($_POST["descripcion"])) ?$_POST["descripcion"]:"";
            $link= (isset($_POST["link"])) ?$_POST["link"]:"";
            $txtID= (isset($_POST["txtID"])) ?$_POST["txtID"]:"";
            
            $sentencia=$conexion-> prepare("UPDATE `tbl_banners` 
            SET titulo=:titulo, descripcion=:descripcion, link=:link 
            WHERE ID=:ID");
        
            $sentencia->bindparam(":titulo",$titulo);
            $sentencia->bindparam(":descripcion",$descripcion);
            $sentencia->bindparam(":link",$link);
            $sentencia->bindparam(":ID",$txtID);

            $sentencia->execute();
        
            header("Location:index.php");
        }


    
    include ("../../templates/header.php");

?>
<div class="card">
    <div class="card-header">Banners</div>
    <div class="card-body">
        <form action="" method="post">

            <div class="mb-3">
                <label for="txtID" class="form-label">ID</label>
                <input type="text"class="form-control" value="<?php echo $txtID;?>"
                name="txtID"id="txtID"aria-describedby="helpId" />
            </div>

            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text"class="form-control" value="<?php echo $titulo;?>"
                name="titulo"id="titulo"aria-describedby="helpId" placeholder="Escriba el título del banner" />
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text"class="form-control" value="<?php echo $descripcion;?>"
                name="descripcion"id="descripcion"aria-describedby="helpId" placeholder="Escriba la descripción del banner" />
            </div>

            <div class="mb-3">
                <label for="link" class="form-label">Enlace</label>
                <input type="text"class="form-control" value="<?php echo $link;?>"
                name="link"id="link"aria-describedby="helpId" placeholder="Escriba el enlace del banner" />
            </div>

           <button type="submit" class="btn btn-success">Modificar</button>
           <a name=""id="" class="btn btn-primary" href="index.php"role="button">Cancelar</a>
        
        </form>

        
        

    </div>

    <div class="card-footer text-muted"></div>
</div>
<?php include ("../../templates/footer.php");?>
