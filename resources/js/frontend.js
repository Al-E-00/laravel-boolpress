import Vue from "vue";
import Frontend from "./Frontend.vue";
import VueRouter from 'vue-router'

Vue.use(VueRouter);


new Vue({
    el: "#app",
    render: h => h(Frontend)
})