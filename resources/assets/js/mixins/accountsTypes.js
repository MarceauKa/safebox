module.exports = {
    props: {
        accountCredentials: {
            type: Object,
            required: false,
            default: function() {
                return this.form;
            }
        },
        accountType: {
            type: String,
            required: false,
            default: ''
        }
    },

    mounted() {
        this.form = this.accountCredentials;
    },

    methods: {
        emitUpdate() {
            this.$emit('updated', JSON.stringify(this.form));
        }
    }
};
