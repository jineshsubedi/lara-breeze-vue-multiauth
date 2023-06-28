<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    datas: Object,
})

const form = useForm({
    type: 'domestic',
    assigned_to: null,
    from: null,
    to: null,
    purpose: null,

    destination: [{'from' : '', 'to': '', 'departure_date': '', 'arrival_date': ''}],

    assignment_type: null,
    assignment_category: null,
    mode_of_transport: 'road',
    road_sub: 1,
    advance_required: 0,
    payment_mode: null,
    reimbursement: 1,
    position: null,
    grade: null,
    per_diem_amount: 0.0,

    account_name: null,
    account_number: null,
    bank_name: null,

});
function addDestination()
{
    form.destination.push({'from' : '', 'to': '', 'departure_date': '', 'arrival_date': ''});
}
function removeDestination(index)
{
    form.destination.splice(index, 1)
}

</script>
<template>
    <Head title="Travel Create" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Travel Create
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.travels.index')"> Travel </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.travels.create')"> Create </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New Travel</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(route('supervisor.travels.store'))
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="type"
                                        class="col-sm-2 col-form-label"
                                        >Type</label
                                    >
                                    <div class="col-sm-10">
                                        <span v-for="(type, tindex) in datas.types" :key="tindex">
                                            <input
                                                type="radio"
                                                id="type"
                                                placeholder="type"
                                                v-model="form.type"
                                                :value="type"
                                            />
                                            {{type}} &nbsp; &nbsp;
                                        </span>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.type"
                                        >
                                            {{ form.errors.type }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="assigned_to"
                                        class="col-sm-2 col-form-label"
                                        >Assigned To</label
                                    >
                                    <div class="col-sm-10">
                                    <select v-model="form.assigned_to" class="form-control" id="assigned_to">
                                        <option v-for="(staff, sindex) in datas.staffs" :key="sindex" :value="staff.id">{{staff.name}}</option>
                                    </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.assigned_to"
                                        >
                                            {{ form.errors.assigned_to }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="from"
                                        class="col-sm-2 col-form-label"
                                        >Departure Date</label
                                    >
                                    <div class="col-sm-10">
                                        <input type="date" v-model="form.from" class="form-control" id="from">
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.from"
                                        >
                                            {{ form.errors.from }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="to"
                                        class="col-sm-2 col-form-label"
                                        >Arrival Date</label
                                    >
                                    <div class="col-sm-10">
                                        <input type="date" v-model="form.to" class="form-control" id="to">
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.to"
                                        >
                                            {{ form.errors.to }}
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Departure Date</th>
                                            <th>Departure Place</th>
                                            <th>Arrival Date</th>
                                            <th>Arrival Place</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(st, index) in form.destination" :key="index">
                                            <td>
                                                <input type="date" v-model="form.destination[index].departure_date" class="form-control" placeholder="city" required>
                                            </td>
                                            <td>
                                                <input type="text" v-model="form.destination[index].from" class="form-control" placeholder="city" required>
                                            </td>
                                            <td>
                                                <input type="date" v-model="form.destination[index].arrival_date" class="form-control" placeholder="city" required>
                                            </td>
                                            <td>
                                                <input type="text" v-model="form.destination[index].to" class="form-control" placeholder="city" required>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-danger" @click="removeDestination(index)"><i class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" >
                                                <div class="text-danger" v-for="(form) in form.errors.destination">
                                                    {{form.errors.destination}}
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <button type="button" class="btn btn-sm btn-outline-primary" @click="addDestination()"><i class="bi bi-plus"></i>  Add More</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="form-group row mb-3">
                                    <label
                                        for="assignment_type"
                                        class="col-sm-2 col-form-label"
                                        >Assignment Of Travel</label
                                    >
                                    <div class="col-sm-5">
                                        <select v-model="form.assignment_type" class="form-control" id="assignment_type">
                                            <option v-for="(type, atindex) in datas.assignment_types" :key="atindex" :value="type.id">{{type.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.assignment_type"
                                        >
                                            {{ form.errors.assignment_type }}
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <select v-model="form.assignment_category" class="form-control" id="assignment_category">
                                            <option v-for="(category, ctindex) in datas.assignment_categories" :key="ctindex" :value="category.id">{{category.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.assignment_category"
                                        >
                                            {{ form.errors.assignment_category }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="purpose"
                                        class="col-sm-2 col-form-label"
                                        >Purpose</label
                                    >
                                    <div class="col-sm-10">
                                        <textarea rows="5" v-model="form.purpose" class="form-control" id="purpose"></textarea>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.purpose"
                                        >
                                            {{ form.errors.purpose }}
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row mb-3">
                                    <label
                                        for="mode_of_transport"
                                        class="col-sm-2 col-form-label"
                                        >Mode Of Transport</label
                                    >
                                    <div class="col-sm-10">
                                        <span v-for="(mode, mindex) in datas.modes" :key="mindex">
                                            <input
                                                type="radio"
                                                placeholder="mode_of_transport"
                                                v-model="form.mode_of_transport"
                                                :value="mode"
                                            />
                                            {{mode}} &nbsp; &nbsp;
                                        </span>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.mode_of_transport"
                                        >
                                            {{ form.errors.mode_of_transport }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="road_sub"
                                        class="col-sm-2 col-form-label"
                                        >Road-sub Option</label
                                    >
                                    <div class="col-sm-10">
                                        <span v-for="(road, rindex) in datas.road_subs" :key="rindex">
                                            <input
                                                type="radio"
                                                placeholder="road_sub"
                                                v-model="form.road_sub"
                                                :value="road.value"
                                            />
                                            {{road.title}} &nbsp; &nbsp;
                                        </span>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.road_sub"
                                        >
                                            {{ form.errors.road_sub }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="advance_required"
                                        class="col-sm-2 col-form-label"
                                        >Is Advance Required?</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.advance_required" class="form-control" id="advance_required">
                                            <option v-for="(advr, aindex) in datas.advance_required" :key="aindex" :value="advr.value">{{advr.title}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.advance_required"
                                        >
                                            {{ form.errors.advance_required }}
                                        </div>
                                    </div>
                                </div>
                                <div v-if="form.advance_required == 1">
                                    <div class="form-group row mb-3" >
                                        <label
                                            for="payment_mode"
                                            class="col-sm-2 col-form-label"
                                            >Payment Mode</label
                                        >
                                        <div class="col-sm-10">
                                        <select v-model="form.payment_mode" class="form-control" id="payment_mode">
                                            <option v-for="(pmode, pindex) in datas.payment_mode" :key="pindex" :value="pmode.value">{{pmode.title}}</option>
                                        </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.payment_mode"
                                            >
                                                {{ form.errors.payment_mode }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3" v-if="form.payment_mode == 1">
                                        <label
                                            for="reimbursement"
                                            class="col-sm-2 col-form-label"
                                            >Sub-option</label
                                        >
                                        <div class="col-sm-10">
                                            <span v-for="(reim, rindex) in datas.reimbursement" :key="rindex">
                                                <input
                                                    type="radio"
                                                    placeholder="reimbursement"
                                                    v-model="form.reimbursement"
                                                    :value="reim.value"
                                                />
                                                {{reim.title}} &nbsp; &nbsp;
                                            </span>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.reimbursement"
                                            >
                                                {{ form.errors.reimbursement }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3" v-if="form.payment_mode == 2">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="position">Position</label>
                                                <select class="form-control" v-model="form.position" id="position">
                                                    <option v-for="(level, lindex) in datas.level" :key="lindex" :value="level.value">{{level.title}}</option>
                                                </select>
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.position"
                                                >
                                                    {{ form.errors.position }}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="grade">Grade</label>
                                                <select class="form-control" v-model="form.grade" id="grade">
                                                    <option v-for="(grade, gindex) in datas.grade" :key="gindex" :value="grade.value">{{grade.title}}</option>
                                                </select>
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.grade"
                                                >
                                                    {{ form.errors.grade }}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="per_diem_amount">Per Diem Amount</label>
                                                <input type="number" step="any" v-model="form.per_diem_amount" class="form-control" id="per_diem_amount">
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.per_diem_amount"
                                                >
                                                    {{ form.errors.per_diem_amount }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row mt-3 mb-3">
                                        <h4>Account Details (if the reimbursement or advance need to be done on another account)</h4>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="account_name">Account Name</label>
                                                <input type="text" v-model="form.account_name" class="form-control" id="account_name">
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.account_name"
                                                >
                                                    {{ form.errors.account_name }}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="account_number">Account Number</label>
                                                <input type="text" v-model="form.account_number" class="form-control" id="account_number">
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.account_number"
                                                >
                                                    {{ form.errors.account_number }}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="bank_name">Bank Name</label>
                                                <input type="text" v-model="form.bank_name" class="form-control" id="bank_name">
                                                <div
                                                    class="text-red-400 text-sm"
                                                    v-if="form.errors.bank_name"
                                                >
                                                    {{ form.errors.bank_name }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


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
    </SupervisorLayout>
</template>
