<!DOCTYPE html>
<!-------------------------------------------------------------------------------
	Desenvolvimento Web
	PUCPR
	Profa. Cristina V. P. B. Souza
	Agosto/2022
---------------------------------------------------------------------------------->
<!-- medIncluir_exe.php -->

<html>

<head>

	<title>Psychoduck</title>
    <link rel="icon" type="image/png" href="imagens/logo-psychoduck.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="css/customize.css">
</head>

<body onload="w3_show_nav('menuMedico')">
	<!-- Inclui MENU.PHP  -->
	<?php require 'geral/menu.php'; ?>
	<?php require 'bd/conectaBD.php'; ?>
	<!-- Conteúdo Principal: deslocado para direita em 270 pixels quando a sidebar é visível -->
	<div class="w3-main w3-container" style="margin-left:270px;margin-top:117px;">

		<div class="w3-panel w3-padding-large w3-card-4 w3-light-grey">
			<p class="w3-large">
			<div class="w3-code cssHigh notranslate">
				<!-- Acesso em:-->
				<?php

				date_default_timezone_set("America/Sao_Paulo");
				$data = date("d/m/Y H:i:s", time());
				echo "<p class='w3-small' > ";
				echo "Acesso em: ";
				echo $data;
				echo "</p> "
					?>

				<!-- Acesso ao BD-->
				<?php
				$nome = $_POST['Nome'];
				$CPF = $_POST['CPF'];
				$dataConsulta = $_POST['DataNasc'];
				$email = $_POST['Email'];


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

				// Faz Select na Base de Dados
				if ($_FILES['Imagem']['size'] == 0) { // Não recebeu uma imagem binária
					$sql = "INSERT INTO Usuario(Nome,CPF,Email,DT_Nascimento,Foto) VALUES('$nome','$CPF','$email','$dataConsulta',NULL)";
				} else { // Recebeu uma imagem binária
					$imagem = addslashes(file_get_contents($_FILES['Imagem']['tmp_name'])); // Prepara para salvar em BD
					$sql = "INSERT INTO Usuario(Nome,CPF,Email,DT_Nascimento,Foto) VALUES('$nome','$CPF','$email','$dataConsulta','$imagem')";
				}
				$conn->query($sql);
				$lastUserID = $conn->insert_id;
				
				$CIP = $_POST["CIP"];
				$especialidade = $_POST['Especialidade'];
				

				$sqlu = "INSERT INTO Psicologo(fk_Usuario_ID, CIP, fk_Especialidade_ID)
							VALUES('$lastUserID','$CIP', '$especialidade')";

				//$conn->query($sqlu);
								
				?>
				<div class='w3-responsive w3-card-4'>
					<div class="w3-container w3-theme">
						<h2>Inclusão de Novo Aluno</h2>
					</div>
					<?php
					if ($result = mysqli_query($conn, $sqlu)) {
						echo "<p>&nbsp;Registro cadastrado com sucesso! </p>";
					} else {
						echo "<p>&nbsp;Erro executando INSERT: " . mysqli_error($conn . "</p>");
					}
					echo "</div>";
					mysqli_close($conn); //Encerra conexao com o BD
					
					?>
				</div>
			</div>


			<?php require 'geral/sobre.php'; ?>
			<!-- FIM PRINCIPAL -->
		</div>
		<!-- Inclui RODAPE.PHP  -->
		<?php require 'geral/rodape.php'; ?>

</body>

</html>