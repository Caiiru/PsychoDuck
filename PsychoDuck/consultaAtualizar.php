<!DOCTYPE html>
<!-------------------------------------------------------------------------------
	Desenvolvimento Web
	PUCPR
	Profa. Cristina V. P. B. Souza
	Agosto/2022
---------------------------------------------------------------------------------->
<!-- MedAtualizar.php -->

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
		<section class="form-container">


			<div class="cssHigh notranslate">
				<!-- Acesso em:-->


				<!-- Acesso ao BD-->
				<?php
				$id = $_GET['id'];

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
				$sqll = "SELECT P.fk_Usuario_ID as ID_Psicologo, ID_Consulta as ID, CIP, UP.Nome as Nome_Psicologo, UA.ID as ID_Aluno, 
					UA.Nome as Nome_Aluno, DT_Consulta, Observacao as Observacoes FROM CONSULTA as C INNER JOIN Aluno as A 
					INNER JOIN USUARIO AS UA ON (A.fk_Usuario_ID = UA.ID) 
					INNER JOIN Psicologo as P INNER JOIN USUARIO AS UP ON(P.fK_Usuario_ID = UP.ID)
					WHERE P.CIP=C.fk_Psicologo_CIP AND A.Matricula = C.fk_Aluno_Matricula";


				//Inicio DIV form
				echo "<div class='w3-responsive w3-card-4' style='width:700px;'>";
				if ($result = mysqli_query($conn, $sqll)) {

					if (mysqli_num_rows($result) != null) {
						$row = mysqli_fetch_assoc($result);

						$id = $row["ID"];
						$ID_Aluno = $row["ID_Aluno"];
						$PsicologoNome = $row["Nome_Psicologo"];
						$alunoNome = $row["Nome_Aluno"];
						$dataConsulta = $row["DT_Consulta"];
						$CIP = $row["CIP"];
						$observacoes = $row["Observacoes"];


						$sqlPsicologo = "SELECT Nome as Nome_Psicologo,CIP ,ID as ID_Psicologo FROM Usuario as U INNER JOIN Psicologo as P ON(P.fk_Usuario_ID = U.ID)";
						$psicologoOptions = array();

						$sqlAluno = "SELECT Nome as Nome_Aluno, ID as ID_Aluno FROM USUARIO AS U 
						INNER JOIN Aluno AS A ON (A.FK_USUARIO_ID = U.ID)";
						$alunoOptions = array();

						if ($result = mysqli_query($conn, $sqlPsicologo)) {
							while ($row = mysqli_fetch_assoc($result)) {
								$selected = "";
								if ($row['CIP'] == $CIP) {
									$selected = 'selected';
								}
								array_push($psicologoOptions, "\t\t\t<option " . $selected . " value='" . $row["CIP"] . "'>" . $row["Nome_Psicologo"] . "</option>\n");
							}
						}

						if ($result = mysqli_query($conn, $sqlAluno)) {
							while ($row = mysqli_fetch_assoc($result)) {
								$selected = "";
								if ($row['ID_Aluno'] == $ID_Aluno) {
									$selected = 'selected';
								}
								array_push($alunoOptions, "\t\t\t<option " . $selected . " value='" . $row["ID_Aluno"] . "'>" . $row["Nome_Aluno"] . "</option>\n");
							}
						}

						?>
						<div class="w3-container w3-purple">
							<h2>Altere os dados da consulta [
								<?php echo $id; ?>]
							</h2>
						</div>
						<form class="w3-container" action="consultaAtualizar_exe.php" method="post"
							enctype="multipart/form-data">
							<table class='w3-table-all'>
								<tr>
									<td style="width:50%;">
										<p>
											<input type="hidden" id="Id" name="Id" value="<?php echo $id; ?>">
										<p><label class="w3-text-IE"><b>Psicologo</b>*</label>
											<select name="Psicologo" id="Psicologo" class="w3-input w3-border w3-light-grey"
												required>
												<option value="<?php echo $PsicologoNome ?>"></option>
												<?php
												foreach ($psicologoOptions as $key => $value) {
													echo $value;
												}
												?>
											</select>
										</p>
										<p><label class="w3-text-IE"><b>Aluno</b>*</label>
											<select name="Aluno" id="Aluno" class="w3-input w3-border w3-light-grey" required>
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
											<input class="w3-input w3-border w3-light-grey " name="DT_Consulta" type="date"
												placeholder="dd/mm/aaaa" title="dd/mm/aaaa" title="Formato: dd/mm/aaaa"
												value="<?php echo $dataConsulta; ?>">
										</p>

									</td>
									<td>
										<p>
										</p>
										<p>
											<label class="w3-text-IE"><b>Observação</b></label>
											<input class="w3-input w3-border w3-light-grey " name="Text_Observacao" type="text"
												title="Observação Consulta" value="<?php echo $observacoes; ?>">
										</p>
									</td>
								</tr>
								<tr>
									<td colspan="2" style="text-align:center">
										<p>
											<input type="submit" value="Alterar" class="w3-btn w3-purple">
											<input type="button" value="Cancelar" class="w3-btn w3-red"
												onclick="window.location.href='consultaListar.php'">
										</p>
								</tr>
							</table>
							<br>
						</form>
						<?php
					} else { ?>
						<div class="w3-container w3-theme">
							<h2>Consulta inexistente</h2>
						</div>
						<br>
						<?php
					}
				} else {
					echo "<p style='text-align:center'>Erro executando UPDATE: " . mysqli_error($conn) . "</p>";
				}
				echo "</div>"; //Fim form
				mysqli_close($conn); //Encerra conexao com o BD
				?>
			</div>
			</p>
		</section>

		<!-- FIM PRINCIPAL -->
	</div>
	<!-- Inclui RODAPE.PHP  -->
	<?php require 'geral/rodape.php'; ?>

</body>

</html>