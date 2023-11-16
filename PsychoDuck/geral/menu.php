<!-------------------------------------------------------------------------------
	Desenvolvimento Web
	PUCPR
	Profa. Cristina V. P. B. Souza
	Agosto/2022
---------------------------------------------------------------------------------->
<!-- menu.php -->

<!-- Top -->


<!-- Sidebar -->
<div class="w3-sidebar w3-bar-block w3-collapse w3-animate-left" style="z-index:3;width:0px" id="mySidebar">

	<div class="side-bar">

		<div id="close-btn">
			<i class="fas fa-times"></i>
		</div>

		<div class="profile">
			<a href="."><img src="Imagens\logo-psychoduck.png" class="image" alt="Psychoduck Logo"></a>
			<h2> PsychoDuck </h2>

		</div>

		<nav class="navbar">
			<a href="alunolistar.php"><i class="fas fa-address-book"></i><span>Alunos</span></a>
			<a href="psicologolistar.php"><i class="fas fa-brain"></i><span>Psicologos</span></a>
			<a href="professorlistar.php"><i class="fas fa-chalkboard-user"></i><span>Professores</span></a>
			<a href="consultalistar.php"><i class="fas fa-comments"></i><span>Consultas</span></a>
		</nav>
		<?php
		

		date_default_timezone_set("America/Sao_Paulo");
		$data = date("d/m/Y H:i:s", time());
		echo "<p class='w3-small' > ";
		echo "Acesso em: ";
		echo $data;
		echo "</p> "
			?>
	</div>



</div>


<script type="text/javascript" src="js/myScriptClinic.js"></script>