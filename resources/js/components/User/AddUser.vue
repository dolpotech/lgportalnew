<template>
    <div>
        <div class="form-group row">
            <div class="col-md-4">
                <label for="role" class="col-sm-4 col-form-label">Role</label>
                <div class="col-sm-8">
                    <select v-model="role" id="role" class="form-control select2 "
                            data-placeholder="Select a Type" style="width: 100%;" name="role">
                        <option value="" disabled selected>Select a Role</option>
                        <option :value="role['slug']" v-for="(role, index) in fetchRoles">{{ role['name'] }}</option>
                    </select>
                    <p v-if="this.errorRole" class="text-danger">{{ this.errorRole }}</p>
                </div>
            </div>
            <div class="col-md-4" v-if="this.role">
                <label for="type" class="col-sm-4 col-form-label">User Type</label>
                <div class="col-sm-8">
                    <select v-model="type" id="type" class="form-control select2 "
                            data-placeholder="Select a Type" style="width: 100%;" name="type">
                        <option value="" disabled selected>Select a Type</option>
                        <option value="local_government" v-if="this.role == 'super_admin' || this.role == 'lg_admin'
                            || this.role == 'lg_cao' || this.role == 'lg_officer'">Local Government
                        </option>
                        <option value="ministry" v-if="this.role == 'super_admin' || this.role == 'ministry_admin' ||
                            this.role == 'ministry_cao' || this.role == 'ministry_officer'">Ministry
                        </option>
                        <option value="ministry_office" v-if="this.role == 'super_admin' || this.role == 'mo_admin' ||
                            this.role == 'mo_cao' || this.role == 'mo_officers'">Ministry Offices
                        </option>
                    </select>
                    <p v-if="this.errorType" class="text-danger">{{ this.errorType }}</p>
                </div>
            </div>
            <div class="col-md-4" v-if="this.type == 'local_government'">
                <label for="lg_role" class="col-sm-4 col-form-label">LG</label>
                <div class="col-sm-8">
                    <select v-model="lg_role" id="lg_role" class="form-control select2"
                            data-placeholder="Select a LG role" style="width: 100%;" name="lg_role">
                        <option value="" disabled selected>Select a LG role</option>
                        <option :value="lg['id']" v-for="(lg, index) in fetchLgRoles">{{ lg['name'] }}</option>
                    </select>
                    <p v-if="this.errorLGRole" class="text-danger">{{ this.errorLGRole }}</p>
                </div>
            </div>
            <div class="col-md-4" v-else-if="this.type == 'ministry'">
                <label for="ministry_role" class="col-sm-4 col-form-label">Ministry</label>
                <div class="col-sm-8">
                    <select v-model="ministry_role" id="ministry_role" class="form-control select2 "
                            data-placeholder="Select a Ministry Role" style="width: 100%;" name="ministry_role">
                        <option value="" disabled selected>Select a Ministry Role</option>
                        <option :value="ministry['id']" v-for="(ministry, index) in fetchMinistryRoles">
                            {{ ministry['name'] }}
                        </option>
                    </select>
                    <p v-if="this.errorMinistryRole" class="text-danger">{{ this.errorMinistryRole }}</p>
                </div>
            </div>
            <div class="col-md-4" v-else-if="this.type == 'ministry_office'">
                <label for="ministry_office_role" class="col-sm-4 col-form-label">Ministry Office</label>
                <div class="col-sm-8">
                    <select v-model="ministry_office_role" id="ministry_office_role" class="form-control select2 "
                            data-placeholder="Select a Ministry Office Role" style="width: 100%;" name="ministry_office_role">
                        <option value="" disabled selected>Select a Ministry Office Role</option>
                        <option :value="ministryOffice['id']" v-for="(ministryOffice, index) in fetchMinistryOfficeRoles">
                            {{ ministryOffice['name'] }}
                        </option>
                    </select>
                    <p v-if="this.errorMinistryOfficeRole" class="text-danger">{{ this.errorMinistryOfficeRole }}</p>
                </div>
            </div>
        </div>
        <div class="form-group row" v-if="this.type == 'ministry'">
            <div class="col-md-4">
                <label for="ministry_department_role" class="col-sm-4 col-form-label">Ministry Department</label>
                <div class="col-sm-8">
                    <select v-model="ministry_department_role" id="ministry_department_role" class="form-control select2 "
                            data-placeholder="Select a Ministry Department Role" style="width: 100%;" name="ministry_department_role">
                        <option value="" disabled selected>Select a Ministry Department Role</option>
                        <option :value="ministryDepartment['id']" v-for="(ministryDepartment, index) in fetchMinistryDepartmentRoles">
                            {{ ministryDepartment['name'] }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-4">
                <label for="first_name" class="col-sm-4 col-form-label">Full Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" v-model="first_name" id="first_name"
                           placeholder="Full Name">
                    <p v-if="this.errorFirstName" class="text-danger">{{ this.errorFirstName }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <label for="address" class="col-sm-4 col-form-label">Address</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" v-model="address" id="middle_name"
                           placeholder="Address">
                </div>
            </div>
            <div class="col-md-4">
                <label for="phone" class="col-sm-4 col-form-label">Phone</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" v-model="phone" id="phone" placeholder="Phone">
                    <p v-if="this.errorPhone" class="text-danger">{{ this.errorPhone }}</p>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-4">
                <label for="email" class="col-sm-4 col-form-label">Email</label>
                <div class="col-sm-8">
                    <input type="email" class="form-control" v-model="email" id="email" placeholder="Email">
                    <p v-if="this.errorEmail" class="text-danger">{{ this.errorEmail }}</p>
                    <p v-if="this.errorValidEmail" class="text-danger">{{ this.errorValidEmail }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <label for="password" class="col-sm-4 col-form-label">Password</label>
                <div class="col-sm-8">
                    <input v-bind:type="[showPassword ? 'text' : 'password']" class="form-control" v-model="password"
                           id="status" placeholder="password">
                    <div class="input-group-append" style ="position:relative; left:197px; top:-38px; height: 38px;">
                          <span class="input-group-text" @click="showPassword = !showPassword">
                                <i class="fa" :class="[showPassword ? 'fa-eye' : 'fa-eye-slash']"
                                   aria-hidden="true"></i>
                          </span>
                    </div>
                    <p v-if="this.errorPassword" class="text-danger">{{ this.errorPassword }}</p>
                    <p v-if="this.errorPasswordLength" class="text-danger">{{ this.errorPasswordLength }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <label for="status" class="col-sm-4 col-form-label">Status</label>
                <div class="col-sm-8">
                    <input type="checkbox" v-model="status" value="" name="status">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="button" @click="storeUsers" class="btn btn-info">Add User</button>
<!--            <button type="button" class="btn btn-default float-right">Cancel</button>-->
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Swal from 'sweetalert2'

export default {
    name: "AddUser",
    data() {
        return {
            role: '',
            type: '',
            lg_role: '',
            ministry_role: '',
            ministry_office_role: '',
            ministry_department_role:'',
            first_name: '',
            address: '',
            email: '',
            password: '',
            phone: '',
            status: false,
            fetchRoles: [],
            fetchLgRoles: [],
            fetchMinistryRoles: [],
            fetchMinistryOfficeRoles: [],
            fetchMinistryDepartmentRoles: [],
            errorRole: '',
            errorType: '',
            errorLGRole: '',
            errorMinistryRole: '',
            errorFirstName: '',
            errorEmail: '',
            errorPhone: '',
            errorPassword: '',
            showPassword: false,
            errorPasswordLength: '',
            errorValidEmail: '',
            errorMinistryOfficeRole:'',
        }
    },

    props: {
        config: { required: true },
    },
    components: {},
    created() {
    },
    watch: {
        role() {
            this.type = "";
            this.errorRole = "";
        },
        type() {
            this.errorType = "";
        },
        lg_role() {
            this.errorLGRole = "";
        },
        ministry_role() {
            this.errorMinistryRole = "";
        },
        ministry_office_role() {
            this.errorMinistryOfficeRole = "";
        },
        first_name() {
            this.errorFirstName = "";
        },
        email() {
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.email)) {
                this.errorValidEmail = '';
            }else{
                this.errorValidEmail = 'Please enter a valid email address';
            }
            this.errorEmail = "";
        },
        password() {
            if (this.password.length > 7)
            {
                this.errorPasswordLength = '';
            }
            this.errorPassword = "";
        },
        phone(){
            if (this.phone.length <= 15 ) {
                return this.errorPhone = "";
            }
        },
    },
    methods: {
        storeUsers() {
            if (this.role == "") {
                return this.errorRole = "Select Role";
            }
            if (this.type == "") {
                return this.errorType = "Select Type";
            }
            if (this.type == "local_government") {
                if (this.lg_role == "") {
                    return this.errorLGRole = "Select LG role";
                }
            }
            if (this.type == "ministry") {
                if (this.ministry_role == "") {
                    return this.errorMinistryRole = "Select Ministry role";
                }
            }
            if (this.type == "ministry_office") {
                if (this.ministry_office_role == "") {
                    return this.errorMinistryOfficeRole = "Select Ministry Office role";
                }
            }
            if (this.first_name == "") {
                return this.errorFirstName = "Enter first name";
            }
            if (this.email == "") {
                return this.errorEmail = "Enter email address";
            }
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.email)) {
            }else{
                this.errorValidEmail = 'Please enter a valid email address';
            }
            if (this.phone.length >= 15 ) {
                return this.errorPhone = "Please Enter phone number less than or equal to 15 digit";
            }
            if (this.password == "") {
                return this.errorPassword = "Enter password";
            }
            if (this.password.length < 7) {
                return this.errorPasswordLength = "Password should be 8 character";
            }
            axios.post(this.config.getAdminUserUrl+ "/storeUser", {
                role: this.role,
                type: this.type,
                lg_role: this.lg_role,
                ministry_role: this.ministry_role,
                ministry_department_role: this.ministry_department_role,
                first_name: this.first_name,
                address: this.address,
                email: this.email,
                phone: this.phone,
                password: this.password,
                status: this.status
            })
                .then((response) => {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'User added successfully',
                        showConfirmButton: false,
                        timer: 1500
                    })
                })
                .catch((error) => {

                })
        },
        getRoles() {
            axios.get(this.config.getAdminUserUrl+"/getRoles")
                .then((response) => {
                    this.fetchRoles = response.data.data;
                })
                .catch((error) => {

                })
        },
        getLgRoles() {
            axios.get(this.config.getAdminUserUrl+"/getLgRoles")
                .then((response) => {
                    this.fetchLgRoles = response.data.data;
                })
                .catch((error) => {

                })
        },
        getMinistryRoles() {
            axios.get(this.config.getAdminUserUrl+"/getMinistryRoles")
                .then((response) => {
                    this.fetchMinistryRoles = response.data.data;
                })
                .catch((error) => {

                })
        },
        getMinistryOfficeRoles() {
            axios.get(this.config.getAdminUserUrl+"/getMinistryOfficeRoles")
                .then((response) => {
                    this.fetchMinistryOfficeRoles = response.data.data;
                })
                .catch((error) => {

                })
        },
        getMinistryDepartmentRoles() {
            axios.get(this.config.getAdminUserUrl+"/getMinistryDepartmentRoles")
                .then((response) => {
                    this.fetchMinistryDepartmentRoles = response.data.data;
                })
                .catch((error) => {

                })
        },
        validateInputs() {
            if (this.role == "") {
                return this.errorRole = "Select Role";
            }
            if (this.type == "") {
                return this.errorType = "Select Type";
            }
            if (this.type == "local_government") {
                if (this.lg_role == "") {
                    return this.errorLGRole = "Select LG role";
                }
            }
            if (this.type == "ministry") {
                if (this.ministry_role == "") {
                    return this.errorMinistryRole = "Select Ministry role";
                }
            }
            if (this.first_name == "") {
                return this.errorFirstName = "Enter first name";
            }
            if (this.last_name == "") {
                return this.errorLastName = "Enter last name";
            }
            // if (this.phone == ""){
            //     return this.errorPhone = "Enter phone number";
            // }
            if (this.email == "") {
                return this.errorEmail = "Enter email address";
            }
            if (this.password == "") {
                return this.errorPassword = "Enter password";
            }
            if (this.password.length < 7) {
                return this.errorPasswordLength = "Password should be 8 character";
            }
        },
        togglePasswordVisibility() {
            this.passwordVisible = !this.passwordVisible
        }
    },
    mounted() {
        this.getRoles();
        this.getLgRoles();
        this.getMinistryRoles();
        this.getMinistryOfficeRoles();
        this.getMinistryDepartmentRoles();
    }
}
</script>
<style>

</style>
