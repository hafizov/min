<template>
    <div>
        <form role="form" v-on:submit.prevent="onSubmit">

            <div class="input-group">
                <input type="text"
                       class="form-control"
                       placeholder="Input your link e.g (http://example.com/ or https://example.com/)"
                       v-model="link"
                       required
                       pattern="^(http|https):\/\/(.*)">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" v-if="!loading">Уменьшить</button>
                    <button class="btn btn-primary" disabled v-else>Подождите...</button>
                </div>
            </div>

            <div class="form-group">
                <a data-toggle="collapse"
                   href="#showAdditional"
                   role="button"
                   aria-expanded="false"
                   aria-controls="showAdditional">
                    Show more
                </a>
            </div>

            <div class="form-group">
                <div class="collapse" id="showAdditional">
                    <input type="date" class="form-control" v-model="time">
                </div>
            </div>

        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                link: null,
                time: null,
                loading: false,

                isValid: false,
                validRegex: '^(http|https)://'
            }
        },
        methods: {
            onSubmit() {
                let self = this;
                let url = route('short.store');
                self.loading = true;

                axios.post(url, {
                    original: self.link,
                    expiration: self.time
                })
                    .then(function (response) {
                        let short = response.data.locUrl + "/" + response.data.link.short;
                        Event.fire('short-link-successful-generate', {
                            link: response.data.link,
                            locUrl: response.data.locUrl
                        });
                        self.loading = false;
                        self.link = short;
                    })
                    .catch(function (error) {
                        self.loading = false;
                        console.log(error);
                    })
            }
        },
        mounted() {
            Event.listen('short-link-successful-update', (data) => {
                this.link = data;
            });
        }
    }
</script>