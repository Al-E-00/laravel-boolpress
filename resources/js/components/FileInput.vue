<template>
    <div class="form-group">
        <label :for="name + '_file'" class="form-label">Immagine di copertina</label>

        <div class="d-flex">
            <img id="new_cover_img_container" style="max-width: 250px;" :src="thumbnailLink" alt="">

            <input type="file" :name="name" class="form-control-file " @change="onFileChange" :id="name + '_file'">
        </div>
        <!--  @error('cover_img')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror -->
    </div>
</template>

<script>
export default {

}
</script>