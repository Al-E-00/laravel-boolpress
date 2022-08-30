<template>
    <div>
        <h1>Home page</h1>

        <h2 class="mt-5">Posts list</h2>

        <PostsList></PostsList>
    </div>
</template>

<script>
import PostsList from '../frontend/components/PostsList.vue';
export default {
    components: { PostsList }
}
</script>