<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import NavLink from "@/Components/NavLink.vue";

const form = useForm();
const props = defineProps({
    subordinates: {
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

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("supervisor.subordinates.destroy", id));
    }
}
</script>
<template>
    <Head title="Subordinate Page" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Subordinate
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.subordinates.index')" :only="['subordinates']"> Subordinate </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('supervisor.subordinates.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> Comment Your Supervisor
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Subordinate</h5>
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <NavLink :active="filters.type == 'mynote' || filters.type == null" :href="route('supervisor.subordinates.index',{type: 'mynote'})" >My Notes</NavLink>
                        </li>
                        <li class="nav-item">
                            <NavLink :active="filters.type == 'others'" :href="route('supervisor.subordinates.index', {type:'others'})" >Subordinate Notes</NavLink>
                        </li>
                    </ul>
                    <div v-if="filters.type == 'mynote' || filters.type == null" class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Comment</th>
                                    <th scope="col">Rating</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr 
                                    v-for="(subordinate, index) in subordinates.data"
                                    :key="subordinate.id"
                                >
                                    <th scope="row">{{ ++index }}</th>
                                    <td scope="row">{{ subordinate.comment }}</td>
                                    <td scope="row">{{ subordinate.rating }}</td>
                                    <td scope="row">{{ subordinate.created_at }}</td>
                                    <td scope="row">
                                        <div class="btn-group">
                                            <Link :href="route('supervisor.subordinates.show', subordinate.id)"
                                                class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-eye"></i>
                                            </Link>
                                            <Link :href="route('supervisor.subordinates.edit', subordinate.id)"
                                                class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </Link>
                                            <button
                                                class="btn btn-sm btn-outline-danger"
                                                @click="destroy(subordinate.id)"
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
                                        <Pagination class="mt-6" :links="subordinates.links" />
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div v-if="filters.type == 'others'">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Comment By</th>
                                    <th scope="col">Comment</th>
                                    <th scope="col">Rating</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr 
                                    v-for="(subordinate, index) in subordinates.data"
                                    :key="subordinate.id"
                                >
                                    <th scope="row">{{ ++index }}</th>
                                    <td scope="row">{{ subordinate.user ? subordinate.user.name : '' }}</td>
                                    <td scope="row">{{ subordinate.comment }}</td>
                                    <td scope="row">{{ subordinate.rating }}</td>
                                    <td scope="row">{{ subordinate.created_at }}</td>
                                    <td scope="row">
                                        <div class="btn-group">
                                            <Link :href="route('supervisor.subordinates.show', subordinate.id)"
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
                                        <Pagination class="mt-6" :links="subordinates.links" />
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </SupervisorLayout>
</template>
