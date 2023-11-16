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
	<div class="w3-main w3-container"  >
		<section class='form-container'>
			<p class="w3-large">
			<div>
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

				$matricula = $_GET['id'];
				$sql = "SELECT ID,CPF, DATE_FORMAT(DT_Nascimento,'%d/%m/%Y') as DataNascimento,CIP,Nome,Nome_Espec as Especialidade, Foto FROM Psicologo as P INNER JOIN Usuario as U ON (P.fk_Usuario_ID = U.ID) inner join especialidade as E On (P.fk_Especialidade_Id = e.ID_Espec)
				WHERE ID=$matricula";

				//Inicio DIV form
				echo "<div class='w3-responsive w3-card-4'>";
				if ($result = mysqli_query($conn, $sql)) {
					if (mysqli_num_rows($result) == 1) {
						$row = mysqli_fetch_assoc($result);

						?>
						<div class="w3-container w3-purple">
							<h2>Exclusão do Psicologo 
						</div>
						<form class="w3-container" action="psicologoExcluir_exe.php" method="post"
							onsubmit="return check(this.form)">
							<input type="hidden" id="Id" name="Id" value="<?php echo $row['ID']; ?>">
							<p>
								<label class="w3-text-IE"><b>Nome: </b>
									<?php echo $row['Nome']; ?>
								</label>
							</p>
							<p>
								<label class="w3-text-IE"><b>CPF: </b>
									<?php echo $row['CPF']; ?>
								</label>
							</p>
							<p>
								<label class="w3-text-IE"><b>Data de Nascimento: </b>
									<?php echo $row['DataNascimento']; ?>
								</label>
							</p>
							<p>
								<label class="w3-text-IE"><b>CIP: </b>
									<?php echo $row['CIP']; ?>
								</label>
							</p>
							<p>
								<label class="w3-text-IE"><b>Especialidade: </b>
									<?php echo $row['Especialidade']; ?>
								</label>
							</p>
							<p>
								<input type="submit" value="Confirma exclusão?" class="w3-btn w3-red">
								<input type="button" value="Cancelar" class="w3-btn w3-purple"
									onclick="window.location.href='psicologoListar.php'">
							</p>
						</form>
						<?php
					} else { ?>
						<div class="w3-container w3-purple">
							<h2>Tentativa de exclusão de Psicologo inexistente</h2>
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

		</section>
		
 
		<!-- FIM PRINCIPAL -->
	</div>
	<!-- Inclui RODAPE.PHP  -->
	<?php require 'geral/rodape.php'; ?>

</body>

</html>