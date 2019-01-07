<template>
  <div class="jumbotron">
    <h1>Create Table</h1>

    <div class="alert" :class="typeOfMessage" v-if="showMessage">
      <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
      <strong>{{ message }}</strong>
    </div>

    <form method="POST" action="api/create_tables/">
      <div class="form-group">
        <label for="table_number">Table Number</label>
        <input type="text" class="form-control" v-model="form.table_number" name="name" id="name">
      </div>

      <br>
      <a class="btn btn-primary" v-on:click.prevent="createTable()">Add</a>
      <a class="btn btn-light" v-on:click.prevent="cancelTable()">Cancel</a>
    </form>
  </div>
</template>

<script type="text/javascript">
import Form from "vform";
// Component code (not registered)
export default {
  //props: ["orders"],
  data: function() {
    return {
      restaurant_tables: [],
      form: new Form({
        table_number: ""
      }),
      showMessage: false,
      message: "",
      typeOfMessage: "alert-success"
    };
  },
  methods: {
    getTables: function() {
      axios.get("api/restaurant_tables").then(response => {
        this.restaurant_tables = response.data;
        //console.log(response);
      }); // ver a estrutura do json
    },
    createTable() {
      this.form
        .post("api/restaurant_tables/")
        .then(response => {
            this.typeOfMessage = "alert-success";
            this.message = "Table created successfully!";
            this.showMessage = !this.showMessage;
            
        })
        .catch(error => {
          if (!Number.isInteger(parseInt(this.form.table_number))) {
            this.message = "Insert a valid table number!";
          } else if(Number.isInteger(parseInt(this.form.table_number))){
            this.message = "Table number already exists!";
          }

          this.typeOfMessage = "alert-danger";
          this.showMessage = !this.showMessage;
        });
    },
    cancelTable() {
      this.$router.push("/");
    }
  },
  mounted() {
    this.getTables();
  }
};
</script>

<style scoped>
tr.activerow {
  background: #123456 !important;
  color: #fff !important;
}
</style>