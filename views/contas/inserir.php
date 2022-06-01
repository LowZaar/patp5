<div id="main-content" class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="title-5 m-b-20"><?= $this->title ?></h3>

                    <?php if (isset($this->modal_notification) && !empty($this->modal_notification)) { ?>
                        <div class="sufee-alert alert with-close alert-<?= $this->modal_notification[1] ?> alert-dismissible fade show">
                            <?= $this->modal_notification[0] ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    <?php } ?>

                    <div class="card">
                        <div class="card-header">
                            <strong>Nova conta</strong> Preencha todos os dados abaixo
                        </div>
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <input type="hidden" name="insere_usuario" value="1">
                            <div class="card-body card-block">
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class="form-control-label">Nome da Loja</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="text-input" name="nome_loja" class="form-control">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class="form-control-label">Responsável</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="text-input" name="responsavel_loja" class="form-control">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class="form-control-label">Previsão de lançamento</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="date" id="text-input" name="previsao_lancamento" class="form-control">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class="form-control-label">Tipo de Conta</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <div class="input-group">
                                            <select name="tipo" class="form-control" onchange="retornaPassosImplantacao(this)">
                                                <option selected disabled>Selecione um tipo</option>
                                                <?php foreach($this->tipos as $key => $tipo) { ?>
                                                    <option value="<?= $tipo['id'] ?>"><?= $tipo['nome'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class="form-control-label">Passos de Implantação</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <div class="input-group">
                                            <select multiple class="form-control selectMultiple" id="passos" name="passos[]" style="width: 100% !important;">    
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa fa-check"></i> Cadastrar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script>
    function retornaPassosImplantacao(element) {
        $('#passos').html('');
        $.ajax({
            url: '<?= HOME_URI ?>/contas/retorna-passos-implantacao',
            method: 'POST',
            data: {
                'tipo_conta': $(element).val() 
            },
            success: data => {
                let passos = JSON.parse(data);
                for (let i = 0; i < passos.length; i++) {
                    let passo = passos[i];
                    $('#passos').append(`<option value="${passo.id}">${passo.nome}</option>`)
                }
            },
            error: data => {
                console.log(data)
            }
        })
    }
</script>