<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    auth: Boolean,
    userId: Number
});
const form = useForm();
$(function (e) {
    var calendarEl = document.getElementById("calendar");
    var calendar = new FullCalendar.Calendar(calendarEl, {
        events: route('staffs.calendar.index', props.userId),
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
</script>

<template>
    <div>
        <div class="mt-3 row">
            <div class="col-xl-12">
                <div class="box">
                    <div class="box-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
thead,
tbody {
    font-size: 13px;
}
.box{border: 1px solid #ededed; margin:0px; padding:0px;}
.box-header{
    background-color: #8484b3;
    color: #fff;
    padding: 4px 5px;
}
</style>