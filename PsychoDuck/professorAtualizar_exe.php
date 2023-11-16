<!DOCTYPE html>
<!-------------------------------------------------------------------------------
	Desenvolvimento Web
	PUCPR
	Profa. Cristina V. P. B. Souza
	Agosto/2022
---------------------------------------------------------------------------------->
<!-- medAtualizar.php -->

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
			<div class="response-box box ">
				<!-- Acesso em:-->

				<div class="w3-container w3-purple">
					<h2>Atualização de Professor</h2>
				</div>
				<!-- Acesso ao BD-->
				<?php
				// Recebe os dados que foram preenchidos no formulário, com os valores que serão atualizados
				// identifica o registro a ser alterado
				$id = $_POST['ID'];
				$nome = $_POST['Nome'];
				$CPF = $_POST['CPF'];
				$Email = $_POST['Email'];
				$dataNasc = $_POST['DT_Nascimento'];
				$curso = $_POST['Curso'];
				// Cria conexão
				$conn = mysqli_connect($servername, $username, $password, $database);

				// Verifica conexão
				if (!$conn) {
					die("<strong> Falha de conexão: </strong>" . mysqli_connect_error());
				}

				// Configura para trabalhar com caracteres acentuados do português
				mysqli_query($conn, "SET NAMES 'utf8'");
				mysqli_query($conn, 'SET character_set_connection=utf8');
				mysqli_query($conn, 'SET character_set_client=utf8');
				mysqli_query($conn, 'SET character_set_results=utf8');
				?>

				<?php

				// Faz Update na Base de Dados
				if ($_FILES['Imagem']['size'] == 0) { // Não recebeu uma imagem binária
					$sqlUsuario = "UPDATE Usuario SET Nome = '$nome', Email ='$Email', CPF='$CPF', 
						DT_Nascimento = '$dataNasc'
					where id = '$id'";

				} else {
					$imagem = addslashes(file_get_contents($_FILES['Imagem']['tmp_name'])); // Prepara para salvar em BD
					$sqlUsuario = "UPDATE Usuario SET Nome = '$nome', Email ='$Email', CPF='$CPF', 
						DT_Nascimento = '$dataNasc', Foto = '$imagem'
					where ID = '$id'";
				}

				$sqlProfessor = "UPDATE Professor SET fK_Curso_ID_Curso = '$curso'
				WHERE fk_Usuario_ID = '$id'";

				echo "<div class='w3-responsive w3-card-4'>";
				if ($result = mysqli_query($conn, $sqlUsuario)) {
					$conn->query($sqlProfessor);
					echo "<p>&nbsp;Registro alterado com sucesso! </p>";
				} else {
					echo "<p>&nbsp;Erro executando UPDATE: " . mysqli_error($conn) . "</p>";
				}
				echo "</div>";
				mysqli_close($conn); //Encerra conexao com o BD
				
				?>


		</section>
		<div class='form-card'>
			<input type="button" value="Voltar" class="w3-btn w3-red"
				onclick="window.location.href='professorListar.php'">
			</tr>
		</div>
	</div>
	<!-- FIM PRINCIPAL -->
	</div>
	<!-- Inclui RODAPE.PHP  -->
	<?php require 'geral/rodape.php'; ?>

</body>

</html>