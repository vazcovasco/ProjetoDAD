<template>
    <div class="jumbotron">
        <h2>Start New Meal</h2>
        <div class="form-group">
            <label for="inputState">State</label>
            <input
                    type="text" class="form-control" v-model="meal.state"
                    placeholder="state of the meal"/>
        </div>

        <div class="form-group">
            <label for="inputWaiter">Responsible Waiter</label>
            <input
                    type="text" class="form-control" v-model="meal.responsible_waiter_id"
            />
        </div>

        <div class="form-group">
            <label for="inputWaiter">tables available</label>
            <select v-model="meal.table_number">
                <option v-for="table in restaurant_tables" v-bind:value="table">
                    {{table}}</option>
            </select>
        </div>
        
                <div class="form-group">
                    <a class="btn btn-success" v-on:click.prevent="CreateMeal">Start Meal</a>
                </div>

        <div class="alert" :class="typeofmsg" v-if="showMessage">
            <button type="button" class="close-btn" v-on:click="showMessage=false">&times;</button>
            <strong>{{ message }}</strong>
        </div>

    </div>
</template>

<script type="text/javascript">
    import Form from 'vform'
    // Component code (not registered)
    export default{


        data: function(){
            return{
                state: 'active',
                user: this.$store.state.user,
                showMessage: false,
                successMessage: '',
                meal: {
                    state: 'active',
                    table_number: '',
                    responsible_waiter_id: '',
                },
                restaurant_tables:[],
            }
        },
        methods: {
            CreateMeal(){
                axios.post('api/meals', this.meal)
                // .then(response => console.log("Success"))
                    .then(response => {
                        console.log(response);
                    })
                    .catch(error => console.log('Whoops'));


            },
            getRestaurantTables: function(){

                axios.get('api/restaurant_tables')
                    .then(response=>{
                        this.restaurant_tables = response.data;
                        this.meal.table_number = this.restaurant_tables[0];
                    }); // ver a estrutura do json

            },



        },
        mounted() {
            this.getRestaurantTables();
            this.meal.responsible_waiter_id = this.user.id;
        }


    }
</script>

<style scoped>
    tr.activerow {
        background: #123456  !important;
        color: #fff          !important;
    }

</style>