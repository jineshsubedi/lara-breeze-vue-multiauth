<script setup>
    let props = defineProps({
        title: String,
        path: String,
        location: String
    })
    
    var data = props.location.split(',');
    var location = {
        lat: parseFloat(data[0]),
        lng: parseFloat(data[1])
    }
</script>
<template>
    <div class="modal fade" :id="path" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">{{title}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <GMapMap
                        :center="location"
                        :zoom="16"
                        style="width: 100%; height: 20rem"
                    >
                        <GMapMarker
                            :key="path"
                            :icon="'/images/user-location.png'"
                            :position="location"
                        />
                    </GMapMap>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>