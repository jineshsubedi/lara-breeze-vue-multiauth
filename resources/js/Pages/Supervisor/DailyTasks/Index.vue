<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import AddTodayTask from "@/Layouts/Common/AddTodayTask.vue"
import { Inertia } from "@inertiajs/inertia";

const form = useForm();
const props = defineProps({
    dtasks: {
        type: Object,
        default: () => ({}),
    },
    kras: Array,
    can: Array
});
let filter = {
    work_date: new Date(),
    status: 'all'
}
function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("supervisor.dailytasks.destroy", id));
    }
}
function filterDailyTask()
{
    Inertia.get(
        route('supervisor.dailytasks.index'),
        { work_date: filter.work_date, status: filter.status },
        {
            preserveState: true,
            replace: true,
        }
    );
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
                    <Link :href="route('supervisor.dailytasks.index')"> Daily Tasks </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#todayTaskModal"><i class="bi bi-plus"></i> Add More</button>
            </div>
            <AddTodayTask :url="route('supervisor.dailytasks.store')" :kras="kras"/>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daily Tasks</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Work Date</th>
                                <th scope="col">Duration</th>
                                <th scope="col">Kra</th>
                                <th scope="col">Description</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>
                                    <input type="date" v-model="filter.work_date" class="form-control" @change="filterDailyTask">
                                </th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>
                                    <select v-model="filter.status" class="form-control" @change="filterDailyTask">
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
                                <th scope="row">{{ index++ }}</th>
                                <td scope="row">{{ dtask.start_time }}</td>
                                <td scope="row">{{ dtask.calculate_duration }}</td>
                                <td scope="row">{{ dtask.kra ? dtask.kra.title : '' }}</td>
                                <td scope="row">{{ dtask.description }}</td>
                                <td scope="row">{{ dtask.status }}</td>
                                <td scope="row">
                                    <div class="btn-group">
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
