<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import CenterModal from "@/Components/CenterModal.vue";

const form = useForm();
const approvalform = useForm({
    status: 1,
    remarks: 'Compensatory Allowed'
});

const props = defineProps({
    compensatories: {
        type: Object,
        default: () => ({}),
    },
    waitings: {
        type: Object,
        default: () => ({}),
    },
    datas: Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("admin.compensatory.destroy", id));
    }
}

function showModal(path) {
    $("#" + path).modal("show");
}
function compensatoryApproval(id) {
    $("#CompensatoryApprovalModal-"+id).modal("hide");

    approvalform.post(route("admin.compensatory.approval", id), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            approvalform.reset()
        },
    });
}
</script>
<template>
    <Head title="Compensatory Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Compensatory
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.compensatory.index')" :only="['compensatories']"> Compensatory </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('admin.compensatory.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> Add New Compensatory
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">My Compensatory</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Waiting For Approval</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane table-responsive fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <br>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Requested By</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Reason</th>
                                        <th scope="col">Inform To</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr 
                                        v-for="(comp, index) in compensatories.data"
                                        :key="comp.id"
                                    >
                                        <th scope="row">{{ ++index }}</th>
                                        <td scope="row">{{ comp.user ? comp.user.name : '' }}</td>
                                        <td scope="row">{{ comp.work_day }}</td>
                                        <td scope="row">{{ comp.reason }}</td>
                                        <td scope="row">{{ comp.inform_to ? comp.inform_to.name : '' }}</td>
                                        <td scope="row"><p v-html="comp.status_label"></p></td>
                                        <td scope="row">
                                            <div class="btn-group" v-if="comp.status == '0'">
                                                <Link :href="route('admin.compensatory.edit', comp.id)"
                                                    class="btn btn-sm btn-outline-warning">
                                                    <i class="bi bi-pencil-square"></i>
                                                </Link>
                                                <button
                                                    class="btn btn-sm btn-outline-danger"
                                                    @click="destroy(comp.id)"
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
                                            <Pagination class="mt-6" :links="compensatories.links" />
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>    
                        </div>
                        <div class="tab-pane table-responsive fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <br>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Requested By</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Reason</th>
                                        <th scope="col">Inform To</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr 
                                        v-for="(comp, index) in waitings"
                                        :key="comp.id"
                                    >
                                        <th scope="row">{{ ++index }}</th>
                                        <td scope="row">{{ comp.user ? comp.user.name : '' }}</td>
                                        <td scope="row">{{ comp.work_day }}</td>
                                        <td scope="row">{{ comp.reason }}</td>
                                        <td scope="row">{{ comp.inform_to ? comp.inform_to.name : '' }}</td>
                                        <td scope="row"><p v-html="comp.status_label"></p></td>
                                        <td scope="row">
                                            <div class="btn-group">
                                                <button
                                                    class="btn btn-sm btn-outline-primary"
                                                    @click="showModal('CompensatoryApprovalModal-'+comp.id)"
                                                >
                                                    <i class="bi bi-check"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <CenterModal
                                                :id="'CompensatoryApprovalModal-'+comp.id"
                                                title="Compensatory Approval Model"
                                            >
                                            <form
                                                class="form-horizontal"
                                                @submit.prevent="compensatoryApproval(comp.id)"
                                            >
                                                <div class="form-group row mb-3">
                                                    <label
                                                        for="status"
                                                        class="col-sm-4 col-form-label"
                                                        >Status</label
                                                    >
                                                    <div class="col-sm-8">
                                                        <select
                                                            v-model="approvalform.status"
                                                            id="status"
                                                            class="form-control"
                                                        >
                                                            <option
                                                                v-for="(
                                                                    status, index
                                                                ) in datas.status"
                                                                :key="index"
                                                                :value="status.value"
                                                            >
                                                                {{ status.title }}
                                                            </option>
                                                        </select>
                                                        <div
                                                            class="text-red-400 text-sm"
                                                            v-if="approvalform.errors.status"
                                                        >
                                                            {{ approvalform.errors.status }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3">
                                                    <label
                                                        for="remarks"
                                                        class="col-sm-4 col-form-label"
                                                        >Remarks</label
                                                    >
                                                    <div class="col-sm-8">
                                                        <textarea v-model="approvalform.remarks" id="remarks" class="form-control" rows="3"></textarea>
                                                        <div
                                                            class="text-red-400 text-sm"
                                                            v-if="approvalform.errors.remarks"
                                                        >
                                                            {{ approvalform.errors.remarks }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="offset-sm-2 col-sm-10">
                                                    <button
                                                        type="submit"
                                                        class="btn btn-outline-primary btn-sm"
                                                    >
                                                        Submit
                                                    </button>
                                                </div>
                                            </form>
                                        </CenterModal> 
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="8">
                                            <Pagination class="mt-6" :links="compensatories.links" />
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                      
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
