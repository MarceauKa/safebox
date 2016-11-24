module.exports = {
    methods: {
        showSite: (site) => {
            eventBus.$emit('siteEntryShow', site)
        },

        createSite: () => {
            eventBus.$emit('siteEntryCreate')
        },

        editSite: (site) => {
            eventBus.$emit('siteEntryEdit', site)
        },

        deleteSite: (site) => {
            eventBus.$emit('siteEntryDelete', site)
        }
    }
}
