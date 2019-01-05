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
			//user: this.$store.
			return {
				id: '',
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
				axios.post('api/orders/setState/'+order.id, {id: this.$store.state.user.id}/*this.$store.state.user.id*/)
						.then(response=>{
							console.log("teste");
							// Copy object properties from response.data.data to this.user
							// without creating a new reference
							if (order.state === 'pending') {
								order.state = 'confirmed';
							} else if(order.state === 'confirmed'){
								order.state = 'in preparation';
								order.resonpible_cook_id = this.$store.state.user.id;
							} else if(order.state === 'in preparation'){
								order.state = 'prepared';
							} else if (order.state === 'prepared') {
								order.state = 'delivered';
							}
							//Object.assign(order, response.data.data);
							this.$emit('message', this.message)
							this.getOrders();
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
	        getOrders: function(){
				//this.user = [];
				//this.user = this.$store.state.user;
				console.log(this.$store.state.user.type);
				//se o user for waiter
				if (this.$store.state.user.type == 'waiter'){
					axios.get('/api/orders/waiter/'+this.$store.state.user.id).then(response=>{
					this.orders = response.data;})
					.catch(error=>{
						this.showFailure = true;
						this.failMessage = 'Error while fetching the existing orders!';
					});
				}
				//se o user for cook
				if (this.$store.state.user.type == 'cook'){
					axios.get('/api/orders/'+this.$store.state.user.id).then(response=>{
					this.orders = response.data;})
					.catch(error=>{
						this.showFailure = true;
						this.failMessage = 'Error while fetching the existing orders!';
					});
					//console.log(order);
				}
			},
			childMessage: function(message){
				this.showSuccess = true;
				this.successMessage = message;
			},
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