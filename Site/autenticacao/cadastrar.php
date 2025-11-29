<div class="modal fade" id="cadastrarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastrar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Container para mensagens dinâmicas -->
                <div id="cadastro-message-container" class="mb-3">
                    <?php 
                    // Mensagens de fallback via GET (para compatibilidade)
                    if (isset($_GET['erro'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?php
                            switch ($_GET['erro']) {
                                case 'campos': echo "Preencha todos os campos obrigatórios."; break;
                                case 'senha':  echo "As senhas não coincidem."; break;
                                case 'email':  echo "Este e-mail já está cadastrado."; break;
                                case 'db':     echo "Erro no banco de dados."; break;
                                case 'inserir':echo "Erro ao inserir usuário."; break;
                                default:       echo "Erro desconhecido.";
                            }
                            ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php elseif (isset($_GET['sucesso'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            Usuário cadastrado com sucesso! Faça login para continuar.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                </div>

                <form method="POST" action="/../autenticacao/salvar_cadastro.php" id="form-cadastro">
                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" name="usuario" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telefone</label>
                        <input type="tel" name="telefone" class="form-control" placeholder="51999999999" pattern="[0-9]{10,11}" required>
                        <div class="form-text">Digite apenas números (10 ou 11 dígitos): 51999999999</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" required>
                        <div class="form-text">Digite seu endereço de email</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Senha</label>
                        <input type="password" name="senha" id="senha" class="form-control" required>
                        <div class="form-text">
                            Digite uma senha segura
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirmar Senha</label>
                        <input type="password" name="confirmar_senha" id="confirmar_senha" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" id="btn-cadastrar">Cadastrar</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Já tenho conta</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form-cadastro');
    
    // Função para validar email
    function validarEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    // Função para validar telefone
    function validarTelefone(telefone) {
        const telefoneLimpo = telefone.replace(/\D/g, '');
        return telefoneLimpo.length >= 10 && telefoneLimpo.length <= 11;
    }

    // Validação em tempo real do email
    const emailInput = document.querySelector('input[name="email"]');
    emailInput.addEventListener('blur', function() {
        const email = this.value.trim();
        const feedbackElement = this.nextElementSibling;
        
        if (email && !validarEmail(email)) {
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
            if (feedbackElement && feedbackElement.classList.contains('form-text')) {
                feedbackElement.innerHTML = '<span class="text-danger">❌ Email inválido. Use o formato: usuario@exemplo.com</span>';
            }
        } else if (email) {
            this.classList.add('is-valid');
            this.classList.remove('is-invalid');
            if (feedbackElement && feedbackElement.classList.contains('form-text')) {
                feedbackElement.innerHTML = '<span class="text-success">✅ Email válido</span>';
            }
        } else {
            this.classList.remove('is-valid', 'is-invalid');
            if (feedbackElement && feedbackElement.classList.contains('form-text')) {
                feedbackElement.innerHTML = 'Digite seu endereço de email';
            }
        }
    });

    // Validação em tempo real do telefone
    const telefoneInput = document.querySelector('input[name="telefone"]');
    telefoneInput.addEventListener('blur', function() {
        const telefone = this.value;
        const feedbackElement = this.nextElementSibling;
        
        if (telefone && !validarTelefone(telefone)) {
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
            if (feedbackElement && feedbackElement.classList.contains('form-text')) {
                feedbackElement.innerHTML = '<span class="text-danger">❌ Telefone inválido. Digite DDD + número (10 ou 11 dígitos)</span>';
            }
        } else if (telefone) {
            this.classList.add('is-valid');
            this.classList.remove('is-invalid');
            if (feedbackElement && feedbackElement.classList.contains('form-text')) {
                feedbackElement.innerHTML = '<span class="text-success">✅ Telefone válido</span>';
            }
        } else {
            this.classList.remove('is-valid', 'is-invalid');
            if (feedbackElement && feedbackElement.classList.contains('form-text')) {
                feedbackElement.innerHTML = 'Digite apenas números (10 ou 11 dígitos): 51999999999';
            }
        }
    });

    // Validação em tempo real da confirmação de senha
    const confirmaInput = document.getElementById('confirmar_senha');
    confirmaInput.addEventListener('input', function() {
        const senha = document.getElementById('senha').value;
        const confirma = this.value;
        
        if (confirma.length > 0) {
            if (senha === confirma && senha.length > 0) {
                this.classList.add('is-valid');
                this.classList.remove('is-invalid');
            } else {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            }
        } else {
            this.classList.remove('is-valid', 'is-invalid');
        }
    });

    // Validação básica no submit
    form.addEventListener('submit', function(e) {
        let formValido = true;
        const errors = [];

        // Validar nome
        const nomeInput = document.querySelector('input[name="usuario"]');
        if (!nomeInput.value.trim()) {
            formValido = false;
            errors.push('Nome é obrigatório');
            nomeInput.classList.add('is-invalid');
        } else {
            nomeInput.classList.remove('is-invalid');
        }

        // Validar email
        const emailInput = document.querySelector('input[name="email"]');
        const email = emailInput.value.trim();
        if (!email) {
            formValido = false;
            errors.push('Email é obrigatório');
            emailInput.classList.add('is-invalid');
        } else if (!validarEmail(email)) {
            formValido = false;
            errors.push('Email inválido. Use o formato: usuario@exemplo.com');
            emailInput.classList.add('is-invalid');
        } else {
            emailInput.classList.remove('is-invalid');
        }

        // Validar telefone
        const telefoneInput = document.querySelector('input[name="telefone"]');
        const telefoneLimpo = telefoneInput.value.replace(/\D/g, '');
        if (!telefoneInput.value) {
            formValido = false;
            errors.push('Telefone é obrigatório');
            telefoneInput.classList.add('is-invalid');
        } else if (telefoneLimpo.length < 10 || telefoneLimpo.length > 11) {
            formValido = false;
            errors.push('Telefone inválido. Digite DDD + número (10 ou 11 dígitos)');
            telefoneInput.classList.add('is-invalid');
        } else {
            // Atualizar o campo com apenas números para envio
            telefoneInput.value = telefoneLimpo;
            telefoneInput.classList.remove('is-invalid');
        }

        // Validar senha (apenas se está preenchida)
        const senhaInput = document.getElementById('senha');
        const senha = senhaInput.value;
        
        if (!senha) {
            formValido = false;
            errors.push('Senha é obrigatória');
            senhaInput.classList.add('is-invalid');
        } else {
            senhaInput.classList.remove('is-invalid');
        }

        // Validar confirmação de senha
        const confirmaInput = document.getElementById('confirmar_senha');
        if (senhaInput.value !== confirmaInput.value) {
            formValido = false;
            errors.push('As senhas não coincidem');
            confirmaInput.classList.add('is-invalid');
        } else {
            confirmaInput.classList.remove('is-invalid');
        }

        if (!formValido) {
            e.preventDefault();
            
            // Mostrar mensagem geral de erro
            const messageContainer = document.getElementById('cadastro-message-container');
            messageContainer.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Erro no formulário:</strong><br>
                    ${errors.join('<br>')}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            
            // Restaurar o valor original do telefone para exibição
            telefoneInput.value = telefoneInput.getAttribute('data-original-value') || telefoneInput.value;
        }
    });

    // Salvar valor original do telefone para restauração
    const telefoneInput = document.querySelector('input[name="telefone"]');
    telefoneInput.setAttribute('data-original-value', telefoneInput.value);
});
</script>