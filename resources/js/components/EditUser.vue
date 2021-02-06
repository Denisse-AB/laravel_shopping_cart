<template>
    <div>
        <div class="container">
        <div class="row">
            <div class="col-sm-6 text-center">
                <div class="row justify-content-center p-3">
                    <h1 id="firaSans" class="display-4" v-text="acc"></h1>
                        <div id="infoBox" class="rounded border border-success text-center w-75 mx-auto shadow">
                            <div v-show="hide">
                            <h5 class="lead p-2 mt-2 font-weight-bold">{{ customerName }}</h5>
                                <p class="lead p-2">{{ customerAddress }}
                                    <br>
                                    <span>{{ customerCity }}</span>
                                    <span>{{ customerState }},</span>
                                    <span>{{ customerZip }}</span>
                                </p>
                                <p>{{ customerTel }}</p>
                                <button type="button" @click="form" class="btn btn-secondary btn-sm mb-3" v-text="edit"></button>
                            </div>
                                <form v-show="show" class="m-2" @submit.prevent="submit">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label v-if="lang === 'en'" for="inputPassword4">Name</label>
                                            <label v-if="lang === 'es'" for="inputPassword4">Nombre</label>
                                            <input type="text" v-model="name" v-bind:class="{'form-control' : 'true', 'is-invalid' : errors.name}">
                                            <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">tel</label>
                                            <input type="tel" v-model="tel" v-bind:class="{'form-control' : 'true', 'is-invalid' : errors.tel}">
                                            <div v-if="errors && errors.tel" class="text-danger">{{ errors.tel[0] }}</div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label v-if="lang === 'en'" for="inputAddress">Address</label>
                                        <label v-if="lang === 'es'" for="inputPassword4">Direccion</label>
                                        <input type="text" v-model="address" v-bind:class="{'form-control' : 'true', 'is-invalid' : errors.address}">
                                        <div v-if="errors && errors.address" class="text-danger">{{ errors.address[0] }}</div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label v-if="lang === 'en'" for="inputCity">City</label>
                                            <label v-if="lang === 'es'" for="inputPassword4">Ciudad</label>
                                            <input type="text" v-model="city" v-bind:class="{'form-control' : 'true', 'is-invalid' : errors.city}">
                                            <div v-if="errors && errors.city" class="text-danger">{{ errors.city[0] }}</div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label v-if="lang === 'en'" for="inputState">State</label>
                                            <label v-if="lang === 'es'" for="inputPassword4">Estado</label>
                                            <input type="text" v-model="state" v-bind:class="{'form-control' : 'true', 'is-invalid' : errors.state}">
                                            <div v-if="errors && errors.state" class="text-danger">{{ errors.state[0] }}</div>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="inputZip">Zip</label>
                                            <input type="text" v-model="zip" v-bind:class="{'form-control' : 'true', 'is-invalid' : errors.zip}">
                                            <div v-if="errors && errors.zip" class="text-danger">{{ errors.zip[0] }}</div>
                                        </div>
                                    </div>
                                <button type="submit" class="btn btn-secondary btn-sm">Edit your info</button>
                            </form>
                        </div>
                </div>
            </div>
            <div class="col-sm-6 text-center">
                <div class="row justify-content-center p-3">
                    <h3 id="firaSans" class="display-4">Password</h3>
                </div>
                <div id="infoBox" class="rounded border border-success text-center w-75 mx-auto shadow">
                    <div class="m-3">
                        <form v-show='passForm' class="m-2" @submit.prevent="changePassword">
                            <div class="form-group">

                                <label v-if="lang === 'en'" for="password1" class="float-left m-2">Old Password</label>
                                <label v-if="lang === 'es'" for="inputPassword4"  class="float-left m-2">Viejo Password</label>
                                <input v-model="oldPassword" :type="password" v-bind:class="{'form-control' : 'true', 'is-invalid' : errors.oldPassword || pwdErr}" id="password1" placeholder="Password">
                                <div v-if="errors && errors.oldPassword" class="text-danger">{{ errors.oldPassword[0] }}</div>
                                <div v-if="pwdErr" class="text-danger">{{ pwdErr }}</div>

                                <label for="password2" class="float-left m-2">Password</label>
                                <input v-model="newPassword" :type="password" v-bind:class="{'form-control' : 'true', 'is-invalid' : errors.password}" id="password2" placeholder="New Password">
                                <div v-if="errors && errors.password" class="text-danger">{{ errors.password[0] }}</div>

                                <label v-if="lang === 'en'" for="password3" class="float-left m-2">Confirm Password</label>
                                <label v-if="lang === 'es'" for="inputPassword4" class="float-left m-2">Confirma tu Password</label>
                                <input v-model="confirmPassword" :type="password" v-bind:class="{'form-control' : 'true', 'is-invalid' : errors.password_confirmation}" id="password3" placeholder="Confirm Password">
                                <div v-if="errors && errors.password_confirmation" class="text-danger">{{ errors.password_confirmation[0] }}</div>

                            </div>
                            <button @click.prevent="reveal" class="btn btn-light btn-sm float-left"><i class="fas fa-eye" style="font-size: 17px;"></i></button>
                            <button class="btn btn-secondary btn-sm" type="submit">Submit</button>
                        </form>
                        <button v-show="passForm == false" @click="showPassform" class="btn btn-secondary btn-sm" type="button" v-text="pass"></button>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <br><br>
    </div>
</template>

<script>
export default {

    props: {
        customerId: String,
        customerName: String,
        customerAddress: String,
        customerCity: String,
        customerState: String,
        customerZip: String,
        customerTel: String,
        lang: String
    },

    data(){
        return {
            show: false,
            hide: true,
            passForm: false,
            id: this.customerId,
            tel: this.customerTel,
            name: this.customerName,
            address: this.customerAddress,
            city: this.customerCity,
            state: this.customerState,
            zip: this.customerZip,
            password: 'password',
            oldPassword: '',
            newPassword: '',
            confirmPassword: '',
            errors: {},
            pwdErr: ''
        }
    },

    methods: {
        form(){
            this.hide = false,
            this.show = true
        },

        submit(){
            this.errors = {};
            axios.patch(`/userEdit/${this.id}`, {
                method: 'PATCH',
                name: this.name,
                tel: this.tel,
                address: this.address,
                city: this.city,
                state: this.state,
                zip: this.zip,
            })
            .then(response => {
                if (response.status === 200 || {} ) {
                    this.show = false;
                    alert('Success, Your credentials has change.');
                    window.location.reload();
                }
            })
            .catch(error => {
                if (error.response.status === 422) {
                this.errors = error.response.data.errors || {};
                }
            });
        },

        showPassform(){
            this.passForm = true;
        },

        reveal(){
            //password reveal button
            if (this.password === 'password') {
                return this.password = 'text';
            } else {
                return this.password = 'password'
            }
        },

        changePassword(){
            this.pwdErr = '';
            this.errors = {};
            axios.put(`/passwordEdit/${this.id}`, {
                method: 'PUT',
                oldPassword: this.oldPassword,
                password: this.newPassword,
                password_confirmation: this.confirmPassword
            })
            .then(response => {
                if (response.data.error === 403) {
                    this.pwdErr = response.data.pwdErr;

                } else if (response.status === 200) {
                    alert('Password change');

                    window.location.reload();
                } else {
                    alert('Server error try again later!');
                }
            })
            .catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                } else {
                    alert('Error updating try again later.');
                }
            });
        }
    },
    computed: {
        edit(){
            return (this.lang == 'es') ? 'Edita tu Direccion' : 'Edit your address';
        },
        pass () {
           return (this.lang == 'es') ? 'Cambia tu password' : 'Change your Password';
        },
        acc () {
            return (this.lang == 'es') ? 'Cuenta' : 'Account';
        }
    }

}
</script>