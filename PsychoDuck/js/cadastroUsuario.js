function showFields() {
  console.log("show fields");
  var userType = document.getElementById("userType").value;
  document.getElementById("alunoFields").style.display = "none";
  document.getElementById("professorFields").style.display = "none";
  document.getElementById("psicologoFields").style.display = "none";

  if (userType != "none") {
    if (userType == "Aluno") {
      document.getElementById("alunoFields").style.display = "block";
      console.log("Aluno");
    } else if (userType == "Professor") {
      document.getElementById("professorFields").style.display = "block";
    } else if (userType == "Psicologo") {
      document.getElementById("psicologoFields").style.display = "block";
    }
  } 
}


function submitForm(){
  console.log("Submiting form");
  var selectedUserType = document.getElementById("userType").value;
   
  fetch("cadastroUsuario_exe.php", {
    method: "POST",
    body:selectedUserType
  })
  .then(Response => Response.json())
}
