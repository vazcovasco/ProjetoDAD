<template>
	<div>
		<div class="jumbotron">
			<h1>{{ title }}</h1>
		</div>

		<router-link to="/orders/add"> <button>Add</button>  </router-link>

		<order-list :orders="orders" @set_state-click="setState" @delete-click="deleteOrder" > </order-list>
		<!--<order-list :orders="orders" @delete-click="deleteOrder" @message="childMessage" ref="ordersListRef"></order-list> -->

		<div class="alert alert-success" v-if="showSuccess">

			<button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
			<strong>{{ successMessage }}</strong>
		</div>

	</div>
</template>

<script type="text/javascript">
	import OrderList from './orderList.vue';

	export default {
		data: function(){
			return {
				title: 'List of Orders',
				showSuccess: false,
				successMessage: '',
				currentOrder: null,
				orders: [],
				meals: [],
				items: []
			}
		},
		methods: {
			setState: function(order){
				if (order.state === 'delivered') {
					this.message = 'Order Delivered';
				} else if(order.state === 'not delivered') {
					this.message = 'Order not delivered';
				} else if(order.state === 'in preparation'){
					this.message = 'Order is being prepared';
				} else if (order.state === 'prepared') {
					this.message = 'Order is prepared';
				} else if(order.state === 'confirmed'){
					this.message = 'Order is confirmed';
				} else {
					this.message = 'Order is pending';
				}
				axios.post('api/orders/'+order.id)
						.then(response=>{
							// Copy object properties from response.data.data to this.user
							// without creating a new reference
							if (order.state === 'pending') {
								order.state = 'confirmed';
							} else if(order.state === 'confirmed'){
								order.state = 'in preparation';
							} else if(order.state === 'in preparation'){
								order.state = 'prepared';
							} else if (order.state === 'prepared') {
								order.state = 'delivered';
							} else if(order.state === 'delivered'){
								order.state = 'not delivered';
							}
							Object.assign(order, response.data.data);

							this.$emit('message', this.message)
						})
						.catch(erros => {
							console.log(erros);
						})
			},
			deleteOrder: function(order){
				axios.delete('api/orders/'+order.id)
						.then(response => {
							this.showSuccess = true;
							this.successMessage = 'Order Deleted';
							this.getOrders();
						});
			},
			/*savedOrder: function(){
                this.currentOrder = null;
                this.$refs.ordersListRef.editingOrder = null;
                this.showSuccess = true;
                this.successMessage = 'Order Saved';
            },*/
	        getOrders: function(){

                axios.get('api/orders').then(response=>{
				this.orders = response.data;})
				.catch(error=>{
					this.showFailure = true;
					this.failMessage = 'Error while fetching the existing orders!';
				});
				//console.log(order);
			},
			childMessage: function(message){
				this.showSuccess = true;
				this.successMessage = message;
			}
	    },
	   	components: {
	    	'order-list': OrderList,
	    },
	    mounted() {
			this.getOrders();

		}

	}
</script>

<style scoped>
	p {
		font-size: 2em;
		text-align: center;
	}
</style>