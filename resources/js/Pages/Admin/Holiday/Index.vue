<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import throttle from "lodash/throttle";

const form = useForm();

const props = defineProps({
    holidays: {
        type: Object,
        default: () => ({}), 
    },
    branches: Object,
    defBranch: Number,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
let SuperAdmin = props.can.includes('SuperAdmin');

let title = ref(props.filters.title);
let from = ref(props.filters.from);
let to = ref(props.filters.to);
let branch = ref(props.defBranch);
function loadFilter()
{
    Inertia.get(
        route('admin.holidays.index'),
        { title: title.value, from: from.value, to: to.value, branch: branch.value},
        {
            preserveState: true,
            replace: true,
        }
    );
}
watch(title, throttle(function (value){
    Inertia.get(
        route('admin.holidays.index'),
        { title: title.value, from: from.value, to: to.value, branch: branch.value},
        {
            preserveState: true,
            replace: true,
        }
    );
}, 500
));

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("admin.holidays.destroy", id));
    }
}
</script>
<template>
    <Head title="Holiday Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Holiday
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.holidays.index')"> Holiday </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('admin.holidays.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> Add Holiday
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" v-if="SuperAdmin">Branch</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th v-if="SuperAdmin">
                                        <select v-model="branch" class="form-control" @change="loadFilter" >
                                            <option value="All">All Branch</option>
                                            <option v-for="(branch, bindex) in branches" :key="bindex" :value="branch.id">{{branch.name}}</option>
                                        </select>
                                    </th>
                                    <th>
                                        <input
                                            type="text"
                                            v-model="title"
                                            placeholder="Search Task By Title"
                                            class="form-control"
                                        />
                                    </th>
                                    <th>
                                        <input
                                            type="date"
                                            v-model="from"
                                            class="form-control"
                                            @change="loadFilter"
                                        />
                                    </th>
                                    <th>
                                        <input
                                            type="date"
                                            v-model="to"
                                            class="form-control"
                                            @change="loadFilter"
                                        />
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr 
                                    v-for="(holiday, index) in holidays.data"
                                    :key="index"
                                >
                                    <th scope="row">{{ ++index }}</th>
                                    <td scope="row" v-if="SuperAdmin">{{ holiday.branch ? holiday.branch.name : '' }}</td>
                                    <td scope="row">{{ holiday.title }}</td>
                                    <td scope="row">{{ holiday.start_date }}</td>
                                    <td scope="row">{{ holiday.end_date }}</td>
                                    <td scope="row">
                                        <div class="btn-group">
                                            <Link :href="route('admin.holidays.edit', holiday.id)"
                                                class="btn btn-sm btn-outline-warning"
                                            >
                                                <i class="bi bi-pencil-square"></i>
                                            </Link>
                                            <button
                                                class="btn btn-sm btn-outline-danger"
                                                @click="destroy(holiday.id)"
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
                                        <Pagination class="mt-6" :links="holidays.links" />
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </AdminLayout>
</template>
