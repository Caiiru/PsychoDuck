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


    <div class w3=main w3-container style='margin-left:270px/ margin-top:117px;'>
        <!-- Conteúdo Principal: deslocado para direita em 270 pixels quando a sidebar é visível -->
        <section class="teachers">

            <h1 class="heading">Lista de Professores</h1>
            <div>
                <?php
                $conn = mysqli_connect($servername, $username, $password, $database);

                if (!$conn) {
                    echo "</table>";
                    echo "</div>";
                    die("Falha na conexção com o Banco de Dados: " . mysqli_connect_error());
                }
                mysqli_query($conn, "SET NAMES 'utf8'");
                mysqli_query($conn, 'SET character_set_connection=utf8');
                mysqli_query($conn, 'SET character_set_client=utf8');
                mysqli_query($conn, 'SET character_set_results=utf8');

                // Faz Select na Base de Dados
                $sql = "SELECT Matricula, Nome as Nome_Professor,CPF, Nome_Curso as Curso, Foto FROM Professor as P INNER JOIN Usuario as U ON (P.fk_Usuario_ID = U.ID) INNER JOIN Curso as C ON (P.fk_Curso_ID_Curso = C.ID_Curso)";

                echo "<div class='box-container'>";
                if ($result = mysqli_query($conn, $sql)) { ?>
                    <div class='box offer'>
                        <h3> Cadastrar novo Professor </h3>
                        <input type='submit' value='Inserir' class='w3-btn w3-green'
                            onclick="window.location.href = 'cadastroProfessor.php'" />

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
                        echo "<h3>$row[Nome_Professor]</h3>";
                        echo "</td><td>";
                        echo "</td><td>";
                        echo $row['Curso'];
                        echo "</td><td>";
                        echo "</div>";
                        ?>
                            <div class='buttons'>
                        <td>
                            <a href='professorAtualizar.php?id=<?php echo $cod; ?>'><img src='imagens/Edit.png'
                                    title='Editar Professor' width='32'></a>
                        </td>
                        <td>
                            <a href='professorExcluir.php?id=<?php echo $cod; ?>'><img src='imagens/Delete.png'
                                    title='Excluir Professor' width='32'></a>
                        </td>
                    </div>
                    <?php
                    echo "</div>";
                    echo "</div>";
                    }
                } else {
                    echo "Erro executando SELECT: " . mysqli_error($conn);
                }

                mysqli_close($conn);

                ?>
    </div>
    </div>
    </div>


    </div>


    </section>




    <!-- FIM PRINCIPAL -->
    </div>
    <!-- Inclui RODAPE.PHP  -->
    <?php require 'geral/rodape.php'; ?>

</body>

</html>