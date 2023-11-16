<!DOCTYPE html>
<!-------------------------------------------------------------------------------
	Desenvolvimento Web
	PUCPR
	Profa. Cristina V. P. B. Souza
	Agosto/2022
---------------------------------------------------------------------------------->


<html>

<head>

	<title>Psychoduck</title>
	<link rel="icon" type="../image/png" href="imagens/favicon.png" />
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

	<!-- Conteúdo Principal: deslocado paa direita em 270 pixels quando a sidebar é visível -->
	<div class="w3-main w3-container" style="margin-top:117px;">

		<div class="w3-panel w3-padding-large w3-card-4 w3-light-grey">
			<!-- h1 class="w3-xxlarge">Contratação de Médico</h1 -->
			<p class="w3-large">
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

				// Faz Select na Base de Dados
				$sqlG = "SELECT P.fk_Usuario_ID as ID_Psicologo, ID_Consulta as ID, UP.Nome as Nome_Psicologo, UA.Nome as Aluno_Nome, DATE_FORMAT(DT_Consulta, '%d/%m/%Y ')  as Data_Consulta, Observacao FROM CONSULTA as C INNER JOIN Aluno as A 
				INNER JOIN USUARIO AS UA ON (A.fk_Usuario_ID = UA.ID) 
				INNER JOIN Psicologo as P INNER JOIN USUARIO AS UP ON(P.fK_Usuario_ID = UP.ID)
				WHERE P.CIP=C.fk_Psicologo_CIP AND A.Matricula = C.fk_Aluno_Matricula";

				$sqlPsicologo = "SELECT Nome as Nome_Psicologo,CIP ,ID as ID_Psicologo FROM Usuario as U INNER JOIN Psicologo as P ON(P.fk_Usuario_ID = U.ID)";
				$sqlAluno = "SELECT Matricula, Nome as Nome_Aluno, ID as ID_Aluno FROM USUARIO AS U INNER JOIN Aluno AS A ON (A.FK_USUARIO_ID = U.ID)";
				$psicologoOptions = array();
				$alunoOptions = array();
				//Selecionar Psicologo
				if ($result = mysqli_query($conn, $sqlPsicologo)) {
					while ($row = mysqli_fetch_assoc($result)) {
						array_push($psicologoOptions, "\t\t\t<option value='" . $row["CIP"] . "'>" . $row["Nome_Psicologo"] . "</option>\n");
					}
				}
				if ($result = mysqli_query($conn, $sqlAluno)) {
					while ($row = mysqli_fetch_assoc($result)) {
						array_push($alunoOptions, "\t\t\t<option value='" . $row["Matricula"] . "'>" . $row["Nome_Aluno"] . "</option>\n");
					}
				}


				?>

				<div class="w3-responsive w3-card-4">
					<div class="w3-container w3-purple">
						<h2>Informe os dados da Consulta</h2>
					</div>
					<form class="w3-container" action="cadastroConsulta_exe.php" method="post"
						enctype="multipart/form-data">
						<table class='w3-table-all'>
							<tr>
								<td style="width:50%;">
									<p><label class="w3-text-IE"><b>Psicologo</b>*</label>
										<select name="Psicologo" id="Psicologo" class="w3-input w3-border w3-light-grey"
											required>
											<option value=""></option>
											<?php
											foreach ($psicologoOptions as $key => $value) {
												echo $value;
											}
											?>
										</select>
									</p>
									<p><label class="w3-text-IE"><b>Aluno</b>*</label>
										<select name="Aluno" id="Aluno" class="w3-input w3-border w3-light-grey"
											required>
											<option value=""></option>
											<?php
											foreach ($alunoOptions as $key => $value) {
												echo $value;
											}
											?>
										</select>
									</p>
									<p>
										<label class="w3-text-IE"><b>Data da Consulta</b>*</label>
										<input class="w3-input w3-border w3-light-grey" name="DT_Consulta" type="date"
											placeholder="dd/mm/aaaa" title="dd/mm/aaaa" required>
									</p>

								</td>
								<td>
									<p>
										<label class="w3-text-IE"><b>Observação</b></label>
										<input class="w3-input w3-border w3-light-grey " name="Observacao" type="text"
											title="Observação Consulta">
									</p>
								</td>

							</tr>
							<tr>
								<td colspan="2" style="text-align:center">
									<p>
										<input type="submit" value="Salvar" class="w3-btn w3-purple">
										<input type="button" value="Cancelar" class="w3-btn w3-red"
											onclick="window.location.href='listarConsulta.php'">
									</p>
								</td>
							</tr>
						</table>
					</form>
					<br>
				</div>
			</div>
			</p>
		</div>
 
		<!-- FIM PRINCIPAL -->
	</div>
	<!-- Inclui RODAPE.PHP  -->
	<?php require 'geral/rodape.php'; ?>

</body>

</html>