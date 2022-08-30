<template>
    <div>
        <Navbar></Navbar>
        <div class="container">

            <router-view></router-view>

            
        </div>    
    </div>
</template>

<script>
import Navbar from './frontend/components/Navbar.vue';
import PostsList from './frontend/components/PostsList.vue';

export default {
    data() {
        return {
            message: "This is Vue"
        };
    },
    components: { Navbar, PostsList }
}
</script>