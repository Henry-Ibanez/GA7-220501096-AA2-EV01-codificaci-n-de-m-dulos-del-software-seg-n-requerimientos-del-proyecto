<?php 
include("../../bd.php");

if($_POST){

    $nombre_plato=(isset($_POST['nombre_plato']))?$_POST['nombre_plato']:"";
    $descripcion=(isset($_POST['descripcion']))?$_POST['descripcion']:"";
    $precio=(isset($_POST['precio']))?$_POST['precio']:"";
    $txtID= (isset($_POST["txtID"])) ?$_POST["txtID"]:""; 
    

    $sentencia=$conexion-> prepare("UPDATE `tbl_menu` 
            SET 
            nombre_plato=:nombre_plato, 
            descripcion=:descripcion, 
            precio=:precio 
            WHERE ID=:ID");
        
            $sentencia->bindParam(":nombre_plato",$nombre_plato);
            $sentencia->bindParam(":descripcion",$descripcion);
            $sentencia->bindParam(":precio",$precio);
            $sentencia->bindParam(":ID",$txtID);

            $sentencia->execute();

    //proceso de actualizacion de foto
    $foto=(isset($_FILES['foto']["name"]))?$_FILES['foto']["name"]:"";
    $tmp_foto=$_FILES["foto"]["tmp_name"];

    if($tmp_foto!=""){
        
        $fecha_foto= new DateTime();
        $nombre_foto=$fecha_foto->getTimestamp()."_".$_FILES['foto']["name"];
         move_uploaded_file($tmp_foto,"../../../images/menus/".$nombre_foto);

        $sentencia=$conexion->prepare("SELECT * FROM `tbl_menu`WHERE ID=:ID");
        $sentencia->bindParam(":ID",$txtID);
        $sentencia->execute();
    
        $registro_foto=$sentencia->fetch(PDO::FETCH_LAZY);
    
        if(isset($registro_foto['foto'])){
            if(file_exists("../../../images/menus/".$registro_foto['foto'])){
                unlink("../../../images/menus/".$registro_foto['foto']);
            }    
        }

        $sentencia=$conexion-> prepare("UPDATE `tbl_menu` 
            SET 
            foto=:foto
            WHERE ID=:ID");
        
            $sentencia->bindParam(":foto",$nombre_foto);
            $sentencia->bindParam(":ID",$txtID);

            $sentencia->execute();
    }
                 header("Location:index.php"); 
}

if(isset($_GET['txtID'])){
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

    $sentencia=$conexion->prepare("SELECT * FROM `tbl_menu` WHERE ID=:ID");
    $sentencia->bindParam(":ID",$txtID);
    $sentencia->execute();
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);

    //recuperacion de datos(asignar al formulario)
    $nombre_plato=$registro["nombre_plato"];
    $descripcion=$registro["descripcion"];
    $precio=$registro["precio"];
    $foto=$registro["foto"];

}


include ("../../templates/header.php")
?>
<div class="card">
    <div class="card-header">Editar menú</div>
    <div class="card-body">

        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="txtID" class="form-label">ID</label>
                <input type="text"class="form-control" value="<?php echo $txtID;?>"
                name="txtID"id="txtID"aria-describedby="helpId" />
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto:</label><br>
                <img width="50" src="../../../images/menus/<?php echo $foto;?>">
                <input type="file" class="form-control" name="foto" id="foto" placeholder="" aria-describedby="fileHelpId" />
            </div>

            <div class="mb-3">
                <label for="nombre_plato" class="form-label">Nombre del plato</label>
                <input type="text"class="form-control" value="<?php echo $nombre_plato;?>" name="nombre_plato"id="nombre_plato"aria-describedby="helpId"placeholder="Escriba el nombre del plato"/>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text"class="form-control" value="<?php echo $descripcion;?>" name="descripcion"id="descripcion"aria-describedby="helpId"placeholder="Describa el plato"/>
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="text"class="form-control"value="<?php echo $precio;?>"name="precio"id=""aria-describedby="helpId"placeholder="Ponga el precio"/>
            </div>

            <button type="submit" class="btn btn-success">Editar plato</button>
            <a name=""id="" class="btn btn-primary" href="index.php"role="button">Cancelar</a>

        </form>

    </div>

    <div class="card-footer text-muted"></div>
</div>

<?php include ("../../templates/footer.php");?>