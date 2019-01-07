<template>
  <div class="jumbotron">
    <h1>Add Item</h1>
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" class="form-control" v-model="item.name" name="name" id="name">
    </div>
    <div class="form-group">
      <label for="username">Price</label>
      <input type="text" class="form-control" v-model="item.price" name="name" id="name">
    </div>
    <div class="form-group">
      <label for="username">Description</label>
      <input type="text" class="form-control" v-model="item.description" name="name" id="name">
    </div>
    <select v-model="item.type">
      <label for="username">Type</label>
      <option>Dish</option>
      <option>Drink</option>
    </select>
    <div class="form-group">
      <label>Photo</label>
      <div class="container">
        <div v-if="imgExists">
          <br>
          <img width="100px" :src="getItemImage(item.photo_url)">
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

    <br>
    <br>
    <div class="form-group">
      <a class="btn btn-primary" v-on:click.prevent="CreateItem()">Add</a>
      <a class="btn btn-light" v-on:click.prevent="cancelAdd()">Cancel</a>
    </div>
  </div>
</template>

<script type="text/javascript">
import Form from "vform";
// Component code (not registered)
export default {
  props: ["items"],
  data: function() {
    return {
      file: "",
      item: {
        name: "",
        price: "",
        description: "",
        type: ""
      },
      imgExists: false
    };
  },
  methods: {
    CreateItem() {
      axios
        .post("api/items", {
          name: this.item.name,
          price: this.item.price,
          description: this.item.description,
          photo_url: this.item.photo_url,
        })

        .then(response => {
          console.log(response);
          this.$router.push('/items');
        })
        .catch(error => console.log("Whoops"));
    },
    getItemImage(photo_url) {
      return `storage/items/${photo_url}`;
    },
    cancelAdd() {
      this.$router.push("/items");
    },
    handleFileUpload() {
      this.file = this.$refs.file.files[0];
    },
    submitFile() {
      let formData = new FormData();
      formData.append("file", this.file);
      let t = this;
      axios
        .post("api/uploadItemPhoto", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(response => {
          t.item.photo_url = response.data.replace("public/items/", "");
          console.log(t.item.photo_url);
          t.imgExists = true;

          console.log("SUCCESS!!");
        })
        .catch(function() {
          console.log("FAILURE!!");
        });
    }
  }
};
</script>

<style scoped>
tr.activerow {
  background: #123456 !important;
  color: #fff !important;
}
</style>