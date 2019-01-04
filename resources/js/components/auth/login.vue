<template>
  <div>
    <form class="jumbotron" @submit.prevent="login">
      <h2>Login</h2>

      <div class="alert" :class="typeofmsg" v-if="showMessage">
        <button type="button" class="close-btn" v-on:click="showMessage=false">&times;</button>
        <strong>{{ message }}</strong>
      </div>

      <div v-if="!loginData.loginByUsername" class="form-group">
        <label for="inputEmail">Email</label>
        <input
          type="email"
          class="form-control"
          v-model.trim="loginData.credential"
          name="email"
          id="inputEmail"
          placeholder="Email address"
        >
      </div>

      <div v-if="loginData.loginByUsername" class="form-group">
        <label for="inputUsername">Username</label>
        <input
          type="username"
          class="form-control"
          v-model.trim="loginData.credential"
          name="username"
          id="inputUsername"
          placeholder="Username"
        >
      </div>

      <div class="form-group">
        <label for="inputPassword">Password</label>
        <input
          type="password"
          class="form-control"
          v-model="loginData.password"
          name="password"
          id="inputPassword"
        >
      </div>

      <div class="form-group">
        <button class="btn btn-primary" type="submit">Login</button>
      </div>

      <div class="form-group">
        <a href="#" v-if="!loginData.loginByUsername" @click="changeLoginType">Login By Username</a>
        <a href="#" v-else @click="changeLoginType">Login By Email</a>
      </div>

    </form>
  </div>
</template>

<script type="text/javascript">
export default {
  data: function() {
    return {
      loginData:{
        credential: '',
        password: '',
        loginByUsername: false
      },
      typeofmsg: 'alert-success',
      showMessage: false,
      message: ''
    };
  },
  methods: {
    login() {
      this.$store
        .dispatch("retrieveToken", this.loginData)
        .then(response => {
          this.$store.dispatch("setUser");
          this.$router.push("/");
        })
        .catch(err => {
            this.typeofmsg = 'alert-danger';
            this.message = 'Invalid Credentials';
            this.showMessage = true;
        });
    },
    changeLoginType() {
      this.loginData.loginByUsername = !this.loginData.loginByUsername;
      this.loginData.credential = '';
    }
  }
};
</script>