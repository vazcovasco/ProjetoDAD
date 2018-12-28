<template>
	<div class="jumbotron">
		<h1>Create Order</h1>
        
        <form method="POST" action="api/orders/">
            <div class="form-group">
                <label for="meal_id">Meal:</label>
                <select class="form-control" id="meal_id" name="meal_id" v-model="form.meal_id" >
                    <option v-for="meal in meals" v-bind:value="meal.id"> {{ meal.id }} </option>
                </select>
	        </div>

            <div class="form-group">
                <label for="item_id">Item:</label>
                <select class="form-control" id="item_id" name="item_id" v-model="form.item_id" >
                    <option v-for="item in items" v-bind:value="item.id"> {{ item.name }} </option>
                </select>
	        </div>

        <br>
        <a class="btn btn-default" v-on:click.prevent="CreateOrder()">Add</a>
        <a class="btn btn-default" v-on:click.prevent="cancelOrder()">Cancel</a>
        </form>

        
	</div>

</template>

<script type="text/javascript">
    import Form from 'vform'
	// Component code (not registered)
	export default{
		props: ["orders"],
		data: function(){
           	return{
                meals: [],
                items: [],
                form: new Form({
                })
            }			
		},
        methods: {
            getMeals: function(meal){
              axios.get('api/meals')
					.then(response=>{ this.meals = response.data; }); // ver a estrutura do json
						
            },
            getItems: function(item){
              axios.get('api/items')
					.then(response=>{ this.items = response.data; }); // ver a estrutura do json
						
			},
            CreateOrder(){
                 this.form.post('api/orders/')
                   // .then(response => console.log("Success"))
                   .then(response => {
                       console.log(response);                        
                   })
                   .catch(error => console.log('Whoops'));
                setTimeout(function() {
                    confirmOrder(order);
                }, 5000);
            },  
            confirmOrder: function(order){
                axios.post('api/orders/'+order.id)
                    .then(response=>{
                        // Copy object properties from response.data.data to this.user
						// without creating a new reference
						//user.blocked = !user.blocked;
						Object.assign(order, response.data.data);
						this.$emit('message', this.message)
					})
					.catch(erros => {
						console.log(erros);
					})
            },       
			
        },
        mounted() {
            this.getMeals();
            this.getItems();
		}
			
	}
</script>

<style scoped>
	tr.activerow {
  		background: #123456  !important;
  		color: #fff          !important;
}

</style>