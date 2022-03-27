<template>
    <div class="row mt-5">
        <div class="col-md-1 d-none d-md-block"></div>
        <div class="col-md-6 col-sm-12">
            <h1>Dashboard</h1>

            <div v-if="isFetchingUser">
                <h1>Loading...</h1>
            </div>

            <div v-if="!isFetchingUser" class="mt-5">
                <span class="h5">E-mail: </span> <span class="d-inline-block"> {{ currentUser.email }} </span> <br />
                <span class="h5">Name: </span> <span class="d-inline-block"> {{ currentUser.name }} </span> <br />
                <span class="h5">Type: </span> <span class="d-inline-block"> {{ currentUser.type === 1? "Normal": "Premium" }} </span> <br />
                <span class="h5">Contract start date: </span> <span class="d-inline-block"> {{ currentUser.contract_start_date }} </span> <br />
                <span class="h5">Contract end date: </span> <span class="d-inline-block"> {{ currentUser.contract_end_date }} </span>
            </div>

        </div>
        <div class="col-md-4 d-none d-md-block"></div>
    </div>

    <div class="row mt-5">
        <div class="col-md-1 d-none d-md-block">
        </div>
        <div class="col-sm-12 col-md-10">
             <form class="form-inline" @submit.prevent="fetchUsers">
                <label class="sr-only" for="name">Name</label>
                <input v-model="filter.name" type="text" class="form-control mb-2 mr-sm-2" id="name" name="name" placeholder="Jane Doe">

                <label class="sr-only" for="email">Email</label>
                <input v-model="filter.email" type="email" class="form-control mb-2 mr-sm-2" id="email" name="email" placeholder="example@gmail.net">

                <label class="sr-only" for="contractStart">Contract start date</label>
                <input v-model="filter.contract_start_date" type="date" class="form-control mb-2 mr-sm-2" id="contractStart" name="contractStart" placeholder="01-01-2022">

                <label class="sr-only" for="contractEnd">Contract end date</label>
                <input v-model="filter.contract_end_date" type="date" class="form-control mb-2 mr-sm-2" id="contractEnd" name="contractEnd" placeholder="01-30-2022">

                <label class="sr-only" for="type">Type</label>
                <select v-model="filter.type" name="type" id="type" class="custom-select">
                    <option selected disabled>Select user type</option>
                    <option value="1">Normal</option>
                    <option value="2">Premium</option>
                </select>

                <div class="checkbox">
                    <label><input type="checkbox" v-model="filter.verified" name="verified">Verified?</label>
                </div>

                <button type="submit" class="btn btn-primary">Fetch users for exporting</button>
            </form>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-1 d-none d-md-block"></div>
        <div class="col-sm-12 col-md-10">

            <table class="table table-striped">

                <tr>
                    <th>Name</th>
                    <th>E-mail</th>
                    <th>Type</th>
                    <th>Contract start date</th>
                    <th>Contract end date</th>
                </tr>
                <tr v-if="users.length === 0">
                    <td colspan="5">No users to display</td>
                </tr>
                <tr v-for="user in users" :key="user.id">
                    <td> {{ user.name }} </td>
                    <td> {{ user.email }} </td>
                    <td> {{ user.type }} </td>
                    <td> {{ user.contract_start_date }} </td>
                    <td> {{ user.contract_end_date }} </td>
                </tr>
            </table>

        </div>
    </div>

    <div v-if="!isFetchingUser && users.length !== 0" class="row mt-3">
        <div class="col-md-1 d-none d-md-block"></div>
        <div class="col-md-6 col-sm-12">
            <button @click="exportAsPDF" class="btn btn-danger">Export users as PDF</button>
            <button @click="exportAsCSV" class="btn btn-success d-inline-block ml-3">Export users as CSV</button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Dashboard',
    data() {
        return {
            isFetchingUser: true,
            currentUser: {},
            users: [],
            filter: {
                name: null,
                email: null,
                contract_start_date: null,
                contract_end_date: null,
                verified: null,
                type: null
            }
        }
    },
    methods: {

        createUrlWithParams(url) {
            let urlWithParams = new URL(url);

            if(this.filter.name !== null) {
                urlWithParams.searchParams.append("name", this.filter.name);
            }
            if(this.filter.email !== null) {
                urlWithParams.searchParams.append("email", this.filter.email);
            }
            if(this.filter.contract_start_date !== null) {
                urlWithParams.searchParams.append("contract_start_date", this.filter.contract_start_date);
            }
            if(this.filter.contract_end_date !== null) {
                urlWithParams.searchParams.append("contract_end_date", this.filter.contract_end_date);
            }
            if(this.filter.verified !== null) {
                urlWithParams.searchParams.append("verified", this.filter.verified);
            }
            if(this.filter.type !== null) {
                urlWithParams.searchParams.append("type", this.filter.type);
            }
            console.log(urlWithParams)
            return urlWithParams;
        },

        fetchUsers(e) {
            const urlWithParams = this.createUrlWithParams('http://localhost:8000/api/fetchUsers');
            console.log(urlWithParams.href);

            e.preventDefault();
           

            axios.get(urlWithParams.href).then((response) => {
                console.log(response.data);
                this.users = response.data.users;
            }).catch((error) => {
                console.log(error);
            });

        },
        exportAsCSV() {
            const urlWithParams = this.createUrlWithParams('http://localhost:8000/api/exportcsv');
            console.log(urlWithParams.href);
            axios.get(urlWithParams).then((response) => {
                console.log(response);
            }).catch((error) => {

                console.log(error);
            });
        },
        exportAsPDF() {
            const urlWithParams = this.createUrlWithParams('http://localhost:8000/api/exportpdf');
            console.log(urlWithParams.href);
            axios.get(urlWithParams).then((response) => {
                console.log(response);
            }).catch((error) => {
                console.log(error);
            });
        }
    },
    mounted() {
        if(this.$store.state.loggedIn === false) {
            this.$router.replace('/login');
            return;
        }

        else {
            axios.get('api/user').then((response) => {
                this.$store.commit('setLoggedIn', true);
                this.currentUser = response.data;
                this.isFetchingUser = false;
            }).catch((error) => {
                if(error.response.status == 401) {
                    this.$store.commit('setLoggedIn', false);
                    return this.$router.replace('/login');
                }
            });
        }

        
        
    }
}
</script>