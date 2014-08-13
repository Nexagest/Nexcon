<?php
error_reporting(0);
$ext = explode('.', $_FILES['form_file']['name']);
$ext = $ext[count($ext) - 1];
$tmp_file = $_FILES["form_file"]["tmp_name"];
$file_name = "../../template/fid_" . $_POST["form_id"] . ".$ext";
move_uploaded_file($tmp_file, $file_name);
echo "<script>
alert('Formulario creado correctamente');
window.location.href = '../';
</script>";
?>