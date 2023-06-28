<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    attendances: Object,
    auth: Boolean,
    userId: Number
});
const form = useForm();

const form2 = useForm({
    position: {lat: 51.093048, lng: 6.842120},
    title: 'Attendance Map'
});
function showModal(path, location)
{
    var data = location.split(',');
    form2.position.lat = parseFloat(data[0]);
    form2.position.lng = parseFloat(data[1]);
    form2.title = path
    $('#jineshsubedi').modal('show');
}
</script>

<template>
    <div>
        <div class="mt-3 row">
            <div class="col-xl-12">
                <div class="box">
                    <div class="box-header">User's Attendance</div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Duty Start</th>
                                    <th scope="col">Duty End</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(attendance, attendanceindex) in attendances" :key="attendanceindex">
                                    <td>{{++attendanceindex}}</td>                                
                                    <td>{{attendance.attendance_date}}</td>                                
                                    <td>
                                        <div v-if="attendance.in_time != null">
                                            <button :class="attendance.in_time_class"  @click="showModal('duty-In', attendance.in_location)"><i class="bi bi-geo-alt"></i> {{attendance.in_time}} {{attendance.in_time_distance}}</button>
                                        </div>
                                    </td>                                
                                    <td>
                                        <div v-if="attendance.out_time != null">
                                            <button :class="attendance.out_time_class" @click="showModal('Duty-Out', attendance.out_location)"><i class="bi bi-geo-alt"></i> {{attendance.out_time}} {{attendance.out_time_distance}}</button>
                                        </div>
                                    </td>                                
                                    <td scope="row">{{ attendance.attendance_duration }}</td>
                                    <td scope="row"><p v-html="attendance.approve_title"></p></td>
                                    <td>
                                        <Link :href="route('admin.attendances.show', attendance.id)"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <Link :href="route('admin.attendances.index', {
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
        <div class="modal fade" id="jineshsubedi" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">{{form2.title}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">
                        <GMapMap
                            :center="form2.position"
                            :zoom="16"
                            style="width: 100%; height: 20rem"
                        >
                            <GMapMarker
                                key="apple"
                                :icon="'/images/user-location.png'"
                                :position="form2.position"
                            />
                        </GMapMap>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
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