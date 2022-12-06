<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import moment from 'moment';

const props = defineProps({
    staffs : Object,
    datas : Object,
    defBranch : Number,
})

const form = useForm({
    branch_id: props.defBranch,
    leave_type_id: 0,
    type: 1,
    start_date: null,
    end_date: null,
    contact_no: null,
    description: null,

    compensation: null,
    documentFile: null,

    accrual: 0,
    apply_before: 0,
    remaining: 0,
    continuous_leave: 0,
    eligible: 0,

    status: null,
    emergency_leave: 0,
    duration: null,

    handover_staff: '',

    join_duration: props.datas.joinduration,
    total_compensation: props.datas.compensatory_off.length,
});
let extra_option = ref('');
let dateField = ref(false);
let docField = ref(0);
let submitBtn = ref(true);

function changeLeaveType(e)
{
    extra_option.value = e.target.selectedOptions[0].dataset.extra
    form.accrual = e.target.selectedOptions[0].dataset.accrual
    form.apply_before = e.target.selectedOptions[0].dataset.apply_before
    form.remaining = e.target.selectedOptions[0].dataset.remaining
    form.continuous_leave = e.target.selectedOptions[0].dataset.continuous_leave
    form.eligible = e.target.selectedOptions[0].dataset.eligible
    if(extra_option.value == '1')
    {
        docField.value = 1;
        dateField.value = false;
    }
    else if(extra_option.value == '0')
    {
        docField.value = 0;
        dateField.value = true;
        if(form.compensation == null)
        {
            submitBtn.value = false
        }else{
            submitBtn.value = true
        }
    }else{
        docField.value = 0;
        dateField.value = false;
    }
    calculateDays()
}

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

function calculateDays()
{
    let start = form.start_date;
    let end = form.end_date;
    let diffDays = 0;
    if(start != null)
    {
        if(end != null)
        {
            var date1 = new Date(start_date.value);
            var date2 = new Date(end_date.value);
            var timeDiff = Math.abs(date2.getTime() - date1.getTime());
            diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
            diffDays = Math.ceil(diffDays + 1);
        }
        let type = form.type
        if(type == 2)
            diffDays = diffDays / 2;
        if(type == 3)
            diffDays = diffDays / 4;
        let continious = form.continuous_leave
        if(continious > 0)
        {
            if(continious < diffDays)
            {
                submitBtn.value = false
                Toast.fire({
                    icon: 'warning',
                    title: 'Sorry you can not take leave more than '+continious+' day(s).'
                })
            }else{
                submitBtn.value = true
            }
        }
        let apply_before = form.apply_before
        var today = moment().startOf('day');
        var startEnd =  moment(start, "YYYY-MM-DD");
        if(apply_before > moment.duration(startEnd.diff(today)).asDays() && end_date != null)
        {
            Toast.fire({
                icon: 'warning',
                title: 'You must apply before '+apply_before+' Days. If you will continue it will go to Emmergency Leave but you have to give reason for Emmergency Leave.'
            })
            form.emergency_leave = 1;
        }else{
            form.emergency_leave = 0;
        }
        if(docField.value == 1 && diffDays > 1){
            docField.value = 2;
        }else{
            docField.value = 1;
        }
        form.duration = diffDays;
    }
}
</script>
<template>
    <Head title="Leave Request" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Leave Request
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.leaves.index')"> Leave </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.leaves.create')"> Request </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New Request</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(route('admin.leaves.store'))
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="leave_type_id"
                                        class="col-sm-2 col-form-label"
                                        >Leave Type</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.leave_type_id" id="leave_type_id" class="form-control" @change="changeLeaveType($event)">
                                            <option value="">Select Leave Type</option>
                                            <option 
                                                v-for="(ltype, lindex) in datas.leaveTypes" 
                                                :key="lindex" 
                                                :value="ltype.id" 
                                                :data-extra="ltype.is_extra"
                                                :data-accrual="ltype.accrual"
                                                :data-apply_before="ltype.apply_before"
                                                :data-eligible="ltype.eligible"
                                                :data-continuous_leave="ltype.continuous_leave"
                                                :data-remaining="ltype.remaining"
                                            >
                                                {{ltype.title}}
                                            </option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.leave_type_id"
                                        >
                                            {{ form.errors.leave_type_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3" v-if="dateField">
                                    <label
                                        for="compensation"
                                        class="col-sm-2 col-form-label"
                                        >Compensation Date</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.compensation" id="compensation" class="form-control">
                                            <option v-for="(comp, cin) in datas.compensatory_off" :key="cin" :value="comp.work_day">{{comp.work_day}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.compensation"
                                        >
                                            {{ form.errors.compensation }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="type"
                                        class="col-sm-2 col-form-label"
                                        >Leave Nature</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.type" id="type" class="form-control">
                                            <option value="">Select Leave Nature</option>
                                            <option v-for="(lnature, nindex) in datas.leaveNatures" :key="nindex" :value="lnature.value">{{lnature.title}}</option>
                                        </select>
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
                                        for="start_date"
                                        class="col-sm-2 col-form-label"
                                        >Start Date</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="start_date"
                                            placeholder="start_date"
                                            v-model="form.start_date"
                                            @change="calculateDays"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.start_date"
                                        >
                                            {{ form.errors.start_date }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="end_date"
                                        class="col-sm-2 col-form-label"
                                        >End Date</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="end_date"
                                            placeholder="end_date"
                                            v-model="form.end_date"
                                            @change="calculateDays"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.end_date"
                                        >
                                            {{ form.errors.end_date }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="description"
                                        class="col-sm-2 col-form-label"
                                        >Description</label
                                    >
                                    <div class="col-sm-10">
                                        <textarea v-model="form.description" class="form-control" id="description" rows="3"></textarea>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.description"
                                        >
                                            {{ form.errors.description }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3" v-if="(docField == 2)">
                                    <label
                                        for="documentFile"
                                        class="col-sm-2 col-form-label"
                                        >Document</label
                                    >
                                    <div class="col-sm-10">
                                        <input type="file" @input="form.documentFile = $event.target.files[0]" accept="image/*" class="form-control" id="documentFile" required>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.documentFile"
                                        >
                                            {{ form.errors.documentFile }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="contact_no"
                                        class="col-sm-2 col-form-label"
                                        >Emergency Contact Number</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="contact_no"
                                            placeholder="contact_no"
                                            v-model="form.contact_no"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.contact_no"
                                        >
                                            {{ form.errors.contact_no }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3" v-if="datas.handover_required == 1">
                                    <label
                                        for="handover_staff"
                                        class="col-sm-2 col-form-label"
                                        >Handover</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.handover_staff" id="handover_staff" class="form-control">
                                            <option value="">Select Staff</option>
                                            <option v-for="(staff, sindex) in staffs" :key="sindex" :value="staff.id">{{staff.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.handover_staff"
                                        >
                                            {{ form.errors.handover_staff }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button
                                            type="submit"
                                            class="btn btn-outline-primary btn-sm"
                                            v-if="submitBtn"
                                        >
                                            Submit
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-outline-secondary btn-sm"
                                            v-else
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
