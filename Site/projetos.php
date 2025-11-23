<?php
session_start();
require 'conexao.php';

$is_admin = isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 1;

function buscarProjetos($conn) {
    $sql = "SELECT p.*, 
                   pl.marca_placa, pl.potencia_placa,
                   i.marca_inversor, i.potencia_inversor
            FROM projeto p
            LEFT JOIN Placa pl ON p.placa_id = pl.placa_id
            LEFT JOIN Inversor i ON p.inversor_id = i.inversor_id
            ORDER BY p.conclusao DESC";
    
    $result = $conn->query($sql);
    $projetos = [];
    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $projetos[] = [
                'id' => $row['projeto_id'],
                'titulo' => $row['titulo'],
                'cidade' => $row['cidade'],
                'quantidade_placas' => $row['quantidade_placas'],
                'marca_placa' => $row['marca_placa'],
                'potencia_placa' => $row['potencia_placa'],
                'marca_inversor' => $row['marca_inversor'],
                'potencia_inversor' => $row['potencia_inversor'],
                'economia' => $row['economia'],
                'conclusao' => $row['conclusao'],
                'tipo' => $row['tipo'],
                'caracteristica' => $row['caracteristica'],
                'imagem' => $row['imagem'] ? 'admin_php/uploads/projetos/' . $row['imagem'] : 'https://via.placeholder.com/600x400/007bff/ffffff?text=Sem+Imagem'            ];
        }
    }
    return $projetos;
}

$projetos = buscarProjetos($conn);
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <?php include __DIR__ . '/head.php'; ?>
    <body id="page-top">
        <?php 
            $pagina_parametros = [
                'projetos.php' => $is_admin ? ['editar_dados'] : [],
            ];
            include __DIR__ . '/includes/navbar.php';
        ?>
        <!--Seção titulo-->
        <?php include __DIR__ . '/includes/funcoes.php'; ?>
        <?php echo gerarTituloPagina($is_admin ? "Gerenciar Projetos" : "Projetos Concluídos"); ?>

        <?php if ($is_admin): ?>
        <div class="container">
            <div class="d-flex justify-content-end mb-4">
                <a href="projetos.php?modal=novo" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i> Novo Projeto
                </a>
            </div>
        </div>
        <?php endif; ?>

        <!-- Seção de projetos-->
        <section class="page-section projects" id="projects">
            <div class="container">
                <?php if (empty($projetos)): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-solar-panel fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Nenhum projeto encontrado</h4>
                        <p class="text-muted">Não há projetos cadastrados no momento.</p>
                        
                        <?php if ($is_admin): ?>
                        <div class="mt-4">
                            <a href="projetos.php?modal=novo" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus me-2"></i> Criar Primeiro Projeto
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <?php foreach ($projetos as $projeto): ?>
                        <div class="project-card mb-5 p-4 rounded-3 bg-light">
                            <div class="row align-items-center g-4">
                                <div class="col-lg-5 col-md-6">
                                    <img src="<?php echo $projeto['imagem']; ?>" 
                                         class="img-fluid rounded shadow projeto-img" 
                                         alt="<?php echo htmlspecialchars($projeto['titulo']); ?>">
                                </div>
                                <div class="col-lg-7 col-md-6">
                                    <div class="ps-lg-4">
                                        <h3 class="project-title mb-3"><?php echo htmlspecialchars($projeto['titulo']); ?></h3>
                                        <ul class="project-features list-unstyled">
                                            <li class="mb-2">
                                                <i class="fas fa-map-marker-alt text-primary me-2"></i> 
                                                <?php echo htmlspecialchars($projeto['cidade']); ?>
                                            </li>
                                            <li class="mb-2">
                                                <i class="fas fa-solar-panel text-primary me-2"></i> 
                                                <?php echo $projeto['quantidade_placas']; ?> módulos de <?php echo $projeto['potencia_placa']; ?>W
                                                <?php if ($projeto['marca_placa']): ?>
                                                    (<?php echo htmlspecialchars($projeto['marca_placa']); ?>)
                                                <?php endif; ?>
                                            </li>
                                            <li class="mb-2">
                                                <i class="fas fa-bolt text-primary me-2"></i> 
                                                Inversor <?php echo htmlspecialchars($projeto['marca_inversor']); ?> de <?php echo $projeto['potencia_inversor']; ?>kW
                                            </li>
                                            <li class="mb-2">
                                                <i class="fas fa-battery-three-quarters text-primary me-2"></i> 
                                                Economia: R$ <?php echo number_format($projeto['economia'], 2, ',', '.'); ?>/mês
                                            </li>
                                        </ul>
                                        <div class="project-meta mt-3 small text-muted">
                                            <span class="me-3">
                                                <i class="far fa-calendar-alt me-1"></i> 
                                                Concluído: <?php echo date('M/Y', strtotime($projeto['conclusao'])); ?>
                                            </span>
                                        </div>
                                        <div class="mt-3">
                                            <?php 
                                            $badgeClass = ($projeto['tipo'] == 'Residencial') ? 'bg-primary' : 'bg-success';
                                            ?>
                                            <span class="badge <?php echo $badgeClass; ?> me-2">
                                                <?php echo htmlspecialchars($projeto['tipo']); ?>
                                            </span>
                                            <?php if ($projeto['caracteristica']): ?>
                                                <span class="badge bg-success">
                                                    <?php echo htmlspecialchars($projeto['caracteristica']); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <?php if ($is_admin): ?>
                                        <!-- Botões de ação (apenas para admin) -->
                                        <div class="mt-4">
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-outline-warning btn-sm" 
                                                        onclick="destacarProjeto(this, <?php echo $projeto['id']; ?>)" 
                                                        title="Destacar projeto">
                                                    <i class="fas fa-star me-1"></i> Destacar
                                                </button>                     
                                                <a href="projetos.php?modal=editar_projeto&id=<?php echo $projeto['id']; ?>" 
                                                    class="btn btn-warning btn-sm">Editar</a>
                                                <a href="projetos.php?modal=excluir_projeto&id=<?php echo $projeto['id']; ?>" 
                                                   class="btn btn-danger btn-sm">Excluir</a>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
        <!-- End section projetos-->
        
        <!-- Footer-->
        <?php include __DIR__ . '/includes/footer.php'; ?>
        
        <script>
        function destacarProjeto(button, projetoId) {
            if (!projetoId) {
                alert('Erro: ID do projeto não encontrado');
                return;
            }

            const card = button.closest('.project-card');
            const projetoData = {
                id: projetoId,
                titulo: card.querySelector('.project-title')?.innerText,
                imagem: card.querySelector('img')?.getAttribute('src'),
                detalhes: card.querySelector('.project-features')?.innerHTML,
                meta: card.querySelector('.project-meta')?.innerHTML,
                tags: Array.from(card.querySelectorAll('.badge')).map(tag => tag.outerHTML),
                timestamp: new Date().getTime() // Adiciona timestamp para controle
            };

            if (!projetoData.titulo || !projetoData.imagem) {
                alert('Erro: Dados do projeto incompletos');
                return;
            }

            const projetosDestacados = JSON.parse(localStorage.getItem('projetosDestacados')) || [];
            
            // Verifica se o projeto já está destacado
            const jaDestacadoIndex = projetosDestacados.findIndex(proj => proj.id === projetoId);
            if (jaDestacadoIndex !== -1) {
                alert('Este projeto já está em destaque!');
                return;
            }

            const LIMITE = 2;
            
            // Se já atingiu o limite, remove o mais antigo (primeiro da array)
            if (projetosDestacados.length >= LIMITE) {
                const projetoRemovido = projetosDestacados.shift(); // Remove o primeiro (mais antigo)
                console.log('Projeto removido dos destacados:', projetoRemovido.titulo);
            }

            // Adiciona o novo projeto no final (mais recente)
            projetosDestacados.push(projetoData);
            localStorage.setItem('projetosDestacados', JSON.stringify(projetosDestacados));
            
            alert('Projeto destacado com sucesso!');
        }

        function removerProjetoDestacado(projetoId) {
            const projetosDestacados = JSON.parse(localStorage.getItem('projetosDestacados')) || [];
            const novosProjetos = projetosDestacados.filter(proj => proj.id !== projetoId);
            localStorage.setItem('projetosDestacados', JSON.stringify(novosProjetos));
            alert('Projeto removido dos destacados!');
            location.reload(); 
        }
        </script>

        <!-- Modal para ações do admin -->
        <?php if (isset($_GET['modal'])): ?>
        <?php
            $modal_type = $_GET['modal'];
            $iframe_src = '';
            
            switch($modal_type) {
                case 'novo':
                    $iframe_src = 'admin_php/crud_projeto/novo_projeto.php';
                    break;
                case 'editar_projeto':
                    $iframe_src = 'admin_php/crud_projeto/editar_projeto.php?id=' . ($_GET['id'] ?? '');
                    break;
                case 'excluir_projeto':
                    $iframe_src = 'admin_php/crud_projeto/excluir_projeto.php?id=' . ($_GET['id'] ?? '');
                    break;
                default:
                    $iframe_src = 'editar_iframe.php?tipo=' . htmlspecialchars($modal_type);
            }
        ?>
        <div class="modal-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: flex; justify-content: center; align-items: center;">
            <div class="modal-content" style="background: white; width: 80%; height: 80%; border-radius: 5px; position: relative;">
                <div class="d-flex justify-content-between align-items-center bg-primary text-white px-3 py-2">
                    <h5 class="m-0">
                        <?php 
                        $titulos = [
                            'novo' => 'Novo Projeto',
                            'editar_projeto' => 'Editar Projeto', 
                            'excluir_projeto' => 'Excluir Projeto'
                        ];
                        echo $titulos[$modal_type] ?? ucfirst(str_replace('_', ' ', $modal_type));
                        ?>
                    </h5>
                    <a href="projetos.php" class="btn-close btn-close-white" style="text-decoration: none;" aria-label="Fechar"></a>
                </div>
                <iframe src="<?php echo $iframe_src; ?>" 
                        style="width: 100%; height: calc(100% - 50px); border: none;"></iframe>
            </div>
        </div>
        <?php endif; ?>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
