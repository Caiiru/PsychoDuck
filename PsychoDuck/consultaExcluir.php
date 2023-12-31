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
    <link rel="icon" type="image/png" href="imagens/logo-psychoduck.png" />
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
		<div class="w3-panel w3-padding-large w3-card-4 w3-light-grey">
			<div class="cssHigh notranslate">
				<!-- Acesso em:-->
			 
				<!-- Acesso ao BD-->
				<?php

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

				$idConsulta = $_GET['id'];

				// Faz Select na Base de Dados
				$sql = "SELECT ID_Consulta as ID, UP.Nome as Psicologo_Nome, UA.Nome as Nome_Aluno, DATE_FORMAT(DT_Consulta, '%d/%m/%Y') as DT_Consulta, Observacao FROM CONSULTA as C INNER JOIN Aluno as A 
				INNER JOIN USUARIO AS UA ON (A.fk_Usuario_ID = UA.ID) 
				INNER JOIN Psicologo as P INNER JOIN USUARIO AS UP ON(P.fK_Usuario_ID = UP.ID)
				WHERE P.CIP=C.fk_Psicologo_CIP AND A.Matricula = C.fk_Aluno_Matricula AND ID_Consulta = $idConsulta";

				//Inicio DIV form
				echo "<div class='w3-responsive w3-card-4'>";
				if ($result = mysqli_query($conn, $sql)) {
					if (mysqli_num_rows($result) == 1) {
						$row = mysqli_fetch_assoc($result);

						?>
						<div class="w3-container w3-purple">
							<h2>Exclusão da Consulta [<?php echo $row['ID']; ?>]
							</h2>
						</div>
						<form class="w3-container" action="consultaExcluir_exe.php" method="post"
							onsubmit="return check(this.form)">
							<input type="hidden" id="Id" name="Id" value="<?php echo $row['ID']; ?>">
							<p>
								<label class="w3-text-IE"><b>Nome Psicologo: </b>
									<?php echo $row['Psicologo_Nome']; ?>
								</label>
							</p>
							<p>
								<label class="w3-text-IE"><b>Nome Aluno: </b>
									<?php echo $row['Nome_Aluno']; ?>
								</label>
							</p>
							<p>
								<label class="w3-text-IE"><b>Data da Consulta: </b>
									<?php echo $row['DT_Consulta']; ?>
								</label>
							</p>
							<p>
								<label class="w3-text-IE"><b>Observacao: </b>
									<?php echo $row['Observacao']; ?>
								</label>
							</p>
							<p>
								<input type="submit" value="Confirma exclusão?" class="w3-btn w3-purple">
								<input type="button" value="Cancelar" class="w3-btn w3-red"
									onclick="window.location.href='consultaListar.php'">
							</p>
						</form>
					<?php
					} else { ?>
						<div class="w3-container w3-theme">
							<h2>Consulta inexistente</h2>
						</div>
						<br>
					<?php }
				} else {
					echo "<p style='text-align:center'>Erro executando DELETE: " . mysqli_error($conn) . "</p>";
				}
				echo "</div>"; //Fim form
				mysqli_close($conn);  //Encerra conexao com o BD
				?>

			</div>
			</p>
		</div>
		</section>
 
		<!-- FIM PRINCIPAL -->
	</div>
	<!-- Inclui RODAPE.PHP  -->
	<?php require 'geral/rodape.php'; ?>

</body>

</html>