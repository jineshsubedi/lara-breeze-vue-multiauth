<script setup>

const props = defineProps({
    id: String,
    title: String,
});

</script>

<template>
    <div class="modal fade" :id="id" tabindex="-1" style="padding-left: 0px;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{title}}</h5> 
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
                </div>
                <div class="modal-body"> 
                    <slot />
                </div>
                <div class="modal-footer"> 
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button> 
                </div>
            </div>
        </div>
    </div>
</template>