<template>
    <div>
        <div class="form-group">
            <label>{{ $t('accounts.types.website.name') }}</label>
            <input type="text" class="form-control" name="name"
                   v-model="form.name" autocomplete="off">
        </div>

        <div class="form-group">
            <label>{{ $t('accounts.types.website.url') }}</label>
            <input type="text" class="form-control" name="url"
                   v-model="form.url" autocomplete="off">
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label>{{ $t('accounts.types.website.login') }}</label>
                    <input type="text" class="form-control" name="login"
                           v-model="form.login" autocomplete="off">
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label>{{ $t('accounts.types.website.password') }}</label>
                    <input type="password" class="form-control" name="password"
                           v-model="form.password" autocomplete="off">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>{{ $t('accounts.types.website.comment') }}</label>
            <textarea class="form-control" name="comment" v-model="form.comment"></textarea>
        </div>
    </div>
</template>

<script>
    import accountsTypesMixins from '../../mixins/accountsTypes';

    export default {

        mixins: [
            accountsTypesMixins
        ],

        data() {
            return {
                form: {
                    name: '',
                    url: '',
                    login: '',
                    password: '',
                    comment: '',
                }
            };
        },

        watch: {
            'form.name': function () {
                this.emitUpdate();
            },
            'form.url': function () {
                this.emitUpdate();
            },
            'form.login': function () {
                this.emitUpdate();
            },
            'form.password': function () {
                this.emitUpdate();
            },
            'form.comment': function () {
                this.emitUpdate();
            }
        }
    }
</script>