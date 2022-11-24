<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import throttle from "lodash/throttle";
import NavLink from "@/Components/NavLink.vue";

const form = useForm();

const props = defineProps({
    tasks: {
        type: Object,
        default: () => ({}), 
    },
    staffs: Object,
    data: Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
let title = ref(props.filters.title);
let from = ref(props.filters.task_from);
let to = ref(props.filters.task_to);
let finish_time = ref(props.filters.finish_time);
let type = ref(props.filters.type);
function loadFilter()
{
    Inertia.get(
        route('staffs.helpdesks.index'),
        { title: title.value, from: from.value, to: to.value, finish_time: finish_time.value, type: type.value },
        {
            preserveState: true,
            replace: true,
        }
    );
}
watch(title, throttle(function (value){
    Inertia.get(
        route('staffs.helpdesks.index'),
        { title: title.value, from: from.value, to: to.value, finish_time: finish_time.value, type: type.value },
        {
            preserveState: true,
            replace: true,
        }
    );
}, 500
));

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("staffs.helpdesks.destroy", id));
    }
}
</script>
<template>
    <Head title="Help Desk Page" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Help Desk
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.helpdesks.index')" :only="['tasks']"> Help Desk </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('staffs.helpdesks.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> Add Help Desk
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <NavLink :active="filters.type == 0 || filters.type == null" :href="route('staffs.helpdesks.index',{type: 0})">All</NavLink>
                        </li>
                        <li class="nav-item">
                            <NavLink :active="filters.type == 1" :href="route('staffs.helpdesks.index', {type:1})">TO DO</NavLink>
                        </li>
                        <li class="nav-item">
                            <NavLink :active="filters.type == 2" :href="route('staffs.helpdesks.index', {type:2})">My Help Desk</NavLink>
                        </li>
                        <li class="nav-item">
                            <NavLink :active="filters.type == 3" :href="route('staffs.helpdesks.index', {type:3})">Help Desk Assigned</NavLink>
                        </li>
                    </ul>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Task From</th>
                                    <th scope="col">Task To</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Deadline</th>
                                    <th scope="col">Action</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>
                                        <input
                                            type="text"
                                            v-model="title"
                                            placeholder="Search Task By Title"
                                            class="form-control"
                                        />
                                    </th>
                                    <th>
                                        <select v-model="from" class="form-control" @change="loadFilter" >
                                            <option value="">Task Provider</option>
                                            <option v-for="(staff, bindex) in staffs" :key="bindex" :value="staff.id">{{staff.name}}</option>
                                        </select>
                                    </th>
                                    <th>
                                        <select v-model="to" class="form-control" @change="loadFilter" >
                                            <option value="">Task Assigned</option>
                                            <option v-for="(staff, bindex) in staffs" :key="bindex" :value="staff.id">{{staff.name}}</option>
                                        </select>
                                    </th>
                                    <th></th>
                                    <th>
                                        <input
                                            type="date"
                                            v-model="finish_time"
                                            placeholder=""
                                            class="form-control"
                                            @change="loadFilter"
                                        />
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr 
                                    v-for="(task, index) in tasks.data"
                                    :key="task.id"
                                >
                                    <th scope="row">{{ ++index }}</th>
                                    <td scope="row">{{ task.title }} ({{task.kra ? task.kra.title : ''}})</td>
                                    <td scope="row">{{ task.from_user ? task.from_user.name : '' }}</td>
                                    <td scope="row">{{ task.to_user ? task.to_user.name : '' }}</td>
                                    <td scope="row"><span v-html="task.complete_status_label"></span></td>
                                    <td scope="row">{{ task.finish_time }}</td>
                                    <td scope="row">
                                        <div class="btn-group">
                                            <Link :href="route('staffs.helpdesks.acceptTask', task.id)" class="btn btn-sm btn-outline-success" v-if="$page.props.auth.user.id == task.task_to && task.accept_status == '0'">
                                                <i class="bi bi-check-lg"></i> Accept
                                            </Link>
                                            <Link :href="route('staffs.helpdesks.completeTask', task.id)" class="btn btn-sm btn-outline-success" v-if="$page.props.auth.user.id == task.task_to && task.accept_status == '1' && task.complete_status == '0'">
                                                <i class="bi bi-check-lg"></i> Complete
                                            </Link>
                                            <Link :href="route('staffs.helpdesks.show', task.id)"
                                                class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-eye"></i> View
                                            </Link>
                                            <Link :href="route('staffs.helpdesks.edit', task.id)"
                                                class="btn btn-sm btn-outline-warning"
                                                v-if="$page.props.auth.user.id == task.task_from"
                                            >
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </Link>
                                            <button
                                                class="btn btn-sm btn-outline-danger"
                                                @click="destroy(task.id)"
                                                v-if="$page.props.auth.user.id == task.task_from"
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
                                        <Pagination class="mt-6" :links="tasks.links" />
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </StaffLayout>
</template>
