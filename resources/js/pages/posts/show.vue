<template>
    <div>
        <div class="container">
            <h1>Show page #{{ post.id }}</h1>
            <div class="row">
                <div class="col-4">
                    <img :src="post.image_path" alt="" class="img-fluid">
                </div>
                <div class="col">
                    <h1>{{  post.title  }}</h1>
                    <p v-html="post.content"></p>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            post: {}
        }
    },
    mounted() {
        axios.get("/api/posts/" + this.$route.params.slug)
            .then((resp) => {
                const data = resp.data
                this.post = data;
            })
    }

}
</script>