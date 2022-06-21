<div id="main-content" class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="title-5 m-b-35">Configurações do calendário</h3>
                    
                    <div class="card">
                        <div class="card-header">
                            <strong>Edite os itens abaixo e clique em salvar!</strong>
                        </div>
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <input type="hidden" name="editar_usuario" value="1">
                            <div class="card-body card-block">
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="titulo" class=" form-control-label">Títulos de horários para visitantes</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <select name="titulo" id="titulo" class="form-control">
                                            <option value="1" <?= $configuracoes['titulo'] == '1' ? 'selected' : '' ?>>Ativar</option>
                                            <option value="0" <?= $configuracoes['titulo'] == '0' ? 'selected' : '' ?>>Desativar</option>
                                        </select>
                                    </div>
                                </div>
    
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="horario" class=" form-control-label">Horário Comercial</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <select name="horario" id="horario" class="form-control">
                                            <option value="1" <?= $configuracoes['horario'] == '1' ? 'selected' : '' ?>>Ativar</option>
                                            <option value="0" <?= $configuracoes['horario'] == '0' ? 'selected' : '' ?>>Desativar</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="fimDeSemana" class=" form-control-label">Exibir final de semana</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <select name="fimDeSemana" id="fimDeSemana" class="form-control">
                                            <option value="1" <?= $configuracoes['fimDeSemana'] == '1' ? 'selected' : '' ?>>Ativar</option>
                                            <option value="0" <?= $configuracoes['fimDeSemana'] == '0' ? 'selected' : '' ?>>Desativar</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <hr>
                                
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class="form-control-label">Cor dos horários ocupados</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="color" value="<?=$configuracoes['cor']?>" id="cor" name="cor" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="salvar-conf btn btn-primary btn-sm">
                                    <i class="fa fa-check"></i> Salvar
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
    $('.salvar-conf').click(function () {
        $.ajax({
            url: '<?=HOME_URI?>/configuracoes/editar',
            type: 'post',
            data: {
                cor: $('#cor').val(),
                titulo: $('#titulo').val(),
                fimDeSemana: $('#fimDeSemana').val(),
                horario: $('#horario').val()
            },
            success: function(response) {
                response = JSON.parse(response)
                
                showNotificatonModal(response.label, response.message, response.status)
            }
        })
    })
</script>