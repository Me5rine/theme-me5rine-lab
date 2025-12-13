document.addEventListener('DOMContentLoaded', function () {
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

    // Cibler tous les blocs de formulaire
    const allForms = document.querySelectorAll('.admin-lab-um-form');
    allForms.forEach(form => form.style.display = 'none');

    // Afficher uniquement celui qu'on veut
    if (editProfile) {
        const profileForm = document.querySelector('.admin-lab-profile-form');
        if (profileForm) profileForm.style.display = 'block';
    }

    if (editSocials) {
        const socialsForm = document.querySelector('.admin-lab-socials-form');
        if (socialsForm) socialsForm.style.display = 'block';
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
