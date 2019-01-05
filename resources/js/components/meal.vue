<template>

	<div>
		<div class="jumbotron">
			<h1>{{ title }}</h1>
		</div>

		<router-link to="/meals/start"> <button>Start</button>  </router-link>


		<div>

			<meal-list :meals="meals"  @show-click="showMeal" ></meal-list>
			<meal-show :meal="currentMeal" :meals="meals" v-if="currentMeal"   ></meal-show>



		</div>
	</div>

</template>
<script type="text/javascript">
	import mealList	 from './mealList.vue';
	import mealShow from './mealShow.vue';

	export default {
		data: function(){
			return {
				title: 'List meals',
				showSuccess: false,
				successMessage: '',
				currentMeal: null,
				showingMeal: false,
				meals:[],
				restaurant_tables:[]
			}
		},
		methods: {
			getMeals: function(){
				axios.get('api/meals/get/'+this.$store.state.user.id)
						.then(response=>{this.meals = response.data;});
			},
			getRestaurantTables: function(){

				axios.get('api/restaurant_tables')
						.then(response=>{ this.restaurant_tables = response.data; }); // ver a estrutura do json

			},
			showMeal: function (meal) {
				console.log(meal);
				this.currentMeal = meal;
				this.showSuccess = false;


				axios.get('api/meals/'+ meal.id)
						.then(response => {
							this.meals=response.data;

							console.log(response);
						}); // ver a estrutura do json

			},
		},
		mounted() {
			this.getMeals();
		},
		components: {
			'meal-list': mealList,
			'meal-show': mealShow,

		},

	}

</script>

<style scoped>
	p {
		font-size: 2em;
		text-align: center;
	}
</style>