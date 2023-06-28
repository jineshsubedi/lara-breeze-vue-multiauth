<script setup>
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import AddTodayTask from "@/Layouts/Common/AddTodayTask.vue"
import Pagination from "@/Components/Pagination.vue";
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import NavLink from "@/Components/NavLink.vue";
import { Inertia } from "@inertiajs/inertia";
import { ref } from "vue";
import moment from "moment";

const form = useForm();
const props = defineProps({
    dtasks: {
        type: Object,
        default: () => ({}),
    },
    kras: Array,
    staffs: Object,
    aprovalCount: Number,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
let work_date = ref(props.filters.work_date)
let status = ref(props.filters.status)
let type = ref(props.filters.type)
let staff = ref(props.filters.staff)
function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("supervisor.dailytasks.destroy", id));
    }
}
function filterDailyTask()
{
    Inertia.get(
        route('supervisor.dailytasks.index'),
        { work_date: work_date.value, status: status.value, staff: staff.value, type: type.value },
        {
            preserveState: true,
            replace: true,
        }
    );
}
function dtaskDateTime(value)
{
    return moment(value).format('MMMM Do YYYY, h:mm:ss a');
}

const approveForm = useForm({
    selected: [],
});
function approveDTask() {
    approveForm.post(route("supervisor.dailytasks.approve"), {
        preserveScroll: true,
        onSuccess: () => {
            // approveForm.reset();
        },
    });
}
let isCheckAllViewAccess = ref(false);
function selectAllDTask() {
    isCheckAllViewAccess.value = !isCheckAllViewAccess.value;
    approveForm.selected.splice(0);
    if (isCheckAllViewAccess.value) {
        for (var key in props.dtasks.data) {
            approveForm.selected.push(props.dtasks.data[key].id);
        }
    }
}
</script>
<template>
    <Head title="Daily Task Page" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Daily Task
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.dailytasks.index')" :only="['dtasks']"> Daily Tasks </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#todayTaskModal"><i class="bi bi-plus"></i> Add More</button>
                <button type="button" class="btn btn-sm btn-outline-success" @click="approveDTask"><i class="bi bi-check2"></i> Approve</button>
            </div>
            <AddTodayTask :url="route('supervisor.dailytasks.store')" :kras="kras"/>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daily Tasks</h5>
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <NavLink :active="filters.type == 0 || filters.type == null" :href="route('supervisor.dailytasks.index',{type: 0})" >All</NavLink>
                        </li>
                        <li class="nav-item">
                            <NavLink :active="filters.type == 1" :href="route('supervisor.dailytasks.index', {type:1})" >My Daily Work</NavLink>
                        </li>
                        <li class="nav-item">
                            <NavLink :active="filters.type == 2" :href="route('supervisor.dailytasks.index', {type:2})">Daily Work Approval <span class="badge bg-danger">{{aprovalCount}}</span></NavLink>
                        </li>
                    </ul>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <input
                                        type="checkbox"
                                        @change="
                                            selectAllDTask
                                        "
                                    />
                                    Select All
                                </th>
                                <th scope="col">Staff</th>
                                <th scope="col">Work Date</th>
                                <th scope="col">Duration</th>
                                <th scope="col">Kra</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>
                                    <select v-model="staff" class="form-control" @change="filterDailyTask">
                                        <option value="">Select Staff</option>
                                        <option v-for="(staff,sindex) in staffs" :key="sindex" :value="staff.id">{{staff.name}}</option>
                                    </select>
                                </th>
                                <th>
                                    <input type="date" v-model="work_date" class="form-control" @change="filterDailyTask">
                                </th>
                                <th></th>
                                <th>
                                    <select v-model="status" class="form-control" @change="filterDailyTask">
                                        <option value="all">All</option>
                                        <option value="0">Pending</option>
                                        <option value="1">Approved</option>
                                        <option value="2">Rejected</option>
                                    </select>
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(dtask, index) in dtasks.data"
                                :key="dtask.id"
                            >
                                <th scope="row">
                                    <input
                                        type="checkbox"
                                        class="myAttendanceCheckbox"
                                        v-model="
                                            approveForm.selected
                                        "
                                        :value="dtask.id"
                                        v-if="(dtask.user_id != $page.props.auth.user.id && dtask.status == '0')"
                                    />
                                    <span v-else>{{
                                        ++index
                                    }}</span>
                                </th>
                                <td scope="row">{{ dtask.user.name }}</td>
                                <td scope="row">{{ dtaskDateTime(dtask.start_time) }}</td>
                                <td scope="row">{{dtask.duration}} Minute</td>
                                <td scope="row">{{ dtask.kra ? dtask.kra.title : '' }}</td>
                                <td scope="row">{{ dtask.status == 1 ? 'Approved' : 'Pending' }}</td>
                                <td scope="row">
                                    <Link :href="route('supervisor.dailytasks.show', dtask.id)"
                                        class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-eye"></i>
                                    </Link>
                                    <div v-if="dtask.status == '0'">
                                        <div class="btn-group" v-if="dtask.user_id == $page.props.auth.user.id">
                                            <Link :href="route('supervisor.dailytasks.edit', dtask.id)"
                                                class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </Link>
                                            <button
                                                class="btn btn-sm btn-outline-danger"
                                                @click="destroy(dtask.id)"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <Pagination class="mt-6" :links="dtasks.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </SupervisorLayout>
</template>
