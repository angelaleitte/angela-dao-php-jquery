<?php

 

   require_once "conexao.php";
   require_once "dao/UsuarioDaoMysql.php";

   $usuario = new UsuarioDaoMysql($pdo);

   //var_dump($usuario);
  

$id = filter_input(INPUT_GET, 'id');
if($id) {
    $user = $usuario->findId($id);
}



?>

<form method="POST" id="alterar">
        <input type="hidden" name="id" value="<?=$user->getId();?>" />
        <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="name" name="nome" value="<?=$user->getNome();?>" class="form-control" id="nome" aria-describedby="nomelHelp">
                    <small id="nomelHelp" class="form-text text-muted">Digite seu nome completo</small>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="<?=$user->getEmail();?>" class="form-control" id="email" aria-describedby="emailHelp">
                    <small id="emailHelp" class="form-text text-muted">exemplo@exemplo.com.br</small>
                </div>
               
                <button type="submit" class="btn btn-primary">Alterar</button>
            </form>


<script>
    $('#alterar').submit(function(e) {
                e.preventDefault();
                var formulario = $(this);
                var retorno = alterarFormulario(formulario)
            });

    function alterarFormulario(dados) {
                  $.ajax({
                      type:"POST",
                      data:dados.serialize(),
                      url:"alterar_ajax.php?id="+<?=$id?>,
                      async:false
                  }).done(function(data){
                      $sucesso = $.parseJSON(data)["sucesso"];
                      $mensagem = $.parseJSON(data)["mensagem"];
                      if($sucesso){
                         $('#mensagemAlterar').html($mensagem);
                      }else{
                         $('#mensagemAlterar').html($mensagem);
                      }
                  }).fail(function(){
                     $('#mensagemAlterar').html("Erro no sistema!");
                  }).always(function(){
                      $('#mensagemAlterar').show();
                  });
            }
</script>




