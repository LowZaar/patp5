<!DOCTYPE html>
<html lang="pt-BR">

<title>Cadastro</title>
<!-- css files -->
<link href="<?=HOME_URI?>/views/_css/stylelogin.css" rel="stylesheet" type="text/css" media="all">
<!-- online-fonts -->
<link href="//fonts.googleapis.com/css?family=Roboto+Slab:100,300,400,700Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900iSlabo+27px&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">
<body>
<!--header-->
<div class="agileheader">
    <h1>Novo usuario:</h1>
</div>
<!--main-->
<div class="main-w3l">
    <div class="w3layouts-main">
        <form action="<?=HOME_URI?>/cadastro/cadastrar" method="post">
            <input id='email' placeholder="E-mail" name="email" type="email" required/>
            <input id='password' placeholder="Senha" name="password" type="password" required/>
            <input id='nome' placeholder="Nome completo" name="nome" type="text" required />
            <input id='cpfcnpj' placeholder="CPF ou CNPJ" name="cpfcnpj" type="text" required/>
            <input id='endereco' placeholder="Endereço" name="endereco" type="text" required/>
            
            <!--<h6><a href="#">Esqueceu sua senha?</a></h6>-->
            <div class="clear"></div>
            <div id="errorlogin"></div>
            <input type="button" id="submitForm" value="Cadastrar-se">
        </form>
        <p>Já possui uma conta? <a href="/login">Logue-se!</a></p>
    </div>
</div>
<!--//main-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    //verifica cadastro
    $('#submitForm').click(function () {
        $("#errorlogin").html('')

        $.ajax({
            method: 'POST',
            url: "<?=HOME_URI?>/cadastro/cadastrar",
            data: {
                email: $('#email').val(),
                senha: $('#password').val(),
                nome: $('#nome').val(),
                cpfcnpj: $('#cpfcnpj').val(),
                endereco: $("#endereco").val()
            },
            success: function (data) {
                let result = JSON.parse(data);
                if (result.status === 'error') {
                    $("#errorlogin").html("<h4 style='color: white; background-color: #ff0000; padding: 1rem'>" + result.message + "</h4>")

                } else {
                    alert('Seu cadastro foi realizado com sucesso!')
                    window.location.replace('<?=HOME_URI?>/login')
                }
            }
        })
    })

</script>
</body>
</html>