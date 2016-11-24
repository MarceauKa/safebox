module.exports = {
    methods: {
        showClient: (client) => {
            eventBus.$emit('clientEntryShow', client)
        },

        createClient: () => {
            eventBus.$emit('clientEntryCreate')
        },

        editClient: (client) => {
            eventBus.$emit('clientEntryEdit', client)
        },

        deleteClient: (client) => {
            eventBus.$emit('clientEntryDelete', client)
        }
    }
}
