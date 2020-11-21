<?php
   require_once "conexao.php";
   require_once "dao/UsuarioDaoMysql.php";

   $usuario = new UsuarioDaoMysql($pdo);
   $lista = $usuario->findAll();




   //var_dump($lista);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-grid.min.css">
    <title>Dao</title>

    <style>
          h1 span a{font-size: 14px;}
    </style>
</head>
<body>
 
<div class="container">
        <h1>Lista de usuários  <span><a href="#" data-toggle="modal" data-target="#staticBackdrop">| Novo usuário</a></span></h1>
        
        <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">E-mail</th>
                <th scope="col">#</th>
                <th scope="col">#</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($lista as $dados): ?>
            <tr>
                <td><?= $dados->getId(); ?></td>
                <td><?= $dados->getNome(); ?></td>
                <td><?= $dados->getEmail(); ?></td>
                <td><a href="#" class="alterar" id="<?= $dados->getId(); ?>" data-id="<?= $dados->getId(); ?>"  data-toggle="modal" data-target="#staticBackdrop1"> Editar</a></td>
                <td><a href="#" class="excluir" id="<?= $dados->getId(); ?>" data-id="<?= $dados->getId(); ?>" >Excluir</td>     
            </tr>
            <?php endforeach; ?>
           
        </tbody>
        </table>
<div>




</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</html>

<!-- Modal -->
<div class="modal fade " id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Novo Usuário</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" id="gravar">
        <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="name" name="nome" class="form-control" id="nome" aria-describedby="nomelHelp">
                    <small id="nomelHelp" class="form-text text-muted">Digite seu nome completo</small>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name = "email" class="form-control" id="email" aria-describedby="emailHelp">
                    <small id="emailHelp" class="form-text text-muted">exemplo@exemplo.com.br</small>
                </div>

                <button type="submit" class="btn btn-primary">Gravar</button>
            </form>
      </div>
      <div class="modal-footer">
        <div id="mensagem"></div>
      </div>
    </div>
  </div>
</div>





<!-- Modal -->
<div class="modal fade " id="staticBackdrop1" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Alterar Usuário</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
           <div class="conteudo" id="conteudo"></div>
      
      </div>
      <div class="modal-footer">
        <div id="mensagemAlterar"></div>
      </div>
    </div>
  </div>
</div>



     <script>
           $('#gravar').submit(function(e){
               e.preventDefault();
               var formulario = $(this);
               var retorno = inserirFormulario(formulario);
               console.log(retorno);
           });

           function inserirFormulario(dados){
               $.ajax({
                   type: "POST",
                   data: dados.serialize(),
                   url: "adicionar.php",
                   async: false
               }).then(sucesso,falha);

               function sucesso(data){
                     //console.log(data);

                     $sucesso = $.parseJSON(data)["sucesso"];
                     $mensagem = $.parseJSON(data)["mensagem"];
                     $("#mensagem").show();

                     if($sucesso){
                         $("#mensagem").html($mensagem);
                     }else{
                         $("#mensagem").html($mensagem);
                     }
               }

               function falha(){
                 //console.log("erro");
               }
           }

           //alterar
            /*var item = document.querySelectorAll(".alterar");
            console.log(item.length);

            for(var i = 0; i < item.length; i++){
              console.log(item[i]);
              item[i].addEventListener('click', function(e){
                    e.preventDefault();
                    //alert("clicou");
                    var id = this.id;
                    //alert('alterar.php?id='+id);

                    $('.conteudo').load("alterar.php?id="+id);
              });
            }  */


            $('.alterar').click(function(e){
               e.preventDefault();
               var id = $(this).attr("id");
               //alert(id);
               
               //console.log(id);

                      $.ajax({
                          type:"POST",
                          data:"id=" + id,
                          url:"alterar.php",
                          async:false
                      }).done(function(data){
                          $('.conteudo').load("alterar.php?id="+id);
                          $sucesso = $.parseJSON(data)["sucesso"];
                          if($sucesso){
                             $("#mensagem").html($mensagem);
                          }else{
                              console.log("erro");
                          }
                      }).fail(function(){
                        console.log("erro no sitema");
                      }); 
           }); 



            $('.excluir').click(function(e){
               e.preventDefault();
               //console.log($(this).parent().parent());
               //$(this).parent().parent().fadeOut();
               var id = $(this).attr("id");
               //alert(id);
               var elemento = $(this).parent().parent();
               console.log(elemento);
              

               var ok=confirm("Deseja deletar o registro "+id+" ?");

               if(ok)
               //console.log(id);

                      $.ajax({
                          type:"POST",
                          data:"id=" + id,
                          url:"delete.php",
                          async:false
                      }).done(function(data){
                          $sucesso = $.parseJSON(data)["sucesso"];
                          if($sucesso){
                              $(elemento).fadeOut();  
                          }else{
                              console.log("erro");
                          }
                      }).fail(function(){
                        console.log("erro no sitema");
                      }); 
           });  
      </script>