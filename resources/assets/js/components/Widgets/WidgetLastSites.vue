<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>{{ name }}</h4>
        </div>
        <div class="panel-body">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis culpa error est fuga fugiat in itaque magnam possimus quas temporibus, ullam vero voluptatum. Dolorum fuga inventore, non perferendis qui sint!</p>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: "Sites récents"
            }
        },

        mounted() {
            console.log('Widget mounted : last sites');
        }
    }
</script>