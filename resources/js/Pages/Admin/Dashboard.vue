<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from "@inertiajs/inertia";
import MapModal from "@/Layouts/Common/MapModal.vue";
import AddTodayTask from "@/Layouts/Common/AddTodayTask.vue"

const props = defineProps({
    datas: Object,
});
const form1 = useForm({
    location: null,
});

$(function() {
    var x = document.getElementById("demo");
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = '<div class="alert alert-danger">Geolocation is not supported by this browser.</div>';
    }
});

function showPosition(position) {
    form1.location = position.coords.latitude + ',' + position.coords.longitude
}

function submitIntime(type)
{
    Inertia.post(
        route('admin.attendances.store'),
        { type: type, location: form1.location },
        {
            preserveState: true,
            replace: true,
        }
    );
}


const form2 = useForm({
    position: {lat: 51.093048, lng: 6.842120},
});
function showModal(path, location)
{
    var data = location.split(',');
    form2.position.lat = data[0];
    form2.position.lng = data[1];

    $('#'+path).modal('show');
}
</script>

<template> 
    <Head title="Dashboard" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
            </ol>
        </template>

        <div class="row">
            <input type="hidden" id="geo_location" v-model="form1.location"/>
            <div class="col-sm-8 col-md-8 col-lg-8">
                <div class="card info-card customers-card">
                    <div class="card-body">
                        <h5 class="card-title">Attendance <span>| {{datas.today}}</span></h5>
                        <table class="table">
                            <tr v-for="(attendance, index) in datas.attendances" :key="index">
                                <td>        
                                    <div class="d-flex align-items-center" v-if="attendance.in_time">
                                        <div class="ps-3"> 
                                            <div 
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center" 
                                                @click="showModal('duty-In'+index, attendance.in_location)"
                                            > 
                                                <i class="bi bi-geo-alt"></i>
                                            </div>
                                            <p class="small pt-1 fw-bold" :class="attendance.in_class">Check-In</p> 
                                            <p class="small pt-2 ps-1" :class="attendance.in_class">{{attendance.in_time}} {{attendance.in_distance}}</p>
                                        </div>
                                        <MapModal :path="'duty-In'+index" :title="'Duty Start At: '+attendance.in_time" :location="attendance.in_location" :key="'duty-In'+index" />
                                    </div>
                                    <div v-else>
                                        <button type="button" class="btn btn-sm btn-outline-primary" @click="submitIntime('clockin')">CHECK IN</button>
                                    </div>
                                </td>
                                <td>
                                    <div v-if="attendance.in_time">
                                        <div class="d-flex align-items-center" v-if="attendance.lunch_start">
                                            <div class="ps-3"> 
                                                <div 
                                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center" 
                                                    @click="showModal('lunch-In'+index, attendance.lunch_start_location)"
                                                > 
                                                    <i class="bi bi-geo-alt"></i>
                                                </div>
                                                <p class="text-info small pt-1 fw-bold">Lunch-Out</p> 
                                                <p class="text-muted small pt-2 ps-1">{{attendance.lunch_start}}</p>
                                            </div>
                                            <MapModal :path="'lunch-In'+index" :title="'Lunch Start At: '+attendance.in_time" :location="attendance.in_location" :key="'Lunch-In'+index"/>
                                        </div>
                                        <div v-else>
                                            <button type="button" class="btn btn-sm btn-outline-primary" @click="submitIntime('lunchout')">LUNCH OUT</button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div v-if="attendance.lunch_start">
                                        <div class="d-flex align-items-center" v-if="attendance.lunch_end">
                                            <div class="ps-3"> 
                                                <div 
                                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center" 
                                                    @click="showModal('lunch-Out'+index, attendance.lunch_end_location)"
                                                > 
                                                    <i class="bi bi-geo-alt"></i>
                                                </div>
                                                <p class="text-info small pt-1 fw-bold">Lunch-In</p> 
                                                <p class="text-muted small pt-2 ps-1">{{attendance.lunch_end}}</p>
                                            </div>
                                            <MapModal :path="'lunch-Out'+index" :title="'Lunch End At: '+attendance.lunch_end" :location="attendance.lunch_end_location" :key="'Lunch-Out'+index"/>
                                        </div>
                                        <div v-else>
                                            <button type="button" class="btn btn-sm btn-outline-primary" @click="submitIntime('lunchin')">LUNCH IN</button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div v-if="attendance.in_time">
                                        <div class="d-flex align-items-center" v-if="attendance.out_time">
                                            <div class="ps-3"> 
                                                <div 
                                                    class="card-icon rounded-circle d-flex align-items-center justify-content-center" 
                                                    @click="showModal('Duty-Out'+index, attendance.out_location)"
                                                > 
                                                    <i class="bi bi-geo-alt"></i>
                                                </div>
                                                <p class="small pt-1 fw-bold" :class="attendance.out_class">Check-Out</p> 
                                                <p class="small pt-2 ps-1" :class="attendance.out_class">{{attendance.out_time}} {{attendance.out_distance}}</p>
                                            </div>
                                            <MapModal :path="'Duty-Out'+index" :title="'Duty End At: '+attendance.out_time" :location="attendance.out_location" :key="'Duty-In'+index"/>
                                        </div>
                                        <div v-else>
                                            <button type="button" class="btn btn-sm btn-outline-primary" @click="submitIntime('clockout')">CHECK OUT</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="filter"> 
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#todayTaskModal"><i class="bi bi-plus"></i></button>
                            <AddTodayTask :url="route('admin.dailytasks.store')" />
                        </div>
                        <h5 class="card-title">Today's Work</h5>
                        <div class="activity">
                            <div class="activity-item d-flex">
                                <div class="activite-label">32 min</div> 
                                <i class="bi bi-person-workspace activity-badge text-success align-self-start"></i>
                                <div class="activity-content"> 
                                    Roles Crud Operation and Permission
                                </div>
                            </div>
                            <div class="activity-item d-flex">
                                <div class="activite-label">156 min</div> 
                                <i class="bi bi-person-workspace activity-badge text-success align-self-start"></i>
                                <div class="activity-content"> Dashboard Design and other changes</div>
                            </div>
                            <div class="activity-item d-flex">
                                <div class="activite-label">56 min</div> 
                                <i class="bi bi-person-workspace activity-badge text-success align-self-start"></i>
                                <div class="activity-content"> Attendance Module workout</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
        </div>
    </AdminLayout>
</template>
<style>
.dashboard .card-icon {
    font-size: 20px;
    line-height: 0;
    width: 40px;
    height: 40px;
    flex-shrink: 0;
    flex-grow: 0;
}
.dashboard .filter {right: 10px;}
.dashboard .activity .activity-item .activity-badge {font-size: 14px;}
</style>