        <div class="modal fade" id="esqueciModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Esqueci a senha</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../autenticacao/gerar_codigo.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Digite seu email cadastrado" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Telefone</label>
                                <input type="tel" name="telefone" class="form-control" placeholder="Digite seu telefone cadastrado" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Enviar Código de Verificação</button>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">
                                <i class="fas fa-arrow-left me-2"></i>Voltar ao login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>