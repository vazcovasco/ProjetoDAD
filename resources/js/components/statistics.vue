<template>
    <div>

        <div v-if="user">
            <h4>  Daily Performance - {{user.name}} (<b>{{user.performance}} {{currentFilter}} p/ day)  </b></h4>
            <h5></h5>

        </div>
        <br>
        <div class="filter">
            <label><input @click="getOrders" type="radio" v-model="currentFilter" value="orders"/> Orders</label>
            <label @click="getMeals" v-if="user && user.type == 'waiter'"><input type="radio" v-model="currentFilter" value="meals"/> Meals</label>
        </div>
        <br>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Date</th>
                <th>Orders</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="day in data" >
                <td>{{ day.date }}</td>
                <td>{{ day[currentFilter] }}</td>
            </tr>
            </tbody>
        </table>

      <!-- table of monthly performance-->

        <div v-if="user">
            <h4>  Restaurant Monthly Performance </h4>
            <h5></h5>

            <span>Restaurant average meals : {{meals}}</span> <br>
            <span>Restaurant average orders : {{orders}}</span> <br>
            <span>Restaurant average time  meals : {{mealsTime}}</span> <br>
          <!--  <span>Restaurant average orders : {{ordersTime}}</span>-->


    </div>
    </div>
</template>

<script type="text/javascript">

    export default {

        data: function(){
            return {
                data: [],
                currentFilter: 'orders',
                currentFilterMonth: 'orders',
                user: null,
                meals:[],
                orders:[],
                mealsTime:[],
                ordersTime:[],
            }
        },
        methods: {
            getMeals: function(){

                if(this.user.type == 'waiter')
                {
                    let t = this;
                    console.log("teste");
                    this.data = [];
                    axios.get('api/statistics/meals/' + this.$route.params.id)
                        .then(response=>{
                            t.data = response.data.data;
                            t.user = response.data.user;
                        }); // ver a estrutura do json
                }


            },
            getOrders: function(){

                axios.get('api/statistics/orders/'+ this.$route.params.id)
                    .then(response=>{
                        this.data = response.data.data;
                        this.user = response.data.user;


                    }); // ver a estrutura do json

            },
            getNumberofMeals: function () {

                axios.get('api/statistics/mealsMonth')
                    .then(response=>{
                        console.log("teste");
                        this.meals= response.data}); // ver a estrutura do json
            },
            getNumberofOrders: function () {

                axios.get('api/statistics/ordersMonth')
                    .then(response=>{
                        console.log("teste");
                        this.orders= response.data}); // ver a estrutura do json
            },
            getMealTime: function () {

                axios.get('api/statistics/mealsAverageTime')
                    .then(response=>{
                        console.log("teste");
                        this.mealsTime= response.data}); // ver a estrutura do json
            },
            getOrderTime: function () {

                axios.get('api/statistics/ordersAverageTime')
                    .then(response=>{
                        console.log("teste");
                        this.mealsTime= response.data}); // ver a estrutura do json
            },

        },
        mounted() {
            this.getOrders();
            this.getNumberofMeals();
            this.getNumberofOrders();
            this.getMealTime();


        }
    }
</script>