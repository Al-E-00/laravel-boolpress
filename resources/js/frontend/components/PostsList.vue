<template>
    <div>
        <div class="row row-cols-2">
            <div class="col" v-for="post in posts" :key="post.id">
                <div class="card mb-4">
                    <img :src="getImageSrc(post)" class="card-img-top">

                    <div class="card-body">
                        <h5 class="card-title">{{  post.title  }}</h5>
                        <p class="card-text" v-html="post.content"></p>
                        <router-link :to="{name: 'posts.show', params: {slug: post.slug} }" class="btn btn-primary">Detail</router-link>
                    </div>
                </div>

            </div>
        </div>

        <Pagination :current-page="paginationData.current_page" :next-page="paginationData.current_page + 1"
            :total-pages="paginationData.last_page" @changePage="onChangePage"></Pagination>
    </div>
</template>

<script>
import axios from "axios";
import Pagination from "./Pagination.vue";

export default {
    data() {
        return {
            posts: [],
            paginationData: {}
        };
    },
    methods: {
        fetchPosts(newPage = 1) {
            axios.get("/api/posts?page=" + newPage)
                .then((resp) => {
                    this.posts = resp.data.data;
                    this.paginationData = resp.data;
                    console.log(this.posts);
                });
        },
        getImageSrc(post) {
            if (!post.cover_img) {
                return "/images/image-placeholder.jpeg";
            }
            return post.cover_img;
        },
        onChangePage(newPage) {
            this.fetchPosts(newPage);
        }
    },
    mounted() {
        this.fetchPosts();
    },
    components: { Pagination }
}
</script>

<style>
.card-img-top {
    aspect-ratio: 16/9;
    object-fit: cover;
}
</style>