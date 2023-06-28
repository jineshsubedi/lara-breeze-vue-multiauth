<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import CenterModal from "@/Components/CenterModal.vue";
import { ref } from "vue";

const form = useForm();
const props = defineProps({
    disciplinaryactions: {
        type: Object,
        default: () => ({}),
    },
    terminationTypes: Array,
    termination_status: String,
    terminationTypes: Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
let SuperAdmin = props.can.includes('SuperAdmin');

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("staffs.disciplinaryactions.destroy", id));
    }
}
const terminateForm = useForm({
    termination_type: null,
    termination_detail: null,
    status: props.termination_status,
    offBoarding_date: null,
});
let terminateStaffRoute = ref('');
function terminationModal(id)
{
    terminateStaffRoute.value = route('staffs.disciplinaryactions.terminatestaff', id)
    if(terminateStaffRoute.value != '')
        $('#TerminationModal').modal('show');
}
function submitTerminationForm()
{
    terminateForm.post(terminateStaffRoute.value, {
        preserveScroll: true,
        onSuccess: () => {
            closeTerminationModal()
        },
    });
}
function closeTerminationModal()
{
    $('#TerminationModal').modal('hide');
    terminateForm.reset();
    terminateStaffRoute.value = '';
}
</script>
<template>
    <Head title="DisciplinaryAction Page" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                DisciplinaryAction
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.disciplinaryactions.index')" :only="['disciplinaryactions']"> DisciplinaryAction </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <Link :href="route('staffs.disciplinaryactions.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New DisciplinaryAction
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">DisciplinaryAction</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Branch</th>
                                <th scope="col">Staff</th>
                                <th scope="col">Disciplinary Ground</th>
                                <th scope="col">Issued By</th>
                                <th scope="col">Issued Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(disciplinaryaction, index) in disciplinaryactions.data"
                                :key="disciplinaryaction.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ disciplinaryaction.branch ? disciplinaryaction.branch.name : '' }}</td>
                                <td scope="row">{{ disciplinaryaction.user ? disciplinaryaction.user.name : '' }}</td>
                                <td scope="row">{{ disciplinaryaction.grounds ? disciplinaryaction.grounds.title : '' }}</td>
                                <td scope="row">{{ disciplinaryaction.isseudby ? disciplinaryaction.isseudby.name : '' }}</td>
                                <td scope="row">{{ disciplinaryaction.issued_date }}</td>
                                <td scope="row">
                                    <span v-html="disciplinaryaction.status" v-if="disciplinaryaction.termination === 0"></span>
                                    <span v-else-if="disciplinaryaction.termination === 1" class="badge bg-danger">Terminated</span>
                                    <span v-else class="badge bg-success">Hold</span>
                                </td>
                                <td scope="row">
                                    <div class="btn-group" v-if="disciplinaryaction.termination == 0">
                                        <Link :href="route('staffs.disciplinaryactions.show', disciplinaryaction.id)"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                        <Link :href="route('staffs.disciplinaryactions.edit', disciplinaryaction.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(disciplinaryaction.id)"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="terminationModal(disciplinaryaction.id)"
                                        >
                                            <i class="bi bi-cross"></i> Terminate
                                        </button>
                                        <Link :href="route('staffs.disciplinaryactions.holdstaff', disciplinaryaction.id)"
                                            class="btn btn-sm btn-outline-success">
                                            Hold
                                        </Link>
                                    </div>
                                    <div class="btn btn-group" v-else>
                                        <Link :href="route('staffs.disciplinaryactions.show', disciplinaryaction.id)"
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
                                    <Pagination class="mt-6" :links="disciplinaryactions.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <CenterModal
                :id="'TerminationModal'"
                title="Staff Termination Form"
            >
                <form
                    class="form-horizontal"
                    @submit.prevent="submitTerminationForm()"
                >
                    <div class="form-group row mb-3">
                        <label
                            for="termination_type"
                            class="col-sm-4 col-form-label"
                            >Termination Type</label
                        >
                        <div class="col-sm-8">
                            <select
                                v-model="terminateForm.termination_type"
                                id="termination_type"
                                class="form-control"
                            >
                                <option v-for="(type, tindex) in terminationTypes" :key="tindex" :value="type.id">{{type.title}}</option>
                                
                            </select>
                            <div
                                class="text-red-400 text-sm"
                                v-if="terminateForm.errors.termination_type"
                            >
                                {{ terminateForm.errors.termination_type }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            for="offBoarding_date"
                            class="col-sm-4 col-form-label"
                            >Offboarding Date</label
                        >
                        <div class="col-sm-8">
                            <input type="date" v-model="terminateForm.offBoarding_date" id="offBoarding_date" class="form-control">
                            <div
                                class="text-red-400 text-sm"
                                v-if="terminateForm.errors.offBoarding_date"
                            >
                                {{ terminateForm.errors.offBoarding_date }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            for="termination_detail"
                            class="col-sm-4 col-form-label"
                            >Termination Detail</label
                        >
                        <div class="col-sm-8">
                            <textarea rows="5" v-model="terminateForm.termination_detail" id="termination_detail" class="form-control"></textarea>
                            <div
                                class="text-red-400 text-sm"
                                v-if="terminateForm.errors.termination_detail"
                            >
                                {{ terminateForm.errors.termination_detail }}
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
        </div>
    </StaffLayout>
</template>
