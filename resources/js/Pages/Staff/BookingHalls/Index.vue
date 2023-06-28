<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import throttle from "lodash/throttle";

const form = useForm();
const props = defineProps({
    bookinghalls: {
        type: Object,
        default: () => ({}),
    },
    bookingplaces: Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
let SuperAdmin = props.can.includes('SuperAdmin');
let place = ref(props.filters.place)
let title = ref(props.filters.title)

function loadFilter()
{
    Inertia.get(
        route('staffs.bookinghalls.index'),
        { place: place.value, title: title.value},
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
}
watch(title, throttle(function (value){
    Inertia.get(
        route('staffs.bookinghalls.index'),
        { place: place.value, title: title.value },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
}, 500
));

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("staffs.bookinghalls.destroy", id));
    }
}
</script>
<template>
    <Head title="BookingHall Page" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                BookingHall
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.bookinghalls.index')" :only="['bookinghalls']"> BookingHall </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('staffs.bookinghalls.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New BookingHall
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">BookingHall</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Place</th>
                                <th scope="col">Title</th>
                                <th scope="col">Action</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>
                                    <select v-model="place" class="form-control" @change="loadFilter">
                                        <option v-for="(p, pindex) in bookingplaces" :key="pindex" :value="p.id">{{p.title}}</option>
                                    </select>
                                </th>
                                <th>
                                    <input type="text" v-model="title" class="form-control">
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(bookinghall, index) in bookinghalls.data"
                                :key="bookinghall.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ bookinghall.place ? bookinghall.place.title : '' }}</td>
                                <td scope="row">{{ bookinghall.title }}</td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('staffs.bookinghalls.edit', bookinghall.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(bookinghall.id)"
                                            v-if="SuperAdmin"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <Pagination class="mt-6" :links="bookinghalls.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </StaffLayout>
</template>
