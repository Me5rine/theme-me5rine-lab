# Structure CSS Modulaire

Ce dossier contient tous les fichiers CSS modulaires du thème Me5rine LAB, organisés par fonctionnalité pour faciliter la maintenance et le développement.

## Organisation des fichiers

### Fichiers principaux

- **`variables.css`** : Variables CSS globales (couleurs, espacements, ombres, transitions)
- **`integrations.css`** : Styles pour les intégrations de plugins (Google reCAPTCHA, Elementor, Contact Form 7, RafflePress)

### Formulaires

- **`forms.css`** : Styles globaux pour tous les formulaires (inputs, selects, textarea, checkboxes, messages, responsive)

### Composants spécifiques

- **`giveaway-partner.css`** : Styles pour les tuiles de giveaway partenaire
- **`tables.css`** : Styles pour les tableaux (style table-05 adapté avec comportement responsive WordPress admin)
- **`buttons.css`** : Styles pour tous les boutons (principal, secondaire, remove, file)
- **`cards.css`** : Styles pour les cartes et tiles génériques
- **`podium.css`** : Styles pour le composant Podium (Top 3)
- **`cards-image.css`** : Styles pour les cartes avec images/thumbnails
- **`state-message.css`** : Styles pour les messages d'état
- **`card-headers.css`** : Styles pour les en-têtes de cartes
- **`filter-labels.css`** : Styles pour les labels de filtres responsive

### Layout et structure

- **`dashboard.css`** : Styles pour les dashboards et containers
- **`profile.css`** : Styles génériques pour les profils
- **`responsive.css`** : Styles responsive globaux front-end

### Ultimate Member

- **`um-profile.css`** : Styles spécifiques pour les profils Ultimate Member (menu, layout, badges)
- **`um-responsive.css`** : Styles responsive spécifiques pour Ultimate Member

## Ordre d'import

Les fichiers sont importés dans `style.css` dans l'ordre suivant :

1. Variables (doit être en premier)
2. Intégrations
3. Formulaires
4. Composants spécifiques
5. Layout et structure
6. Ultimate Member

## Maintenance

Pour modifier un style :

1. Identifier le fichier concerné dans cette structure
2. Modifier uniquement ce fichier
3. Les changements seront automatiquement pris en compte via l'import dans `style.css`

## Notes importantes

- Les variables CSS sont définies dans `variables.css` et doivent être utilisées partout
- L'ordre d'import est important : les variables doivent être chargées en premier
- Chaque fichier est indépendant et peut être modifié sans affecter les autres

