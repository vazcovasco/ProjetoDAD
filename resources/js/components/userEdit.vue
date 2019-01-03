<template>
  <div class="jumbotron">
    <h2>Profile</h2>

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
        :disabled="!isManager ? true : false"
      >
    </div>

    <div class="form-group">
      <label>Photo</label>
      <br>
      <img width="100px" :src="getProfileImage(user.photo_url)">
      <br>
      <br>
      <div class="container">
        <div class="large-12 medium-12 small-12 cell">
          <label>
            <input type="file" id="file" ref="file" v-on:change="handleFileUpload()">
          </label>
          <button v-on:click="submitFile()">Submit</button>
        </div>
      </div>
    </div>

    <div class="form-group">
      <a href="#">
        <router-link
          @click="showPassEdit"
          :editPage="editPage"
          :user="this.user"
          @save-password="savePassword"
          to="/changePassword"
        >Change Password</router-link>
      </a>
    </div>

    <div class="form-group">
      <button class="btn btn-primary" v-on:click.prevent="saveUser()">Save</button>
      <button class="btn btn-light" v-on:click.prevent="cancelEdit()">Cancel</button>
    </div>
  </div>
</template>

<script type="text/javascript">
export default {
  props: ["user"],
  data() {
    return {
      file: "",
      disabled: false,
      isManager: this.$store.getters.isManager,
      editPage: false
    };
  },
  methods: {
    saveUser: function() {
      let instance = this;
      axios.put("api/users/" + this.user.id, this.user).then(response => {
        Object.assign(this.user, response.data.data);
        instance.$emit("user-saved", this.user);
      });
      this.$router.push("/users");
    },
    cancelEdit: function() {
      this.$router.push("/use");
    },
    savePassword: function(user) {

    },
    getProfileImage(photo_url) {
      return `storage/profiles/${photo_url}`;
    },
    handleFileUpload() {
      this.file = this.$refs.file.files[0];
    },
    submitFile() {
      let formData = new FormData();
      formData.append("file", this.file);
      console.log(this.user);
      axios
        .post("api/upload", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(response => {
          console.log(this.user);
          this.user.photo_url = response.data.replace("public/profiles/", "");

          console.log("SUCCESS!!");
        })
        .catch(function() {
          console.log("FAILURE!!");
        });
    },
    showPassEdit() {
      this.editPage = !this.editPage;
    }
  }
}
</script>

<style scoped>
</style>