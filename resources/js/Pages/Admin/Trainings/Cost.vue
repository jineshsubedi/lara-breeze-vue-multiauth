<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import CenterModal from "@/Components/CenterModal.vue";

const form = useForm();
const cForm = useForm({
    attach : []
});

const props = defineProps({
    costs: {
        type: Object,
        default: () => ({}),
    },
    training: Object,
    can: Array
});
let SuperAdmin = props.can.includes('SuperAdmin');
let TrainingHandler = props.can.includes('TrainingHandler');

function  destroy(id, training_id) {
    if (confirm("Are you sure?")) {
        form.delete(route("admin.trainings.deleteCosts", [training_id, id]));
    }
}
function addCategory()
{
    cForm.attach.push({'quantity' : '', 'title': '', 'total_cost': ''});
}
function removeCategory(index)
{
    cForm.attach.splice(index, 1)
}
function addMoreCostModal()
{
    $('#addMoreCostModal').modal('show');
}
function handleAddMoreCostModal()
{
    cForm.reset();
    $('#addMoreCostModal').modal('hide');
}
</script>
<template>
    <Head title="Training Cost Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Training Cost
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.trainings.index')" :only="['trainings']"> Training </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.trainings.getCosts', training.id)" :only="['costs']"> Training Costs </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <button type="button" class="btn btn-sm btn-outline-primary" @click="addMoreCostModal">Add More Attachment</button>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Training Attachment</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Attachment</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(cost, index) in costs.data"
                                :key="cost.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ cost.title }}</td>
                                <td scope="row">{{ cost.quantity }}</td>
                                <td scope="row">{{ cost.total_cost }}</td>
                                <td scope="row">
                                    <div class="btn-group">
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(cost.id, cost.training_id)"
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
                                    <Pagination class="mt-6" :links="costs.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <CenterModal
                    :id="'addMoreCostModal'"
                    title="Training Attachment Form"
                >
                    <form
                        class="form-horizontal"
                        @submit.prevent="
                            cForm.post(route('admin.trainings.saveCosts', training.id),{
                                preserveScroll: true,
                                onSuccess: () => handleAddMoreCostModal()
                            })
                        "
                    >
                        <div class="form-group mb-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Quantity</th>
                                        <th>Total Cost</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(st, index) in cForm.attach" :key="index">
                                        <td>
                                            <input type="text" v-model="cForm.attach[index].title" class="form-control" required>
                                        </td>
                                        <td>
                                            <input type="number" v-model="cForm.attach[index].quantity" class="form-control" required>
                                        </td>
                                        <td>
                                            <input type="number" step="any" v-model="cForm.attach[index].total_cost" class="form-control" required>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-danger" @click="removeCategory(index)"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-right">
                                            <button type="button" class="btn btn-sm btn-outline-primary" @click="addCategory"><i class="bi bi-plus"></i>  Add More</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-sm-12">
                            <button
                                type="submit"
                                class="btn btn-outline-primary btn-sm"
                            >
                                Submit
                            </button>
                        </div>
                    </form>
            </CenterModal>
        </div>
    </AdminLayout>
</template>
