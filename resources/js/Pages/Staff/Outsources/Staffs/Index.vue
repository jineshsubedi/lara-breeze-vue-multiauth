<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import throttle from "lodash/throttle";
import Pagination from "@/Components/Pagination.vue";
import LargeModal from "@/Components/LargeModal.vue";

const props = defineProps({
    outsource: Object,
    staffs: Object,
    statuss: Object,
    datas: Object,
    filters: Object,
})
const form = useForm({});
const importForm = useForm({
    outsource_importStaff: null
});
const checklistForm = useForm({
    group_medical_insurance: 'yes',
    group_accidental_insurance: 'yes',
    assets: 'yes',
    id_card: 'yes',
    experience_letter: 'yes',
    salary_settlement: 'yes',
    warning_letter: 'yes',
    pending_work: 'yes',
    advance_payment: 'yes',
});

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("staffs.outsources.staffs.destroy", [props.outsource.id, id]));
    }
}
let modalTitle = ref('');
let modalRoute = ref('');
function openCHecklistFormModel(id, title, checklist)
{
    checklistForm.reset();
    if(checklist != null)
    {
        checklistForm.group_medical_insurance = checklist.group_medical_insurance;
        checklistForm.group_accidental_insurance = checklist.group_accidental_insurance;
        checklistForm.assets = checklist.assets;
        checklistForm.id_card = checklist.id_card;
        checklistForm.experience_letter = checklist.experience_letter;
        checklistForm.salary_settlement = checklist.salary_settlement;
        checklistForm.warning_letter = checklist.warning_letter;
        checklistForm.pending_work = checklist.pending_work;
        checklistForm.advance_payment = checklist.advance_payment;
    }
    modalTitle.value = title;
    modalRoute.value = route('staffs.outsources.staffs.checklist',[props.outsource.id, id])
    $('#openCHecklistFormModel').modal('show');
}
function submitChecklistForm()
{
    checklistForm.reset();
    $('#openCHecklistFormModel').modal('hide');
}

let code = ref(props.filters.code);
let name = ref(props.filters.name);
let email = ref(props.filters.email);
let status = ref(props.filters.status);
let from = ref(props.filters.from);
let to = ref(props.filters.to);

function loadFilter()
{
    Inertia.get(
        route('staffs.outsources.staffs.index', props.outsource.id),
        { code: code.value, from: from.value, to: to.value, name: name.value, email: email.value, status: status.value },
        {
            preserveState: true,
            replace: true,
        }
    );
}
watch([code, name, email], throttle(function (value){
    Inertia.get(
        route('staffs.outsources.staffs.index', props.outsource.id),
        { code: code.value, from: from.value, to: to.value, name: name.value, email: email.value, status: status.value },
        {
            preserveState: true,
            replace: true,
        }
    );
}, 500
));
function exportOutsource()
{
    Inertia.get(
        route('staffs.outsources.staffs.export_staff', props.outsource.id),
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
}
function uploadFileToImport()
{
    importForm.post(
        route('staffs.outsources.staffs.import_staff', props.outsource.id),
        {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => importForm.reset(),
        },
    )
}
</script>
<template>
    <Head title="Outsource Staffs" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Outsource Staffs
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.outsources.index')"> Outsource </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.outsources.show', outsource.id)"> Information </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.outsources.staffs.index', outsource.id)"> Staffs </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="text-right">
                            <a :href="datas.import" v-if="datas.import != ''" class="btn btn-sm btn-info"><i class="bi bi-upload"></i> Import Sample</a>
                            <button type="button" class="btn btn-sm btn-outline-success" @click="exportOutsource">Export</button>
                            <a :href="datas.excel" v-if="datas.excel != ''" class="btn btn-sm btn-success"><i class="bi bi-download"></i></a>
                            &nbsp;
                            <Link :href="route('staffs.outsources.staffs.create', outsource.id)" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-plus"></i> New Outsource
                            </Link>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{outsource.project_name}} - Staffs Lists</h5>
                            <label for="">Import Staff </label>&nbsp;
                            <input type="file" @input="importForm.outsource_importStaff = $event.target.files[0]" @change="uploadFileToImport()" accept=".xls,.xlsx">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Employee Code</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Contract From</th>
                                            <th>Contract To</th>
                                            <th>Action</th>
                                        </tr>
                                        <tr>
                                            <th>
                                                <input type="text" v-model="code" class="form-control">
                                            </th>
                                            <th>
                                                <input type="text" v-model="name" class="form-control">
                                            </th>
                                            <th>
                                                <input type="text" v-model="email" class="form-control">
                                            </th>
                                            <th>
                                                <select v-model="status" class="form-control" @change="loadFilter">
                                                    <option v-for="(sta, sindex) in statuss" :key="sindex" :value="sta">{{sta}}</option>
                                                </select>
                                            </th>
                                            <th>
                                                <input type="date" v-model="from" class="form-control" @change="loadFilter">
                                            </th>
                                            <th>
                                                <input type="date" v-model="to" class="form-control" @change="loadFilter">
                                            </th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(staff, sindex) in staffs.data" :key="sindex">
                                            <td>{{staff.staff_code}}</td>
                                            <td>{{staff.name}}</td>
                                            <td>{{staff.email}}</td>
                                            <td>{{staff.status}}</td>
                                            <td>{{staff.contract_start}}</td>
                                            <td>{{staff.contract_end}}</td>
                                            <td class="btn-group">
                                                <button type="button" class="btn btn-sm btn-outline-primary" @click="openCHecklistFormModel(staff.id, staff.name+' Checklist', staff.checklist)"><i class="bi bi-person-check"></i></button>
                                                <Link :href="route('staffs.outsources.staffs.show', [outsource.id, staff.id])"
                                                    class="btn btn-sm btn-outline-info">
                                                    <i class="bi bi-eye"></i>
                                                </Link>
                                                <Link :href="route('staffs.outsources.staffs.edit', [outsource.id, staff.id])"
                                                    class="btn btn-sm btn-outline-warning">
                                                    <i class="bi bi-pencil-square"></i>
                                                </Link>
                                                <button
                                                        class="btn btn-sm btn-outline-danger"
                                                        @click="destroy(staff.id)"
                                                    >
                                                        <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>
                                                <Pagination class="mt-6" :links="staffs.links" />
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <LargeModal
                :id="'openCHecklistFormModel'"
                :title="modalTitle"
            >
                <form
                    class="form-horizontal"
                    @submit.prevent="checklistForm.post(modalRoute, {
        preserveScroll:true,
        onSuccess: () => submitChecklistForm()
    })"
                >
                    <div class="form-group row mb-3">
                        <label
                            for="checklistForm"
                            class="col-sm-4 col-form-label"
                            >Group Medical Insurance</label
                        >
                        <div class="col-sm-8">
                            <select
                                v-model="checklistForm.group_medical_insurance"
                                id="group_medical_insurance"
                                class="form-control"
                            >
                                <option value="yes">YES</option>
                                <option value="no">NO</option>
                                
                            </select>
                            <div
                                class="text-red-400 text-sm"
                                v-if="checklistForm.errors.group_medical_insurance"
                            >
                                {{ checklistForm.errors.group_medical_insurance }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            for="group_accidental_insurance"
                            class="col-sm-4 col-form-label"
                            >Group Accidental Insurance</label
                        >
                        <div class="col-sm-8">
                            <select
                                v-model="checklistForm.group_accidental_insurance"
                                id="group_accidental_insurance"
                                class="form-control"
                            >
                                <option value="yes">YES</option>
                                <option value="no">NO</option>
                                
                            </select>
                            <div
                                class="text-red-400 text-sm"
                                v-if="checklistForm.errors.group_accidental_insurance"
                            >
                                {{ checklistForm.errors.group_accidental_insurance }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            for="assets"
                            class="col-sm-4 col-form-label"
                            >Assets</label
                        >
                        <div class="col-sm-8">
                            <select
                                v-model="checklistForm.assets"
                                id="assets"
                                class="form-control"
                            >
                                <option value="yes">YES</option>
                                <option value="no">NO</option>
                                
                            </select>
                            <div
                                class="text-red-400 text-sm"
                                v-if="checklistForm.errors.assets"
                            >
                                {{ checklistForm.errors.assets }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            for="id_card"
                            class="col-sm-4 col-form-label"
                            >ID Card</label
                        >
                        <div class="col-sm-8">
                            <select
                                v-model="checklistForm.id_card"
                                id="id_card"
                                class="form-control"
                            >
                                <option value="yes">YES</option>
                                <option value="no">NO</option>
                                
                            </select>
                            <div
                                class="text-red-400 text-sm"
                                v-if="checklistForm.errors.id_card"
                            >
                                {{ checklistForm.errors.id_card }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            for="experience_letter"
                            class="col-sm-4 col-form-label"
                            >Experience Letter</label
                        >
                        <div class="col-sm-8">
                            <select
                                v-model="checklistForm.experience_letter"
                                id="experience_letter"
                                class="form-control"
                            >
                                <option value="yes">YES</option>
                                <option value="no">NO</option>
                                
                            </select>
                            <div
                                class="text-red-400 text-sm"
                                v-if="checklistForm.errors.experience_letter"
                            >
                                {{ checklistForm.errors.experience_letter }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            for="salary_settlement"
                            class="col-sm-4 col-form-label"
                            >Salary Settlement</label
                        >
                        <div class="col-sm-8">
                            <select
                                v-model="checklistForm.salary_settlement"
                                id="salary_settlement"
                                class="form-control"
                            >
                                <option value="yes">YES</option>
                                <option value="no">NO</option>
                                
                            </select>
                            <div
                                class="text-red-400 text-sm"
                                v-if="checklistForm.errors.salary_settlement"
                            >
                                {{ checklistForm.errors.salary_settlement }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            for="warning_letter"
                            class="col-sm-4 col-form-label"
                            >Warning Letter</label
                        >
                        <div class="col-sm-8">
                            <select
                                v-model="checklistForm.warning_letter"
                                id="warning_letter"
                                class="form-control"
                            >
                                <option value="yes">YES</option>
                                <option value="no">NO</option>
                                
                            </select>
                            <div
                                class="text-red-400 text-sm"
                                v-if="checklistForm.errors.warning_letter"
                            >
                                {{ checklistForm.errors.warning_letter }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            for="pending_work"
                            class="col-sm-4 col-form-label"
                            >Pending Work</label
                        >
                        <div class="col-sm-8">
                            <select
                                v-model="checklistForm.pending_work"
                                id="pending_work"
                                class="form-control"
                            >
                                <option value="yes">YES</option>
                                <option value="no">NO</option>
                                
                            </select>
                            <div
                                class="text-red-400 text-sm"
                                v-if="checklistForm.errors.pending_work"
                            >
                                {{ checklistForm.errors.pending_work }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            for="advance_payment"
                            class="col-sm-4 col-form-label"
                            >Advance Payment</label
                        >
                        <div class="col-sm-8">
                            <select
                                v-model="checklistForm.advance_payment"
                                id="advance_payment"
                                class="form-control"
                            >
                                <option value="yes">YES</option>
                                <option value="no">NO</option>
                                
                            </select>
                            <div
                                class="text-red-400 text-sm"
                                v-if="checklistForm.errors.advance_payment"
                            >
                                {{ checklistForm.errors.advance_payment }}
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
            </LargeModal>
        </div>
    </StaffLayout>
</template>
