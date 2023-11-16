<!DOCTYPE html>
<!-------------------------------------------------------------------------------
    Desenvolvimento Web
    PUCPR
    Profa. Cristina V. P. B. Souza
    Agosto/2022
---------------------------------------------------------------------------------->
<!-- medListar.php -->

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

        <div class="w3-panel w3-padding-large w3-card-4 w3-light-grey">
            <p class="w3-large">
            <p>
            <div class="  cssHigh notranslate">
                <!-- Acesso em:-->

                <div class="w3-container w3-purple">
                    <h2>Listagem de Consultas</h2>

                </div>

                <!-- Acesso ao BD-->
                <?php

                // Cria conexão
                $conn = mysqli_connect($servername, $username, $password, $database);

                // Verifica conexão 
                if (!$conn) {
                    echo "</table>";
                    echo "</div>";
                    die("Falha na conexão com o Banco de Dados: " . mysqli_connect_error());
                }

                // Configura para trabalhar com caracteres acentuados do português
                mysqli_query($conn, "SET NAMES 'utf8'");
                mysqli_query($conn, 'SET character_set_connection=utf8');
                mysqli_query($conn, 'SET character_set_client=utf8');
                mysqli_query($conn, 'SET character_set_results=utf8');

                // Faz Select na Base de Dados
                $sql = "SELECT P.FK_Usuario_ID as ID_Psicologo,CIP, ID_Consulta as ID, UP.Nome as Psicologo_Name, UA.Nome as Aluno_Nome, DATE_FORMAT(DT_Consulta, '%d/%m/%Y') as Data_Consulta, Observacao FROM CONSULTA as C INNER JOIN Aluno as A 
                INNER JOIN USUARIO AS UA ON (A.fk_Usuario_ID = UA.ID) 
                INNER JOIN Psicologo as P INNER JOIN USUARIO AS UP ON(P.fK_Usuario_ID = UP.ID)
                WHERE P.CIP=C.fk_Psicologo_CIP AND A.Matricula = C.fk_Aluno_Matricula";


                echo "<div class='w3-responsive w3-card-4'>";
                if ($result = mysqli_query($conn, $sql)) {
                    echo "<table class='w3-table-all'>";
                    echo "	<tr>";
                    echo "	  <th width='7%'>ID</th>";
                    echo "	  <th width='14%'>Psicologo</th>";
                    echo "	  <th width='14%'>CIP</th>";
                    echo "	  <th width='14%'>Aluno</th>";
                    echo "	  <th width='18%'>Data</th>";
                    echo "	  <th width='15%'>Observação</th>";
                    echo "	  <th width='7%'> </th>";
                    echo "	  <th width='7%'> </th>";
                    echo "	</tr>";
                    if (mysqli_num_rows($result) > 0) {
                        // Apresenta cada linha da tabela
                        while ($row = mysqli_fetch_assoc($result)) {

                            $cod = $row["ID"];
                            echo "<td>";
                            echo $cod;
                            echo "</td><td>";
                            echo $row["Psicologo_Name"];
                            echo "</td><td>";
                            echo $row["CIP"];
                            echo "</td><td>";
                            echo $row["Aluno_Nome"];
                            echo "</td><td>";
                            echo $row["Data_Consulta"];
                            echo "</td><td>";
                            echo $row["Observacao"];
                            echo "</td><td>";

                            //Atualizar e Excluir registro de médicos
                            ?>
                            <td>
                                <a href='consultaAtualizar.php?id=<?php echo $cod; ?>'><img src='imagens/Edit.png'
                                        title='Editar Consulta' width='32'></a>
                            </td>
                            <td>
                                <a href='consultaExcluir.php?id=<?php echo $cod; ?>'><img src='imagens/Delete.png'
                                        title='Excluir Consulta' width='32'></a>
                            </td>
                            </tr>
                            <?php
                        }
                    }
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "Erro executando SELECT: " . mysqli_error($conn);
                }

                mysqli_close($conn);

                ?>
            </div>

        </div>
        <div class='form-card' style="bottom: 0; right: 0;">
            <input type="button" value="Inserir Nova Consulta" class="w3-btn w3-purple"
                onclick="window.location.href='cadastroConsulta.php'">
            </tr>
        </div>
        <!-- FIM PRINCIPAL -->
    </div>
    <!-- Inclui RODAPE.PHP  -->
    <?php require 'geral/rodape.php'; ?>

</body>

</html>