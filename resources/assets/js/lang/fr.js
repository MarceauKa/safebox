module.exports = {
    app: {
        http_error: "Une erreur est survenue, merci de réessayer.",
        validation_error: "Oups, il y'a un problème",
        option_choose: "Choisir...",
        button_see: "Voir",
        button_visit: "Visiter",
        button_save: "Enregistrer",
        button_history: "Révisions",
        button_action: "Action",
        button_close: "Fermer",
        button_create: "Créer",
        button_edit: "Modifier",
        button_delete: "Supprimer"
    },
    password: {
        copy: "Copier"
    },
    history: {
        empty: "Aucune révision.",
        field: "Champs",
        from: "De",
        to: "A"
    },
    search: {
        title: "Recherche",
        placeholder: "Votre recherche",
        sites: "Sites",
        clients: "Clients",
        indicator_searching: "Recherche...",
        indicator_typing: "En train d'écrire..."
    },
    pagination: {
        previous: "Précédent",
        next: "Suivant",
        showing: "Page"
    },
    clients: {
        singular: "Client",
        plural: "Clients",
        title_all: "Tous les clients",
        title_create: "Créer un client",
        title_edit: "Modifier client",
        empty: "Vous n'avez créé aucun client.",
        name: "Nom",
        email: "Email",
        phone: "Téléphone",
        address: "Adresse",
        note: "Note",
        facebook: "Facebook",
        twitter: "Twitter",
        placeholders: {
            facebook: "URL de la page Facebook",
            twitter: "Compte twitter. Ex: @404labfr"
        }
    },
    sites: {
        singular: "Site",
        plural: "Sites",
        title_all: "Tous les sites",
        title_create: "Créer un site",
        title_edit: "Modifier site",
        empty: "Vous n'avez créé aucun site.",
        name: "Nom",
        url: "URL",
        client: "Client",
        repo_url: "URL dépôt git",
        google_analytics: "Google Analytics"
    },
    accounts: {
        singular: "Account",
        plural: "Accounts",
        title_all: "Tous les comptes",
        title_create: "Créer un compte",
        title_edit: "Modifier compte",
        empty: "Vous n'avez créé aucun compte.",
        site: "Site",
        type: "Type",
        login: "Identifiant",
        password: "Mot de passe",
        types: {
            ssh: {
                host: 'Hôte',
                login: 'Utilisateur',
                password: 'Mot de passe',
                port: 'Port',
                comment: 'Commentaire',
            },
            ftp: {
                host: 'Hôte',
                login: 'Utilisateur',
                password: 'Mot de passe',
                port: 'Port',
                comment: 'Commentaire',
            },
            mysql: {
                host: 'Hôte',
                login: 'Utilisateur',
                password: 'Mot de passe',
                database: 'Base de données',
                port: 'Port',
                comment: 'Commentaire',
            },
            website: {
                name: 'Nom',
                url: 'URL',
                login: 'Identifiant',
                password: 'Mot de passe',
                comment: 'Commentaire',
            },
            email: {
                name: 'Name',
                url: 'Webmail URL',
                login: 'Login',
                password: 'Password',
                comment: 'Comment',
            }
        }
    }
};
