<template>
    <div>
        <!-- Buttons -->
        <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-default" @click="copyToClipboard($event)">{{ $t('password.copy') }}</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            password: {
                type: String,
                required: true
            }
        },

        methods: {
            copyToClipboard(event) {
                let $elem = $(event.target).eq(0),
                    $input = $('<input type="text" />').attr('value', this.password);

                $elem.attr('disabled', true).addClass('btn-primary');

                $input.appendTo('body');
                $input.select();
                document.execCommand('copy');

                setTimeout(() => {
                    $elem.attr('disabled', false).removeClass('btn-primary');
                }, 400)

                $input.remove();
            }
        }
    }
</script>