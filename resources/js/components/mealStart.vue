<template>
    <div class="jumbotron">
        <h2>Start New Meal</h2>
        <div class="form-group">
            <label for="inputState">State</label>
            <input
                    type="text" class="form-control" v-model="state"
                    placeholder="state of the meal"/>
        </div>

        <div class="form-group">
            <label for="inputWaiter">Responsible Waiter</label>
            <input
                    type="text" class="form-control" v-model="user.id"
            />
        </div>

        <div class="form-group">
            <label for="inputWaiter">tables available</label>
            <select v-model="table_number">
                <option v-for="restaurant_table in restaurant_tables" :value="restaurant_table.id">
                    {{restaurant_table.table_number}}</option>
            </select>
        </div>
        
                <div class="form-group">
                    <a class="btn btn-success" v-on:click.prevent="startMeal">Start Meal</a>
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
                table_number:'',
                restaurant_tables:[],

                selectedItem: null,


            }
        },
        methods: {
            CreateMeal(){
                this.form.post('api/meals/')
                // .then(response => console.log("Success"))
                    .then(response => {
                        console.log(response);
                    })
                    .catch(error => console.log('Whoops'));

            },
            getRestaurantTables: function(){

                axios.get('api/restaurant_tables')
                    .then(response=>{ this.restaurant_tables = response.data; }); // ver a estrutura do json

            },


        },
        mounted() {
            this.getRestaurantTables();
        }


    }
</script>

<style scoped>
    tr.activerow {
        background: #123456  !important;
        color: #fff          !important;
    }

</style>