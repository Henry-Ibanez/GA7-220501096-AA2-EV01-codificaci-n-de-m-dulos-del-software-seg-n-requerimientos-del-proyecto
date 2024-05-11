<?php 
include("../../bd.php");

if(isset($_GET['txtID'])){
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

    //borrado de foto
    $sentencia=$conexion->prepare("SELECT * FROM `tbl_menu`WHERE ID=:ID");
    $sentencia->bindParam(":ID",$txtID);
    $sentencia->execute();

    $registro_foto=$sentencia->fetch(PDO::FETCH_LAZY);

    

    if(isset($registro_foto['foto'])){
        if(file_exists("../../../images/menus/".$registro_foto['foto'])){
            unlink("../../../images/menus/".$registro_foto['foto']);
        }

    }


    $sentencia=$conexion->prepare("DELETE FROM `tbl_menu` WHERE ID=:ID");
    $sentencia->bindParam(":ID",$txtID);
    $sentencia->execute();

    header("location:index.php");
}

$sentencia=$conexion->prepare("SELECT * FROM `tbl_menu`");
$sentencia->execute();
$lista_menu=$sentencia->fetchAll(PDO::FETCH_ASSOC);


include ("../../templates/header.php");
?>

<div class="card">
    <div class="card-header">
         <a name=""id=""class="btn btn-primary"href="crear.php"role="button">Agregar menú</a>
        </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Titulo</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($lista_menu as $key=>$value ){?>
                        <tr class="">
                            <td scope="row"><?php echo $value['ID'];?></td>
                            <td>
                                <img src="../../../images/menus/<?php echo $value['foto'];?>" width="50" alt="">
                            </td>
                            <td><?php echo $value['nombre_plato'];?></td>
                            <td><?php echo $value['descripcion'];?></td>
                            <td><?php echo $value['precio'];?></td>
                            <td>
                                <a name="" id="" class="btn btn-info" href="editar.php?txtID=<?php echo $value['ID'];?>" role="button">Editar</a>  
                                <a name="" id="" class="btn btn-danger" href="index.php?txtID=<?php echo $value['ID'];?>" role="button">Eliminar</a>    
                            </td>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
        
    </div>
    <div class="card-footer text-muted"></div>
</div>


<?php include ("../../templates/footer.php");?>