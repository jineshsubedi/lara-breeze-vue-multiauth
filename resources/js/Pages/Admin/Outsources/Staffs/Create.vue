<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    outsource: Object,
    status: Object,
})

const form = useForm({
    staff_code: null,
    name: null,
    email: null,
    status: null,
    contract_start: null,
    contract_end: null,
    join_date: null,
    phone_number: null,
    profile_image: null,

    department: null,
    designation: null,
    temporary_address: null,
    citizenship: null,
    sex: null,
    dob: null,
    age: null,

    education: null,
    account_name: null,
    account_number: null,
    cit_number: null,
    ssf_number: null,
    pan_number: null,

    emergency_name: null,
    emergency_relation: null,
    emergency_number: null,
    emergency_other_number: null,

    staff_document: [],
    staff_asset: [],
    staff_medical: [],
    staff_contract: [],
});
function addDocument()
{
    form.staff_document.push({'document_label' : '', 'document_file': ''});
}
function removeDocument(index)
{
    form.staff_document.splice(index, 1)
}
function addAsset()
{
    form.staff_asset.push({'asset_title' : '', 'asset_action': ''});
}
function removeAsset(index)
{
    form.staff_asset.splice(index, 1)
}
function addMedical()
{
    form.staff_medical.push({'medical_type' : '', 'policy_number': '', 'medical_from': '', 'medical_to': ''});
}
function removeMedical(index)
{
    form.staff_medical.splice(index, 1)
}
function addContract()
{
    form.staff_contract.push({'salary' : '', 'position': '', 'contract_start': '', 'contract_end': '', 'current': ''});
}
function removeContract(index)
{
    form.staff_contract.splice(index, 1)
}
</script>
<template>
    <Head title="Outsource New Staff" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Outsource New Staff
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.outsources.index')"> Outsource </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.outsources.staffs.index', outsource.id)"> {{outsource.project_name}} Staffs </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.outsources.staffs.create', outsource.id)"> {{outsource.project_name}} New Staff </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{outsource.project_name}} New Staff</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(route('admin.outsources.staffs.store', outsource.id))
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="profile_image"
                                        class="col-sm-2 col-form-label"
                                        >Profile Image</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="file"
                                            class="form-control"
                                            id="profile_image"
                                            placeholder="profile_image"
                                            @input="form.profile_image = $event.target.files[0]"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.profile_image"
                                        >
                                            {{ form.errors.profile_image }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="staff_code"
                                        class="col-sm-2 col-form-label"
                                        >Employee Code</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="staff_code"
                                            placeholder="staff_code"
                                            v-model="form.staff_code"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.staff_code"
                                        >
                                            {{ form.errors.staff_code }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="name"
                                        class="col-sm-2 col-form-label"
                                        >Employee Name</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="name"
                                            placeholder="name"
                                            v-model="form.name"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.name"
                                        >
                                            {{ form.errors.name }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="email"
                                        class="col-sm-2 col-form-label"
                                        >Email</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="email"
                                            class="form-control"
                                            id="email"
                                            placeholder="email"
                                            v-model="form.email"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.email"
                                        >
                                            {{ form.errors.email }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="phone_number"
                                        class="col-sm-2 col-form-label"
                                        >Phone Number</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="phone_number"
                                            placeholder="phone_number"
                                            v-model="form.phone_number"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.phone_number"
                                        >
                                            {{ form.errors.phone_number }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="contract_start"
                                        class="col-sm-2 col-form-label"
                                        >Contract Start</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="contract_start"
                                            placeholder="contract_start"
                                            v-model="form.contract_start"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.contract_start"
                                        >
                                            {{ form.errors.contract_start }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="contract_end"
                                        class="col-sm-2 col-form-label"
                                        >Contract End</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="contract_end"
                                            placeholder="contract_end"
                                            v-model="form.contract_end"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.contract_end"
                                        >
                                            {{ form.errors.contract_end }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="join_date"
                                        class="col-sm-2 col-form-label"
                                        >Join Date</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="join_date"
                                            placeholder="join_date"
                                            v-model="form.join_date"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.join_date"
                                        >
                                            {{ form.errors.join_date }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="status"
                                        class="col-sm-2 col-form-label"
                                        >Status</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.status" class="form-control">
                                            <option v-for="(sta, stindex) in status" :key="stindex" :value="sta">{{sta}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.status"
                                        >
                                            {{ form.errors.status }}
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row mb-3">
                                    <label
                                        for="department"
                                        class="col-sm-2 col-form-label"
                                        >Department</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="department"
                                            placeholder="department"
                                            v-model="form.department"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.department"
                                        >
                                            {{ form.errors.department }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="designation"
                                        class="col-sm-2 col-form-label"
                                        >Designation</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="designation"
                                            placeholder="designation"
                                            v-model="form.designation"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.designation"
                                        >
                                            {{ form.errors.designation }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="temporary_address"
                                        class="col-sm-2 col-form-label"
                                        >Temporary Address</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="temporary_address"
                                            placeholder="temporary_address"
                                            v-model="form.temporary_address"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.temporary_address"
                                        >
                                            {{ form.errors.temporary_address }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="citizenship"
                                        class="col-sm-2 col-form-label"
                                        >Citizenship</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="citizenship"
                                            placeholder="citizenship"
                                            v-model="form.citizenship"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.citizenship"
                                        >
                                            {{ form.errors.citizenship }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="sex"
                                        class="col-sm-2 col-form-label"
                                        >Gender</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="sex"
                                            placeholder="Male, Female, Other"
                                            v-model="form.sex"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.sex"
                                        >
                                            {{ form.errors.sex }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="dob"
                                        class="col-sm-2 col-form-label"
                                        >DOB</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="dob"
                                            v-model="form.dob"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.dob"
                                        >
                                            {{ form.errors.dob }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="age"
                                        class="col-sm-2 col-form-label"
                                        >Age</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="age"
                                            v-model="form.age"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.age"
                                        >
                                            {{ form.errors.age }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="education"
                                        class="col-sm-2 col-form-label"
                                        >Education</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="education"
                                            placeholder="education"
                                            v-model="form.education"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.education"
                                        >
                                            {{ form.errors.education }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="pan_number"
                                        class="col-sm-2 col-form-label"
                                        >PAN Number</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="pan_number"
                                            placeholder="pan_number"
                                            v-model="form.pan_number"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.pan_number"
                                        >
                                            {{ form.errors.pan_number }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="ssf_number"
                                        class="col-sm-2 col-form-label"
                                        >SSF Number</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="ssf_number"
                                            placeholder="ssf_number"
                                            v-model="form.ssf_number"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.ssf_number"
                                        >
                                            {{ form.errors.ssf_number }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="cit_number"
                                        class="col-sm-2 col-form-label"
                                        >CIT Number</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="cit_number"
                                            placeholder="cit_number"
                                            v-model="form.cit_number"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.cit_number"
                                        >
                                            {{ form.errors.cit_number }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="account_name"
                                        class="col-sm-2 col-form-label"
                                        >Account Name</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="account_name"
                                            placeholder="account_name"
                                            v-model="form.account_name"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.account_name"
                                        >
                                            {{ form.errors.account_name }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="account_number"
                                        class="col-sm-2 col-form-label"
                                        >Account Number</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="account_number"
                                            placeholder="account_number"
                                            v-model="form.account_number"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.account_number"
                                        >
                                            {{ form.errors.account_number }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="emergency_name"
                                        class="col-sm-2 col-form-label"
                                        >Emergency Name</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="emergency_name"
                                            placeholder="emergency_name"
                                            v-model="form.emergency_name"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.emergency_name"
                                        >
                                            {{ form.errors.emergency_name }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="emergency_relation"
                                        class="col-sm-2 col-form-label"
                                        >Emergency Relation</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="emergency_relation"
                                            placeholder="emergency_relation"
                                            v-model="form.emergency_relation"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.emergency_relation"
                                        >
                                            {{ form.errors.emergency_relation }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="emergency_number"
                                        class="col-sm-2 col-form-label"
                                        >Emergency Number</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="emergency_number"
                                            placeholder="emergency_number"
                                            v-model="form.emergency_number"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.emergency_number"
                                        >
                                            {{ form.errors.emergency_number }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="emergency_other_number"
                                        class="col-sm-2 col-form-label"
                                        >Emergency Alternate Number</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="emergency_other_number"
                                            placeholder="emergency_other_number"
                                            v-model="form.emergency_other_number"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.emergency_other_number"
                                        >
                                            {{ form.errors.emergency_other_number }}
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h4 class="mt-3">Staffs Contract</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Salary</th>
                                            <th>Position</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Current</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(st, index) in form.staff_contract" :key="index">
                                            <td>
                                                <input type="text" v-model="form.staff_contract[index].salary" class="form-control" required>
                                            </td>
                                            <td>
                                                <input type="text" v-model="form.staff_contract[index].position" class="form-control" required>
                                            </td>
                                            <td>
                                                <input type="date" v-model="form.staff_contract[index].contract_start" class="form-control" required>
                                            </td>
                                            <td>
                                                <input type="date" v-model="form.staff_contract[index].contract_end" class="form-control" required>
                                            </td>
                                            <td>
                                                <select v-model="form.staff_contract[index].current" class="form-control" required>
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-danger" @click="removeContract(index)"><i class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5">
                                                <div  class="text-danger" v-for="(form) in form.errors.form_contract">
                                                    {{form}}
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <button type="button" class="btn btn-sm btn-outline-primary" @click="addContract"><i class="bi bi-plus"></i>  Add More</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <h4 class="mt-3">Staffs Documents</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Label</th>
                                            <th>File</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(st, index) in form.staff_document" :key="index">
                                            <td>
                                                <input type="text" v-model="form.staff_document[index].document_label" class="form-control" placeholder="DOcument title" required>
                                            </td>
                                            <td>
                                                <input type="file" @input="form.staff_document[index].document_file = $event.target.files[0]" class="form-control" placeholder="DOcument File" required>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-danger" @click="removeDocument(index)"><i class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">
                                                <div  class="text-danger" v-for="(form) in form.errors.asset">
                                                    {{form}}
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <button type="button" class="btn btn-sm btn-outline-primary" @click="addDocument"><i class="bi bi-plus"></i>  Add More</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <h4 class="mt-3">Staffs Assest Taken</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Handover</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(st, index) in form.staff_asset" :key="index">
                                            <td>
                                                <input type="text" v-model="form.staff_asset[index].asset_title" class="form-control" placeholder="Asset title" required>
                                            </td>
                                            <td>
                                                <select v-model="form.staff_asset[index].asset_action" class="form-control" required>
                                                    <option value="1">No</option>
                                                    <option value="2">Yes</option>
                                                    <option value="3">Hold</option>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-danger" @click="removeAsset(index)"><i class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">
                                                <div  class="text-danger" v-for="(form) in form.errors.asset">
                                                    {{form}}
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <button type="button" class="btn btn-sm btn-outline-primary" @click="addAsset"><i class="bi bi-plus"></i>  Add More</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <h4 class="mt-3">Staffs Medical</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Medical Type</th>
                                            <th>Policy Number</th>
                                            <th>Medical from</th>
                                            <th>Medical To</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(st, index) in form.staff_medical" :key="index">
                                            <td>
                                                <select v-model="form.staff_medical[index].medical_type" class="form-control" required>
                                                    <option value="1">Group Medical Insurance</option>
                                                    <option value="2">Group Accidental Insurance</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" v-model="form.staff_medical[index].policy_number" class="form-control" placeholder="policy_number" required>
                                            </td>
                                            <td>
                                                <input type="date" v-model="form.staff_medical[index].medical_from" class="form-control" placeholder="medical_from" required>
                                            </td>
                                            <td>
                                                <input type="date" v-model="form.staff_medical[index].medical_to" class="form-control" placeholder="medical_to" required>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-danger" @click="removeMedical(index)"><i class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">
                                                <div  class="text-danger" v-for="(form) in form.errors.medical">
                                                    {{form}}
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <button type="button" class="btn btn-sm btn-outline-primary" @click="addMedical"><i class="bi bi-plus"></i>  Add More</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="form-group row mb-3">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button
                                            type="submit"
                                            class="btn btn-outline-primary btn-sm"
                                        >
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
