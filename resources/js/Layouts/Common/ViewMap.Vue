<script setup>
const props = defineProps({
    location: String,
    title: String,
});

var map = null;
    var myMarker;
    var myLatlng;

    function initializeGMap(lat, lng) {
        myLatlng = new google.maps.LatLng(lat, lng);

        var myOptions = {
            zoom: 16,
            zoomControl: true,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true,
            panoramio: true
        };

        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

        myMarker = new google.maps.Marker({
            position: myLatlng,
            draggable: true
        });

        myMarker.setMap(map);

    }
    function showModalMap(location) {
        var data = location.split(',');
        initializeGMap(data[0], data[1]);
        $('#verticalycentered').modal('show');
    }
</script>

<template>
    <div>
    <div 
        class="card-icon rounded-circle d-flex align-items-center justify-content-center" 
        @click="showModalMap(location)"
    > 
        <i class="bi bi-geo-alt"></i>
    </div>
    <div>
        <div class="modal fade" id="verticalycentered" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">{{title}}</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">
                        <div style="width: 100%; height: 400px;" id="map_canvas"></div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
            </div>
    </div>
    </div>

</template>