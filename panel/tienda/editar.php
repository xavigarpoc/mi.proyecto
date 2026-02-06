<?php
include '../seguridad.php';
include '../menu.php';
include '../conexion.php';

if(!isset($_GET['id'])){
    header("Location: productos.php");
    exit;
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM productos WHERE id = $id";
$result = $conexion->query($sql);
if($result->num_rows == 0){
    echo "Producto no encontrado";
    exit;
}
$producto = $result->fetch_assoc();

$mensaje = '';

if(isset($_POST['guardar'])){
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $precio = $conexion->real_escape_string($_POST['precio']);
    $descripcion = $conexion->real_escape_string($_POST['descripcion']);

    // Imagen
    $imagen = $producto['imagen'];
    if(isset($_FILES['imagen']) && $_FILES['imagen']['name'] != ''){
        $imgNombre = time() . '_' . $_FILES['imagen']['name'];
        move_uploaded_file($_FILES['imagen']['tmp_name'], '../uploads/' . $imgNombre);
        $imagen = $imgNombre;
    }

    $sqlUpdate = "UPDATE productos SET nombre='$nombre', precio='$precio', descripcion='$descripcion', imagen='$imagen' WHERE id=$id";
    if($conexion->query($sqlUpdate)){
        $mensaje = 'Producto actualizado correctamente.';
    } else {
        $mensaje = 'Error al actualizar producto.';
    }
}
?>

<h2>Editar Producto</h2>

<?php if($mensaje != ''): ?>
    <div class="error"><?php echo $mensaje; ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>" required>
    <input type="number" step="0.01" name="precio" value="<?php echo $producto['precio']; ?>" required>
    <textarea name="descripcion" required><?php echo $producto['descripcion']; ?></textarea>
    <input type="file" name="imagen">
    <?php if($producto['imagen'] != ''): ?>
        <img src="../uploads/<?php echo $producto['imagen']; ?>" alt="" style="max-width:150px; display:block; margin:10px 0;">
    <?php endif; ?>
    <button type="submit" name="guardar">Guardar Cambios</button>
</form>
