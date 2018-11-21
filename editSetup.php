<?php
	session_start();
	
	if(!isset($_SESSION['id'])){
		header("Location login.php");
	}
	
	include_once("db.php");
	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/masks.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Users - Admin Template</title>

<link rel="stylesheet" type="text/css" href="css/theme1.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
			
<body>
	<div id="container">
    	<div id="header">
        	<h2>Neuro Stim Web App</h2>
    <div id="topmenu">
            	<ul>
                	<li class="current"><a href="index.php">Pacientes</a></li>
              </ul>
          </div>
      </div>

        <div id="wrapper">
            <div id="content">
                
                <div id="box">
                	<h3 id="adduser">Adicionar Usuário</h3>
                    <form id="form" action="newPaciente.php" method="post">
                      <fieldset id="personal">
                        <legend>Informações Pessoais</legend>
                        <label for="firstname">Nome: </label>
                        <input name="firstname" id="firstname" type="text" 
                        tabindex="1" required />
                        <br />
						<label for="lastname">Sobrenome: </label> 
                        <input name="lastname" id="lastname" type="text" tabindex="2" required />
                        <br />
						<label for="age">Idade: </label> 
                        <input name="age" id="age" type="number" tabindex="2" required />
                        <br />
                        <label for="email">E-mail : </label>
                        <input name="email" id="email" type="email" 
                        tabindex="3" />
                        <br />
						 <label for="cpf">CPF : </label>
						 <input type="text" name="cpf" id="cpf" maxlength="14" OnKeyPress="formatar('###.###.###-##', this)" tabindex="3" required />
                        <br />
                      </fieldset>
                      <fieldset id="address">
                        <legend>Endereço</legend>
                        <label for="street">Rua: </label> 
                        <input name="street" id="street" type="text" 
                        tabindex="4" required />
                        <br />						
						<label for="number">Número: </label> 
                        <input name="number" id="number" type="number" 
                        tabindex="5" required />
						<br />
						<label for="acompl">Complemento: </label> 
                        <input name="compl" id="compl" type="text" 
                        tabindex="4"  />
                        <br />
                        <label for="city">Cidade: </label>
                        <input name="city" id="city" type="text" 
                        tabindex="6" required />
                        <br />
                        <label for="state">Estado: </label>
                        <input name="state" id="state" type="text" 
                        tabindex="7" required />
                        <br />
						<label for="country">País: </label> 
                        <input name="country" id="country" type="text" 
                        tabindex="8" required />
                        <br />
                        <label for="cep">CEP: </label>
						<input type="text" name="cep" id="cep" maxlength="9" OnKeyPress="formatar('#####-###', this)" tabindex="9" required />
                        <br />
                        <label for="tel">Telefone : </label>
                        <input name="tel" id="tel" type="number" 
                        tabindex="10" required />
						<br />
						<label for="cel">Celular : </label>
                        <input name="cel" id="cel" type="number" 
                        tabindex="11" />
                      </fieldset>
                      <fieldset id="opt">
						<label for="idPaciente">ID Paciente: </label>
                        <input name="idPaciente" id="idPaciente" type="number" 
                        tabindex="12" required />
                        <br />
						<label for="escalaRankin">Escala Rankin: </label>
                        <input name="escalaRankin" id="escalaRankin" type="number" 
                        tabindex="12" min="1" max="5" required />
                        <br />
						<label for="diagnostico">Diagnóstico: </label>
                        <textarea name="diagnostico" id="diagnostico" rows="20" cols="100"
                        tabindex="12" required /></textarea>
                        <br />
						<label for="idFisio">ID Terapeuta: </label>
                        <input name="idFisio" id="idFisio" type="number" 
                        tabindex="12" required />
                        <br />
                      </fieldset>
                      <div align="center">
                      <input id="button1" type="submit" value="Adicionar" tabindex="14" /> 
                      <input id="button2" type="reset" value="Limpar" tabindex="15" />
                      </div>
                    </form>

                </div>
            </div>
            <div id="sidebar">
  				<ul>
                  <li><h3><a href="#" class="online">Navegação</a></h3>
          				<ul>
                            <li><a href="index.php" class="goback">Voltar</a></li>
                        </ul>
                    </li>
				</ul>       
          </div>
      </div>
        <div id="footer">
        <div id="credits">
   		Powered by <a href="http://facebook.com/lucas.argentim">Lucas Argentim</a>
        </div>
        <br />
        </div>
</div>
</body>
</html>
