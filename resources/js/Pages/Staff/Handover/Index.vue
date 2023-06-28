<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref } from "vue";

const props = defineProps({
    handovers: {
        type: Object,
        default: () => ({}), 
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});

const form = useForm();

const approveForm = useForm({
    selected: [],
});

function approveHandover() {
    approveForm.post(route("staffs.handovers.accept"), {
        preserveScroll: true,
        onSuccess: () => {
            // approveForm.reset();
        },
    });
}

let isCheckAllViewAccess = ref(false);
function selectAllAttendance() {
    isCheckAllViewAccess.value = !isCheckAllViewAccess.value;
    approveForm.selected.splice(0);
    if (isCheckAllViewAccess.value) {
        for (var key in props.handovers.data) {
            approveForm.selected.push(props.handovers.data[key].id);
        }
    }
}

</script>
<template>
    <Head title="Handover Requests Page" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Handover Requests
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.handovers.index')" :only="['handovers']"> Handover Requests </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                <button
                    class="btn btn-sm btn-outline-success"
                    type="button"
                    @click="approveHandover()"
                    data-bs-toggle="tooltip" 
                    data-bs-title="Approve handovers"
                >
                    <i class="bi bi-check2-all"></i> Approve Selected
                </button>
            </div>
            <div class="card">
                <div class="card-body">
                    
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <input
                                            type="checkbox"
                                            @change="
                                                selectAllAttendance
                                            "
                                        />
                                        All
                                    </th>
                                    <th scope="col">From</th>
                                    <th scope="col">Leave Type</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr 
                                    v-for="(hand, index) in handovers.data"
                                    :key="hand.id"
                                >
                                    <th scope="row">
                                        <input
                                            type="checkbox"
                                            class="myAttendanceCheckbox"
                                            v-model="
                                                approveForm.selected
                                            "
                                            :value="hand.id"
                                            v-if="
                                                hand.status !=
                                                '1'
                                            "
                                        />
                                        <span v-else>{{
                                            ++index
                                        }}</span>
                                    </th>
                                    <td scope="row">{{ hand.leave.user ? hand.leave.user.name : '' }}</td>
                                    <td scope="row">{{ hand.leave.leave_type ? hand.leave.leave_type.title : '' }}</td>
                                    <td scope="row">{{ hand.leave ? hand.leave.start_date : '' }}</td>
                                    <td scope="row">{{ hand.leave ? hand.leave.end_date : '' }}</td>
                                    <td scope="row"><span v-html="hand.status_label"></span></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8">
                                        <Pagination class="mt-6" :links="handovers.links" />
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </StaffLayout>
</template>
