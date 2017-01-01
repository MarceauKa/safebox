<template>
    <div>
        <div v-show="records.length > 0 && last_page > 1">
            <hr />
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <ul class="pager" style="margin: 0;">
                        <li :class="{ disabled: is_first_page }"><a @click="prev">{{ $t('pagination.previous') }}</a></li>
                        <li :class="{ disabled: is_last_page }"><a @click="next">{{ $t('pagination.next') }}</a></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <p class="text-center">{{ $t('pagination.showing') }} {{ current_page }} / {{ last_page }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {

        props: {
            source: {
                type: String,
                required: true
            }
        },

        data() {
            return {
                is_first_page: true,
                is_last_page: false,
                current_page: 1,
                last_page: 0,
                next_page_url: null,
                prev_page_url: null,
                to: 0,
                total: 0,
                records: []
            }
        },

        mounted() {
            eventBus.$on('paginatorRefresh', () => {
                this.fetch();
            });

            this.fetch();
        },

        methods: {
            isFirstPage() {
                this.is_first_page = this.current_page == 1;
                return this.is_first_page;
            },

            isLastPage() {
                this.is_last_page = this.current_page == this.last_page;
                return this.is_last_page;
            },

            next() {
              if (this.next_page_url) {
                  this.fetch(this.next_page_url);
              }
            },

            prev() {
                if (this.prev_page_url) {
                    this.fetch(this.prev_page_url);
                }
            },

            fetch(url = null) {
                let query = url === null ? this.source : url;

                this.$http
                        .get(query)
                        .then(response => {
                    this.prev_page_url = response.data.prev_page_url;
                    this.next_page_url = response.data.next_page_url;
                    this.current_page = response.data.current_page;
                    this.last_page = response.data.last_page;
                    this.total = response.data.total;
                    this.to = response.data.to;

                    this.isLastPage();
                    this.isFirstPage();

                    this.records = response.data.data;
                    this.$emit('fetch', this.records);
                });
            }
        },

        watch: {
            source: function(value) {
                this.fetch(value);
            }
        }
    }
</script>