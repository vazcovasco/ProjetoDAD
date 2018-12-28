<template>
    <div>
        <form class="jumbotron" @submit.prevent="login">

            <h2>Login</h2>

            <div class="form-group">
                <label for="inputEmail">Email</label>
                <input
                    type="email" class="form-control" v-model.trim="email"
                    name="email" id="inputEmail"
                    placeholder="Email address"/>
            </div>

            <div class="form-group">
                <label for="inputPassword">Password</label>
                <input
                    type="password" class="form-control" v-model="password"
                    name="password" id="inputPassword"/>
            </div>

            <div class="form-group">
                <button class="btn btn-primary" type="submit">Login</button>
            </div>

        </form>
    </div>
</template>

<script type="text/javascript">
    export default {
        data: function(){
            return {
                email: '',
                password: ''
            }
        },
        methods: {
            login() {
                this.$store.dispatch('retrieveToken', {
                    email: this.email,
                    password: this.password
                })
                .then(response => {
                    this.$store.dispatch('setUser');
                    this.$router.push('/');
                }) 
            }
        },
    }
</script>