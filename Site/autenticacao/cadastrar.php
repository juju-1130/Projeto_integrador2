        <div class="modal fade" id="cadastrarModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cadastrar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                         <?php if (isset($_GET['erro'])): ?>
                            <div class="alert alert-danger">
                                <?php
                                switch ($_GET['erro']) {
                                    case 'campos': echo "⚠️ Preencha todos os campos obrigatórios."; break;
                                    case 'senha':  echo "⚠️ As senhas não coincidem."; break;
                                    case 'email':  echo "⚠️ Este e-mail já está cadastrado."; break;
                                    case 'db':     echo "❌ Erro no banco de dados."; break;
                                    case 'inserir':echo "❌ Erro ao inserir usuário."; break;
                                    default:       echo "❌ Erro desconhecido.";
                                }
                                ?>
                            </div>
                        <?php elseif (isset($_GET['sucesso'])): ?>
                            <div class="alert alert-success">
                                ✅ Usuário cadastrado com sucesso!
                            </div>
                        <?php endif; ?>
                        <form action="../autenticacao/salvar_cadastro.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nome</label>
                                <input type="text" name="usuario" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Telefone</label>
                                <input type="tel" name="telefone" class="form-control" placeholder="(51)99999-9999" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Senha</label>
                                <input type="password" name="senha" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirmar Senha</label>
                                <input type="password" name="confirmar_senha" class="form-control" required>
                            </div>
                            <div class="invalid-feedback" id="senhaError">As senhas não coincidem</div>
                            <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Já tenho conta</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

