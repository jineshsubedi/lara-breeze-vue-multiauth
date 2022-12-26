<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import NavLink from "@/Components/NavLink.vue";

const form = useForm();
const props = defineProps({
    bookings: {
        type: Object,
        default: () => ({}),
    },
    datas: Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
let SuperAdmin = props.can.includes('SuperAdmin');

let branch = ref(props.filters.branch);
let hall = ref(props.filters.hall);
let purpose = ref(props.filters.purpose);
let place = ref(props.filters.place);
let staff = ref(props.filters.staff);
let type = ref(props.filters.type);

function loadFilter()
{
    Inertia.get(
        route('supervisor.bookings.index'),
        { branch: branch.value, hall: hall.value, purpose: purpose.value, place: place.value, staff: staff.value, type: type.value },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
}

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("supervisor.bookings.destroy", id));
    }
}
</script>
<template>
    <Head title="Booking Page" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Booking
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.bookings.index')" :only="['bookings']"> Booking </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('supervisor.bookings.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New Booking
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Booking</h5>
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <NavLink :active="filters.type == 0 || filters.type == null" :href="route('supervisor.bookings.index',{type: 0})" >All Booking</NavLink>
                        </li>
                        <li class="nav-item">
                            <NavLink :active="filters.type == 1" :href="route('supervisor.bookings.index', {type:1})" >My Booking</NavLink>
                        </li>
                    </ul>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" v-if="SuperAdmin">Branch</th>
                                <th scope="col">Place</th>
                                <th scope="col">Purpose</th>
                                <th scope="col">Date</th>
                                <th scope="col">Booked By</th>
                                <th scope="col">Action</th>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <select v-model="branch" class="form-control" @change="loadFilter">
                                        <option v-for="(branch, bindex) in datas.branches" :key="bindex" :value="branch.id">{{branch.name}}</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="place" class="form-control" @change="loadFilter">
                                        <option v-for="(place, pindex) in datas.places" :key="pindex" :value="place.id">{{place.title}}</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="purpose" class="form-control" @change="loadFilter">
                                        <option v-for="(purpose, prindex) in datas.purposes" :key="prindex" :value="purpose.id">{{purpose.title}}</option>
                                    </select>
                                </td>
                                <td></td>
                                <td>
                                    <select v-model="staff" class="form-control" @change="loadFilter">
                                        <option v-for="(staff, sindex) in datas.staffs" :key="sindex" :value="staff.id">{{staff.name}}</option>
                                    </select>
                                </td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(booking, index) in bookings.data"
                                :key="booking.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row" v-if="SuperAdmin">{{ booking.branch ? booking.branch.name : '' }}</td>
                                <td scope="row">{{ booking.place ? booking.place.title : '' }}</td>
                                <td scope="row">{{ booking.purpose ? booking.purpose.title : '' }}</td>
                                <td scope="row">{{ booking.booking_date }} ({{booking.start_time}} - {{booking.end_time}})</td>
                                <td scope="row">{{ booking.user ? booking.user.name : '' }}</td>
                                <td scope="row">
                                    <div class="btn-group" v-if="booking.booked_by == $page.props.auth.user.id">
                                        <Link :href="route('supervisor.bookings.show', booking.id)"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                        <Link :href="route('supervisor.bookings.getParticipants', booking.id)"
                                            class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-people-fill"></i>
                                        </Link>
                                        <Link :href="route('supervisor.bookings.edit', booking.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(booking.id)"
                                            
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <div v-else class="btn-group">
                                        <Link :href="route('supervisor.bookings.show', booking.id)"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <Pagination class="mt-6" :links="bookings.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </SupervisorLayout>
</template>
