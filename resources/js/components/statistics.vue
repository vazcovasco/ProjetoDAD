<template>
    <div>

        <div v-if="user">
            <h4> Performance - {{user.name}} (<b>{{user.performance}} {{currentFilter}} p/ day)  </b></b></h4>
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
    </div>
</template>

<script type="text/javascript">

    export default {

        data: function(){
            return {
                data: [],
                currentFilter: 'orders',
                user: null,
            }
        },
        methods: {
            getMeals: function(){

                if(this.user.type == 'meals')
                {
                    this.data = [];
                    axios.get('api/statistics/meals' + this.$route.params.id)
                        .then(response=>{
                            this.data = response.data.data;
                            this.user = response.data.user;
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
        },
        mounted() {
            this.getOrders();
        }
    }
</script>