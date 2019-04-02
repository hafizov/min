<template>
    <div v-if="link">
        <div class="alert alert-secondary" role="alert">
            {{locUrl}}/{{short}}

            <button class="btn btn-warning btn-sm float-right" @click="showUpdate">Изменить</button>
        </div>

        <form role="form" v-on:submit.prevent="onSubmit" v-if="showUpdateForm">

            <div class="input-group">
                <input type="text"
                       class="form-control"
                       placeholder="Input your custom link"
                       v-model="short"
                       required>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" v-if="!loading">Изменить</button>
                    <button class="btn btn-primary" disabled v-else>Подождите...</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                lastShort: null,
                link: null,
                locUrl: null,
                short: null,
                loading: false,
                showUpdateForm: false,
            }
        },

        methods: {
            showUpdate() {
                this.lastShort = this.short;
                this.showUpdateForm = !this.showUpdateForm;
            },

            onSubmit() {
                let self = this;
                let url = route('short.update');
                self.loading = true;

                axios.put(url, {
                    lastShort: self.lastShort,
                    short: self.short,
                })
                    .then(function (response) {
                        let short = response.data.locUrl + "/" + response.data.link.short;
                        Event.fire('short-link-successful-update', short);
                        self.showUpdateForm = false;
                        self.loading = false;
                    })
                    .catch(function (error) {
                        self.loading = false;
                        console.log(error);
                    })
            }
        },

        mounted() {
            Event.listen('short-link-successful-generate', (data) => {
                this.link = data.link;
                this.short = data.link.short;
                this.locUrl = data.locUrl;
            });
        }
    }
</script>