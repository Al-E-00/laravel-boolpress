<template>
    <div class="row row-cols-3 mt-5">
        <div class="card mb-3" style="width: 18rem;" v-for="post in posts" :key="post.id">
            <img :src="'/storage/' + post.image_path" class="card-img-top" :alt="post.title">
            <div class="card-body">
                <h5 class="card-title"> {{post.title}} </h5>
                <p class="card-text">
                    {{post.content}}</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            posts: []
        }
    },
    methods: {
        fetchPosts() {
            axios.get("/api/posts")
            .then((resp) => {
                this.posts = resp.data
            })
        }
    },
    mounted() {
        this.fetchPosts();
    }
}
</script>