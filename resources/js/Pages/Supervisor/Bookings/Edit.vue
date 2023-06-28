<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import axios from "axios";

const props = defineProps({
    datas: Object,
    booking: Object
})

const form = useForm({
    hall_id: props.booking.hall_id,
    place_id: props.booking.place_id,
    purpose_id: props.booking.purpose_id,
    booking_date: props.booking.booking_date,
    start_time: props.booking.start_time,
    end_time: props.booking.end_time,
    description: props.booking.description,
});

let allHalls = ref([])
loadPlaceHalls()
function loadPlaceHalls()
{
    axios
        .post(route("getHallByPlaceId"), {
            place: form.place_id,
        })
        .then((res) => {
            allHalls.value = res.data;
        })
        .catch((err) => {
            console.log(err);
        });
}

</script>
<template>
    <Head title="Booking Edit" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Booking Edit
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.bookings.index')"> Booking </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.bookings.edit', booking.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New Booking</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.put(route('supervisor.bookings.update', booking.id))
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="purpose_id"
                                        class="col-sm-2 col-form-label"
                                        >Purpose</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.purpose_id" id="purpose_id" class="form-control">
                                            <option v-for="(purpose, prindex) in datas.purposes" :key="prindex" :value="purpose.id">{{purpose.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.purpose_id"
                                        >
                                            {{ form.errors.purpose_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="place_id"
                                        class="col-sm-2 col-form-label"
                                        >Place</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.place_id" class="form-control" @change="loadPlaceHalls">
                                            <option v-for="(place, pindex) in datas.places" :key="pindex" :value="place.id">{{place.title}}</option>
                                    </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.place_id"
                                        >
                                            {{ form.errors.place_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="hall_id"
                                        class="col-sm-2 col-form-label"
                                        >Hall</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.hall_id" class="form-control">
                                            <option v-for="(hall, hindex) in allHalls" :key="hindex" :value="hall.id">{{hall.title}}</option>
                                    </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.hall_id"
                                        >
                                            {{ form.errors.hall_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="booking_date"
                                        class="col-sm-2 col-form-label"
                                        >Booking Date</label
                                    >
                                    <div class="col-sm-10">
                                        <input type="date" v-model="form.booking_date" class="form-control">
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.booking_date"
                                        >
                                            {{ form.errors.booking_date }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group row mb-3">
                                        <label
                                            for="start_time"
                                            class="col-sm-4 col-form-label"
                                            >Start Time</label
                                        >
                                        <div class="col-sm-8">
                                            <input type="time" v-model="form.start_time" class="form-control">
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.start_time"
                                            >
                                                {{ form.errors.start_time }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group row mb-3">
                                        <label
                                            for="end_time"
                                            class="col-sm-4 col-form-label"
                                            >End Time</label
                                        >
                                        <div class="col-sm-8">
                                            <input type="time" v-model="form.end_time" class="form-control">
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.end_time"
                                            >
                                                {{ form.errors.end_time }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="description"
                                        class="col-sm-2 col-form-label"
                                        >Description</label
                                    >
                                    <div class="col-sm-10">
                                        <QuillEditor v-model:content="form.description" id="description" class="form-control" contentType="html" theme="snow" />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.description"
                                        >
                                            {{ form.errors.description }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mt-5 mb-3">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button
                                            type="submit"
                                            class="btn btn-outline-primary btn-sm"
                                        >
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </SupervisorLayout>
</template>
