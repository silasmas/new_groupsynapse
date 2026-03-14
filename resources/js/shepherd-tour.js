/**
 * Tour guidé Groupsynapse - Shepherd.js
 * Guide de démarrage interactif pour le tableau de bord admin
 */
import Shepherd from 'shepherd.js';
import 'shepherd.js/dist/css/shepherd.css';

const menuSteps = [
    { id: 'menu-users', title: 'Utilisateurs', text: 'Gérez les comptes utilisateurs, assignez des rôles et consultez les profils.' },
    { id: 'menu-produits', title: 'Produits', text: 'Catalogue des produits : prix, stock, catégories et disponibilité.' },
    { id: 'menu-services', title: 'Services', text: 'Offres de services bancaires : cartes, comptes, recharges. Tarifs et activation.' },
    { id: 'menu-categories', title: 'Catégories', text: 'Organisez produits et services par catégories pour une navigation claire.' },
    { id: 'menu-branches', title: 'Branches', text: 'Grandes sections du catalogue : cartes, comptes, recharges, agence bancaire...' },
    { id: 'menu-commandes', title: 'Commandes', text: 'Produits et services commandés : suivi des achats, états de paiement (En attente, Payée, Livrée...).' },
    { id: 'menu-transactions', title: 'Transactions', text: 'Logs des transactions et tentatives de paiement. Consultation en lecture seule.' },
    { id: 'menu-service-users', title: 'Services utilisateurs', text: 'Souscriptions aux services : états, suivi et renouvellements.' },
    { id: 'menu-shield', title: 'Rôles & Permissions (Shield)', text: 'Module Shield : gérez les rôles et permissions par ressource, page et widget. Contrôlez qui accède à quoi.' },
];

function getSidebarItemSelector(label) {
    const items = document.querySelectorAll('.fi-sidebar-item a, .fi-sidebar-item button, [data-slot="sidebar"] a');
    for (const el of items) {
        if (el.textContent && el.textContent.toLowerCase().includes(label.toLowerCase())) {
            return el;
        }
    }
    return null;
}

/**
 * Crée et démarre le tour guidé du dashboard
 */
function createGroupsynapseTour() {
    if (window.groupsynapseTour) {
        window.groupsynapseTour.cancel();
        window.groupsynapseTour = null;
    }

    const tour = new Shepherd.Tour({
        useModalOverlay: true,
        defaultStepOptions: {
            cancelIcon: { enabled: true, label: 'Fermer le guide' },
            scrollTo: { behavior: 'smooth', block: 'center' },
            classes: 'shepherd-theme-custom',
        },
    });

    // Étape 1 : Bienvenue
    tour.addStep({
        id: 'welcome',
        title: 'Bienvenue sur Groupsynapse',
        text: 'Ce guide vous présente le menu latéral et chaque section. Le menu est <strong>réductible</strong> : cliquez sur la flèche pour le replier.',
        attachTo: { element: () => document.querySelector('main.fi-main') || document.body, on: 'bottom' },
        buttons: [
            { text: 'Commencer', action: tour.next, classes: 'shepherd-button-primary' },
        ],
    });

    // Étape 2 : Sidebar réductible
    tour.addStep({
        id: 'sidebar',
        title: 'Menu latéral réductible',
        text: 'Le menu latéral peut être <strong>réduit</strong> pour gagner de l\'espace. Utilisez le bouton de repli en bas du menu. Sur mobile, il s\'ouvre en overlay.',
        attachTo: {
            element: () => document.querySelector('.fi-main-sidebar') || document.querySelector('nav') || document.body,
            on: 'right',
        },
        buttons: [
            { text: 'Précédent', action: tour.back, classes: 'shepherd-button-secondary' },
            { text: 'Suivant', action: tour.next },
        ],
    });

    // Étapes pour chaque menu
    menuSteps.forEach((step, index) => {
        const searchLabel = step.title.toLowerCase().includes('shield') ? 'rôles' : step.title.split(' ')[0];
        tour.addStep({
            id: step.id,
            title: step.title,
            text: step.text,
            attachTo: {
                element: () => getSidebarItemSelector(searchLabel) || document.querySelector('.fi-main-sidebar') || document.body,
                on: 'right',
            },
            buttons: [
                { text: 'Précédent', action: tour.back, classes: 'shepherd-button-secondary' },
                { text: 'Suivant', action: tour.next },
            ],
        });
    });

    // Étape : Zone de contenu
    tour.addStep({
        id: 'content',
        title: 'Tableau de bord',
        text: 'Ici s\'affichent les statistiques, graphiques (achats, transactions) et le guide. Les graphiques prennent chacun 6 colonnes pour une vue détaillée.',
        attachTo: { element: () => document.querySelector('main.fi-main') || document.body, on: 'bottom' },
        buttons: [
            { text: 'Précédent', action: tour.back, classes: 'shepherd-button-secondary' },
            { text: 'Suivant', action: tour.next },
        ],
    });

    // Étape : Recherche globale
    tour.addStep({
        id: 'search',
        title: 'Recherche rapide',
        text: 'Utilisez <kbd>Ctrl+K</kbd> (ou <kbd>Cmd+K</kbd> sur Mac) pour ouvrir la recherche globale.',
        attachTo: {
            element: () => document.querySelector('[x-data*="globalSearch"]') || document.querySelector('button[aria-label*="search" i]') || document.querySelector('.fi-topbar') || document.body,
            on: 'bottom',
        },
        buttons: [
            { text: 'Précédent', action: tour.back, classes: 'shepherd-button-secondary' },
            { text: 'Suivant', action: tour.next },
        ],
    });

    // Étape : Fin
    tour.addStep({
        id: 'complete',
        title: 'C\'est parti !',
        text: 'Vous êtes prêt. N\'oubliez pas : Shield gère les permissions pour chaque ressource et widget.',
        attachTo: { element: () => document.body, on: 'bottom' },
        buttons: [
            { text: 'Terminer', action: tour.complete, classes: 'shepherd-button-primary' },
        ],
    });

    tour.on('complete', () => {
        window.groupsynapseTour = null;
    });

    tour.on('cancel', () => {
        window.groupsynapseTour = null;
    });

    window.groupsynapseTour = tour;
    tour.start();
}

window.runGroupsynapseTour = createGroupsynapseTour;
