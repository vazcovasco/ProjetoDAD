<template>
  <div class="jumbotron">
    <h1>Create Order</h1>

    <form method="POST" action="api/orders/">
      <div class="form-group">
        <label for="meal_id">Meal:</label>
        <select class="form-control" id="meal_id" name="meal_id" v-model="form.meal_id">
          <option v-for="meal in meals" v-bind:value="meal.id">{{ meal.id}}</option>
        </select>
      </div>

      <div class="form-group">
        <label for="item_id">Item:</label>
        <select class="form-control" id="item_id" name="item_id" v-model="form.item_id">
          <option v-for="item in items" v-bind:value="item.id">{{ item.id}}</option>
        </select>
      </div>

      <br>
      <a class="btn btn-default" v-on:click.prevent="createOrder()">Add</a>
      <a class="btn btn-default" v-on:click.prevent="cancelOrder()">Cancel</a>
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
      orders: [],
      createdorder: [],
      meals: [],
      items: [],
      cenas: '',
      
      form: new Form({
        meal_id: "",
        item_id: ""
      })
    };
  },
  methods: {
    getMeals: function(meal) {
      axios
        .get("api/meals/getActive/" + this.$store.state.user.id)
        .then(response => {
          this.meals = response.data;
        }); // ver a estrutura do json
    },
    getItems: function(item) {
      axios.get("api/items/all").then(response => {
        this.items = response.data;
      }); // ver a estrutura do json
    },
    getAll: function(order) {
      axios.get("api/orders").then(response => {
        this.orders = response.data;
        //console.log(response);
      }); // ver a estrutura do json
    },
    createOrder() {
      this.createdorder = [];
      let self = this;
      this.form
        .post("api/orders/")
        .then(response => {
          this.createdorder = response.data;
          console.log(this.createdorder);
          this.$router.push("/orders");
        })
        .catch(error => console.log("Whoops"));
      //setTimeout(()=> { this.confirmOrder(this.createdorder) }, 5000);
    },
    
    order(){
        this.cenas = this.createOrder();
    },
    cancelOrder() {
      this.$router.push("/");
    }
  },
  mounted() {
    this.getMeals();
    this.getItems();
    //this.getAll();
    this.order;
  }
};
</script>

<style scoped>
tr.activerow {
  background: #123456 !important;
  color: #fff !important;
}
</style>