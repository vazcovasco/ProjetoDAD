<template>

	<div>
		<div class="jumbotron">
			<h1>{{ title }}</h1>
		</div>

		<div> 
	    <meal-list :meals="meals" ></meal-list>

		</div>
	</div>

</template>

<script type="text/javascript">
	
	
	export default {
		data: function(){
			return { 
		        title: 'List meals',
		        showSuccess: false,
		        successMessage: '',
		        currentUser: null,
				meals: [],
			}
		},
	    methods: {
	    	getMeals: function(){
	            axios.get('api/meals')
	                .then(response=>{
						this.meals = response.data;
									});
			}
		},
	    	
	}

</script>

<style scoped>	
p {
	font-size: 2em;
	text-align: center;
}
</style>