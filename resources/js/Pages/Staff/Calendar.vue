<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
    datas: Object,
    can: Object,
});

$(function (e) {
    var calendarEl = document.getElementById("calendar");
    var calendar = new FullCalendar.Calendar(calendarEl, {
        events: route('calendar.events'),
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
    <Head title="Calendar" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Calendar
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
            </ol>
        </template>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </StaffLayout>
</template>
<style scoped>
    .fc-event {
        background: #0056b3;
        border-color: #0056b3;
        color: #ffffff !important;
    }
</style>