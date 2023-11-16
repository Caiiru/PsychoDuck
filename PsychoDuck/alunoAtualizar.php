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
				$sql = "SELECT ID,ID_Curso, Matricula,CPF,Nome,Email, Nome_Curso as Curso, NotaMedia, QTD_FALTAS as Faltas,
				DT_Inicio, 
				DT_Nascimento as Data_Nascimento, Foto 
				FROM Usuario as U INNER JOIN Aluno as A ON (A.fk_Usuario_ID = U.ID) 
				INNER JOIN CURSO AS C ON (A.fk_Curso_ID_CUrso = C.ID_Curso)
				WHERE Matricula = $id";


				//Inicio DIV form
				echo "<div class='w3-responsive w3-card-4'>";
				if ($result = mysqli_query($conn, $sql)) {

					if (mysqli_num_rows($result) != null) {
						$row = mysqli_fetch_assoc($result);

						$id = $row["ID"];
						$matricula = $row['Matricula'];
						$nome = $row['Nome'];
						$Email = $row['Email'];
						$CPF = $row['CPF'];
						$dataNasc = $row['Data_Nascimento'];
						$dataInicio = $row['DT_Inicio'];
						$foto = $row['Foto'];
						$NotaMedia = $row['NotaMedia'];
						$QTD_FALTAS = $row['Faltas'];
						$Curso = $row['ID_Curso'];

						$sqlG = "SELECT ID_Curso, Nome_Curso FROM Curso";

						$optionsEspec = array();

						if ($result = mysqli_query($conn, $sqlG)) {
							while ($row = mysqli_fetch_assoc($result)) {
								$selected = "";
								if($row["ID_Curso"] == $Curso){
									$selected = "selected";
								}
								array_push($optionsEspec, "\t\t\t<option ". $selected . " value='" . $row["ID_Curso"] . "'>" . $row["Nome_Curso"] . "</option>\n");
							}
						}

						?>
						<div class="w3-container w3-theme">
							<h2>Altere os dados de Matricula. = [
								<?php echo $matricula; ?>]
							</h2>
						</div>
						<form class="w3-container" action="alunoAtualizar_exe.php" method="post" enctype="multipart/form-data">
							<table class='w3-table-all'>
								<tr>
									<td style="width:50%;">
										<p>
											<input type="hidden" id="Id" name="Id" value="<?php echo $id; ?>">
										<p>
											<label class="w3-text-IE"><b>Nome</b></label>
											<input class="w3-input w3-border w3-light-grey " name="Nome" type="text"
												pattern="[a-zA-Z\u00C0-\u00FF ]{10,100}$" title="Nome entre 10 e 100 letras."
												value="<?php echo $nome; ?>" required>
										</p>
										<p>
											<label class="w3-text-IE"><b>CPF</b>*</label>
											<input class="w3-input w3-border w3-light-grey " name="CPF" id="CPF" type="text"
												maxlength="15" value="<?php echo $CPF; ?>" required>
										</p>
										<p>
											<label class="w3-text-IE"><b>Email</b>*</label>
											<input class="w3-input w3-border w3-light-grey " name="Email" id="Email"
												type="email" maxlength="15" placeholder="email@email.com"
												title="email@email.com" value="<?php echo $Email; ?>" required>
										</p>
										<p>
											<label class="w3-text-IE"><b>Data de Nascimento</b></label>
											<input class="w3-input w3-border w3-light-grey " name="DT_Nascimento" type="date"
												placeholder="dd/mm/aaaa" title="dd/mm/aaaa" title="Formato: dd/mm/aaaa"
												value="<?php echo $dataNasc; ?>">
										</p>
										<p><label class="w3-text-IE"><b>Curso</b>*</label>
											<select name="Curso" id="Curso" class="w3-input w3-border w3-light-grey" required>
												<option value=""></option>
												<?php
												foreach ($optionsEspec as $key => $value) {
													echo $value;
												}
												?>
											</select>
										</p>
										<p>
											<label class="w3-text-IE"><b>Data de Ingressão</b></label>
											<input class="w3-input w3-border w3-light-grey " name="dtInicio" type="date"
												placeholder="dd/mm/aaaa" title="dd/mm/aaaa" title="Formato: dd/mm/aaaa"
												value="<?php echo $dataInicio; ?>">
										</p>
										<p>
											<label class="w3-text-IE"><b>Notas</b></label>
											<input class="w3-input w3-border w3-light-grey " name="NotaMedia" type="number"
												placeholder="100" value="<?php echo $NotaMedia; ?>">
										</p>
										<p>
											<label class="w3-text-IE"><b>Faltas</b></label>
											<input class="w3-input w3-border w3-light-grey " name="QTD_Faltas" type="number"
												placeholder="0" value="<?php echo $QTD_FALTAS; ?>">
										</p>

										</select>
										</p>


									</td>
									<td>

										<p style="text-align:center"><label class="w3-text-IE"><b>Minha Imagem para
													Identificação: </b></label></p>
										<?php
										if ($foto) { ?>
											</p>
											<p style="text-align:center">
												<img id="imagemSelecionada" class="w3-circle w3-margin-top"
													src="data:image/png;base64,<?= base64_encode($foto); ?>" />
											</p>
											<?php
										} else {
											?>
											<p style="text-align:center">
												<img id="imagemSelecionada" class="w3-circle w3-margin-top"
													src="imagens/pessoa.jpg" />
											</p>
											<?php
										}
										?>
										<p style="text-align:center"><label class="w3-btn w3-theme">Selecione uma Imagem
												<input type="hidden" name="MAX_FILE_SIZE" value="16777215" />
												<input type="file" id="Imagem" name="Imagem" accept="imagem/*"
													onchange="validaImagem(this);" /></label>
										</p>
										<p style='display:none'>
											<input id='ID' name='ID' value="<?php echo $id; ?>" />

										</p>

									</td>
								</tr>
								<tr>
									<td colspan="2" style="text-align:center">
										<p>
											<input type="submit" value="Alterar" class="w3-btn w3-red">
											<input type="button" value="Cancelar" class="w3-btn w3-theme"
												onclick="window.location.href='alunolistar.php'">
										</p>
								</tr>
							</table>
							<br>
						</form>
						<?php
					} else { ?>
						<div class="w3-container w3-theme">
							<h2>Aluno inexistente</h2>
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
		</div>

		<?php require 'geral/sobre.php'; ?>
		<!-- FIM PRINCIPAL -->
	</div>
	<!-- Inclui RODAPE.PHP  -->
	<?php require 'geral/rodape.php'; ?>

</body>

</html>