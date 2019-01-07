<template>
    <div>

        <!-- table of monthly performance-->

        <div>
            <h4>  Restaurant Monthly Performance </h4>
            <h5></h5>

            <span>Restaurant total Number of Orders by month : {{ orders }}</span> <br>
            <span>Restaurant total Number of Meals by month: {{meals}}</span> <br>

        </div>
    </div>
</template>

<script type="text/javascript">

    export default {

        data: function(){
            return {
                data: [],
                user: null,
                meals:[],
                orders:[],
                mealsTime:[],
                ordersTime:[],
            }
        },
        methods: {
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
            }

        },
        mounted() {
            this.getNumberofMeals();
            this.getNumberofOrders();
            this.getMealTime();


        }
    }
    </script>