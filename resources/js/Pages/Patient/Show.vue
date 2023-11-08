<script setup>
    import Sidebar from '@/Layouts/Sidebar.vue';
    import { Link } from '@inertiajs/vue3';
    import moment from 'moment';
    import { computed } from 'vue';

    const props = defineProps({
        patient: Object,
        patientAppointments: Object,
        doctor: Object
    })

    function formattedDate(date){
        return moment(date).format('MMMM   D, YYYY');
    }

    const formatTimeToAMPM = (time) => {
        const [hours, minutes] = time.split(':').map(Number);
        const period = hours >= 12 ? 'PM' : 'AM';
        const formattedHours = hours % 12 || 12;
        const formattedMinutes = minutes.toString().padStart(2, '0');
        return `${formattedHours}:${formattedMinutes} ${period}`;
    };

</script>

<template>
    <Sidebar>
        <Head title="Patients"/>
        <template #header>
            <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Patients</h2>
                <a as="button" href='/generate-pdf' class="p-2 rounded-lg text-sm text-white bg-blue-600">Export PDF</a>
            </div>
        </template>

        <div class="container mx-auto p-4">
            <div class="flex flex-col md:flex-row">
                <div class="w-full md:w-2/5 lg:w-2/5 xl:w-2/5"> <!-- 40% width for user details -->
                    <!-- User details section -->

                        <div class="bg-white overflow-hidden shadow rounded-lg border">
                            <div class="px-4 py-5 sm:px-6">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                   Patient Information
                                </h3>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                    This is some information about the user.
                                </p>
                            </div>
                            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                                <dl class="sm:divide-y sm:divide-gray-200">
                                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Full name
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ patient.user.firstname }} {{ patient.user.middlename }} {{ patient.user.lastname }} {{ patient.user.suffix }}
                                        </dd>
                                    </div>
                                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Gender
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ patient.user.gender }}
                                        </dd>
                                    </div>
                                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Email address
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ patient.user.email }}
                                        </dd>
                                    </div>
                                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Phone number
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ patient.user.contact_no }}
                                        </dd>
                                    </div>
                                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Address
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ patient.address }}
                                        </dd>
                                    </div>

                                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Age
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ patient.age }}
                                        </dd>
                                    </div>
                                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Course
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ patient.course }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                </div>
                <div class="w-full md:w-3/5 lg:w-3/5 xl:w-3/5 md:ml-4"> <!-- 60% width for the table -->
                    <!-- Table section -->
                    <div class="bg-white p-6 shadow-sm">
                        <div class="flex justify-between ">
                            <h4 class="text-2xl mb-3">Appointment History</h4>
                            <Link href="/appointment/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-2 mr-4" >+</Link>
                        </div>
                        <table class="w-full text-sm text-left text-black-500 dark:text-gray-400">
                            <thead class="text-xs text-white uppercase text-center bg-gray-50 dark:bg-blue-500 dark:text-white-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Date and Time
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                      Doctor
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                       Service
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Reason
                                     </th>
                                     <th scope="col" class="px-6 py-3">
                                        Status
                                     </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                     </th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr class="bg-blue-200 hover:bg-s-50 text-center font-medium text-black  whitespace-nowrap" v-for="appointment in patientAppointments" :key="appointment.id">

                                    <td scope="row" >
                                        {{ formattedDate(appointment.date)}} at {{ formatTimeToAMPM(appointment.time) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ appointment.doctor.user.firstname }} {{ appointment.doctor.user.middlename }} {{ appointment.doctor.user.lastname }}{{ appointment.doctor.user.suffix }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ appointment.service.name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ appointment.reason }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ appointment.status }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div  class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            <Link :href="'/appointment/show/'+ appointment.id" title="Show Details">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </Link>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Add another table below the first one -->
                    <div class="bg-white p-6 mt-12 shadow-sm">
                        <div class="flex justify-between ">
                            <h4 class="text-2xl mb-3">History And Physical Form</h4>
                            <Link :href="'/healthForm/create/'+patient.id" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-2 mr-4" >+</Link>
                        </div>
                        <table class="w-full text-sm text-left text-black-500 dark:text-gray-400">
                            <thead class="text-xs text-white uppercase text-center bg-gray-50 dark:bg-blue-500 dark:text-white-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Date
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Payment
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr class="bg-blue-200 hover:bg-s-50 text-center font-medium text-black  whitespace-nowrap ">

                                    <td scope="row" >

                                    </td>
                                    <td class="px-6 py-4">

                                    </td>
                                    <td class="px-6 py-4">

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </Sidebar>
</template>

