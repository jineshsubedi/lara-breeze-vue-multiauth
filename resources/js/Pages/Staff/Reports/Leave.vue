<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    leaves: Object,
    auth: Boolean,
    userId: Number
});
const form = useForm();

</script>

<template>
    <div>
        <div class="mt-3 row">
            <div class="col-xl-12">
                <div class="box">
                    <div class="box-header">User's Leave Request</div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                     <th scope="col">Leave Type</th>
                                    <th scope="col">Request Date</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(leave, leaveindex) in leaves" :key="leaveindex">
                                    <td>{{++leaveindex}}</td>                                
                                    <td>
                                        {{leave.leave_type ? leave.leave_type.title : ''}}
                                        {{leave.paid == 0 ? '(PAID)' : '(UNPAID)'}}
                                    </td>                                
                                    <td>{{leave.request_date}}</td>                                
                                    <td>{{leave.start_date}}</td>                                
                                    <td>{{leave.end_date}}</td>                                
                                    <td>{{leave.duration}} Day ({{leave.type_label}})</td>
                                    <td><span v-html="leave.status"></span></td>
                                    <td>
                                        <Link :href="route('staffs.leaves.show', leave.id)"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <Link :href="route('staffs.leaves.index', {
                                            staff: userId
                                        })"
                                            class="">
                                            <i class="bi bi-eye"></i> View All
                                        </Link>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
thead,
tbody {
    font-size: 13px;
}
.box{border: 1px solid #ededed; margin:0px; padding:0px;}
.box-header{
    background-color: #8484b3;
    color: #fff;
    padding: 4px 5px;
}
</style>