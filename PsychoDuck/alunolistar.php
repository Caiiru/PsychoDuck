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
    <div class="w3-main w3-container">

        <section class='teachers'>
            <h1 class="heading">Lista de Alunos</h1>
            <div>
                <?php

                // Cria conexão
                $conn = mysqli_connect($servername, $username, $password, $database);

                // Verifica conexão 
                if (!$conn) {
                    echo "</table>";
                    echo "</div>";
                    die
                        ("Falha na conexão com o Banco de Dados: " . mysqli_connect_error());
                }
                mysqli_query($conn, "SET NAMES 'utf8'");
                mysqli_query($conn, 'SET character_set_connection=utf8');
                mysqli_query($conn, 'SET character_set_client=utf8');
                mysqli_query($conn, 'SET character_set_results=utf8');

                // Faz Select na Base de Dados
                $sql = "SELECT Matricula,Nome,CPF,NotaMedia, Nome_Curso as Curso, DATE_FORMAT(DT_Inicio, '%d/%m/%Y') as Data_Inicio, Foto FROM Usuario as U INNER JOIN Aluno as A ON (A.fk_Usuario_ID = U.ID) INNER JOIN CURSO AS C ON (A.fk_Curso_ID_CUrso = C.ID_Curso)";
                echo "<div class ='box-container'>";
                if ($result = mysqli_query($conn, $sql)) { ?>
                    <div class='box offer'>
                        <h3> Cadastrar novo Aluno </h3>
                        <input type='submit' value='Inserir' class='w3-btn w3-green'
                            onclick="window.location.href = 'cadastroAluno.php'" />

                    </div>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $cod = $row["Matricula"];

                        if (mysqli_num_rows($result) > 0) {
                            echo "<div class='box'>";
                            echo "<div class='tutor'>";
                            if ($row['Foto']) { ?>
                                <td>
                                    <img id="imagemSelecionada" class="w3-circle w3-margin-top"
                                        src="data:image/png;base64,<?= base64_encode($row['Foto']) ?>" />
                                </td>
                                <td>
                                    <?php
                            } else {
                                ?>
                                <td>
                                    <img id="imagemSelecionada" class="w3-circle w3-margin-top" src="imagens/pessoa.jpg" />
                                </td>
                                <td>

                                    <?php
                            }
                        }


                        echo "<div>";
                        echo "</td><td>";
                        echo "<span>Matricula: $row[Matricula]</span>";
                        echo "<h3>$row[Nome]</h3>";
                        echo "</td><td>";
                        echo "</td><td>";
                        echo "<span>Curso: $row[Curso]</span>";
                        echo "<br>";
                        echo "<span>Notas: $row[NotaMedia]</span>";
                        echo "</td><td>";
                        echo "</div>";
                        ?>
                            <div class='buttons'>
                        <td>
                            <a href='alunoAtualizar.php?id=<?php echo $cod; ?>'><img src='imagens/Edit.png'
                                    title='Editar Aluno' width='32'></a>
                        </td>
                        <td>
                            <a href='alunoExcluir.php?id=<?php echo $cod; ?>'><img src='imagens/Delete.png'
                                    title='Excluir Aluno' width='32'></a>
                        </td>
                    </div>
                    <?php
                    echo "</div>";
                    echo "</div>";
                    }
                    if (mysqli_num_rows($result) > 0) {
                        // Apresenta cada linha da tabela
                        while ($row = mysqli_fetch_assoc($result)) {

                            echo "<div class='box'>";
                            echo "<div class='tutor'>";
                            if ($row['Foto']) { ?>
                            <td>
                                <img id="imagemSelecionada" class="w3-circle w3-margin-top"
                                    src="data:image/png;base64,<?= base64_encode($row['Foto']) ?>" />
                            </td>
                            <td>
                                <?php
                            } else {
                                ?>
                            <td>
                                <img id="imagemSelecionada" class="w3-circle w3-margin-top" src="imagens/pessoa.jpg" />
                            </td>
                            <td>

                                <?php
                            }

                            echo "</div>";
                            echo "</div>";

                            $cod = $row["ID"];
                            echo "<tr>";
                            echo "<td>";
                            echo $cod;
                            echo "</td><td>";
                            echo $row["CIP"];
                            if ($row['Foto']) { ?>
                            <td>
                                <img id="imagemSelecionada" class="w3-circle w3-margin-top"
                                    src="data:image/png;base64,<?= base64_encode($row['Foto']) ?>" />
                            </td>
                            <td>
                                <?php
                            } else {
                                ?>
                            <td>
                                <img id="imagemSelecionada" class="w3-circle w3-margin-top" src="imagens/pessoa.jpg" />
                            </td>
                            <td>
                                <?php
                            }
                            echo $row["Nome"];
                            echo "</td><td>";
                            echo $row["Especialidade"];
                            echo "</td><td>";
                            //Atualizar e Excluir registro de médicos
                            ?>
                        <td>
                            <a href='alunoExcluir.php?id=<?php echo $cod; ?>'><img src='imagens/Edit.png'
                                    title='Editar Aluno' width='32'></a>
                        </td>
                        <td>
                            <a href='alunoExcluir_exe.php?id=<?php echo $cod; ?>'><img src='imagens/Delete.png'
                                    title='Excluir Aluno' width='32'></a>
                        </td>
                        </tr>
                        <?php
                        }
                    }
                } else {
                    echo "Erro executando SELECT: " . mysqli_error($conn);
                }

                ?>
    </div>
    </section>
    

    <!-- FIM PRINCIPAL --> 
    <!-- Inclui RODAPE.PHP  -->
    <?php require 'geral/rodape.php'; ?>

</body>

</html>