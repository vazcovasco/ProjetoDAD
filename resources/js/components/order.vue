<template>
  <div>
    <div class="jumbotron">
      <h1>{{ title }}</h1>
    </div>

    <div>
      <table class="table">
        <tbody class="center">
          <tr>
            <router-link v-if="isWaiter" class="button" to="/orders/add">Register New Order</router-link>
          </tr>
        </tbody>
      </table>
    </div>

    <order-list :orders="orders" @set_state-click="setState" @delete-click="deleteOrder"></order-list>

    <!--<order-list :orders="orders" @delete-click="deleteOrder" @message="childMessage" ref="ordersListRef"></order-list> -->
    <div class="alert alert-success" v-if="showSuccess">
      <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
      <strong>{{ successMessage }}</strong>
    </div>
  </div>
</template>

<script type="text/javascript">
import OrderList from "./orderList.vue";
var moment = require("moment");

export default {
  data: function() {
    //user: this.$store.
    return {
      moment: moment,
      id: "",
      title: "List of Orders",
      showSuccess: false,
      successMessage: "",
      currentOrder: null,
      orders: [],
      meals: [],
      items: [],
      isWaiter: false,
      pendingOrders: [],
    };
  },
  methods: {
    setState: function(order) {
      if (order.state === "delivered") {
        this.message = "Order Delivered";
      } else if (order.state === "not delivered") {
        this.message = "Order not delivered";
      } else if (order.state === "in preparation") {
        this.message = "Order is being prepared";
      } else if (order.state === "prepared") {
        this.message = "Order is prepared";
      } else if (order.state === "confirmed") {
        this.message = "Order is confirmed";
      } else {
        this.message = "Order is pending";
      }
      axios
        .post(
          "api/orders/setState/" + order.id,
          { id: this.$store.state.user.id } /*this.$store.state.user.id*/
        )
        .then(response => {
          console.log("teste");
          // Copy object properties from response.data.data to this.user
          // without creating a new reference
          if (order.state === "pending") {
            order.state = "confirmed";
          } else if (order.state === "confirmed") {
            order.state = "in preparation";
            order.resonpible_cook_id = this.$store.state.user.id;
          } else if (order.state === "in preparation") {
            order.state = "prepared";
          } else if (order.state === "prepared") {
            order.state = "delivered";
          }
          //Object.assign(order, response.data.data);
          this.$emit("message", this.message);
          this.getOrders();
        })
        .catch(erros => {
          console.log(erros);
        });
    },
    deleteOrder: function(order) {
      axios.delete("api/orders/" + order.id).then(response => {
        this.showSuccess = true;
        this.successMessage = "Order Deleted";
        this.getOrders();
      });
    },
    getOrders: function() {
      //this.user = [];
      //this.user = this.$store.state.user;
      console.log(this.$store.state.user.type);
      //se o user for waiter

      if (this.$store.state.user.type == "waiter") {
        this.isWaiter = true;
        axios
          .get("/api/orders/waiter/" + this.$store.state.user.id)
          .then(response => {
            this.orders = response.data;
            this.filterPendingOrders();
          })
          .catch(error => {
            this.showFailure = true;
            this.failMessage = "Error while fetching the existing orders!";
          });
      }
      //se o user for cook
      if (this.$store.state.user.type == "cook") {
        axios
          .get("/api/orders/" + this.$store.state.user.id)
          .then(response => {
            this.orders = response.data;
            this.filterPendingOrders();
          })
          .catch(error => {
            this.showFailure = true;
            this.failMessage = "Error while fetching the existing orders!";
          });
        //console.log(order);
      }
    },
    childMessage: function(message) {
      this.showSuccess = true;
      this.successMessage = message;
    },
    filterPendingOrders() {
      this.pendingOrders = this.orders.filter(
        element => element.state == "pending"
      );

      if (this.pendingOrders.length > 0) {
        setTimeout(() => {
          this.updatePendingOrders();
        }, 7000);
      }
    },

    updatePendingOrders() {
      this.pendingOrders.forEach(element => {
        axios
          .post("api/orders/confirmOrder/" + element.id)
          .then(response => {
            // Copy object properties from response.data.data to this.user
            // without creating a new reference

            element.state = "confirmed";
            //Object.assign(order, response.data.data);

            //this.$emit("message", this.message);
          })
          .catch(erros => {
            console.log(erros);
          });
      });
    },
  },
  components: {
    "order-list": OrderList
  },
  mounted() {
    console.log("mounted - order.vue");
    this.getOrders();
  }
};
</script>

<style scoped>
p {
  font-size: 2em;
  text-align: center;
}
.center {
  text-align: center;
}

.button {
  background-color: #4caf50;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}
</style>