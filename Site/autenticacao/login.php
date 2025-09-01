        <div class="modal fade" id="loginModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Login</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="validar_login.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Digite seu email cadastrado" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Senha</label>
                                <input type="password" name="senha" class="form-control" placeholder="Digite sua senha" required>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="lembrarSenha">
                                <label class="form-check-label" for="lembrarSenha">
                                    Lembrar de mim
                                </label>
                            </div>
                            <a href="../Site/admin_php/index.php" class="btn btn-primary w-100">Login</a>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="cadastrar.php" data-bs-toggle="modal" data-bs-target="#cadastrarModal" data-bs-dismiss="modal">Cadastrar</a> |
                            <a href="#" data-bs-toggle="modal" data-bs-target="#esqueciModal" data-bs-dismiss="modal">Esqueci a senha</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>