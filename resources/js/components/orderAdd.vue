<template>
	<div class="jumbotron">
			<h1>Create Order</h1>   

        <form method="POST" action="api/orders/">
            <!--<div class="form-group">
                <label for="meal_id">Meal:</label>
                <select class="form-control" id="meal_id" name="meal_id" v-model="order.meal_id" >
                    <option v-for="meal in meals" v-bind:value="meal.id"> {{ meal.id }} </option>
                </select>
	        </div> -->

            <select v-model="form.type">
                <label for="state">Item</label>
                <option>Waiter</option>
                <option>Cook</option>
                <option>Manager</option>
            </select>

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
		props: ["orders", "meals", "items"],
		data: function(){
           	return{
                form: new Form({
                })
            }			
		},
        methods: {
            CreateOrder(){
                 this.form.post('api/orders/')
                   // .then(response => console.log("Success"))
                   .then(response => {
                       console.log(response);                        
                   })
                   .catch(error => console.log('Whoops'));
                
            },         
			
		},
			
	}
</script>

<style scoped>
	tr.activerow {
  		background: #123456  !important;
  		color: #fff          !important;
}

</style>