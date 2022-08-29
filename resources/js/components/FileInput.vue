<template>
    <div class="form-group">
        <label :for="name + '_file'" class="form-label">Image</label>

        <div class="d-flex">
            <img id="new_cover_img_container" style="max-width: 250px;" :src="thumbnailLink" alt="">

            <input type="file" :name="name" class="form-control-file " @change="onFileChange" :id="name + '_file'">
        </div>

    </div>
</template>

<script>
export default {
    props: {
        name: String,
    },
    data() {
        return {
            thumbnailLink: ""
        }
    },
    methods: {
        onFileChange(e) {
            const files = e.target.files;

            const firstFile = files[0];

            if(!firstFile) {
                this.thumbnailLink = "";

                return
            }

            this.thumbnailLink = URL.createObjectURL(firstFile)
        }
    }
}
</script>