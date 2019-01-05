<template>
  <div class="jumbotron">
    <h1>Add Item</h1>
    <form method="POST" action="api/items/">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" v-model="form.name" name="name" id="name">
      </div>
      <div class="form-group">
        <label for="username">Price</label>
        <input type="text" class="form-control" v-model="form.price" name="name" id="name">
      </div>
      <div class="form-group">
        <label for="username">Description</label>
        <input type="text" class="form-control" v-model="form.description" name="name" id="name">
      </div>
      <select v-model="form.type">
        <label for="username">Type</label>
        <option>Dish</option>
        <option>Drink</option>
      </select>

      <br><br>
      <div class="form-group">
        <a class="btn btn-primary" v-on:click.prevent="CreateItem()">Add</a>
        <a class="btn btn-light" v-on:click.prevent="cancelAdd()">Cancel</a>
      </div>
    </form>
  </div>
</template>

<script type="text/javascript">
import Form from "vform";
// Component code (not registered)
export default {
  props: ["items"],
  data: function() {
    return {
      form: new Form({
        name: "",
        price: "",
        description: "",
        type: ""
      })
    };
  },
  methods: {
    CreateItem() {
      this.form
        .post("api/items/")
        // .then(response => console.log("Success"))
        .then(response => {
          console.log(response);
        })
        .catch(error => console.log("Whoops"));
    },
    getProfileImage(photo_url) {
      return `storage/profiles/${photo_url}`;
    },
    cancelAdd() {
      this.$router.push("/items");
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