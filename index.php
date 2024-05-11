<?php 
include("admin/bd.php");

$sentencia=$conexion->prepare("SELECT * FROM tbl_banners ORDER BY ID DESC LIMIT 1");
$sentencia->execute();

$lista_banners=$sentencia->fetchAll(PDO::FETCH_ASSOC);

$sentencia=$conexion->prepare("SELECT * FROM tbl_colaboradores ORDER BY ID DESC");
$sentencia->execute();

$lista_colaboradores=$sentencia->fetchAll(PDO::FETCH_ASSOC);

$sentencia=$conexion->prepare("SELECT * FROM tbl_testimonios ORDER BY ID DESC LIMIT 4");
$sentencia->execute();

$lista_testimonios=$sentencia->fetchAll(PDO::FETCH_ASSOC);

$sentencia=$conexion->prepare("SELECT * FROM tbl_menu ORDER BY ID DESC LIMIT 8");
$sentencia->execute();

$lista_menu=$sentencia->fetchAll(PDO::FETCH_ASSOC);


if($_POST){

    $nombre=filter_var($_POST["nombre"],FILTER_SANITIZE_STRING);
    $correo=filter_var($_POST["correo"],FILTER_VALIDATE_EMAIL);
    $mensaje=filter_var($_POST["mensaje"],FILTER_SANITIZE_STRING);
    if($nombre && $correo && $mensaje) {
        
        $sql="INSERT INTO tbl_comentarios (nombre,correo,mensaje) VALUES (:nombre, :correo , :mensajes)";
        
        $sentencia=$conexion->prepare($sql);
        $sentencia->bindParam(":nombre",$nombre, PDO::PARAM_STR);
        $sentencia->bindParam(":correo",$correo, PDO::PARAM_STR);
        $sentencia->bindParam(":mensajes",$mensaje, PDO::PARAM_STR);
        $sentencia->execute();
    }
    header("location:index.php");
}

?>

<!doctype html>
<html lang="en">
    <head>
        <title>Restaurante de la abuela</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"/>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    </head>

    <body>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <!-- Sección de menú de navegación-->
        <div class="container">

            <a id="inicio" class="navbar-brand" href="admin/login.php"> <i class="fas fa-utensils"></i> Restaurante de la abuela</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarnav"
            aria-controls="navbarnav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarnav">
            
            <ul class="nav navbar-nav ml-auto">

                <li class="nav-item">
                    <a class="nav-link" href="#Menú">Menú del día</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#Chefs">Chefs</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#Testimonios">Testimonio</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#contacto">Contacto</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#horario">Horarios</a>
                </li>
            </ul>
            </div>
        </div>
        </nav>

        <!-- Sección de Banner-->
        <section class="container-fluid p-0">
            <div class= "banner-img"   style="position:relative; background:url('images/logo/logorestaurante.png') center/cover no-repeat; height:400px;">
                <div class="banner-text" style="position:absolute; top:50%; left:50%; transform:translate (-50%,-50%); transform:translate(-50%,-50%); text-align:center; color:White;">
             
                    <?php foreach($lista_banners as $banner){?>

                        <h1><?php echo $banner['titulo'];?></h1>
                        <h3><?php echo $banner['descripcion'];?></h3>
                        <a href="<?php echo $banner['link'];?>" class="btn btn-primary">Ver menu</a>
                        
                    <?php }?>
                </div>
            </div>
        </section>

        <section id="id" class= "container mt-4 text-center">
            <div class="jumbotron bg-dark text-white">
                </br>
                    <h2> ¡Bienvenid@ al Restaurante de la abuela!</h2>
                    <p>Dejanos sorprenderte con las delicias de la abuela.</p>   
                </br>
            </div>
        </section>

        <!-- Sección de Chef-->
        <section id= "Chefs" class="container mt-4 text-center">
            <h2 >Nuestros chefs</h2>
            <div class="row"> 
               
                <?php foreach($lista_colaboradores as $coloborador){?> 
                    <div class="col-md-4">
                        <div class="card">
                            <img src="images/colaboradores/<?php echo $coloborador['foto']?>" class="card-img-top" alt="chef 1"/>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $coloborador['nombre']?></h5>
                                <p class="card-text"><?php echo $coloborador['descripcion']?></p>
                                <div class="social-icons mt-3">
                                    <a href=<?php echo $coloborador['linkfacebook']?> class="fab fa-facebook-f"></i></a>
                                    <a href=<?php echo $coloborador['linkinstagram']?> class="fab fa-instagram"></i></a>
                                    <a href=<?php echo $coloborador['linklinkedin']?> class= "fab fa-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
        </section>

        <!-- Sección de Testimonios -->
        <section id="Testimonios" class="bg-light py-5">
            <div class="container">
                <h2 class="text-center mb-4">Testimonios</h2>
                <div class="row">
                    <?php foreach($lista_testimonios as $testimonios){?>

                        <div class="col-md-6 d-flex">
                            <div class="card mb-4 w-100">
                                <div class="card-body">
                                    <div class="card-footer text-muted"><?php echo $testimonios['nombre']?> </div>
                                    <p class="card-text"><?php echo $testimonios['opinion']?></p>
                                </div>
                            </div> 
                        </div>
                    <?php }?>
                </div>
            </div>
        </section>

        <!-- Sección de Menú de comida -->
        <section id= "Menú" class="container mt-4">
            <h2 class="text-center">Menú</h2>
            <div class="row row-cols-1 row-cols-md-4 g-4">
                
                <?php foreach($lista_menu as $menu){?>
                    <div class="col d-flex">
                        <div class="card">
                            <img src="images/menus/<?php echo $menu['foto']?>" class="card-img-top" alt="Bandeja Paisa">
                            <div class="card-body">
                                <h5 class="card-title text-center"><?php echo $menu['nombre_plato']?></h5>
                                <p class="card-text small"><strong>Ingredientes:</strong><?php echo $menu['descripcion']?>.</p>
                                <p class="card-text text-center"> <strong>Precio:</strong> <?php echo $menu['precio']?></p>
                            </div>
                        </div>
                    </div>
                 <?php }?>
            </div>
        </section>

        <!-- Sección de Contacto-->
        <section id="contacto" class="container mt-4">

            <h2 class="text-center">Contacto</h2>
            <p>Estamos aqui para servirle,</p>

            <form action="?" method="post">

                <div class="mb-3">

                    <label for="name">Nombre</label><br/>
                    <input type="text" class="form-control" name="nombre" placeholder="Escriba su nombre aqui..." require><br/>
                </div>

                <div class="mb-3">

                    <label for="email">correo electronico</label><br/>
                    <input type="email" class="form-control" name="correo"  placeholder="Escriba su correo electronico aqui..." require><br/>
                
                </div>

                <div class="mb-3">
                    <label for="message">Mensaje</label><br/>
                    <textarea class="form-control" name="mensaje" rows="6" cols="50"></textarea><br/>
            
                </div>

                <input class="btn btn-primary"type="submit" value="Enviar mensaje">
            </form>
        </section>

    

        <!-- Sección de horarios-->   
        <section id="horarios" class="container mt-4">
            <div id="horario" class="text-center bg-light p-4">
                <h3 class="mb-4">Horario de atención</h3>
                    <div>
                        <p><strong>Lunes a Viernes:</strong></p>
                        <p><strong> 10:00 - 20:00</strong></p>
                    </div>

                    <div>
                        <p><strong>Sábado y Domingo:</strong></p>
                        <p><strong>09:00 - 16:00</strong></p>
                    </div>
            </div>
        </section>   


            

            <footer class="bg-dark text-light text-center py-3">
                <!-- place footer here -->
                <p>Copyright &copy; 2024 Restaurante de la abuela,todos los derechos reservados.</p>
            </footer>


            <!-- Bootstrap JavaScript Libraries -->
            <script
                src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
                integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
                crossorigin="anonymous"
            ></script>

            <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
         ></script>
   
   
    
    </body>
</html>
