
<?php
$conexion = mysqli_connect("localhost","root","","sistemausuarios") or DIE("Error de conexion");
echo'<h1>CRUD USUARIOS</h1>';
//comienzo insertar registro
echo '<form action="" method="get"> 
    <input type="text" name="nombre" placeholder="nombre" required>
    <input type="text" name="apellido" placeholder="apellido" required>
    <input type="email" name="email" placeholder="email">
    <input type="submit" name="registrar" value="registrar">
</form>';
if(isset($_REQUEST['registrar'])){
    $nombre = $_REQUEST['nombre'];
    $apellido = $_REQUEST['apellido'];
    $email = $_REQUEST['email'];
    $sql = "INSERT INTO usuarios (nombre, apellido, email) VALUES ('$nombre','$apellido','$email')";
    $insertar = mysqli_query($conexion,$sql)? print("<script>alert('registro agregado'); window.location ='crud.php'</script>") : print("<script>alert('error al registrar')</script>");
}
//fin insertar registro

//comienzo borrar registro
if(isset($_GET['id_borrar'])){
    $id_borrar = $_GET['id_borrar'];
    $borrar = mysqli_query($conexion,"DELETE FROM usuarios WHERE id_usuario = '$id_borrar'")? print("<script>alert('registro borrado'); window.location ='crud.php'</script>") : print("<script>alert('error al borrar')</script>");
}
//fin borrar registro

//comienzo modificar registro
if(isset($_GET['id_editar'])){
    echo '<h2>Editar Registro</h2>';
    $id = $_GET['id_editar'];

    $sql = "SELECT * FROM usuarios WHERE id_usuario='$id'";
    $consulta = mysqli_query($conexion,$sql);
    if(mysqli_num_rows($consulta)>0){
        $registro = mysqli_fetch_assoc($consulta);
        echo '<form action="" method="post"> 
            <input type="text" name="nombre" value = '.$registro['nombre'].'   required>
            <input type="text" name="apellido" value =  '.$registro['apellido'].' required>
            <input type="email" name="email" value ='.$registro['email'].'>
            <input type="submit" name="actualizar" value="Modificar">
            </form>';
    }
}
if(isset($_POST['actualizar'])){
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $sql = "UPDATE usuarios SET nombre = '$nombre', apellido = '$apellido', email = '$email' WHERE id_usuario ='$id'";
    $actualizar = mysqli_query($conexion,$sql)? print("<script>alert('registro actualizado'); window.location ='crud.php'</script>") : print("<script>alert('error al editar')</script>");
}

//comienzo tabla usuarios
echo '<h2>tabla usuarios</h2>';
$sql= "SELECT * FROM usuarios";
$select = mysqli_query($conexion, $sql);
if(mysqli_num_rows($select)>0){
    echo'<table border="1">
    <tr>
      <th>ID</th>
      <th>NOMBRE</th>
      <th>APELLIDO</th>
      <th>EMAIL</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>    
    </tr>';
    while($registro = mysqli_fetch_assoc($select)){
        echo '<tr>
            <td>'.$registro['id_usuario'].'</td>
            <td>'.$registro['nombre'].'</td>
            <td>'.$registro['apellido'].'</td>
            <td>'.$registro['email'].'</td>
            <td><a href="crud.php?id_editar='.$registro['id_usuario'].'" ">editar</a></td>
            <td><a href="crud.php?id_borrar='.$registro['id_usuario'].'" onclick="return confirm(\'Realmente desea borrar\')">borrar</a></td>
        </tr>';
    }
    echo '</table>';
}else{
    echo 'tabla vacia, no hay registros';
}
//fin tabla usuarios
?>
