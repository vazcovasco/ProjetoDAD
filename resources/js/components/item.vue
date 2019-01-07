<template>
  <div>
    <div class="jumbotron">
      <h1>{{ title }}</h1>
    </div>
    <div>
      <table class="table">
        <tbody class="center">
          <tr>
            <router-link
              v-if="this.$store.getters.loggedIn && this.$store.getters.isManager"
              class="button"
              to="/items/add"
            >Register New Item</router-link>
          </tr>
        </tbody>
      </table>
    </div>

    <div>
      <item-list
        :items="items"
        @delete-click="deleteItem"
        @restore-click="restoreItem"
        ref="itemsListRef"
        @edit-click="editItem"
      ></item-list>

      <div class="pagination">
        <button
          class="btn btn-default"
          v-on:click="fetchPaginateItems(pagination.previousPageUrl)"
          :disabled="!pagination.previousPageUrl"
        >Previous</button>
        <span>{{ pagination.currentPage }} of {{ pagination.lastPage }}</span>
        <button
          class="btn btn-default"
          v-on:click="fetchPaginateItems(pagination.nextPageUrl)"
          :disabled="!pagination.nextPageUrl"
        >Next</button>
      </div>

      <item-edit
        :item="currentItem"
        @item-saved="saveItem"
        @item-canceled="cancelEdit"
        v-if="currentItem"
      ></item-edit>
    </div>
  </div>
</template>

<script type="text/javascript">
import ItemEdit from "./itemEdit.vue";
import ItemList from "./itemList.vue";

export default {
  data: function() {
    return {
      title: "List item",
      editingItem: false,
      showSuccess: false,
      showFailure: false,
      successMessage: "",
      failMessage: "",
      currentItem: null,
      currentItemIndex: -1,
      items: [],
      url: "api/items",
      pagination: []
    };
  },
  methods: {
    editItem: function(item) {
      this.isLoggedIn = this.$store.getters.loggedIn;
      this.currentItem = item;
      this.showSuccess = false;
    },
    deleteItem: function(item) {
      axios.delete("api/items/", { params: { id: item.id } }).then(response => {
        this.showSuccess = true;
        this.successMessage = "Item Deleted";
        this.getItems();
      });
    },
    saveItem: function() {
      this.currentItem = null;
      this.$refs.itemsListRef.editingItem = null;
      this.showSuccess = true;
      this.successMessage = "Item Saved";
    },
    cancelEdit: function() {
      this.currentItem = null;
      this.$refs.itemsListRef.editingItem = null;
    },
    restoreItem: function(item) {
      if (item.deleted_at === null) {
        this.message = "Item not Softdeleted";
      } else {
        this.message = "Item  Softdeleted";
      }
      axios
        .post("api/items/delete/" + item.id)
        .then(response => {
          // Copy object properties from response.data.data to this.user
          // without creating a new reference
          item.deleted_at = !item.deleted_at;

          //Object.assign(user, response.data.data);
          this.$emit("message", this.message);
        })
        .catch(erros => {
          console.log(erros);
        });
    },
    getItems: function() {
      let t = this;
      axios.get(t.url).then(response => {
        console.log(response);
        t.items = response.data.data;
        t.makePagination(response.data);
      }); // ver a estrutura do json
    },
    makePagination(data) {
      var next = "";
      var previous = "";
      if (data.next_page_url != undefined) {
        next = data.next_page_url.replace("http://157.230.136.9/", "");
      } else {
        next = data.next_page_url;
      }
      if (data.prev_page_url != undefined) {
        previous = data.prev_page_url.replace("http://157.230.136.9/", "");
      } else {
        previous = data.prev_page_url;
      }

      let pagination = {
        currentPage: data.current_page,
        lastPage: data.last_page,
        nextPageUrl: next,
        previousPageUrl: previous
      };

      this.pagination = pagination;
      console.log(this.pagination);
    },
    fetchPaginateItems(url) {
      console.log(url);
      this.url = url;
      this.getItems();
    }
  },
  components: {
    "item-list": ItemList,
    "item-edit": ItemEdit
  },
  mounted() {
    this.getItems();
  }
};
</script>

<style scoped>
p {
  font-size: 2em;
  text-align: center;
}

.center {
  text-align: center;
}

.button {
  background-color: #4caf50;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}
</style>