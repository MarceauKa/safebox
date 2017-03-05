<template>
    <div class="widgets">
        <div class="widgets actions">
            <div class="actions-buttons">
                <button @click="toggleEdit" class="btn btn-primary" v-if="!editing">Manage widgets</button>
                <button @click="toggleEdit" class="btn btn-primary" v-if="editing">Quit editing</button>
                <div class="btn-group" v-if="editing">
                    <button class="btn btn-default" @click="addNew">Add new widget</button>
                </div>
            </div>
        </div>
        <grid-layout :layout="layout"
                     :col-num="12"
                     :row-height="20"
                     :is-draggable="editing"
                     :is-resizable="editing"
                     :vertical-compact="true"
                     :margin="[10, 10]"
                     :class="{'editing': editing}"
                     :use-css-transforms="true">
            <grid-item v-for="item in layout"
                       :x="item.x"
                       :y="item.y"
                       :w="item.w"
                       :h="item.h"
                       :i="item.i">
                <div :is="item.type"></div>
            </grid-item>
        </grid-layout>
    </div>
</template>

<script>

    import { GridLayout, GridItem } from 'vue-grid-layout';
    import WidgetLastSites from './Widgets/WidgetLastSites.vue';
    import WidgetLastClients from './Widgets/WidgetLastClients.vue';

    var testLayout = [
        {"x":0,"y":0,"w":9,"h":7,"i":"0"},
        {"x":9,"y":0,"w":3,"h":11,"i":"1"},
        {"x":0,"y":1,"w":9,"h":7,"i":"2"}
    ];

    export default {
        components: {
            GridLayout,
            GridItem,
            WidgetLastSites,
            WidgetLastClients
        },

        data() {
            return {
                editing: false,
                layout: [],
                widgets: []
            }
        },

        mounted() {
            this.fetchWidgets();
        },

        methods: {
            toggleEdit() {
                this.editing = !this.editing;
            },

            addNew() {
                this.layout.push({"x":0,"y":0,"w":6,"h":7,"i":this.layout.length + 1});
            },

            fetchWidgets() {
                this.layout = [
                    {"x":0, "y":0, "w":9, "h":7, "i":"0", "type": 'WidgetLastClients'},
                    {"x":0,"y":1, "w":9, "h":7, "i":"1", "type": 'WidgetLastSites'}
                ];
            }
        }
    }

</script>
