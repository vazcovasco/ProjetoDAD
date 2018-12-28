<template>
	<table class="table table-striped">
	    <thead>
	        <tr>
	            <th>Order ID</th>
	            <th>State</th>
				<th>Item</th>
            	<th>Meal</th>
				<th>Cook</th>
				<th>Start</th>
				<th>End</th>
				<th>Created</th>
				<th>Updated</th>
				<th>Actions</th>
	        </tr>
	    </thead>
	    <tbody>
			<!--v-bind:class="{textColorState}"-->
			<tr v-for="order in 44"  :key="order.id" v-bind:class="{textColorState}">
                <td>{{ order.id }}</td>
                <td>{{ order.state }}</td>
				<td>{{ order.item_id }}</td>
				<td>{{ order.meal_id }}</td>
				<td>{{ order.responsible_cook_id }}</td>
				<td>{{ order.start }}</td>
				<td>{{ order.end }}</td>
				<td>{{ order.created_at }}</td>
				<td>{{ order.updated_at }}</td>
				<td>
	                <a class="btn btn-sm btn-primary" click.prevent="setState(order)">State</a>
	                <a v-if="order.state='pending'" class="btn btn-sm btn-danger" v-on:click.prevent="deleteOrder(order)">Delete</a>
	            </td>
	        </tr>
	    </tbody>
	</table>
</template>

<script type="text/javascript">
	// Component code (not registered)
	module.exports={
		props:["orders"],
		data: function () {
			return {
				confirmedStyle: {
					color: 'red'
				},
				pendingStyle: {
					color:'blue'
				},
				inPreperationStyle: {
					color:'green'
				},
				currentOrder: null
			}
		},
		computed: {
			textColorState: function() {
			return {
				pendingStyle : order.state === 'pending',
				confirmedStyle : order.state === 'confirmed',
				inPreperationStyle : order.state === 'in_preparation'
   			}

			}
		},
        methods: {
            setState: function(order){
                if (order.state === 'delivered') {
					this.message = 'Order Delivered';
                } else if(order.state === 'not delivered') {
                    this.message = 'Order not delivered';
                } else if(order.state === 'in preperation'){
					this.message = 'Order is being prepared';
				} else if ($order.state === 'prepared') {
					this.message = 'Order is prepared';
				} else if(order.state === 'confirmed'){
					this.message = 'Order is confirmed';
				} else {
					this.message = 'Order is pending';
				}
                axios.post('api/orders/setState/'+order.id)
                    .then(response=>{
                        // Copy object properties from response.data.data to this.user
						// without creating a new reference
						//user.blocked = !user.blocked;
						//Object.assign(order, response.data.data);
						this.$emit('message', this.message);
						this.getOrders();
					})
					.catch(erros => {
						console.log(erros);
					})
            },		
            deleteOrder: function(order){
                this.currentOrder = null;
				this.$emit('delete-click', order);
				this.getOrders();
			}
        },	
	}
</script>

<style scoped>
/*	  Specific style applied only on the component*/
</style>