module.exports = {
    methods: {
        showAccount: (account) => {
            eventBus.$emit('accountEntryShow', account)
        },

        createAccount: () => {
            eventBus.$emit('accountEntryCreate')
        },

        editAccount: (account) => {
            eventBus.$emit('accountEntryEdit', account, account.accountable.id)
        },

        deleteAccount: (account) => {
            eventBus.$emit('accountEntryDelete', account)
        },

        showAccountHistory: (account) => {
            eventBus.$emit('accountHistoryShow', account)
        }
    }
}
