<script setup>

import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import OrgChartVue from "@/Layouts/Common/OrgChart.vue";

const props = defineProps({
    chartDatas: Object,
    branches: Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Object
});

    let SuperAdmin = props.can.includes('SuperAdmin');

    let branch = ref(props.filters.branch);

    function loadFilter()
    {
        Inertia.get(
            route('staffs.organization_chart'),
            { branch: branch.value },
            {
                preserveState: false,
                replace: true,
            }
        );
    }
</script>
<template>
    <Head title="Organization Chart" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Organization Chart
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.organization_chart')"> Chart </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Organization Chart</h5>
                            <div class="row" v-if="SuperAdmin">
                                <div class="col-md-4">
                                    <label for="">Select Branch to filter Chart</label>
                                    <select v-model="branch" class="form-control" @change="loadFilter">
                                        <option v-for="(branch, bin) in branches" :key="bin" :value="branch.id">{{branch.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <OrgChartVue :chartDatas="chartDatas" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </StaffLayout>
</template>
