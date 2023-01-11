<script>
    import axios from "axios";

    export default {
        components: {

        },
        props:{
            changeFile: { type: Function },
            description: String,
        },
        emits: ['update:changeFile'],
        data: () => {
            return {
                pdfFile: null,
            }
        },
        methods: {
            submitSelectFile() {
                let data = {
                    pdf_file: this.pdfFile,
                };
                this.$emit("changeFile", data);
                // this.$emit('update:modelValue', this.pdfFile)
            },
        },
    }
</script>
<template>
    <div v-if="this.description != ''">
        <input type="file" class="form-control" @input="this.pdfFile = $event.target.files[0]" @change="submitSelectFile">
    </div>
</template>