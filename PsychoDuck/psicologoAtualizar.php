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


			$sql = "SELECT ID, CIP,DT_Nascimento,CPF,Email,CPF,Nome,ID_Espec as Especialidade, FOTO FROM Psicologo as P 
				INNER JOIN Usuario as U ON (P.fk_Usuario_ID = U.ID) 
				inner join especialidade as E On (P.fk_Especialidade_Id = e.ID_Espec)
				WHERE ID = $id";
			echo "<div class='w3-responsive w3-card-4'>";
			if ($result = mysqli_query($conn, $sql)) {

				if (mysqli_num_rows($result) != null) {
					$row = mysqli_fetch_assoc($result);
					$ID = $row["ID"];
					$CIP = $row["CIP"]; 
					$CPF = $row["CPF"];
					$nome = $row["Nome"];
					$Especialidade = $row["Especialidade"];
					$Email = $row["Email"];
					$dataNasc = $row["DT_Nascimento"];
					$foto = $row["FOTO"];

					$sqlG = "SELECT ID_Espec, Nome_Espec FROM Especialidade";

					$optionsEspec = array();

					if ($result = mysqli_query($conn, $sqlG)) {
						while ($row = mysqli_fetch_assoc($result)) {
							$selected = "";
							if ($row["ID_Espec"] == $Especialidade) {
								$selected = "selected";
							}
							array_push($optionsEspec, "\t\t\t<option " . $selected . " value='" . $row["ID_Espec"] . "'>" . $row["Nome_Espec"] . "</option>\n");
						}
					}

					?>
					<div class="w3-container w3-purple">
						<h2>Altere os dados do Psicologo.
							 
						</h2>
					</div>
					<form class="w3-container" action="psicologoAtualizar_exe.php" method="post" enctype="multipart/form-data">
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
										<label class="w3-text-IE"><b>CIP</b>*</label>
										<input class="w3-input w3-border w3-light-grey " name="CIP" id="CIP" type="text"
											maxlength="15" value="<?php echo $CIP; ?>" required>
									</p>
									<p>
										<label class="w3-text-IE"><b>Email</b>*</label>
										<input class="w3-input w3-border w3-light-grey " name="Email" id="Email" type="email"
											maxlength="15" placeholder="email@email.com" title="email@email.com"
											value="<?php echo $Email; ?>" required>
									</p>
									<p>
										<label class="w3-text-IE"><b>CPF</b>*</label>
										<input class="w3-input w3-border w3-light-grey " name="CPF" id="CPF" type="text"
											maxlength="11" placeholder="CPF XXXXXXXXXXX" title="CPF XXXXXXXXXXX" required
											value="<?php echo $CPF; ?>">
									</p>
									<p>
										<label class="w3-text-IE"><b>Data de Nascimento</b></label>
										<input class="w3-input w3-border w3-light-grey " name="DT_Nascimento" type="date"
											placeholder="dd/mm/aaaa" title="dd/mm/aaaa" title="Formato: dd/mm/aaaa"
											value="<?php echo $dataNasc; ?>">
									</p>
									<p><label class="w3-text-IE"><b>Especialidade?</b>*</label>
										<select name="Especialidade" id="Especialidade" class="w3-input w3-border w3-light-grey"
											required>
											<option value=""></option>
											<?php
											foreach ($optionsEspec as $key => $value) {
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
											onclick="window.location.href='psicologoListar.php'">
									</p>
							</tr>
						</table>
						<br>
					</form>
					<?php
				} else { ?>
					<div class="w3-container w3-purple">
						<h2>Psicologo inexistente</h2>
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

	</section>

	<!-- FIM PRINCIPAL -->
	<!-- Inclui RODAPE.PHP  -->
	<?php require 'geral/rodape.php'; ?>

</body>

</html>