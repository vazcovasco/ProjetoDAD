<template>
  <div class="jumbotron">
    <h2>Edit Item</h2>
    <div class="form-group">
      <label for="inputName">Name</label>
      <input type="text" class="form-control" v-model="item.name" name="name" id="inputName">
    </div>
    <div class="form-group">
      <label for="inputPrice">Price</label>
      <input
        type="text"
        class="form-control"
        v-model="item.price"
        name="name"
        id="inputPrice"
        placeholder="Username"
      >
    </div>
    <div class="form-group">
      <label for="inputEmail">Email</label>
      <input
        type="email"
        class="form-control"
        v-model="item.description"
        name="email"
        id="inputEmail"
        placeholder="Email address"
      >
    </div>

    <div class="form-group">
      <label>Photo</label>
      <br>
      <img width="100px" :src="getFoodImage(item.photo_url)">
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
      <a class="btn btn-default" v-on:click.prevent="saveItem()">Save</a>
      <a class="btn btn-default" v-on:click.prevent="cancelEdit()">Cancel</a>
    </div>
  </div>
</template>

<script type="text/javascript">
module.exports = {
  props: ["item"],
  data() {
    return {
      file: ""
    };
  },
  methods: {
    saveItem: function() {
      axios.put(`api/items/?id=` + this.item.id, this.item).then(response => {
        // Copy object properties from response.data.data to this.user
        // without creating a new reference
        console.log(response.data);
        Object.assign(this.item, response.data.data);
        this.$emit("item-saved", this.item);
      });
    },
    cancelEdit: function() {
      axios.get("api/items/" + this.item.id).then(response => {
        // Copy object properties from response.data.data to this.user
        // without creating a new reference
        Object.assign(this.item, response.data.data);
        this.$emit("item-canceled", this.item);
      });
    },
    handleFileUpload() {
      this.file = this.$refs.file.files[0];
    },
    submitFile() {
      let formData = new FormData();
      formData.append("file", this.file);
      axios
        .post("api/uploadItemPhoto", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(response => {
          console.log(this.item);
          this.item.photo_url = response.data.replace("public/items/", "");

          console.log("SUCCESS!!");
        })
        .catch(function() {
          console.log("FAILURE!!");
        });
	},
	getFoodImage(photo_url) {
      return `storage/items/${photo_url}`;
    },
  }
};
</script>

<style scoped>
</style>