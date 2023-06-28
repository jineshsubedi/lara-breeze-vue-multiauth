<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import ReportLink from "@/Components/ReportLink.vue";

const form = useForm();
const props = defineProps({
    travelplanners: {
        type: Object,
        default: () => ({}),
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
let SuperAdmin = props.can.includes('SuperAdmin');
let HrHandler = props.can.includes('HrHandler');

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("staffs.travelplanners.destroy", id));
    }
}
</script>
<template>
    <Head title="TravelPlanner Page" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                TravelPlanner
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.travelplanners.index')" :only="['travelplanners']"> TravelPlanner </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('staffs.travelplanners.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New TravelPlanner
                </Link>
            </div>
            <div class="card">
                <ul class="nav nav-tabs">
                    <li class="nav-item" v-if="SuperAdmin || HrHandler">
                        <ReportLink
                            :active="
                                filters.tab == 'all'
                            "
                            :href="
                                route('staffs.travelplanners.index', [
                                    { tab: 'all' },
                                ])
                            "
                            :only="['travelplanners', 'filters']"
                            >ALl</ReportLink
                        >
                    </li>
                    <li class="nav-item">
                        <ReportLink
                            :active="
                                filters.tab == null
                            "
                            :href="
                                route('staffs.travelplanners.index', [
                                    { tab: null },
                                ])
                            "
                            :only="['travelplanners', 'filters']"
                            >My Planner</ReportLink
                        >
                    </li>
                    <li class="nav-item">
                        <ReportLink
                            :active="
                                filters.tab == 'waiting'
                            "
                            :href="
                                route('staffs.travelplanners.index', [
                                    { tab: 'waiting' },
                                ])
                            "
                            :only="['travelplanners', 'filters']"
                            >Approval</ReportLink
                        >
                    </li>
                </ul>
                <div class="card-body">
                    <h5 class="card-title">TravelPlanner</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Travel ID</th>
                                <th scope="col">Type</th>
                                <th scope="col">Supervisor</th>
                                <th scope="col">HR</th>
                                <th scope="col">Chairman</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(travelplanner, index) in travelplanners.data"
                                :key="travelplanner.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ travelplanner.travel ? travelplanner.travel.unique_id : '' }}</td>
                                <td scope="row">{{ travelplanner.travel ? travelplanner.travel.type : '' }}</td>
                                <td scope="row"><span v-html="travelplanner.supervisor_action"></span></td>
                                <td scope="row"><span v-html="travelplanner.hr_action"></span></td>
                                <td scope="row"><span v-html="travelplanner.chairman_action"></span></td>
                                <td scope="row">
                                    <div class="btn-group" v-if="filters.tab == null">
                                        <Link :href="route('staffs.travels.show', travelplanner.travel_id)"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                        <Link :href="route('staffs.travelplanners.edit', travelplanner.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(travelplanner.id)"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <div class="btn-group" v-if="filters.tab == 'all'">
                                        <Link :href="route('staffs.travels.show', travelplanner.travel_id)"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                    </div>
                                    <div class="btn-group" v-if="filters.tab == 'waiting'">
                                        <Link :href="route('staffs.travels.show', travelplanner.travel_id)"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                        <Link :href="route('staffs.travelplanners.approval', travelplanner.id)" method="post" :data="{ action: 'Approve' }" class="btn btn-sm btn-outline-success">Approve</Link>
                                        <Link :href="route('staffs.travelplanners.approval', travelplanner.id)" method="post" :data="{ action: 'Reject' }" class="btn btn-sm btn-outline-danger">Reject</Link>

                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <Pagination class="mt-6" :links="travelplanners.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </StaffLayout>
</template>
