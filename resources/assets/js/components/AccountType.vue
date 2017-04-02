<template>
    <div>
        <div class="form-group">
            <label>{{ $t('accounts.type') }}</label>
            <select name="type" v-model="type" class="form-control">
                <option value="">{{ $t('app.option_choose') }}</option>
                <option v-for="(type, key, index) in types" :value="key">{{ type }}</option>
            </select>
        </div>
        <div :is="typeSelected" @updated="updated"></div>
    </div>
</template>

<script>
    import typeSsh from './Types/TypeSSH.vue';
    import typeFtp from './Types/TypeFTP.vue';
    import typeMysql from './Types/TypeMySQL.vue';
    import typeWebsite from './Types/TypeWebsite.vue';
    import typeEmail from './Types/TypeEmail.vue';

    export default {

        components: {
            'type-ssh': typeSsh,
            'type-ftp': typeFtp,
            'type-mysql': typeMysql,
            'type-website': typeWebsite,
            'type-email': typeEmail
        },

        props: {
            types: {
                type: Object,
                required: false,
                default: () => {
                    return {
                        'ssh': 'SSH',
                        'ftp': 'FTP',
                        'mysql': 'MySQL',
                        'website': 'Website',
                        'email': 'Email'
                    }
                }
            },
            selectedType: {
                type: String,
                required: false,
                default: ''
            }
        },

        data() {
            return {
                type: '',
                form: '',
            };
        },

        methods: {
            updated(payload) {
                this.form = JSON.parse(payload);
                this.$emit('updated', this.type, this.form);
            }
        },

        computed: {
            typeSelected: function() {
                if (this.type) {
                    return `type-${this.type}`;
                }

                return false;
            }
        },

        watch: {
            selectedType: function(value) {
                this.type = value;
            }
        }
    }
</script>