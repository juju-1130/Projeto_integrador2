        <div class="modal fade" id="loginModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Login</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../autenticacao/valida_login.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Digite seu email cadastrado" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Senha</label>
                                <input type="password" name="senha" class="form-control" placeholder="Digite sua senha" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="cadastrar.php" data-bs-toggle="modal" data-bs-target="#cadastrarModal" data-bs-dismiss="modal">Cadastrar</a> |
                            <a href="#" data-bs-toggle="modal" data-bs-target="#esqueciModal" data-bs-dismiss="modal">Esqueci a senha</a>
                        </div>
                        <!-- Container para mensagens de login -->
                        <div id="login-message-container" class="mb-3">
                            <?php 
                            // Mensagem de erro da sessão (fallback)
                            if (isset($_SESSION['erro_login'])) {
                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                                echo '<i class="fas fa-exclamation-triangle me-2"></i>';
                                echo 'Usuário ou senha incorretos!';
                                echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
                                echo '</div>';
                                unset($_SESSION['erro_login']);
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>