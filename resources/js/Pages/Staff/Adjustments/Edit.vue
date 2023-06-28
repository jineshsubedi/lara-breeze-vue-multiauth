<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    adjustment: Object,
    categories: Object,
    staffs: Object
})

const form = useForm({
    login_time: props.adjustment.login_time,
    logout_time: props.adjustment.logout_time,
    adjustment_reason_id: props.adjustment.adjustment_reason_id,
    time_to_be_adjusted: props.adjustment.time_to_be_adjusted,
    informed_to: props.adjustment.informed_to,
    remarks: props.adjustment.remarks,
    login_date: props.adjustment.login_date,
});

</script>
<template>
    <Head title="Adjustment Edit" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Adjustment Edit
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.adjustments.index')"> Adjustment </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.adjustments.edit', adjustment.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Edit Adjustment</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.put(route('staffs.adjustments.update', adjustment.id))
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
                                        for="time_to_be_adjusted"
                                        class="col-sm-2 col-form-label"
                                        >Time To Be Adjusted</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="time"
                                            class="form-control"
                                            id="time_to_be_adjusted"
                                            placeholder="time_to_be_adjusted"
                                            v-model="form.time_to_be_adjusted"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.time_to_be_adjusted"
                                        >
                                            {{ form.errors.time_to_be_adjusted }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="adjustment_reason_id"
                                        class="col-sm-2 col-form-label"
                                        >Adjustment Reason</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.adjustment_reason_id" id="adjustment_reason_id" class="form-control">
                                        <option v-for="(category, index) in categories" :key="index" :value="category.id">{{ category.title }}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.adjustment_reason_id"
                                        >
                                            {{ form.errors.adjustment_reason_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="informed_to"
                                        class="col-sm-2 col-form-label"
                                        >Inform To</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.informed_to" id="informed_to" class="form-control">
                                        <option v-for="(staff, index) in staffs" :key="index" :value="staff.id">{{ staff.name }}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.informed_to"
                                        >
                                            {{ form.errors.informed_to }}
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
    </StaffLayout>
</template>
