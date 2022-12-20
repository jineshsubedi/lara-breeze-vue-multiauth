<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    overtime: Object,
    categories: Object,
    staffs: Object,
    holidays: Object
})

const form = useForm({
    login_time: props.overtime.login_time,
    logout_time: props.overtime.logout_time,
    overtime_reason_id: props.overtime.overtime_reason_id,
    ot_hour: props.overtime.ot_hour,
    holiday: props.overtime.holiday,
    remarks: props.overtime.remarks,
    login_date: props.overtime.login_date,
});

</script>
<template>
    <Head title="Overtime Edit" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Overtime Edit
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.overtimes.index')"> Overtime </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.overtimes.edit', overtime.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Edit Overtime</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.put(route('supervisor.overtimes.update', overtime.id))
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="login_date"
                                        class="col-sm-2 col-form-label"
                                        >Logn Date</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="login_date"
                                            placeholder="login_date"
                                            v-model="form.login_date"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.login_date"
                                        >
                                            {{ form.errors.login_date }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="login_time"
                                        class="col-sm-2 col-form-label"
                                        >Logn Time</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="time"
                                            class="form-control"
                                            id="login_time"
                                            placeholder="login_time"
                                            v-model="form.login_time"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.login_time"
                                        >
                                            {{ form.errors.login_time }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="logout_time"
                                        class="col-sm-2 col-form-label"
                                        >Logout Time</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="time"
                                            class="form-control"
                                            id="logout_time"
                                            placeholder="logout_time"
                                            v-model="form.logout_time"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.logout_time"
                                        >
                                            {{ form.errors.logout_time }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="ot_hour"
                                        class="col-sm-2 col-form-label"
                                        >Overtime Hour</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="time"
                                            class="form-control"
                                            id="ot_hour"
                                            placeholder="ot_hour"
                                            v-model="form.ot_hour"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.ot_hour"
                                        >
                                            {{ form.errors.ot_hour }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="overtime_reason_id"
                                        class="col-sm-2 col-form-label"
                                        >Overtime Reason</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.overtime_reason_id" id="overtime_reason_id" class="form-control">
                                        <option v-for="(category, index) in categories" :key="index" :value="category.id">{{ category.title }}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.overtime_reason_id"
                                        >
                                            {{ form.errors.overtime_reason_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="holiday"
                                        class="col-sm-2 col-form-label"
                                        >Holiday</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.holiday" id="holiday" class="form-control">
                                        <option v-for="(holiday, index) in holidays" :key="index" :value="holiday.value">{{ holiday.title }}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.holiday"
                                        >
                                            {{ form.errors.holiday }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="remarks"
                                        class="col-sm-2 col-form-label"
                                        >Remarks</label
                                    >
                                    <div class="col-sm-10">
                                        <textarea v-model="form.remarks" id="remarks" class="form-control" rows="3"></textarea>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.remarks"
                                        >
                                            {{ form.errors.remarks }}
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
