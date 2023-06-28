<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    tasks: Object,
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
                    <div class="box-header">User's Tasks</div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Task From</th>
                                    <th>KRA</th>
                                    <th>Weightage</th>
                                    <th>Project</th>
                                    <th>Status</th>
                                    <th>Deadline</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(task, taskindex) in tasks" :key="taskindex">
                                    <td>{{++taskindex}}</td>                                
                                    <td>{{task.title}}</td>                                
                                    <td>{{task.from_user ? task.from_user.name : ''}}</td>                                
                                    <td>{{task.kra ? task.kra.title : ''}}</td>                                
                                    <td>{{task.weightage}}</td>
                                    <td>{{task.project}}</td>
                                    <td><span v-html="task.complete_status[1]"></span></td>
                                    <td>{{task.finish_time}}</td>
                                    <td>
                                        <Link :href="route('supervisor.tasks.show', task.id)"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <Link :href="route('supervisor.tasks.index', {
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