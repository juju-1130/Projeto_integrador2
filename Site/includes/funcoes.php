<?php
function gerarTituloPagina($titulo, $classeBg = 'bg-primary', $id = 'title') {
    $tituloSeguro = htmlspecialchars($titulo);
    $tituloSeguro = str_replace('&lt;br&gt;', '<br>', $tituloSeguro);
    $tituloSeguro = str_replace('&lt;br/&gt;', '<br>', $tituloSeguro);
    
    return '
    <section class="page-section ' . $classeBg . ' text-white mb-0" id="' . $id . '">
        <div class="container">
            <h5 class="page-section-heading text-uppercase text-white">' . $tituloSeguro . '</h5>
        </div>
    </section>';
}

function carregarAPICidades() {
    echo '
    <script>
    // Função para buscar cidades via API do IBGE
    function buscarCidades(query, campoId) {
        if (query.length < 3) {
            document.getElementById("sugestoes-" + campoId).style.display = "none";
            return;
        }

        fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/municipios?orderBy=nome`)
            .then(response => response.json())
            .then(data => {
                const cidadesFiltradas = data.filter(cidade => 
                    cidade.nome.toLowerCase().includes(query.toLowerCase())
                ).slice(0, 10);
                exibirSugestoes(cidadesFiltradas, campoId);
            })
            .catch(error => {
                console.error("Erro ao buscar cidades:", error);
            });
    }

    function exibirSugestoes(cidades, campoId) {
        const container = document.getElementById("sugestoes-" + campoId);
        container.innerHTML = "";

        if (cidades.length === 0) {
            container.style.display = "none";
            return;
        }

        cidades.forEach(cidade => {
            const item = document.createElement("button");
            item.type = "button";
            item.className = "list-group-item list-group-item-action";
            item.textContent = `${cidade.nome} - ${cidade.microrregiao.mesorregiao.UF.sigla}`;
            item.onclick = () => {
                document.getElementById(campoId).value = `${cidade.nome} - ${cidade.microrregiao.mesorregiao.UF.sigla}`;
                container.style.display = "none";
            };
            container.appendChild(item);
        });

        container.style.display = "block";
    }

    function inicializarCampoCidade(campoId) {
        const campoCidade = document.getElementById(campoId);
        const containerSugestoes = document.getElementById("sugestoes-" + campoId);

        if (!campoCidade) return;

        campoCidade.addEventListener("input", function() {
            buscarCidades(this.value, campoId);
        });

        document.addEventListener("click", function(e) {
            if (!campoCidade.contains(e.target) && !containerSugestoes.contains(e.target)) {
                containerSugestoes.style.display = "none";
            }
        });

        campoCidade.addEventListener("keydown", function(e) {
            const sugestoes = containerSugestoes.querySelectorAll(".list-group-item");
            const sugestaoAtiva = containerSugestoes.querySelector(".list-group-item.active");
            
            if (e.key === "ArrowDown") {
                e.preventDefault();
                if (!sugestaoAtiva) {
                    sugestoes[0]?.classList.add("active");
                } else {
                    const index = Array.from(sugestoes).indexOf(sugestaoAtiva);
                    sugestaoAtiva.classList.remove("active");
                    sugestoes[(index + 1) % sugestoes.length]?.classList.add("active");
                }
            } else if (e.key === "ArrowUp") {
                e.preventDefault();
                if (sugestaoAtiva) {
                    const index = Array.from(sugestoes).indexOf(sugestaoAtiva);
                    sugestaoAtiva.classList.remove("active");
                    const newIndex = index > 0 ? index - 1 : sugestoes.length - 1;
                    sugestoes[newIndex]?.classList.add("active");
                }
            } else if (e.key === "Enter" && sugestaoAtiva) {
                e.preventDefault();
                sugestaoAtiva.click();
            }
        });
    }

    // Estilos para as sugestões de cidades
    const estiloCidades = document.createElement("style");
    estiloCidades.textContent = `
        .list-group-item {
            border: none;
            border-bottom: 1px solid #dee2e6;
            cursor: pointer;
        }
        
        .list-group-item:hover,
        .list-group-item.active {
            background-color: #007bff;
            color: white;
        }
        
        .sugestoes-cidade {
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            z-index: 1050;
            max-height: 200px;
            overflow-y: auto;
        }
    `;
    document.head.appendChild(estiloCidades);
    </script>';
}

function gerarCampoCidade($id = 'cidade', $valor = '', $placeholder = 'Digite o nome da cidade...') {
    return '
    <div class="position-relative">
        <input type="text" name="cidade" id="' . $id . '" class="form-control" 
               value="' . htmlspecialchars($valor) . '" 
               placeholder="' . $placeholder . '" autocomplete="off">
        <div id="sugestoes-' . $id . '" class="list-group position-absolute w-100 sugestoes-cidade" style="display: none;"></div>
    </div>
    <script>document.addEventListener("DOMContentLoaded", function() { inicializarCampoCidade("' . $id . '"); });</script>';
}

// NOVAS FUNÇÕES PARA O ORÇAMENTO
function carregarFuncoesOrcamento() {
    echo '
    <script>
    // Funções para o modo rápido
    function habilitarModoRapido() {
        console.log("Ativando modo rápido...");
        
        document.getElementById("modo-rapido-banner").style.display = "block";
        document.getElementById("ajuste-geracao").style.display = "block";
        document.getElementById("modo_rapido").value = "1";
        
        atualizarCamposHidden();

        console.log("Campos do modo rápido:", {
            geracao_desejada: document.getElementById("geracao_desejada").value,
            margem_seguranca: document.getElementById("margem_seguranca").value,
            modo_rapido: document.getElementById("modo_rapido").value
        });
        
        // Adiciona ícones de edição a todos os campos
        adicionarIconesEdicao();
        
        // Destaca visualmente os campos
        document.querySelectorAll(".form-control, .form-select").forEach(campo => {
            campo.style.borderLeft = "4px solid #28a745";
            campo.style.backgroundColor = "#f8fff9";
        });
    }

    function atualizarCamposHidden() {
        const geracaoInput = document.getElementById("geracao_desejada");
        const margemSelect = document.getElementById("margem_seguranca");
        const geracaoHidden = document.getElementById("geracao_desejada_hidden");
        const margemHidden = document.getElementById("margem_seguranca_hidden");
        
        if (geracaoInput && geracaoHidden) {
            geracaoHidden.value = geracaoInput.value;
        }
        if (margemSelect && margemHidden) {
            margemHidden.value = margemSelect.value;
        }
    }

    function desabilitarModoRapido() {
        document.getElementById("modo-rapido-banner").style.display = "none";
        document.getElementById("ajuste-geracao").style.display = "none";
        document.getElementById("modo_rapido").value = "0";
        
        document.getElementById("geracao_desejada_hidden").value = "";
        document.getElementById("margem_seguranca_hidden").value = "";

        // Remove destaque dos campos
        document.querySelectorAll(".form-control, .form-select").forEach(campo => {
            campo.style.borderLeft = "";
            campo.style.backgroundColor = "";
        });
    }

    function adicionarIconesEdicao() {
        // Os ícones já estão no HTML, esta função é para garantir
        console.log("Modo rápido ativado - campos editáveis");
    }

    function destacarCampo(botao) {
        const campo = botao.closest(".mb-3").querySelector(".form-control, .form-select");
        campo.style.border = "2px solid #007bff";
        campo.style.backgroundColor = "#f0f8ff";
        campo.focus();
        
        // Remove o destaque após alguns segundos
        setTimeout(() => {
            if (document.getElementById("modo_rapido").value === "1") {
                campo.style.borderLeft = "4px solid #28a745";
                campo.style.backgroundColor = "#f8fff9";
            } else {
                campo.style.border = "";
                campo.style.backgroundColor = "";
            }
        }, 3000);
    }

    // Atualizar imagem do telhado
    function atualizarImagemTelhado() {
        const select = document.getElementById("telhado-select");
        const imagemContainer = document.getElementById("imagem-telhado");
        const selectedOption = select.options[select.selectedIndex];
        
        if (selectedOption.value && selectedOption.dataset.imagem) {
            const img = imagemContainer.querySelector("img");
            img.src = selectedOption.dataset.imagem;
            imagemContainer.style.display = "block";
        } else {
            imagemContainer.style.display = "none";
        }
    }

    // Bootstrap form validation
    function inicializarValidacaoFormulario() {
        "use strict";
        var forms = document.querySelectorAll(".needs-validation");
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener("submit", function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add("was-validated");
            }, false);
        });
    }

    // Inicializar todas as funções do orçamento
    function inicializarOrcamento() {
        console.log("Inicializando funções do orçamento...");
        
        // Inicializar imagem do telhado
        atualizarImagemTelhado();

        // Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll("[data-bs-toggle=\"tooltip\"]"));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Event listeners para campos do modo rápido
        const geracaoInput = document.getElementById("geracao_desejada");
        const margemSelect = document.getElementById("margem_seguranca");
        
        if (geracaoInput) {
            geracaoInput.addEventListener("input", function() {
                if (document.getElementById("modo_rapido").value === "1") {
                    atualizarCamposHidden();
                }
            });
        }
        
        if (margemSelect) {
            margemSelect.addEventListener("change", function() {
                if (document.getElementById("modo_rapido").value === "1") {
                    atualizarCamposHidden();
                }
            });
        }

        // Inicializar validação do formulário
        inicializarValidacaoFormulario();
    }

    // Executar quando DOM estiver pronto
    document.addEventListener("DOMContentLoaded", function() {
        inicializarOrcamento();
    });
    </script>';
}

// FUNÇÕES PARA O INDEX 
function carregarFuncoesIndex() {
    echo '
    <script>
    // Função para carregar e exibir projetos destacados
    function carregarProjetosDestacados() {
        const container = document.getElementById("projetos-destacados-container");
        const semProjetosMsg = document.getElementById("sem-projetos-destacados");
        
        if (!container) return;

        const projetosDestacados = JSON.parse(localStorage.getItem("projetosDestacados")) || [];

        container.innerHTML = "";

        if (projetosDestacados.length === 0) {
            if (semProjetosMsg) semProjetosMsg.style.display = "block";
            container.style.display = "none";
            return;
        }

        if (semProjetosMsg) semProjetosMsg.style.display = "none";
        container.style.display = "block";

        projetosDestacados.forEach((projeto, index) => {
            const isEven = index % 2 === 0;
            
            const projetoHTML = `
                <div class="project-card mb-5 p-4 rounded-3 bg-light">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-5 col-md-6 ${!isEven ? "order-lg-2 order-2" : ""}">
                            <img src="${projeto.imagem}" 
                                class="img-fluid rounded shadow projeto-img" 
                                alt="${projeto.titulo}">
                        </div>
                        <div class="col-lg-7 col-md-6 ${!isEven ? "order-lg-1 order-1" : ""}">
                            <div class="${isEven ? "ps-lg-4" : "pe-lg-4"}">
                                <h3 class="project-title mb-3">${projeto.titulo}</h3>
                                <div class="project-features">
                                    ${projeto.detalhes}
                                </div>
                                <div class="project-meta mt-3 small text-muted">
                                    ${projeto.meta}
                                </div>
                                <div class="mt-3">
                                    ${projeto.tags.join("")}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.innerHTML += projetoHTML;
        });
    }

    function verificarModais() {
        const urlParams = new URLSearchParams(window.location.search);
        
        if (urlParams.get("show_login") === "1") {
            const loginModal = new bootstrap.Modal(document.getElementById("loginModal"));
            loginModal.show();
        }
        
        if (urlParams.get("show_cadastro") === "1") {
            const cadastroModal = new bootstrap.Modal(document.getElementById("cadastrarModal"));
            cadastroModal.show();
        }
    }

    function limparURL() {
        if (window.location.search.includes("show_login") || window.location.search.includes("show_cadastro")) {
            history.replaceState({}, document.title, window.location.pathname);
        }
    }

    // Inicializar funções do index quando DOM estiver pronto
    document.addEventListener("DOMContentLoaded", function() {
        carregarProjetosDestacados();
        verificarModais();
        limparURL();
    });

    // Atualizar projetos quando localStorage mudar
    window.addEventListener("storage", function(e) {
        if (e.key === "projetosDestacados") {
            carregarProjetosDestacados();
        }
    });
    </script>';
}

// FUNÇÕES PARA GERENCIAMENTO DE PROJETOS
function carregarFuncoesProjetos() {
    echo '
    <script>
    function destacarProjeto(button, projetoId) {
        if (!projetoId) {
            alert("Erro: ID do projeto não encontrado");
            return;
        }

        const card = button.closest(".project-card");
        const projetoData = {
            id: projetoId,
            titulo: card.querySelector(".project-title")?.innerText,
            imagem: card.querySelector("img")?.getAttribute("src"),
            detalhes: card.querySelector(".project-features")?.innerHTML,
            meta: card.querySelector(".project-meta")?.innerHTML,
            tags: Array.from(card.querySelectorAll(".badge")).map(tag => tag.outerHTML),
            timestamp: new Date().getTime() // Adiciona timestamp para controle
        };

        if (!projetoData.titulo || !projetoData.imagem) {
            alert("Erro: Dados do projeto incompletos");
            return;
        }

        const projetosDestacados = JSON.parse(localStorage.getItem("projetosDestacados")) || [];
        
        // Verifica se o projeto já está destacado
        const jaDestacadoIndex = projetosDestacados.findIndex(proj => proj.id === projetoId);
        if (jaDestacadoIndex !== -1) {
            alert("Este projeto já está em destaque!");
            return;
        }

        const LIMITE = 2;
        
        // Se já atingiu o limite, remove o mais antigo (primeiro da array)
        if (projetosDestacados.length >= LIMITE) {
            const projetoRemovido = projetosDestacados.shift(); // Remove o primeiro (mais antigo)
            console.log("Projeto removido dos destacados:", projetoRemovido.titulo);
        }

        // Adiciona o novo projeto no final (mais recente)
        projetosDestacados.push(projetoData);
        localStorage.setItem("projetosDestacados", JSON.stringify(projetosDestacados));
        
        alert("Projeto destacado com sucesso!");
    }

    function removerProjetoDestacado(projetoId) {
        const projetosDestacados = JSON.parse(localStorage.getItem("projetosDestacados")) || [];
        const novosProjetos = projetosDestacados.filter(proj => proj.id !== projetoId);
        localStorage.setItem("projetosDestacados", JSON.stringify(novosProjetos));
        alert("Projeto removido dos destacados!");
        location.reload(); 
    }

    // Função para inicializar tooltips e outros elementos dos projetos
    function inicializarProjetos() {
        // Tooltips para botões de ação
        var tooltipTriggerList = [].slice.call(document.querySelectorAll("[data-bs-toggle=\"tooltip\"]"));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        console.log("Funções de projetos inicializadas");
    }

    // Executar quando DOM estiver pronto
    document.addEventListener("DOMContentLoaded", function() {
        inicializarProjetos();
    });
    </script>';
}

?>