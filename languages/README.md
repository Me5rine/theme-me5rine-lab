# Traductions du thème Me5rine LAB

Ce dossier contient les fichiers de traduction pour le thème Me5rine LAB.

## Fichiers de traduction

- `me5rine.pot` : Fichier template contenant toutes les chaînes à traduire (en anglais)
- `me5rine-fr_FR.po` : Traduction française (exemple)

## Messages Ultimate Member traduisibles

Les messages suivants sont disponibles pour traduction :

### Messages de succès
- `Profile updated successfully` → "Profil mis à jour avec succès"
- `Social networks updated` → "Réseaux sociaux mis à jour"

### Utilisation dans le code

Tous les messages utilisent le domaine de texte `me5rine`. Exemple :

```php
// Message simple
esc_html__( 'Profile updated successfully', 'me5rine' )

// Avec les fonctions utilitaires
me5rine_um_add_success( esc_html__( 'Profile updated successfully', 'me5rine' ) );
me5rine_um_add_error( esc_html__( 'Error saving data', 'me5rine' ) );
me5rine_um_add_warning( esc_html__( 'Warning: some fields were not updated', 'me5rine' ) );
me5rine_um_add_info( esc_html__( 'Info: this field will be validated later', 'me5rine' ) );
```

## Comment créer une nouvelle traduction

1. Copiez le fichier `me5rine.pot` vers `me5rine-{locale}.po` (ex: `me5rine-fr_FR.po`)
2. Ouvrez le fichier `.po` avec Poedit ou un autre éditeur de traductions
3. Traduisez toutes les chaînes
4. Compilez le fichier `.po` en `.mo` (Poedit le fait automatiquement)
5. Placez les fichiers `.po` et `.mo` dans ce dossier

## Locales supportées

- `fr_FR` : Français (France)
- Ajoutez d'autres locales selon vos besoins

## Génération automatique du .pot

Pour régénérer le fichier `.pot` avec toutes les chaînes du thème :

```bash
# Avec WP-CLI (recommandé)
wp i18n make-pot . languages/me5rine.pot --domain=me5rine

# Ou avec Poedit
# Tools > Update from POT file...
```

