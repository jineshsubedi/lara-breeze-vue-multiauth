<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import throttle from "lodash/throttle";

const form = useForm();
const props = defineProps({
    trainers: {
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
let TrainingHandler = props.can.includes('TrainingHandler');

let name = ref(props.filters.name);
watch(name, throttle(function (value){
    Inertia.get(
        route('admin.trainers.index'),
        { name: name.value},
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
        form.delete(route("admin.trainers.destroy", id));
    }
}
</script>
<template>
    <Head title="Trainer Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Trainer
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.trainers.index')" :only="['trainers']"> Trainer </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('admin.trainers.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New Trainer
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Trainer</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Action</th>
                            </tr>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">
                                    <input
                                        type="text"
                                        v-model="name"
                                        placeholder="Search Trainer By Name"
                                        class="form-control"
                                    />
                                </th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(trainer, index) in trainers.data"
                                :key="trainer.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ trainer.name }}</td>
                                <td scope="row">{{ trainer.email }}</td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <Link :href="route('admin.trainers.show', trainer.id)"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                        <Link :href="route('admin.trainers.edit', trainer.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(trainer.id)"
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
                                    <Pagination class="mt-6" :links="trainers.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
