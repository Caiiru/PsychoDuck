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
	<div class="w3-main w3-container" >

		<section class='form-container'>
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
			$sql = "SELECT ID, fk_Curso_ID_Curso, Matricula,CPF,Nome,Email, Nome_Curso as Curso,
			DT_Nascimento as Data_Nascimento, Foto
			FROM Usuario as U INNER JOIN Professor as P ON (P.fk_Usuario_ID = U.ID)
			INNER JOIN CURSO AS C ON (P.fk_Curso_ID_CUrso = C.ID_Curso)
			WHERE Matricula = $id";

			echo "<div class='form-card w3-card-4'>";
			if ($result = mysqli_query($conn, $sql)) {

				if (mysqli_num_rows($result) != null) {
					$row = mysqli_fetch_assoc($result);

					$id = $row["ID"];
					$matricula = $row['Matricula'];
					$nome = $row['Nome'];
					$Email = $row['Email'];
					$CPF = $row['CPF'];
					$dataNasc = $row['Data_Nascimento'];
					$foto = $row['Foto'];
					$curso = $row['fk_Curso_ID_Curso'];
					$sqlG = "SELECT ID_Curso, Nome_Curso FROM Curso";

					$optionsCurso = array();
					if ($result = mysqli_query($conn, $sqlG)) {
						while ($row = mysqli_fetch_assoc($result)) {
							$selected = "";
							if ($row['ID_Curso'] == $curso)
								$selected = "selected";
							array_push($optionsCurso, "\t\t\t<option " . $selected . " value='" . $row["ID_Curso"] . "'>" . $row["Nome_Curso"] . "</option>\n");
						}
					}

					?>
					<div class="w3-container w3-purple">
						<h3>Altere os dados do professor
						</h3>
					</div>
					<form class="w3-container" action="professorAtualizar_exe.php" method="post" enctype="multipart/form-data">
						<table class='w3-table-all'>
							<tr>
								<td style="width:50%;">
									<p>
										<input type="hidden" id="Id" name="Id" value="<?php echo $id; ?>">

									</p>
									<p>
										<label class='w3-text-IE'>Matricula <?php echo $matricula; ?></label>
									</p>
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
										<input class="w3-input w3-border w3-light-grey " name="Email" id="Email" type="email"
											maxlength="15" placeholder="email@email.com" title="email@email.com"
											value="<?php echo $Email; ?>" required>
									</p>
									<p>
										<label class="w3-text-IE"><b>Data de Nascimento</b></label>
										<input class="w3-input w3-border w3-light-grey " name="DT_Nascimento" type="date"
											placeholder="dd/mm/aaaa" title="dd/mm/aaaa" title="Formato: dd/mm/aaaa"
											value="<?php echo $dataNasc; ?>">
									</p>
									<p><label class="w3-text-IE"><b>Curso</b>*</label>
										<select name="Curso" id="Curso" class="w3-input w3-border w3-light-grey " required>

											<?php
											foreach ($optionsCurso as $key => $value) {
												echo $value;
											}
											?>
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
											<img id="imagemSelecionada" class="w3-circle w3-margin-top" src="imagens/pessoa.jpg" />
										</p>
										<?php
									}
									?>
									<p style="text-align:center"><label class="w3-btn w3-purple">Selecione uma Imagem
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
										<input type="submit" value="Alterar" class="w3-btn w3-purple">
										<input type="button" value="Cancelar" class="w3-btn w3-red"
											onclick="window.location.href='professorListar.php'">
									</p>
							</tr>
						</table>
						<br>
					</form>
					<?php
				} else { ?>
					<div class="w3-container w3-theme">
						<h2>Professor inexistente</h2>
					</div>
					<br>
					<?php
				}
			} else {
				echo "<p style='text-align:center'>Erro executando UPDATE: " . mysqli_error($conn) . "</p>";
			}
			echo "</div>"; //Fim form
			

			?>
		</section>

 
		<!-- FIM PRINCIPAL -->
	</div>
	<!-- Inclui RODAPE.PHP  -->
	<?php require 'geral/rodape.php'; ?>

</body>

</html>