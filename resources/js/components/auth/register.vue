<template>
  <div class="jumbotron">
    <h2>Register</h2>

    <div class="alert" :class="typeofmsg" v-if="showMessage">
      <button type="button" class="close-btn" v-on:click="showMessage=false">&times;</button>
      <strong>{{ message }}</strong>
    </div>

    <div class="form-group">
      <label for="inputName">Fullname</label>
      <input
        type="text"
        class="form-control"
        v-model="user.name"
        name="name"
        id="inputName"
        placeholder="Fullname"
      >
    </div>

    <div class="form-group">
      <label for="inputUserName">Username</label>
      <input
        type="text"
        class="form-control"
        v-model="user.username"
        name="username"
        id="inputUserName"
        placeholder="Username"
      >
    </div>

    <div class="form-group">
      <label for="inputEmail">Email</label>
      <input
        type="email"
        class="form-control"
        v-model="user.email"
        name="email"
        id="inputEmail"
        placeholder="Email address"
      >
    </div>

    <div class="form-group">
      <label for="inputType">Type</label>
      <br>
      <select class="form-control" v-model="user.type">
        <option value disabled selected>Select Type</option>
        <option value="0">Waiter</option>
        <option value="1">Cook</option>
        <option value="2">Manager</option>
        <option value="3">Cashier</option>
      </select>
    </div>

    <div class="form-group">
      <label>Photo</label>
      <div class="container">
        <div v-if="imgExists">
          <br>
          <img width="100px" :src="getProfileImage(user.photo)">
          <br>
          <br>
        </div>
        <div class="large-12 medium-12 small-12 cell">
          <label>
            <input type="file" id="file" ref="file" v-on:change="handleFileUpload()">
          </label>
          <button v-on:click="submitFile()">Submit</button>
        </div>
      </div>
    </div>

    <div class="form-group">
      <button class="btn btn-primary"  v-on:click.prevent="register()">Register</button>
      <button class="btn btn-light" v-on:click.prevent="cancel()">Cancel</button>
    </div>
  </div>
</template>

<script>
export default {
  props: ["users"],
  data: function() {
    return {
      file: "",
      user: {
        name: "",
        username: "",
        email: "",
        password: "123",
        photo: "",
        type: ""
      },
      imgExists: false,
      typeofmsg: "alert-success",
      showMessage: false,
      message: ""
    };
  },
  methods: {
    getProfileImage(photo_url) {
      return `storage/profiles/${photo_url}`;
    },
    handleFileUpload() {
      this.file = this.$refs.file.files[0];
    },
    submitFile() {
      let formData = new FormData();
      formData.append("file", this.file);
      let t = this;
      axios
        .post("api/upload", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(response => {
          console.log("response - " + response);
          t.user.photo = response.data.replace("public/profiles/", "");
          console.log(t.user.photo)

          console.log("SUCCESS!!");
        })
        .catch(function() {
          console.log("FAILURE!!");
        });
    },
    register() {
      this.$store
        .dispatch("register", {
          name: this.user.name,
          username: this.user.username,
          email: this.user.email,
          password: this.user.password,
          photo: this.user.photo,
          type: this.user.type
        })
        .then(response => {
          this.typeofmsg = "alert-success";
          this.message = "Email sent to new user";
          this.showMessage = true;
        })
        .catch(err => {
          this.typeofmsg = "alert-danger";
          this.message = "Invalid Credentials";
          this.showMessage = true;
        });
    },
    cancel() {
      this.$router.push("/");
    }
  }
};
</script>