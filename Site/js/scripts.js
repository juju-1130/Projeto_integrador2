window.addEventListener('DOMContentLoaded', event => {
    // Navbar shrink
    var navbarShrink = function () {
        const navbarCollapsible = document.body.querySelector('#mainNav');
        if (!navbarCollapsible) return;
        if (window.scrollY === 0) {
            navbarCollapsible.classList.remove('navbar-shrink');
        } else {
            navbarCollapsible.classList.add('navbar-shrink');
        }
    };
    navbarShrink();
    document.addEventListener('scroll', navbarShrink);

    // Scrollspy
    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            rootMargin: '0px 0px -40%',
        });
    }

    // Fecha navbar ao clicar nos itens
    const navbarToggler = document.body.querySelector('.navbar-toggler');
    const responsiveNavItems = [].slice.call(document.querySelectorAll('#navbarResponsive .nav-link'));
    responsiveNavItems.map(function (item) {
        item.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });

    // ===== MODO DE EDIÇÃO =====

    const toggleEditMode = document.getElementById('toggleEditMode');

    const addCheckboxesToProjects = () => {
        const projects = document.querySelectorAll('.project-card');
        projects.forEach((card, index) => {
            if (!card.querySelector('.project-checkbox')) {
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.className = 'project-checkbox';
                checkbox.dataset.index = index;

                checkbox.addEventListener('change', () => {
                    if (checkbox.checked) {
                        const modal = new bootstrap.Modal(document.getElementById('editModal'));
                        modal.show();
                        checkbox.checked = false;
                    }
                });

                card.appendChild(checkbox);
            }
        });
    };

    if (toggleEditMode) {
        toggleEditMode.addEventListener('click', function (e) {
            e.preventDefault();
            const projectsSection = document.getElementById('projects');
            projectsSection.classList.toggle('edit-mode');

            this.textContent = projectsSection.classList.contains('edit-mode')
                ? 'Sair do Modo Edição'
                : 'Editar projetos';

            if (projectsSection.classList.contains('edit-mode')) {
                addCheckboxesToProjects();
            }
        });
    }

    // Modal funcionalidade futura
    const exampleModal = document.getElementById('editModal');
    if (exampleModal) {
        exampleModal.addEventListener('show.bs.modal', event => {
            console.log('Modal aberto');
        });
    }

    // Abrir modal telhados 
    function abrirModal(item) {
        if (item === 'Tipos de telhado') {
            // Abre o modal específico para Tipos de Telhado
            var modalTelhado = new bootstrap.Modal(document.getElementById('modalTelhado'));
            modalTelhado.show();
        } else {
            // Abre o modal genérico de edição
            document.getElementById('modalTitulo').textContent = 'Editar ' + item;
            var modalGenerico = new bootstrap.Modal(document.getElementById('modalEditar'));
            modalGenerico.show();
        }
    }


});
