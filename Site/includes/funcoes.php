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
                ).slice(0, 10); // Limita a 10 resultados

                exibirSugestoes(cidadesFiltradas, campoId);
            })
            .catch(error => {
                console.error("Erro ao buscar cidades:", error);
            });
    }

    // Função para exibir sugestões de cidades
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

    // Inicializar campo de cidade com autocomplete
    function inicializarCampoCidade(campoId) {
        const campoCidade = document.getElementById(campoId);
        const containerSugestoes = document.getElementById("sugestoes-" + campoId);

        if (!campoCidade) return;

        campoCidade.addEventListener("input", function() {
            buscarCidades(this.value, campoId);
        });

        // Fechar sugestões ao clicar fora
        document.addEventListener("click", function(e) {
            if (!campoCidade.contains(e.target) && !containerSugestoes.contains(e.target)) {
                containerSugestoes.style.display = "none";
            }
        });

        // Navegação por teclado nas sugestões
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

// Função para gerar o HTML do campo de cidade com autocomplete
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

?>