<?php
include '../seguridad.php';
include '../menu.php';
include '../conexion.php';

$mensaje = '';

if(isset($_POST['guardar'])){
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $precio = $conexion->real_escape_string($_POST['precio']);
    $descripcion = $conexion->real_escape_string($_POST['descripcion']);
    
    $imagen = '';
    if(isset($_FILES['imagen']) && $_FILES['imagen']['name'] != ''){
        $imgNombre = time() . '_' . $_FILES['imagen']['name'];
        move_uploaded_file($_FILES['imagen']['tmp_name'], '../uploads/' . $imgNombre);
        $imagen = $imgNombre;
    }

    $sql = "INSERT INTO productos (nombre, precio, descripcion, imagen) VALUES ('$nombre', '$precio', '$descripcion', '$imagen')";
    if($conexion->query($sql)){
        $mensaje = 'Producto creado correctamente.';
    } else {
        $mensaje = 'Error al crear producto.';
    }
}
?>

<h2>Crear Producto</h2>

<?php if($mensaje != ''): ?>
    <div class="error"><?php echo $mensaje; ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="nombre" placeholder="Nombre del producto" required>
    <input type="number" step="0.01" name="precio" placeholder="Precio" required>
    <textarea name="descripcion" placeholder="Descripción" required></textarea>
    <input type="file" name="imagen">
    <button type="submit" name="guardar">Guardar Producto</button>
</form>
