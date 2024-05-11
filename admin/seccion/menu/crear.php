<?php 
include("../../bd.php");

if($_POST){

    $nombre_plato=(isset($_POST['nombre_plato']))?$_POST['nombre_plato']:"";
    $descripcion=(isset($_POST['descripcion']))?$_POST['descripcion']:"";
    $precio=(isset($_POST['precio']))?$_POST['precio']:""; 
   
    
   

    $sentencia=$conexion->prepare("INSERT INTO `tbl_menu`
     (`ID`, `foto`, `nombre_plato`, `descripcion`, `precio`) 
    VALUES (NULL, :foto, :nombre_plato, :descripcion,:precio);");

     $foto=(isset($_FILES['foto']["name"]))?$_FILES['foto']["name"]:"";

     $fecha_foto= new DateTime();
     $nombre_foto=$fecha_foto->getTimestamp()."_".$_FILES['foto']["name"];
     $tmp_foto=$_FILES["foto"]["tmp_name"];

     if($tmp_foto){

        move_uploaded_file($tmp_foto,"../../../images/menus/".$nombre_foto);
     }
     
     $sentencia->bindParam(":foto",$nombre_foto);
     $sentencia->bindParam(":nombre_plato",$nombre_plato);
     $sentencia->bindParam(":descripcion",$descripcion);
     $sentencia->bindParam(":precio",$precio);
     


     $sentencia->execute();
     header("Location:index.php");
}




include ("../../templates/header.php");
?>

<div class="card">
    <div class="card-header">Agregar menú</div>
    <div class="card-body">

        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" name="foto" id="foto" placeholder="" aria-describedby="fileHelpId" />
            </div>

            <div class="mb-3">
                <label for="nombre_plato" class="form-label">Nombre del plato</label>
                <input type="text"class="form-control"name="nombre_plato"id="nombre_plato"aria-describedby="helpId"placeholder="Escriba el nombre del plato"/>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text"class="form-control"name="descripcion"id="descripcion"aria-describedby="helpId"placeholder="Describa el plato"/>
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="text"class="form-control"name="precio"id=""aria-describedby="helpId"placeholder="Ponga el precio"/>
            </div>

            <button type="submit" class="btn btn-success">Agregar plato</button>
            <a name=""id="" class="btn btn-primary" href="index.php"role="button">Cancelar</a>

        </form>


    </div>
    <div class="card-footer text-muted"></div>
</div>


<?php include ("../../templates/footer.php");?>