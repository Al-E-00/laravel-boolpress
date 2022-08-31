<template>
    <div>
        <div class="container">
            <h1 class="mt-4">Show page #{{ post.id }}</h1>
            <div class="row">
                <div class="col-4">

                    <img :src='post.image_path' style="width: 350px" class="mt-4"/>
                    
                </div>
                <div class="col">
                    <h1>{{  post.title  }}</h1>
                    <h3>Post by {{post.user.name}}</h3>
                    <p v-html="post.content"></p>

                    <div class="mt-3" v-if="post.category">
                        <h4>Category:</h4>  {{post.category.name}}</div>
                    <div class="mt-3" v-if="post.tags.length > 0">
                        <h4>Tags:</h4>
                        <ul>
                            <li v-for="tag in post.tags" :key="tag.id">{{tag.name}}</li>
                        </ul>    
                    </div>
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