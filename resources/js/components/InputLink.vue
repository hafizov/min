<template>
    <div class="row">

        <div class="col-md-10">

            <div class="form-group">
                <input type="text"
                       class="form-control"
                       placeholder="Input your link"
                       v-model="link"
                       pattern="^(http|https)://">
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

        </div>

        <div class="col-md-2">
            <div class="form-group">
                <button class="btn btn-primary" @click="submit" v-if="!loading">Уменьшить</button>
                <button class="btn btn-primary" disabled v-else>
                    Подождите...
                </button>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                link: null,
                time: null,
                loading: false,
            }
        },
        methods: {
            submit() {
                let self = this;
                let url = route('short.store');
                self.loading = true;

                axios.post(url, {
                    original: self.link,
                    expiration: self.time
                })
                    .then(function (response) {
                        self.loading = false;
                        self.link = response.data.locUrl + "/" + response.data.link.short;
                    })
                    .catch(function (error) {
                        self.loading = false;
                        console.log(error);
                    })
            }
        },
    }
</script>