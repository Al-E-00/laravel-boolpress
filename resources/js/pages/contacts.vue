<template>
    <div>
        <h1>Contacts page</h1>

        <form @submit.prevent="onFormSubmit">
            <div class="form-group">
                <label for="UserName">User Name</label>
                <input type="text" class="form-control" id="UserName" placeholder="Name" v-model="name">
            </div>

            <div class="form-group">
                <label for="TextArea">Message</label>
                <textarea class="form-control" id="TextArea" rows="3" placeholder="Message" v-model="message"></textarea>
            </div>

            <button class="btn btn-primary" type="submit">Send</button>
        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return  {
            name: "",
            message: "",
        }
    },
    methods: {
        onFormSubmit() {
            axios.post("/api/contacts", {
                name: this.name,
                message: this.message
            })
        }
    }
}
</script>