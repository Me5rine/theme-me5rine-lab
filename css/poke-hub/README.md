# CSS Poké HUB (dans le thème Me5rine Lab)

Cette arborescence est la **source de vérité** du CSS **public** (front) de Poké HUB sur ce site.

### Les trois réponses courantes

1. **Où est le CSS front des modules (collections, blocs, profils, etc.) ?** → Ici : `poke-hub-front.css` et les `parts/`, **pas** le gros pack historique `assets/css/poke-hub-*-front.css` du plugin en production.
2. **Que reste-t-il dans le plugin ?** → Surtout l’**admin** et un **minimum** (variables / notices, icônes de types en admin via `poke-hub-type-icons.css`, filet optionnel collections — voir la doc du plugin). Pas le « gros lot » front quand le filtre ci‑dessous est actif.
3. **Comment le plugin n’en double pas le thème ?** → Dans le `functions.php` du thème : `add_filter( 'poke_hub_load_default_plugin_front_css', '__return_false' );` + déqueue des handles côté plugin. **Détail et tableau** : dépôt **poke-hub** → `docs/THEME_FRONT_CSS.md`.

---

Le plugin n’enfile plus le gros lot front lorsque le filtre `poke_hub_load_default_plugin_front_css` vaut `false` (déjà configuré dans le `functions.php` du thème enfant).

## Ordre de chargement (résumé)

1. Thème parent (Hello Elementor)  
2. `style.css` du thème enfant (me5rine) — base Me5rine, **sans** import Poké HUB.  
3. `poke-hub-front.css` (ce dossier) — point d’entrée qui `@import` les fichiers `parts/`.  
4. `poke-hub-late-overrides.css` — surcharges toutes dernières (cascade, correctifs ciblés).

Détail : documentation du plugin **Poké HUB** : `docs/THEME_FRONT_CSS.md` (dépôt `poke-hub`).

## Fichiers

| Fichier | Rôle |
|---------|------|
| `poke-hub-front.css` | Enchaîne `parts/01-…` à `parts/16-…` (modules, collections, profils, etc.) |
| `poke-hub-late-overrides.css` | Couche **après** `responsive.css` / `um-responsive` (chargée via `functions.php`, pas via `style.css`) |
| `parts/` | Morceaux par domaine (global-colors, blocs, collections, friend codes, …) |
| `parts/13-collections-front.css` | Vue collections + liste + **bloc recherche GO in-game** (copy-paste) : préférer `--me5rine-lab-*` (`../variables.css`) pour ce bloc front |
| `parts/02-type-icons.css` | Styles des icônes **types** (SVG inline, `currentColor`, variantes admin-list / admin-preview). **Aligner** avec le fichier du plugin `poke-hub/assets/css/poke-hub-type-icons.css` si vous modifiez l’un ou l’autre (le plugin charge sa copie en **admin** toujours ; le front ici ne s’applique que lorsque le filtre `poke_hub_load_default_plugin_front_css` est à `false`). |

Préférer les **règles de base** du thème (`../dashboard.css`, `../cards.css`, …) et **compléter** ici seulement ce qui est spécifique au plugin.
