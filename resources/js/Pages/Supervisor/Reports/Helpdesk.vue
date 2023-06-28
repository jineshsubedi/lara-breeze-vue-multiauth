<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    helpdesks: Object,
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
                    <div class="box-header">User's Helpdesk</div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Task From</th>
                                    <th>KRA</th>
                                    <th>Status</th>
                                    <th>Request Date</th>
                                    <th>Deadline</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(htask, htaskindex) in helpdesks" :key="htaskindex">
                                    <td>{{++htaskindex}}</td>                                
                                    <td>{{htask.title}}</td>                                
                                    <td>{{htask.from_user ? htask.from_user.name : ''}}</td>                                
                                    <td>{{htask.kra ? htask.kra.title : ''}}</td>                                
                                    <td><span v-html="htask.complete_status_label"></span></td>
                                    <td>{{htask.start_time}}</td>
                                    <td>{{htask.finish_time}}</td>
                                    <td>
                                        <Link :href="route('supervisor.helpdesks.show', htask.id)"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <Link :href="route('supervisor.helpdesks.index', {
                                            to: userId
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