document.addEventListener('DOMContentLoaded', function () {
    // --- TOGGLE MENU MOBILE avec animation améliorée
    const menuToggle = document.querySelector('.um-profile-menu-toggle');
    const profileMenu = document.querySelector('#um-profile-menu');
    
    // Initialiser l'affichage selon la taille d'écran
    function initMenuDisplay() {
        if (window.innerWidth > 1024) {
            // Desktop : toujours afficher le menu
            if (profileMenu) {
                profileMenu.style.display = 'flex';
            }
            if (menuToggle) {
                menuToggle.setAttribute('aria-expanded', 'false');
            }
        } else {
            // Mobile : cacher le menu par défaut
            if (profileMenu) {
                profileMenu.style.display = 'none';
            }
        }
    }
    
    // Initialiser au chargement
    initMenuDisplay();
    
    if (menuToggle && profileMenu) {
        menuToggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            const newState = !isExpanded;
            
            this.setAttribute('aria-expanded', newState);
            
            if (newState) {
                profileMenu.style.display = 'flex';
                // Force reflow pour l'animation
                profileMenu.offsetHeight;
                profileMenu.classList.add('open');
            } else {
                profileMenu.classList.remove('open');
                // Attendre la fin de l'animation avant de cacher
                setTimeout(() => {
                    if (!profileMenu.classList.contains('open')) {
                        profileMenu.style.display = 'none';
                    }
                }, 300);
            }
        });

        // Fermer le menu si on clique en dehors (mobile uniquement)
        function handleOutsideClick(e) {
            if (window.innerWidth <= 1024 &&
                profileMenu && menuToggle && 
                !profileMenu.contains(e.target) && 
                !menuToggle.contains(e.target) &&
                profileMenu.classList.contains('open')) {
                menuToggle.setAttribute('aria-expanded', 'false');
                profileMenu.classList.remove('open');
                setTimeout(() => {
                    profileMenu.style.display = 'none';
                }, 300);
            }
        }
        
        document.addEventListener('click', handleOutsideClick);

        // Gérer le redimensionnement de la fenêtre
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                initMenuDisplay();
            }, 250);
        });
    }

    // --- MENU déroulant vertical
    const items = document.querySelectorAll(".um-profile-menu-vertical .has-sub > a");
    items.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const parent = this.parentElement;

            document.querySelectorAll(".um-profile-menu-vertical .has-sub.open").forEach(item => {
                if (item !== parent) {
                    item.classList.remove("open");
                }
            });

            parent.classList.toggle("open");
        });
    });

    const current = document.querySelector(".um-profile-menu-vertical .submenu .active");
    if (current) {
        const parent = current.closest(".has-sub");
        if (parent) {
            parent.classList.add("open");
        }
    }

    // --- Suppression du bouton "modifier"
    const editMenu = document.querySelector('.um-profile-edit');
    if (editMenu) {
        editMenu.remove();
    }

    // --- Affichage conditionnel des onglets personnalisés (edit)
    const urlParams = new URLSearchParams(window.location.search);

    // Ne rien faire si ce n'est pas le mode édition
    const isEditing = urlParams.get('um_action') === 'edit';
    if (!isEditing) return;

    // Récupération des paramètres
    const editProfile = urlParams.get('edit-profile') === 'true';
    const editSocials = urlParams.get('edit-socials') === 'true';

    // Fonction pour masquer un form et son heading associé
    function hideFormAndHeading(form) {
        if (!form) return;
        
        // Masquer le form
        form.style.display = 'none';
        
        // Trouver le heading précédent (um-row-heading juste avant ce form)
        let previousElement = form.previousElementSibling;
        while (previousElement) {
            if (previousElement.classList.contains('um-row-heading')) {
                previousElement.style.display = 'none';
                break;
            }
            previousElement = previousElement.previousElementSibling;
        }
    }

    // Fonction pour afficher un form et son heading associé
    function showFormAndHeading(form) {
        if (!form) return;
        
        // Afficher le form
        form.style.display = 'block';
        
        // Trouver et afficher le heading précédent
        let previousElement = form.previousElementSibling;
        while (previousElement) {
            if (previousElement.classList.contains('um-row-heading')) {
                previousElement.style.display = 'block';
                break;
            }
            previousElement = previousElement.previousElementSibling;
        }
    }

    // Masquer toutes les rows vides (um-row sans contenu ou avec seulement um-col vide)
    const allRows = document.querySelectorAll('.um-row');
    allRows.forEach(row => {
        const cols = row.querySelectorAll('.um-col-1, .um-col-2, .um-col-121, .um-col-122');
        let isEmpty = true;
        
        cols.forEach(col => {
            // Vérifier si la colonne a du contenu (en excluant um-clear)
            const content = Array.from(col.childNodes).filter(node => {
                if (node.nodeType === Node.TEXT_NODE) {
                    return node.textContent.trim().length > 0;
                }
                if (node.nodeType === Node.ELEMENT_NODE) {
                    return !node.classList.contains('um-clear');
                }
                return false;
            });
            
            if (content.length > 0) {
                isEmpty = false;
            }
        });
        
        // Si la row est vide ou n'a pas de colonnes avec contenu, la masquer
        if (isEmpty && cols.length > 0) {
            row.style.display = 'none';
        }
    });

    // Cibler tous les blocs de formulaire et masquer avec leurs headings
    const allForms = document.querySelectorAll('.admin-lab-um-form');
    allForms.forEach(form => hideFormAndHeading(form));

    // Afficher uniquement celui qu'on veut avec son heading
    if (editProfile) {
        const profileForm = document.querySelector('.admin-lab-profile-form');
        if (profileForm) showFormAndHeading(profileForm);
    }

    if (editSocials) {
        const socialsForm = document.querySelector('.admin-lab-socials-form');
        if (socialsForm) showFormAndHeading(socialsForm);
    }
});

document.addEventListener('DOMContentLoaded', () => {
    // --- Déplacement du bloc .um-profile-connect
    const meta = document.querySelector('.um-main-meta');
	const clear = meta ? meta.querySelector('.um-clear') : null;
    const socials = document.querySelector('.um-profile-connect.um-member-connect');

    if (meta && clear && socials) {
        meta.insertBefore(socials, clear.nextSibling);
    }
});
