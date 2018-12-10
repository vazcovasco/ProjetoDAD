<template>
	<table class="table table-striped">
	    <thead>
	        <tr>
	            <th>Name</th>
	            <th>Description</th>
	            <th>Photo</th>
	            <th>Prices</th>	
	        </tr>
	    </thead>
	    <tbody>
	        <tr v-for="item in items"  :key="item.id">
	            <td>{{ item.name }}</td>
							<td>{{ item.description }}</td>
							<td>{{ item.price }}</td>
							<td ><img width="100px" :src="getFoodImage(item.photo_url)"></td> 
	        </tr>
	    </tbody>
	</table>
</template>

<script>
// Component code (not registered)
module.exports = {
  props: ["items"],
  data: function() {
    return {};
  },
  methods: {
		getFoodImage(photo_url) {
      return `storage/items/${photo_url}`;
		}

	}
	 
};
</script>

<style scoped>
tr.activerow {
  background: #123456 !important;
  color: #fff !important;
}
</style>