<?php
include '../../Modelos/conexiones.php';
sleep(1);
// error_reporting(0);

if (isset($_POST)) {
	$username = (string)$_POST['username'];
	if ($username == true) {
		$consulta = "";
		$ContibuDatos = Conexiones::conMunicipio()->prepare("SELECT  * FROM [municipio].[dbo].[Usuarios2]
					WHERE
					codusu = $username");

		if ($ContibuDatos->execute()) {
			$RTA = $ContibuDatos->fetchAll();
			if (empty($RTA)) { ?>
				<label class="UsuarioNOexiste">USUARIO NO EXISTE</label>
				<?php } else {
				foreach ($RTA as $key => $value) { ?>
					<label class="text-success"><?php echo $value['nombre'] ?></label>
<?php }
			}
		}
	}
}
