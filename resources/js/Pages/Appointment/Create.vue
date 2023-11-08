<script setup>
    import Sidebar from '@/Layouts/Sidebar.vue';
    import { ref, reactive, computed, watch, onMounted } from 'vue';
    import axios from 'axios';
    import { Link , Head} from '@inertiajs/vue3';
    import { useForm } from '@inertiajs/vue3';



    let form = useForm({
       'date' : '',
       'time' : '',
       'user_id': '',
       'reason': '',
       'doc_id': '',
       'service_id': ''

    })

    let props = defineProps({
        appointment: Array,
        doctors: Array,
        services: Object,
        users:Array,
        isAdminOrDoctor:Boolean,
        isDoctor: Boolean,

    });

    const availableServices = ref([]);
    const searchTerm = ref('');
    const searchResults = ref([]);
    const selectedUser = reactive({
        id: null,
        lastname: '',
        firstname: ''
    });

    const searchUsers = async () => {
        try {
            const response = await axios.get(`/api/users/search?term=${searchTerm.value}`);
            const data = response.data; // Assuming the API response contains the search results.
            const activeUsers = data.users.filter(user => user.status === 1);
            searchResults.value = activeUsers; // Update searchResults with the retrieved user data.
        } catch (error) {
            console.error('Error searching for users:', error);
        }
    };


    const selectUser = (user) => {

        // Set the selected user and populate the form fields
        selectedUser.id = user.id;
        selectedUser.fullname = `${user.firstname} ${user.lastname}`;
        form.user_id = user.id; // Populate the user_id field with the selected user's ID

        searchTerm.value = '';
    };

    const fetchServicesByDoctorId = async () => {
        if (form.doc_id) {
            try {
            // Make an API request to fetch services offered by the selected doctor
            const response = await axios.get(`/api/doctors/${form.doc_id}/services`);
            const data = response.data; // Assuming the API response contains the services

            // Update the availableServices array with the fetched services
            availableServices.value = data.services;
            } catch (error) {
            console.error('Error fetching services:', error);
            }
        } else {
            // Clear availableServices if no doctor is selected
            availableServices.value = [];
        }
    };

    const isAdminOrDoctor = props.isAdminOrDoctor;

    onMounted(() => {
  // Fetch services based on the logged-in user's role
  if (props.isDoctor) {
    // User is a doctor, set doctor and services automatically
    const doctor = props.doctors[0]; // You might need to get the correct doctor based on your data
    form.doc_id = doctor.id;
    availableServices.value = doctor.services;
  }
});

const filteredDoctors = computed(() => {
    return props.doctors.filter(doctor => doctor.user.status === 1);
});

    const submit = () =>{
        console.log(props.appointment);
        form.post('/appointment')
    }


</script>

<template>
    <Head title="Create Appointment"/>
    <Sidebar>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Appointment</h2>
        </template>
        <div>
            <div class="w-full mt-10 mx-auto px-4 ">


                <!-- component -->
                <div class="" v-if="isAdminOrDoctor">
                    <div class="inline-flex flex-col justify-center relative text-gray-500">
                        <div class="relative">
                            <input type="text" v-model="searchTerm" @input="searchUsers" placeholder="Search patients by name" class="p-2 pl-8 rounded border border-gray-200 bg-gray-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:border-transparent"/>
                            <svg class="w-4 h-4 absolute left-2.5 top-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <h3 class="mt-2 text-sm">Patients:</h3>
                        <ul class="bg-white border border-gray-100 w-full mt-2 ">
                            <li v-for="user in searchResults" :key="user.id" @click="selectUser(user)" class="pl-8 pr-2 py-1 border-b-2 border-gray-100 relative cursor-pointer hover:bg-yellow-50 hover:text-gray-900">
                                <b>{{ user.firstname }} {{ user.lastname }}</b>
                            </li>

                        </ul>
                    </div>
                </div>

                <form @submit.prevent="submit">
                    <div class="space-y-6">
                        <div class="block pl-12 font-semibold text-xl self-start text-gray-700">
                            <h1 class="leading-relaxed">Appointment Details Form</h1>
                            <hr>
                          </div>
                      <div class="border-b border-gray-900/10 pb-12">
                        <div class=" px-12 py-2 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-3 mx-auto">



                        <div class="sm:col-span-1" v-if="isAdminOrDoctor">
                            <label for="time" class="block text-sm font-medium leading-6 text-gray-900">Patient Name</label>
                            <div class="mt-2">
                              <input id="time" v-model="selectedUser.fullname" name="time" type="text" readonly class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                              <div class="text-sm text-red-500 italic" v-if="form.errors.time">{{ form.errors.time }}</div>
                            </div>
                          </div>
                          <div class="sm:col-span-1">
                            <label for="time" class="block text-sm font-medium leading-6 text-gray-900">Time</label>
                            <div class="mt-2">
                              <input id="time" v-model="form.time" name="time" type="time" autocomplete="time" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                              <div class="text-sm text-red-500 italic" v-if="form.errors.time">{{ form.errors.time }}</div>
                            </div>
                          </div>
                          <div class="sm:col-span-1">
                            <label for="date" class="block text-sm font-medium leading-6 text-gray-900">Date</label>
                            <div class="mt-2">
                              <input id="date" v-model="form.date" name="date" type="date" autocomplete="date" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                              <div class="text-sm text-red-500 italic" v-if="form.errors.date">{{ form.errors.date }}</div>
                            </div>
                          </div>

                          <div class="sm:col-span-1" v-if="!isDoctor">
                                <label for="doctor" class="block text-sm font-medium leading-6 text-gray-900">Doctor</label>
                                <div class="mt-2">
                                <select id="doctor" v-model="form.doc_id" name="doctor" @change="fetchServicesByDoctorId" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                    <option selected disabled >Select doctor</option>
                                    <option v-for="doc in filteredDoctors" :key="doc.id" :value="doc.id">{{ doc.user.firstname }} {{ doc.user.lastname }}</option>
                                </select>
                                <div class="text-sm text-red-500 italic" v-if="form.errors.doc_id">{{ form.errors.doc_id }}</div>
                                </div>
                          </div>


                          <div class="sm:col-span-2" >
                            <label for="service" class="block text-sm font-medium leading-6 text-gray-900">Services</label>
                            <div class="mt-2">
                                <select id="service" v-model="form.service_id"  name="service" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6" >
                                  <option selected disabled >Select services</option>
                                  <option v-for="service in availableServices" :key="service.id" :value="service.id">{{ service.name }}</option>
                                </select>
                                <div class="text-sm text-red-500 italic" v-if="form.errors.service_id">{{ form.errors.service_id }}</div>
                              </div>
                          </div>

                          <div class="sm:col-span-3">
                            <label for="reason" class="block text-sm font-medium leading-6 text-gray-900">Reason</label>
                            <div class="mt-2">
                              <textarea id="reason" v-model="form.reason" name="reason" type="text"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                              <div class="text-sm text-red-500 italic" v-if="form.errors.reason">{{ form.errors.reason }}</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-x-6 mb-3">
                      <!-- <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button> -->
                      <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                    </div>
                  </form>
            </div>
        </div>
    </Sidebar>

</template>
