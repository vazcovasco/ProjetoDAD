<template>
  <div>
    <div class="jumbotron">
      <h1>{{ title }}</h1>
    </div>

    <div class="alert" :class="typeofmsg" v-if="showMessage">
      <button type="button" class="close-btn" v-on:click="showMessage=false">&times;</button>
      <strong>{{ message }}</strong>
    </div>

    <div class="form-group">
      <label for="oldPassword">Old Password</label>
      <input
        type="password"
        class="form-control"
        name="name"
        id="oldPassword"
        v-model="password.oldPassword"
        placeholder="Old Password"
      >
    </div>

    <div class="form-group">
      <label for="newPassword">New Password</label>
      <input
        type="password"
        class="form-control"
        name="name"
        id="newPassword"
        v-model="password.newPassword"
        placeholder="New Password"
      >
    </div>

    <div class="form-group">
      <label for="confirmPassword">Confirm Password</label>
      <input
        type="password"
        class="form-control"
        name="name"
        id="confirmPassword"
        v-model="password.confirmPassword"
        placeholder="Confirm Password"
      >
    </div>

    <div class="form-group">
      <button class="btn btn-primary" v-on:click.prevent="savePassword()">Save</button>
      <button class="btn btn-light" v-on:click.prevent="cancel()">Cancel</button>
    </div>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      title: "Change Password",
      editPage: false,
      password: {
        oldPassword: "",
        newPassword: "",
        confirmPassword: ""
      },
      typeofmsg: "alert-success",
      showMessage: false,
      message: ""
    };
  },
  methods: {
    savePassword: function() {
      let id = this.$store.state.user.id;
      let t = this;
      axios
        .post("api/users/changePassword/" + id, this.password)
        .then(response => {
          let message = response.data.message
          if (message == 'Password updated') {
            t.message = message;
            t.showMessage = true;
          } else {
            t.typeofmsg = "alert-danger";
            t.message = message;
            t.showMessage = true;
          }
        });
    },
    cancel: function() {
      this.$router.push("/profile");
    }
  }
};
</script>
