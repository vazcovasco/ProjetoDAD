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
	        <tr v-for="order in orders"  :key="order.id">
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
	                <a class="btn btn-sm btn-primary" click.prevent="setState(order)">Edit</a>
	                <a class="btn btn-sm btn-danger" v-on:click.prevent="deleteOrder(order)">Delete</a>
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
				currentOrder: null
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
						this.$emit('message', this.message)
					})
					.catch(erros => {
						console.log(erros);
					})
            },		
            deleteOrder: function(order){
                this.currentOrder = null;
                this.$emit('delete-click', order);
			}
        },	
	}
</script>

<style scoped>
/*	  Specific style applied only on the component*/
</style>