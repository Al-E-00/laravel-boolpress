<template>
    <div>
        <Navbar></Navbar>
        <div class="container">
            <h1 class="mt-3">Hello Vue {{  message  }}</h1>
    
            <h2 class="mt-5">Posts list</h2>

            
        </div>    
    </div>
</template>

<script>
import Navbar from './frontend/components/Navbar.vue';

export default {
    data() {
        return {
            message: "This is Vue"
        };
    },
    components: { Navbar }
}
</script>