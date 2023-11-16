<!DOCTYPE html>
<!-------------------------------------------------------------------------------
	Desenvolvimento Web
	PUCPR
	Profa. Cristina V. P. B. Souza
	Agosto/2022
---------------------------------------------------------------------------------->
<!-- medExcluir.php -->

<html>

<head>

	<title>Psychoduck</title>
	<link rel="icon" type="image/png" href="imagens/favicon.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="css/customize.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>

<body onload="w3_show_nav('menuMedico')">
	<!-- Inclui MENU.PHP  -->
	<?php require 'geral/menu.php'; ?>
	<?php require 'bd/conectaBD.php'; ?>

	<!-- Conteúdo Principal: deslocado para direita em 270 pixels quando a sidebar é visível -->
	<div class="w3-main w3-container">
		<section class='form-container'>

			<?php
			// Cria conexão
			$conn = mysqli_connect($servername, $username, $password, $database);

			// ID do registro a ser excluído
			$matricula = $_POST['Id'];

			// Verifica conexão
			if (!$conn) {
				die("Connection failed: " . mysqli_connect_error());
			}

			// Faz DELETE na Base de Dados
			$sql = "DELETE FROM Aluno WHERE FK_USUARIO_ID = $matricula";

			echo "<div class='w3-responsive w3-card-4'>"; ?>
			<div class="w3-container w3-purple">
				<h2>Exclusão de Aluno</h2>
			</div>
			<?php
			if ($result = mysqli_query($conn, $sql)) {
				$sqlu = "DELETE FROM USUARIO WHERE ID = $matricula";
				$conn->query($sqlu);
				echo "<p>&nbsp;Registro excluído com sucesso! </p>";
			} else {
				echo "<p>&nbsp;Erro executando DELETE: " . mysqli_error($conn . "</p>");
			}
			echo "</div>";
			mysqli_close($conn);  //Encerra conexao com o BD
			
			?>

		</section>

		<div class='form-card'>
			<input type="button" value="Voltar" class="w3-btn w3-red"
				onclick="window.location.href='alunoListar.php'">
			</tr>
		</div>
		<!-- FIM PRINCIPAL -->
	</div>
	<!-- Inclui RODAPE.PHP  -->
	<?php require 'geral/rodape.php'; ?>

</body>

</html>