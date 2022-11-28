<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import throttle from "lodash/throttle";

const form = useForm();
const props = defineProps({
    users: {
        type: Object,
        default: () => ({}),
    },
    branches: Object,
    datas: Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
let SuperAdmin = props.can.includes('SuperAdmin');
let branch = ref(props.filters.branch_id);
let name = ref('');
let type = ref('');
let status = ref('');

function loadFilter()
{
    Inertia.get(
        route('supervisor.users.index'),
        { branch: branch.value, name: name.value, type: type.value, status: status.value },
        {
            preserveState: true,
            replace: true,
        }
    );
}
watch(name, throttle(function (value){
    Inertia.get(
        route('supervisor.users.index'),
        { branch: branch.value, name: name.value, type: type.value, status: status.value },
        {
            preserveState: true,
            replace: true,
        }
    );
}, 500
));

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("supervisor.users.destroy", id));
    }
}
</script>
<template>
    <Head title="Staffs Page" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Staffs
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.users.index')" :only="['users']"> Staffs </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('supervisor.users.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New Staff
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Staff</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" v-if="SuperAdmin">Branch</th>
                                <th scope="col">Name</th>
                                <th scope="col">Work Mode</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                            <tr v-if="SuperAdmin">
                                <th></th>
                                <th>
                                    <select v-model="branch" class="form-control" @change="loadFilter">
                                        <option value="">Select Branch</option>
                                        <option v-for="(branch, bindex) in branches" :key="bindex" :value="branch.id">{{branch.name}}</option>
                                    </select>
                                </th>
                                <th>
                                    <input
                                        type="text"
                                        v-model="name"
                                        placeholder="Search Staff By Name"
                                        class="form-control"
                                    />
                                </th>
                                <th>
                                    <select v-model="type" class="form-control" @change="loadFilter" >
                                        <option value="">Work Mode</option>
                                        <option v-for="(type, bindex) in datas.types" :key="bindex" :value="type">{{type}}</option>
                                    </select>
                                </th>
                                <th>
                                    <select v-model="status" class="form-control" @change="loadFilter" >
                                        <option value="">Status</option>
                                        <option v-for="(status, bindex) in datas.status" :key="bindex" :value="status.value">{{status.title}}</option>
                                    </select>
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(user, index) in users.data"
                                :key="user.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row" v-if="SuperAdmin">{{ user.branch.name }}</td>
                                <td scope="row">{{ user.name }}</td>
                                <td scope="row">{{ user.employment_type }}</td>
                                <td scope="row"><p v-html="user.status_label"></p></td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('supervisor.users.show', user.id)"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                        <Link :href="route('supervisor.users.edit', user.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(user.id)"
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
                                    <Pagination class="mt-6" :links="users.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </SupervisorLayout>
</template>
