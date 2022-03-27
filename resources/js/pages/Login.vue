<template>

    <div class="row">
        <div class="col-md-3 d-none d-md-block"></div>
        <div class="col-md-6 col-sm-12">
            <form action="#" class="p-5 mt-5" @submit.prevent="login">
                <div class="form-row">
                    <input v-model="email" class="form-control formField" type="email" name="email" placeholder="E-mail address"/>
                </div>

                <div class="form-row">
                    <input v-model="password" class="form-control formField" type="password" name="password" placeholder="Password" min="8"/>
                </div>
                
                <div class="form-row">
                    <button class="btn btn-primary formField form-control" type="submit">Log in</button>
                </div>

            </form>
        </div>
        
        <div class="col-md-3 d-none d-md-block"></div>
    </div>
    

</template>

<script>
export default {
    data() {
        return {
            email: '',
            password: '',
            errors: []
        }
    },
    methods: {
        login(e) {
            e.preventDefault();
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/login', {
                    email: this.email,
                    password: this.password
                }).then(response => {
                    this.$store.commit('setLoggedIn', true);
                    this.$router.replace('/');
                })
            }).catch((errors) => {
                console.log(errors);
            })
        }
    },
    mounted() {
        if(this.$store.state.loggedIn === true) {
            this.$router.replace('/');
            return;
        }
    }
}
</script>

<style scoped>
    .formField {
        font-size: 20;
        margin: 20px;
    }
</style>