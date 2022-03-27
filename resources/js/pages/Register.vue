<template>
    <h1>Register</h1>
</template>

<script>
export default {
    mounted() {
        if(this.$store.state.loggedIn === true) {
            this.$router.replace('/');
            return;
        }
    }
}
</script>