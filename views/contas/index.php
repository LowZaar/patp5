<div id="main-content" class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12 m-b-20">
                    <div class="overview-wrap">
                        <h3 class="title-3">Contas</h3>
                        <div class="filter">
                            <div>
                                <label>Tipo de conta: </label>
                                <select id="select-tipo">
                                    <option value="4">Todos</option>
                                    <option value="1">Delivery</option>
                                    <option value="2">E-Commerce</option>
                                    <option value="3">Delivery e E-commerce</option>
                                </select>
                            </div>
                            <div>
                                <label>Implantação: </label>
                                <select id="select-implantacao">
                                    <option value="4">Todos</option>
                                    <option value="1">Implantado <i class="fa fa-cloud"></i></option>
                                    <option value="2">Não implantado <i class="fa fa-file"></i></option>
                                    <option value="3">Em implantação <i class="fa fa-bug"></i></option>
                                </select>
                            </div>
                        
                            <a href="<?= HOME_URI . '/contas/inserir' ?>" class="au-btn au-btn--small au-btn-icon au-btn--green">
                                <i class="fa fa-plus"></i>Inserir
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 m-b-20" id="lista-contas">
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="editConta" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Conta</h5></p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="." method="post" class="form-horizontal" id="form-passos">
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="nome-loja" class="form-control-label">Nome</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" class="form-control" id="nome-loja">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="responsavel-loja" class="form-control-label">Responsavel da loja</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" class="form-control" id="responsavel-loja">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="previsao-lancamento" class="form-control-label">Previsão de lançamento</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="date" id="previsao-lancamento" name="fim" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="implantado" class="form-control-label">Implantação</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <select name="status" id="implantado" class="form-control">
                                <option value="">Status da Implantação</option>
                                <option value="1">Implantado</option>
                                <option value="2" selected>Não Implantado</option>
                                <option value="3" selected>Em Implantação</option>
                            </select>
                        </div>
                        <input type="hidden" id="id-conta-edita">
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelar-edicao">Cancelar</button>
                <button type="button" class="btn btn-success" onclick="editarConta()">Salvar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Passos</h5></p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="." method="post" class="form-horizontal" id="form-passos">
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="passo" class="form-control-label">Passo</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <select name="id_tipo" id="passo" class="form-control">
                                <!-- <?php foreach($this->tipos as $key => $tipo) {?>
                                    <option value="<?=$tipo['id']?>" data-tempo="<?=$tipo['previsao_de_dias']?>"><?=$tipo['nome']?></option>
                                <?php } ?> -->
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="data-inicio" class=" form-control-label">Data Inicial</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="date" id="data-inicio" name="inicio" class="form-control">
                            <span class="help-block">Data de início do período.</span>
                        </div>
                    </div>
                    <div class="row form-group ocultavel" id="div-data-fim" style="height: 0px;">
                        <div class="col col-md-3">
                            <label for="data-fim" class=" form-control-label">Data Final</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="date" id="data-fim" name="fim" class="form-control">
                            <span class="help-block">Data de termino do período.</span>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="status-passo" class="form-control-label">Status</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <select name="status" id="status" class="form-control">
                                <option value="1">Concluído</option>
                                <option value="2" selected>Não Concluído</option>
                            </select>
                        </div>
                        <input type="hidden" id="id_conta_passos" name="id_conta">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelarPassos" onclick="limpaModalPassos()">Cancelar</button>
                <button type="button" class="btn btn-success" onclick="atualizaPassos()">Salvar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="historicoModal" tabindex="-1" role="dialog" aria-labelledby="historicoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="historicoModalLabel">Histórico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeTabs()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        <strong>Adicionar</strong> entrada
                        <button onclick="exibeFormulario(this)" data-show="false" id="show-form-history"><i class="fa fa-chevron-down"></i></button>
                    </div>
                    <div class="card-body card-block hidden" id="card-form-body">
                        <form action="" method="post" class="form-horizontal">
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="conteudo" class=" form-control-label">Conteúdo</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <textarea id="conteudo" name="conteudo" placeholder="O cliente relatou..." class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="anexo" class=" form-control-label">Anexo</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="file" id="file" name="anexo" placeholder="Arraste um arquivo aqui" class="form-control" style="padding: .300rem .50rem;">
                                    <span class="help-block">Adicione uma imagem ou arquivo de áudio</span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer hidden" id="card-form-footer">
                        <button type="submit" class="btn btn-success btn-sm" onclick="salvaHistorico(this)" id="bt-salva-historico">
                            <i class="fa fa-check-circle"></i> Salvar
                        </button>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <strong>Ver</strong> entradas
                        <button onclick="exibeEntradas(this)" data-show="false" id="show-entries-history"><i class="fa fa-chevron-down"></i></button>
                    </div>
                    <div class="card-body card-block hidden" id="card-entries-body"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="closeTabs()">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(() => {
        let imp = 4;
        let tipo = 4;
        try {
            imp_ls = localStorage.getItem('status-implantacao');
            if (imp_ls != null) {
                imp = imp_ls
                $('#select-implantacao').val(imp);
            }
            tipo_ls = localStorage.getItem('tipo-conta');
            if (tipo_ls != null) {
                tipo = tipo_ls
                $('#select-tipo').val(tipo);
            }
        } catch (error) {
            console.log(error)
        }
        buscaContas(imp, tipo);
    });

    $('#select-implantacao').change(() => {
        defineBuscaContas();
    });

    $('#select-tipo').change(() => {
        defineBuscaContas();
    });

    function defineBuscaContas() {
        let imp = $('#select-implantacao').val()
        let tipo = $('#select-tipo').val();
        console.log(imp, tipo)
        try {
            localStorage.setItem('status-implantacao', imp);
            localStorage.setItem('tipo-conta', tipo);
        } catch (error) {
            console.log(error)
        }
        buscaContas(imp, tipo);
    }

    function buscaContas(imp, tipo) {
        $.ajax({
            url: '<?= HOME_URI ?>/contas/retorna-contas',
            method: 'post',
            data: {
                'implantacao': imp,
                'tipo' : tipo
            },
            success: data => {
                let contas = JSON.parse(data);
                console.log(contas);
                $('#lista-contas').html('');
                for (let i = 0; i < contas.length; i++) {
                    let conta = contas[i];
                    let itens = conta.ut_implantacao;
                    let icone = ''
                    switch (conta.implantado) {
                        case '1':
                            icone = 'fa fa-cloud';
                            break;
                        case '2':
                            icone = 'fa fa-file-text';
                            break;
                        case '3':
                            icone = 'fa fa-bug';
                            break;
                    }
                    let itens_string = '';
                    for (let i = 0; i < itens.length; i++) {
                        let classes = '';
                        let item = itens[i];
                        switch (item.status) {
                            case '1':
                                classes = 'fa fa-check-circle success';
                                break;
                            case '2':
                                classes = 'fa fa-times-circle failed';
                                break;
                            case '3':
                                classes = 'fa fa-exclamation-circle warning';
                                break;
                        }
                        itens_string += `<div class="flex-item">
                                            <i class="fa ${classes}"></i><br />
                                            ${item.nome}<br />
                                            <small>
                                                ${item.inicio}<br />
                                                ${item.status == 1 ? item.fim : '' }
                                            </small>
                                        </div>`
                    }
                    let str = `<div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <strong style="color: #000;">${conta.nome_loja}</strong> - ${conta.nome_tipo} <i class="${icone}"></i>
                                        </div>
                                        <div class="card-body">
                                            <div class="flex-container">
                                                ${itens_string}
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#editConta" data-conta="${conta.id}" data-select="passos" data-tipo-conta="${conta.tipo}" data-apenas-conta="false" onclick="setInputValues(this); retornaConta(this); retornaPassosImplantacao(this);">Editar Conta</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#editModal" data-conta="${conta.id}" data-select="passo" data-tipo-conta="${conta.tipo}" data-apenas-conta="true" onclick="setInputValues(this); retornaPassosImplantacao(this);">Editar Passos</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#historicoModal" data-conta="${conta.id}" data-nome="${conta.nome}" onclick="buscaHistoricoConta(this)">Histórico</button>
                                        </div>
                                    </div>
                                </div>`;
                    $('#lista-contas').append(str);
                }
            },
            error: data => {
                console.log(data)
                $('#lista-contas').html(`<div class="card"><div class="card-body">${data.responseText}</div></div>`)
            }
        })
    }

    function buscaHistoricoConta(element) {
        let id = $(element).data('conta');
        let nome = $(element).data('nome');
        $('#bt-salva-historico').data('conta', id);
        $.ajax({
            url: '<?= HOME_URI ?>/contas/retorna-historico',
            method: 'post',
            data: {
                'id': id
            },
            success: data => {
                let entradas = JSON.parse(data);
                console.log(entradas);
                $('#card-entries-body').html('');
                for (let i = 0; i < entradas.length; i++) {
                    let entrada = entradas[i];
                    let body = '';
                    if (entrada.anexo == 1) {
                        body = `<div class="media">
                                    <img class="mx-50 d-block" src="${entrada.arquivo}" alt="Arquivo do Histórico" style="max-width: 50%;border-radius: 2%;height: auto;margin-right: 1rem;">
                                    <div class="media-body">
                                        ${entrada.texto}
                                    </div>
                                </div>`;
                    } else if (entrada.anexo == 2) {
                        console.log(nome)
                        body = `<div class="media">
                                    <div class="player">
                                        <div class="controls" style="justify-content:space-between;">
                                            <button id="play-audio-${i}" data-play="false">
                                                <i class="fa fa-play"></i>
                                            </button>

                                            <div id="tempo-audio-${i}">0:00</div>

                                            <input type="range" id="range-audio-${i}" value="0" style="width:60%;">

                                            <div id="duracao-audio-${i}">0:00</div>
                                        </div>

                                        <div class="controls">
                                            <button id="mute-audio-${i}" data-mute="false" style="margin-right:1rem;">
                                                <i class="fa fa-volume-up"></i>
                                            </button>

                                            <input type="range" id="range-volume-${i}" value="100">

                                            <button id="download-audio-${i}" style="margin-left:1rem;" data-src="${entrada.arquivo}" data-nome="Registro de áudio - ${nome} - ${i}">
                                                <i class="fa fa-download"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <audio style="margin-rigth:1rem;" preload=”metadata” src="${entrada.arquivo}" id="audio-file-${i}"></audio>
                                    
                                    <div class="media-body">
                                        ${entrada.texto}
                                    </div>
                                </div>`;
                    } else {
                        body = `<div class="media">
                                    <div class="media-body">
                                        ${entrada.texto}
                                    </div>
                                </div>`;
                    }
                    $('#card-entries-body').append(`
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-user"></i>
                                <strong class="card-title pl-2">${entrada.nome}</strong>
                            </div>
                            <div class="card-body">
                                ${body}
                                <hr>
                                <div class="card-text text-sm-left">
                                   Data de Registro: ${entrada.data_formatada}
                                </div>
                            </div>
                        </div>
                    `);

                    if (entrada.anexo == 2) {
                        const audio = document.getElementById('audio-file-'+i);
                        const durationContainer = document.getElementById(`duracao-audio-${i}`);

                        const calculateTime = (secs) => {
                            const minutes = Math.floor(secs / 60);
                            const seconds = Math.floor(secs % 60);
                            const returnedSeconds = seconds < 10 ? `0${seconds}` : `${seconds}`;
                            return `${minutes}:${returnedSeconds}`;
                        }

                        const displayDuration = () => {
                            durationContainer.innerHTML = calculateTime(audio.duration);
                        }

                        if (audio.readyState > 0) {
                            displayDuration();
                        } else {
                            audio.addEventListener('loadedmetadata', () => {
                                displayDuration();
                            });
                        }

                        const seekSlider = document.getElementById(`range-audio-${i}`);

                        const setSliderMax = () => {
                            seekSlider.max = Math.floor(audio.duration);
                        }

                        if (audio.readyState > 0) {
                            displayDuration();
                            setSliderMax();
                        } else {
                            audio.addEventListener('loadedmetadata', () => {
                                displayDuration();
                                setSliderMax();
                            });
                        }

                        $('#play-audio-'+i).click((data)=> {
                            let play = $('#play-audio-'+i).data('play');

                            if (play == false) {
                                audio.play();
                                $('#play-audio-'+i).data('play', true);
                                $('#play-audio-'+i).html('<i class="fa fa-pause"></i>')
                            } else {
                                audio.pause();
                                $('#play-audio-'+i).data('play', false);
                                $('#play-audio-'+i).html('<i class="fa fa-play"></i>')
                            }
                        })

                        $('#mute-audio-'+i).click((data) => {
                            let mute = $('#mute-audio-'+i).data('mute');
                            if (mute == true) {
                                $('#mute-audio-'+i).data('mute', false);
                                $('#mute-audio-'+i).html('<i class="fa fa-volume-off"></i>')
                                audio.muted = false;
                            } else {
                                $('#mute-audio-'+i).data('mute', true);
                                $('#mute-audio-'+i).html('<i class="fa fa-volume-off"></i>')
                                audio.muted = true;
                            }
                        })

                        seekSlider.addEventListener('change', () => {
                            audio.currentTime = seekSlider.value;
                        });

                        audio.addEventListener('timeupdate', () => {
                            seekSlider.value = Math.floor(audio.currentTime);
                            const minutes = Math.floor(audio.currentTime / 60);
                            const seconds = Math.floor(audio.currentTime % 60);
                            const returnedSeconds = seconds < 10 ? `0${seconds}` : `${seconds}`;
                            $('#tempo-audio-'+i).html(minutes +":"+ returnedSeconds);
                        });

                        const volumeSlider = document.getElementById('range-volume-'+i);

                        volumeSlider.addEventListener('input', (e) => {
                            const value = e.target.value;
                            audio.volume = value / 100;
                        });

                        $('#download-audio-'+i).click(() => {
                            let fileUrl = $('#download-audio-'+i).data('src')
                            let fileName = $('#download-audio-'+i).data('nome')
                            var a = document.createElement("a");
                            a.href = fileUrl;
                            a.setAttribute("download", fileName);
                            a.click();
                        });
                    }
                }
            },
            error: data => {
                console.log(data);
            }
        });
    }

    function exibeFormulario(element) {
        let show = $(element).data('show');
        if (show == 'true') {
            $(element).data('show', 'false');
            $(element).html('<i class="fa fa-chevron-down"></i>');
            $('#card-form-body').addClass('hidden');
            $('#card-form-footer').addClass('hidden');
        } else {
            $(element).data('show', 'true');
            $(element).html('<i class="fa fa-chevron-up"></i>');
            $('#card-form-body').removeClass('hidden');
            $('#card-form-footer').removeClass('hidden');
        }
    }

    function exibeEntradas(element) {
        let show = $(element).data('show');
        if (show == 'true') {
            $(element).data('show', 'false');
            $(element).html('<i class="fa fa-chevron-down"></i>');
            $('#card-entries-body').addClass('hidden');
        } else {
            $(element).data('show', 'true');
            $(element).html('<i class="fa fa-chevron-up"></i>');
            $('#card-entries-body').removeClass('hidden');
        }
    }

    function closeTabs() {
        setTimeout(() => {
            let form = $('#show-form-history');
            $(form).data('show', 'false');
            $(form).html('<i class="fa fa-chevron-down"></i>');
            $('#card-form-body').addClass('hidden');
            $('#card-form-footer').addClass('hidden');

            let list = $('#show-entries-history');
            $(list).data('show', 'false');
            $(list).html('<i class="fa fa-chevron-down"></i>');
            $('#card-entries-body').addClass('hidden');
        }, 5)
    }

    function getBase64(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = error => reject(error);
        });
    }

    function salvaHistorico(element) {
        let id_conta = $(element).data('conta')
        let fd = new FormData();
        let files = $('#file')[0].files;
        if (files.length > 0) {
            let arquivo = '';
            getBase64(files[0]).then(
                data => {
                    arquivo = data;
                    $.ajax({
                        url: `<?=HOME_URI?>/contas/salva-historico`,
                        method: 'post',
                        data: {
                            'arquivo': arquivo,
                            'conteudo': $('#conteudo').val(),
                            'id_conta': id_conta
                        },
                        success: function (data) {
                            buscaHistoricoConta(element);
                            let files = $('#file').val('');
                            $('#conteudo').val('');
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                }
            );
        } else {
            $.ajax({
                url: `<?=HOME_URI?>/contas/salva-historico`,
                method: 'post',
                data: {
                    'foto': 'false',
                    'conteudo': $('#conteudo').val(),
                    'id_conta': id_conta
                },
                success: function (data) {
                    buscaHistoricoConta(element)
                    let files = $('#file').val('');
                    $('#conteudo').val('');
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
    }

    function setInputValues(element) {
        let conta = $(element).data('conta');
        $('#id_conta_passos').val(conta);
        $('#id-conta-edita').val(conta);
    }

    function editarConta() {
        let nome = $('#nome-loja').val();
        let responsavel = $('#responsavel-loja').val();
        let previsao = $('#previsao-lancamento').val();
        let implantado = $('#implantado').val();
        let id = $('#id-conta-edita').val();
        let passos = $('#passos').val();

        $.ajax({
            url: '<?=HOME_URI?>/contas/editar-conta',
            method: 'post',
            data: {
                'id': id,
                'nome_loja': nome,
                'responsavel_loja': responsavel,
                'previsao_lancamento': previsao,
                'implantado': implantado,
                'passos': passos
            },
            success: data => {
                console.log(data);
                showNotificatonModal('Sucesso', 'Conta atualizada com sucesso', 'success');
                defineBuscaContas();
                $('#cancelar-edicao').click();
            },
            error: data => {
                showNotificatonModal('Erro', 'Erro ao atulizar os dados da conta', 'error');
            }
        })
    }

    function retornaConta(element) {
        let id = $(element).data('conta');
        $.ajax({
            url: '<?=HOME_URI?>/contas/retorna-conta',
            method: 'post',
            data: {
                'id': id
            },
            success: data => {
                let conta = JSON.parse(data);
                $('#nome-loja').val(conta.nome_loja);
                $('#responsavel-loja').val(conta.responsavel_loja);
                $('#previsao-lancamento').val(conta.previsao_lancamento);
                $('#implantado').val(conta.implantado)
            },
            error: data => {
                showNotificatonModal('Erro', 'Conta não encontrada', 'error');
            }
        })
    }

    function atualizaPassos() {
        let passo = $('#passo').val();
        let inicio = $('#data-inicio').val();
        let fim = $('#data-fim').val();
        let status = $('#status').val();
        let id = $('#id_conta_passos').val();

        if (passo == null) {
            showNotificatonModal('Aviso', 'Selecione o passo de implantação que deseja editar', 'warning');
            return;
        }

        $.ajax({
            url: '<?=HOME_URI?>/contas/atualiza-passos',
            method: 'post',
            data: {
                'id': id,
                'inicio': inicio,
                'fim': fim,
                'id_tipo': passo,
                'status': status
            },
            success: data => {
                console.log(data);
                showNotificatonModal('Sucesso', 'Passo de impantação atualizado com sucesso', 'success');
                defineBuscaContas();
                $('#cancelarPassos').click();
                limpaModalPassos()
            },
            error: data => {
                console.log(data);
                showNotificatonModal('Erro', data.responseText, 'error');
            }
        })
    }

    function limpaModalPassos() {
        $('#data-inicio').val('');
        $('#data-fim').val('');
        $('#status').val(2);
    }

    function retornaPassosImplantacao(element) {
        $('#passos').html('');
        $.ajax({
            url: '<?= HOME_URI ?>/contas/retorna-passos-implantacao',
            method: 'POST',
            data: {
                'tipo_conta': $(element).data('tipo-conta'),
                'id_conta': $(element).data('conta'),
                'apenas_conta': $(element).data('apenas-conta')
            },
            success: data => {
                let passos = JSON.parse(data);
                console.log(passos);
                if ($(element).data('select') == 'passo') {
                    $('#passo').html('')
                    $('#passo').append('<option selected disabled value="false">Passos da Implantação</option>');
                }
                for (let i = 0; i < passos.length; i++) {
                    let passo = passos[i];
                    if ($(element).data('select') == 'passos') {
                        $('#passos').append(`<option value="${passo.id}" ${passo.selected == 1 ? 'selected' : ''}>${passo.nome}</option>`)
                    } else {
                        $('#passo').append(`<option value="${passo.id}">${passo.nome}</option>`)
                    }
                }
            },
            error: data => {
                console.log(data)
            }
        })
    }

    $('#status').change(() => {
        let status = $('#status').val();
        let tam = '64px'; 
        if (innerWidth < 768) {
            tam = '98px';
        }
        if (status == 1) {
            $('#div-data-fim').css('height', tam);
        } else {
            $('#div-data-fim').css('height', '0px');
            $('#data-fim').val('');
        }
    })
</script>