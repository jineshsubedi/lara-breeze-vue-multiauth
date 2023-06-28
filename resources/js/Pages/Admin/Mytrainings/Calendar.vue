<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import axios from "axios";

const props = defineProps({});
const form = useForm();
$(function (e) {
    var calendarEl = document.getElementById("calendar");
    var calendar = new FullCalendar.Calendar(calendarEl, {
        events: route('admin.mytrainings.calendar'),
        eventClick: function(info){
            loadEventView(info.event.id)
        },
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay",
        },
        footer: {
            left: "",
            center: "",
            right: "prev,next",
        },
        customButtons: {
            prev: {
                text: "Prev",
                click: function () {
                    calendar.prev();
                },
            },
            next: {
                text: "Next",
                click: function () {
                    calendar.next();
                },
            },
        },
    });
    calendar.render();
});

let training = ref([]);

function loadEventView(trainingId)
{
    axios.get(route('admin.mytrainings.getTraining', trainingId))
    .then(res => {
        training.value = res.data
    }).catch(err => {
        console.log(err)
    })
}
</script>

<template>
    <div>
        <div class="mt-3">
            <div class="card">
                <div class="row">
                    <div class="col-md-7">
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card-body">
                            <div>
                                <h5 class="card-title">Below is the planned schedule of the Training program.</h5>
                                <p>Program/Course Name: {{training.program ? training.program.title : ''}} </p>
                                <p>Venue: {{training ? training.venue : ''}} </p>
                                <p v-if="training">Date: {{training.from}} - {{training.to}} </p>
                                <p v-else>Date: </p>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Topic</th>
                                            <th>Time</th>
                                            <th>Duration</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(cat, index) in training.category">
                                            <td>{{cat.idate}}</td>
                                            <td>{{cat.topic}}</td>
                                            <td>{{cat.start_time}} - {{cat.end_time}}</td>
                                            <td>{{cat.duration}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
.card-body
{
    font-size: 13px;
}
</style>