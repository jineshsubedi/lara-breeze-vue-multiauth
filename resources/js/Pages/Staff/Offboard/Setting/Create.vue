<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    branches: Object,
})

const form = useForm({
    branch_id: null,
    retirement: null,
    retirement_alert: null,
    retraction: null,
});

</script>
<template>
    <Head title="OffboardSetting Create" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                OffboardSetting Create
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.offboardsettings.index')"> OffboardSetting </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.offboardsettings.create')"> Create </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New OffboardSetting</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(route('staffs.offboardsettings.store'))
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="branch_id"
                                        class="col-sm-2 col-form-label"
                                        >Branch</label
                                    >
                                    <div class="col-sm-10">
                                        <select v-model="form.branch_id" id="branch_id" class="form-control">
                                            <option v-for="(branch, bindex) in branches" :key="bindex" :value="branch.id">{{branch.name}}</option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.branch_id"
                                        >
                                            {{ form.errors.branch_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="retirement"
                                        class="col-sm-2 col-form-label"
                                        >Retirement</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="retirement"
                                            placeholder="retirement"
                                            v-model="form.retirement"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.retirement"
                                        >
                                            {{ form.errors.retirement }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="retirement_alert"
                                        class="col-sm-2 col-form-label"
                                        >Retirement Alert</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="retirement_alert"
                                            placeholder="retirement_alert"
                                            v-model="form.retirement_alert"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.retirement_alert"
                                        >
                                            {{ form.errors.retirement_alert }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label
                                        for="retraction"
                                        class="col-sm-2 col-form-label"
                                        >Retraction</label
                                    >
                                    <div class="col-sm-10">
                                        <input
                                            type="Number"
                                            class="form-control"
                                            id="retraction"
                                            placeholder="retraction"
                                            v-model="form.retraction"
                                        />
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.retraction"
                                        >
                                            {{ form.errors.retraction }}
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
