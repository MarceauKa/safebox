module.exports = {
    app: {
        http_error: "Something went wrong. Please try again.",
        validation_error: "Whoops, something went wrong!",
        option_choose: "Choose...",
        button_see: "See",
        button_visit: "Visit",
        button_save: "Save",
        button_history: "History",
        button_action: "Action",
        button_close: "Close",
        button_create: "Create",
        button_edit: "Edit",
        button_delete: "Delete"
    },
    password: {
        copy: "Copy"
    },
    history: {
        empty: "There's no history.",
        field: "Field",
        from: "From",
        to: "To"
    },
    search: {
        title: "Search",
        placeholder: "Your query",
        sites: "Sites",
        clients: "Clients",
        indicator_searching: "Searching...",
        indicator_typing: "Typing..."
    },
    pagination: {
        previous: "Previous",
        next: "Next",
        showing: "Showing page"
    },
    clients: {
        singular: "Client",
        plural: "Clients",
        title_all: "All clients",
        title_create: "Create client",
        title_edit: "Edit client",
        empty: "You have not created any clients.",
        name: "Name",
        email: "Email",
        phone: "Phone",
        address: "Address",
        note: "Note",
        facebook: "Facebook",
        twitter: "Twitter",
        placeholders: {
            facebook: "Facebook page URL",
            twitter: "Twitter account. Ex: @404labfr"
        }
    },
    sites: {
        singular: "Site",
        plural: "Sites",
        title_all: "All sites",
        title_create: "Create a site",
        title_edit: "Edit site",
        empty: "You have not created any sites.",
        name: "Name",
        url: "URL",
        client: "Client",
        repo_url: "Git repository URL",
        google_analytics: "Google Analytics ID"
    },
    accounts: {
        singular: "Account",
        plural: "Accounts",
        title_all: "All accounts",
        title_create: "Create account",
        title_edit: "Edit account",
        empty: "You have not created any accounts.",
        site: "Site",
        type: "Type",
        login: "Account",
        password: "Password",
        types: {
            ssh: {
                host: 'Host',
                login: 'User',
                password: 'Password',
                port: 'Port',
                comment: 'Comment',
            },
            ftp: {
                host: 'Host',
                login: 'User',
                password: 'Password',
                port: 'Port',
                comment: 'Comment',
            },
            mysql: {
                host: 'Host',
                login: 'User',
                password: 'Password',
                database: 'Database',
                port: 'Port',
                comment: 'Comment',
            },
            website: {
                name: 'Custom name',
                url: 'URL',
                login: 'Login',
                password: 'Password',
                comment: 'Comment',
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
