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

                <form action="<?= BASE_URL ?>/autenticacao/salvar_cadastro.php" method="POST" id="form-cadastro" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" name="usuario" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telefone</label>
                        <input type="tel" name="telefone" class="form-control" placeholder="51999466563" required>
                        <div class="form-text">Digite apenas números: 51999999999</div>
                        <div class="invalid-feedback">Por favor, insira um telefone válido com DDD + número</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                        <div class="invalid-feedback">Por favor, insira um email válido</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Senha</label>
                        <input type="password" name="senha" id="senha" class="form-control" required>
                        <div class="form-text">
                            A senha deve conter:
                            <ul class="small mb-0">
                                <li id="req-maiuscula">⭕ Pelo menos 1 letra maiúscula</li>
                                <li id="req-minuscula">⭕ Pelo menos 1 letra minúscula</li>
                                <li id="req-numero">⭕ Pelo menos 1 número</li>
                                <li id="req-especial">⭕ Pelo menos 1 caractere especial (@$!%*?&)</li>
                                <li id="req-tamanho">⭕ Mínimo de 8 caracteres</li>
                            </ul>
                        </div>
                        <div class="invalid-feedback" id="senhaInvalida">A senha não atende aos requisitos de segurança</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirmar Senha</label>
                        <input type="password" name="confirmar_senha" id="confirmar_senha" class="form-control" required>
                        <div class="invalid-feedback" id="senhaError">As senhas não coincidem</div>
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
    const senhaInput = document.getElementById('senha');
    const confirmaInput = document.getElementById('confirmar_senha');
    const senhaError = document.getElementById('senhaError');
    const senhaInvalida = document.getElementById('senhaInvalida');
    const btnCadastrar = document.getElementById('btn-cadastrar');
    
    // Elementos dos requisitos da senha
    const reqMaiuscula = document.getElementById('req-maiuscula');
    const reqMinuscula = document.getElementById('req-minuscula');
    const reqNumero = document.getElementById('req-numero');
    const reqEspecial = document.getElementById('req-especial');
    const reqTamanho = document.getElementById('req-tamanho');

    // Estado das validações
    let senhaValida = false;
    let senhasCoincidem = false;

    // Função para validar força da senha
    function validarForcaSenha(senha) {
        const temMaiuscula = /[A-Z]/.test(senha);
        const temMinuscula = /[a-z]/.test(senha);
        const temNumero = /[0-9]/.test(senha);
        const temEspecial = /[@$!%*?&]/.test(senha);
        const temTamanho = senha.length >= 8;

        // Atualizar visual dos requisitos
        reqMaiuscula.innerHTML = (temMaiuscula ? '✅' : '⭕') + ' Pelo menos 1 letra maiúscula';
        reqMinuscula.innerHTML = (temMinuscula ? '✅' : '⭕') + ' Pelo menos 1 letra minúscula';
        reqNumero.innerHTML = (temNumero ? '✅' : '⭕') + ' Pelo menos 1 número';
        reqEspecial.innerHTML = (temEspecial ? '✅' : '⭕') + ' Pelo menos 1 caractere especial (@$!%*?&)';
        reqTamanho.innerHTML = (temTamanho ? '✅' : '⭕') + ' Mínimo de 8 caracteres';

        senhaValida = temMaiuscula && temMinuscula && temNumero && temEspecial && temTamanho;
        
        // Atualizar estado visual do campo
        if (senha.length > 0) {
            if (senhaValida) {
                senhaInput.classList.remove('is-invalid');
                senhaInput.classList.add('is-valid');
                senhaInvalida.style.display = 'none';
            } else {
                senhaInput.classList.remove('is-valid');
                senhaInput.classList.add('is-invalid');
                senhaInvalida.style.display = 'block';
            }
        } else {
            senhaInput.classList.remove('is-valid', 'is-invalid');
            senhaInvalida.style.display = 'none';
        }

        return senhaValida;
    }

    // Função para validar se senhas coincidem
    function validarSenhas() {
        const senha = senhaInput.value;
        const confirma = confirmaInput.value;
        
        if (confirma.length > 0) {
            if (senha === confirma) {
                confirmaInput.classList.remove('is-invalid');
                confirmaInput.classList.add('is-valid');
                senhaError.style.display = 'none';
                senhasCoincidem = true;
            } else {
                confirmaInput.classList.remove('is-valid');
                confirmaInput.classList.add('is-invalid');
                senhaError.style.display = 'block';
                senhasCoincidem = false;
            }
        } else {
            confirmaInput.classList.remove('is-valid', 'is-invalid');
            senhaError.style.display = 'none';
            senhasCoincidem = false;
        }

        return senhasCoincidem;
    }

    // Função para validar telefone - ACEITA APENAS NÚMEROS
    function validarTelefone(telefone) {
        // Remove tudo que não é número
        const apenasNumeros = telefone.replace(/\D/g, '');
        
        // Verifica se tem entre 10 e 11 dígitos (DDD + número)
        return apenasNumeros.length >= 10 && apenasNumeros.length <= 11;
    }

    // Função para formatar telefone (opcional)
    function formatarTelefone(telefone) {
        const apenasNumeros = telefone.replace(/\D/g, '');
        
        if (apenasNumeros.length === 11) {
            return `(${apenasNumeros.substring(0,2)})${apenasNumeros.substring(2,7)}-${apenasNumeros.substring(7)}`;
        } else if (apenasNumeros.length === 10) {
            return `(${apenasNumeros.substring(0,2)})${apenasNumeros.substring(2,6)}-${apenasNumeros.substring(6)}`;
        }
        
        return telefone;
    }

    // Função para validar email - SIMPLIFICADA
    function validarEmail(email) {
        // Regex mais simples e eficaz
        const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regexEmail.test(email) && email.length <= 254;
    }

    // Event listeners
    senhaInput.addEventListener('input', function() {
        validarForcaSenha(this.value);
        validarSenhas(); // Revalidar confirmação quando a senha principal mudar
    });

    confirmaInput.addEventListener('input', validarSenhas);

    // Validação do telefone em tempo real
    const telefoneInput = document.querySelector('input[name="telefone"]');
    telefoneInput.addEventListener('blur', function() {
        // Remove formatação para validação
        const telefoneLimpo = this.value.replace(/\D/g, '');
        
        if (this.value && !validarTelefone(this.value)) {
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
        } else if (this.value) {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
            
            // Opcional: Formatar automaticamente
            if (telefoneLimpo.length >= 10) {
                this.value = formatarTelefone(this.value);
            }
        } else {
            this.classList.remove('is-invalid', 'is-valid');
        }
    });

    // Permitir apenas números no telefone
    telefoneInput.addEventListener('input', function() {
        // Remove caracteres não numéricos
        this.value = this.value.replace(/\D/g, '');
    });

    // Validação do email em tempo real
    const emailInput = document.querySelector('input[name="email"]');
    emailInput.addEventListener('blur', function() {
        if (this.value && !validarEmail(this.value)) {
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
        } else if (this.value) {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        } else {
            this.classList.remove('is-invalid', 'is-valid');
        }
    });

    // Validação do formulário no submit
    form.addEventListener('submit', function(e) {
        let formValido = true;
        const errors = [];

        // Validar nome
        const nomeInput = document.querySelector('input[name="usuario"]');
        if (!nomeInput.value.trim()) {
            nomeInput.classList.add('is-invalid');
            formValido = false;
            errors.push('Nome é obrigatório');
        } else {
            nomeInput.classList.remove('is-invalid');
            nomeInput.classList.add('is-valid');
        }

        // Validar telefone
        if (!validarTelefone(telefoneInput.value)) {
            telefoneInput.classList.add('is-invalid');
            formValido = false;
            errors.push('Telefone inválido. Digite DDD + número (10 ou 11 dígitos)');
        } else {
            telefoneInput.classList.remove('is-invalid');
        }

        // Validar email
        if (!validarEmail(emailInput.value)) {
            emailInput.classList.add('is-invalid');
            formValido = false;
            errors.push('Email inválido');
        } else {
            emailInput.classList.remove('is-invalid');
        }

        // Validar força da senha
        if (!validarForcaSenha(senhaInput.value)) {
            senhaInput.classList.add('is-invalid');
            formValido = false;
            errors.push('Senha não atende aos requisitos de segurança');
        }

        // Validar confirmação de senha
        if (!validarSenhas()) {
            formValido = false;
            errors.push('As senhas não coincidem');
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
            
            // Rolagem para o primeiro erro
            const primeiroErro = form.querySelector('.is-invalid');
            if (primeiroErro) {
                primeiroErro.scrollIntoView({ behavior: 'smooth', block: 'center' });
                primeiroErro.focus();
            }
        }
    });

    // Remover validação ao digitar
    form.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', function() {
            if (this.type !== 'password' && this.name !== 'telefone') {
                this.classList.remove('is-invalid');
            }
        });
    });
});
</script>