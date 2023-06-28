<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import MapModal from "@/Layouts/Common/MapModal.vue";

const form = useForm();
const props = defineProps({
    attendances: {
        type: Object,
        default: () => ({}),
    },
    staffs: Object,
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
let staff = ref(props.filters.staff);
let from = ref(props.filters.from);
let to = ref(props.filters.to);
function loadFilter()
{
    Inertia.get(
        route('admin.attendances.index'),
        { staff: staff.value, from: from.value, to: to.value},
        {
            preserveState: true,
            replace: true,
        }
    );
}
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
    <Head title="Attendance Page" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Attendance
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.attendances.index')" :only="['attendances', 'filters']"> Attendance </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right">
                
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Attendance</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="filter_from">Attendance From</label>
                            <input type="date" v-model="from" class="form-control" id="filter_from" @change="loadFilter">
                        </div>
                        <div class="col-md-3">
                            <label for="filter_to">Attendance To</label>
                            <input type="date" v-model="to" class="form-control" id="filter_to" @change="loadFilter">
                        </div>
                        <div class="col-md-3">
                            <label for="filter_staff">Staffs</label>
                            <select v-model="staff" class="form-control" id="filter_staff" @change="loadFilter">
                                <option value="">Select Staff</option>
                                <option v-for="(staff,index) in staffs" :key="index" :value="staff.id">{{staff.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Action</th>
                                    <th scope="col">Staff</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Duty Start</th>
                                    <th scope="col">Lunch Start</th>
                                    <th scope="col">Lunch End</th>
                                    <th scope="col">Duty End</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr 
                                    v-for="(attendance, index) in attendances.data"
                                    :key="attendance.id"
                                >
                                    <td scope="row">
                                        <div class="btn-group">
                                            <Link :href="route('admin.attendances.show', attendance.id)"
                                                class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-eye"></i>
                                            </Link>
                                        </div>
                                    </td>
                                    <td scope="row">{{ attendance.user ? attendance.user.name : '' }}</td>
                                    <td scope="row">{{ attendance.attendance_date }}</td>
                                    <td scope="row">
                                        <div v-if="attendance.in_time != null">
                                            <button :class="attendance.in_time_class"  @click="showModal('duty-In', attendance.in_location)"><i class="bi bi-geo-alt"></i> {{attendance.in_time}} {{attendance.in_time_distance}}</button>
                                            <!-- <MapModal :path="'duty-In'+index" :title="'Duty Start At: '+attendance.in_time" :location="attendance.in_location" :key="'duty-In'+index" /> -->
                                        </div>
                                    </td>
                                    <td scope="row">
                                        <div v-if="attendance.lunch_start != null">
                                            <button :class="attendance.lunch_start_class" @click="showModal('lunch-In', attendance.lunch_start_location)"><i class="bi bi-geo-alt"></i> {{attendance.lunch_start}} {{attendance.lunch_start_distance}}</button>
                                            <!-- <MapModal :path="'lunch-In'+index" :title="'Lunch Start At: '+attendance.in_time" :location="attendance.in_location" :key="'Lunch-In'+index"/> -->
                                        </div>
                                    </td>
                                    <td scope="row">
                                        <div v-if="attendance.lunch_end != null">
                                            <button :class="attendance.lunch_end_class" @click="showModal('lunch-Out', attendance.lunch_end_location)"><i class="bi bi-geo-alt"></i> {{attendance.lunch_end}} {{attendance.lunch_end_distance}}</button>
                                            <!-- <MapModal :path="'lunch-Out'+index" :title="'Lunch End At: '+attendance.lunch_end" :location="attendance.lunch_end_location" :key="'Lunch-Out'+index"/> -->
                                        </div>
                                    </td>
                                    <td scope="row">
                                        <div v-if="attendance.out_time != null">
                                            <button :class="attendance.out_time_class" @click="showModal('Duty-Out', attendance.out_location)"><i class="bi bi-geo-alt"></i> {{attendance.out_time}} {{attendance.out_time_distance}}</button>
                                            <!-- <MapModal :path="'Duty-Out'+index" :title="'Duty End At: '+attendance.out_time" :location="attendance.out_location" :key="'Duty-In'+index"/> -->
                                        </div>
                                    </td>
                                    <td scope="row">{{ attendance.attendance_duration }}</td>
                                    <td scope="row"><p v-html="attendance.approve_title"></p></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8">
                                        <Pagination class="mt-6" :links="attendances.links" />
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
    </AdminLayout>
</template>
