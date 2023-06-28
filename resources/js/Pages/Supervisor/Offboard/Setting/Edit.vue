<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    offboardsetting: Object,
})

const form = useForm({
    branch_id: props.offboardsetting.branch_id,
    retirement: props.offboardsetting.retirement,
    retirement_alert: props.offboardsetting.retirement_alert,
    retraction: props.offboardsetting.retraction,
});

</script>
<template>
    <Head title="OffboardSetting Edit" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                OffboardSetting Edit
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.offboardsettings.index')"> OffboardSetting </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.offboardsettings.edit', offboardsetting.id)"> Edit </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Edit OffboardSetting</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.put(route('supervisor.offboardsettings.update', offboardsetting.id))
                                "
                            >
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
    </SupervisorLayout>
</template>
