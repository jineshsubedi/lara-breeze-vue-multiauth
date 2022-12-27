<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    booking: Object,
    myparticipant: Object,
    statuss: Object
})

const form = useForm({
    status: 1,
    remarks: null
});

</script>
<template>
    <Head title="Booking Information" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Booking Information
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.bookings.index')"> Booking </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.bookings.create')" :only="['booking']"> Information </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Booking Information</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Booking Date</th>
                                        <td>{{booking.booking_date}}</td>
                                    </tr>
                                    <tr>
                                        <th>Booking Time</th>
                                        <td>{{booking.start_time}} - {{booking.end_time}}</td>
                                    </tr>
                                    <tr>
                                        <th>Booked By</th>
                                        <td>{{booking.user ? booking.user.name : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Purpose</th>
                                        <td>{{booking.purpose ? booking.purpose.title : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Place</th>
                                        <td>{{booking.place ? booking.place.title : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Hall</th>
                                        <td>{{booking.hall ? booking.hall.title : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td><p v-html="booking.description"></p></td>
                                    </tr>
                                    <tr>
                                        <th>Participants</th>
                                        <td>
                                            <ul class="list-group">
                                                <a 
                                                class="list-group-item list-group-item-action flex-column align-items-start"
                                                v-for="(staff, index) in booking.staffs"
                                                :key="index"
                                                >
                                                    <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">{{staff.user ? staff.user.name : ''}}</h5>
                                                    <small><span class="label" v-html="staff.status_label"></span></small>
                                                    </div>
                                                    <p class="mb-1"><p v-if="staff.remarks != ''" class="text-muted">remarks: {{ staff.remarks }}</p></p>
                                                </a>
                                            </ul>
                                            <br>
                                            <Link :href="route('staffs.bookings.getParticipants', booking.id)" class="btn btn-sm btn-outline-primary" v-if="booking.booked_by == $page.props.auth.user.id"> Add Participants </Link>
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>

                            <div class="mt-5" v-if="myparticipant != null">
                                <h5 class="card-title">Participants Form</h5>
                                <form
                                    class="form-horizontal"
                                    @submit.prevent="
                                        form.post(route('staffs.bookings.updateStatus', myparticipant.id))
                                    "
                                >
                                    <div class="form-group row mb-3">
                                        <label
                                            for="status"
                                            class="col-sm-2 col-form-label"
                                            >Accept Invitation</label
                                        >
                                        <div class="col-sm-10">
                                            <select v-model="form.status" id="status" class="form-control">
                                                <option v-for="(status, prindex) in statuss" :key="prindex" :value="status.value">{{status.title}}</option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.status"
                                            >
                                                {{ form.errors.status }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label
                                            for="remarks"
                                            class="col-sm-2 col-form-label"
                                            >Remarks</label
                                        >
                                        <div class="col-sm-10">
                                            <textarea v-model="form.remarks" id="remarks" class="form-control" rows="3"></textarea>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.remarks"
                                            >
                                                {{ form.errors.remarks }}
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
        </div>
    </StaffLayout>
</template>
