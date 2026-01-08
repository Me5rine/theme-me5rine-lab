// Fonction pour initialiser le menu (appelée au chargement ou immédiatement si DOM déjà chargé)
function initMenuSystem() {
    // --- TOGGLE MENU MOBILE avec animation améliorée (UM et me5rine-lab)
    // Fonction pour initialiser un menu spécifique
    function initMenu(menuToggleSelector, menuSelector) {
        const menuToggle = document.querySelector(menuToggleSelector);
        const profileMenu = document.querySelector(menuSelector);
        
        if (!menuToggle || !profileMenu) {
            return; // Menu non présent sur cette page
        }
        
        // Initialiser l'affichage selon la taille d'écran
        function initMenuDisplay() {
            if (window.innerWidth > 782) {
                // Desktop et Tablette : toujours afficher le menu à gauche
                profileMenu.style.display = 'flex';
                menuToggle.setAttribute('aria-expanded', 'false');
            } else {
                // Mobile uniquement : cacher le menu par défaut (menu déroulant)
                profileMenu.style.display = 'none';
            }
        }
        
        // Initialiser au chargement
        initMenuDisplay();
        
        // Variable pour suivre si on vient de toggle
        let isToggling = false;

        // Gérer le clic sur le toggle
        menuToggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            
            isToggling = true;
            
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            const newState = !isExpanded;
            
            this.setAttribute('aria-expanded', newState ? 'true' : 'false');
            
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
            
            // Réinitialiser le flag après que l'événement soit complètement traité
            setTimeout(() => {
                isToggling = false;
            }, 200);
        }, true); // Utiliser capture phase pour intercepter en premier

        // Fermer le menu si on clique en dehors (mobile uniquement)
        document.addEventListener('click', function(e) {
            // Ignorer si on vient juste de toggle
            if (isToggling) {
                return;
            }
            
            // Vérifier si le clic vient du toggle (y compris ses enfants) ou du menu
            const clickedToggle = e.target.closest('.me5rine-lab-menu-toggle, .um-profile-menu-toggle');
            const clickedMenu = e.target.closest('#me5rine-lab-menu, #um-profile-menu');
            
            if (clickedToggle === menuToggle || clickedMenu === profileMenu) {
                return;
            }
            
            // Fermer seulement si on est en mobile (<= 782px) et que le menu est ouvert
            if (window.innerWidth <= 782 && profileMenu.classList.contains('open')) {
                menuToggle.setAttribute('aria-expanded', 'false');
                profileMenu.classList.remove('open');
                setTimeout(() => {
                    profileMenu.style.display = 'none';
                }, 300);
            }
        }, false); // Utiliser bubble phase pour s'exécuter après le toggle

        // Gérer le redimensionnement de la fenêtre
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                initMenuDisplay();
            }, 250);
        });
    }

    // Initialiser les deux menus séparément
    initMenu('.um-profile-menu-toggle', '#um-profile-menu');
    initMenu('.me5rine-lab-menu-toggle', '#me5rine-lab-menu');

    // --- MENU déroulant vertical (UM et me5rine-lab)
    function initSubmenus() {
        // Fermer TOUS les sous-menus par défaut (UM et me5rine-lab)
        const allHasSub = document.querySelectorAll(".um-profile-menu-vertical .has-sub, .me5rine-lab-menu-vertical .has-sub");
        allHasSub.forEach(item => {
            item.classList.remove("open");
        });

        // Ouvrir uniquement le sous-menu actif au chargement (UM et me5rine-lab)
        const current = document.querySelector(".um-profile-menu-vertical .submenu .active, .me5rine-lab-menu-vertical .submenu .active");
        if (current) {
            const parent = current.closest(".has-sub");
            if (parent) {
                parent.classList.add("open");
            }
        }
    }

    // Initialiser les sous-menus immédiatement
    initSubmenus();

    // Réinitialiser après un court délai pour gérer les menus chargés dynamiquement
    setTimeout(initSubmenus, 100);

    // Attacher les événements de clic sur les liens avec sous-menus
    function attachSubmenuEvents() {
        const items = document.querySelectorAll(".um-profile-menu-vertical .has-sub > a, .me5rine-lab-menu-vertical .has-sub > a");
        
        items.forEach(link => {
            // Éviter d'ajouter plusieurs fois le même listener
            if (link.dataset.submenuListener === 'attached') {
                return;
            }
            link.dataset.submenuListener = 'attached';

            link.addEventListener("click", function (e) {
                e.preventDefault();
                const parent = this.parentElement;
                const menuContainer = this.closest('.um-profile-menu-vertical, .me5rine-lab-menu-vertical');

                // Fermer les autres sous-menus dans le même menu
                if (menuContainer) {
                    menuContainer.querySelectorAll(".has-sub.open").forEach(item => {
                        if (item !== parent) {
                            item.classList.remove("open");
                        }
                    });
                }

                parent.classList.toggle("open");
            });
        });
    }

    // Attacher les événements
    attachSubmenuEvents();
    
    // Réattacher après un court délai pour gérer les menus chargés dynamiquement
    setTimeout(attachSubmenuEvents, 100);
}

// Initialiser immédiatement si le DOM est déjà chargé, sinon attendre DOMContentLoaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initMenuSystem);
} else {
    // DOM déjà chargé, initialiser immédiatement
    initMenuSystem();
}

// Réinitialiser après un court délai pour gérer les menus chargés dynamiquement
setTimeout(initMenuSystem, 500);

document.addEventListener('DOMContentLoaded', function () {
    // --- Suppression du bouton "modifier"
    const editMenu = document.querySelector('.um-profile-edit');
    if (editMenu) {
        editMenu.remove();
    }

    // --- Affichage conditionnel des onglets personnalisés (edit)
    const urlParams = new URLSearchParams(window.location.search);

    // Récupération des paramètres
    const isEditing = urlParams.get('um_action') === 'edit';
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

    // En mode view, masquer les formulaires vides (surtout socials)
    if (!isEditing) {
        const socialsForm = document.querySelector('.admin-lab-socials-form');
        if (socialsForm) {
            // Vérifier si le formulaire contient des champs avec du contenu
            const visibleFields = socialsForm.querySelectorAll('.um-field:not(.um-field-hidden)');
            let hasContent = false;
            
            visibleFields.forEach(field => {
                const fieldValue = field.querySelector('.um-field-value');
                if (fieldValue) {
                    const text = fieldValue.textContent.trim();
                    // Vérifier si la valeur n'est pas vide (exclure les espaces, retours à la ligne, etc.)
                    if (text.length > 0) {
                        hasContent = true;
                    }
                }
            });
            
            // Vérifier aussi les colonnes directement
            const col121 = socialsForm.querySelector('.um-col-121');
            const col122 = socialsForm.querySelector('.um-col-122');
            
            const checkColContent = (col) => {
                if (!col) return false;
                // Vérifier tous les enfants sauf um-clear
                const children = Array.from(col.children).filter(child => 
                    !child.classList.contains('um-clear') && 
                    child.nodeType === Node.ELEMENT_NODE
                );
                
                if (children.length === 0) return false;
                
                // Vérifier si au moins un enfant a du contenu
                return children.some(child => {
                    const text = child.textContent.trim();
                    return text.length > 0;
                });
            };
            
            const col121HasContent = checkColContent(col121);
            const col122HasContent = checkColContent(col122);
            
            // Si pas de contenu du tout, masquer le form et son heading
            if (!hasContent && !col121HasContent && !col122HasContent) {
                // Ajouter un attribut pour le CSS
                socialsForm.setAttribute('data-empty', 'true');
                hideFormAndHeading(socialsForm);
            }
        }
    }
    
    // En mode edit, masquer tous les formulaires sauf celui qu'on édite
    if (isEditing) {
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