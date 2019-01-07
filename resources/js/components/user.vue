<template>
  <div>
    <div class="jumbotron">
      <h1>{{ title }}</h1>
    </div>

    <div class="alert alert-success" v-if="showSuccess">
      <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
      <strong>{{ successMessage }}</strong>
    </div>

    <div>
      <table class="table">
        <tbody class="center">
          <tr>
            <router-link class="button" to="/register">Register New User</router-link>
          </tr>
        </tbody>
      </table>
    </div>

    <user-list
      :users="users"
      @delete-click="deleteUser"
      @restore-click="restoreUser"
      ref="usersListRef"
      @edit-click="editUser"
      @show-performance-click="showPerformance"
    ></user-list>

    <div class="pagination">
      <button
        class="btn btn-default"
        v-on:click="fetchPaginateUsers(pagination.previousPageUrl)"
        :disabled="!pagination.previousPageUrl"
      >Previous</button>
      <span>{{ pagination.currentPage }} of {{ pagination.lastPage }}</span>
      <button
        class="btn btn-default"
        v-on:click="fetchPaginateUsers(pagination.nextPageUrl)"
        :disabled="!pagination.nextPageUrl"
      >Next</button>
    </div>

    <user-edit
      :user="currentUser"
      @user-saved="saveUser"
      @user-canceled="cancelEdit"
      v-if="currentUser"
    ></user-edit>
  </div>
</template>

<script type="text/javascript">
import UserEdit from "./userEdit.vue";
import UserList from "./userList.vue";
import shift from "./shift.vue";

export default {
  data: function() {
    return {
      title: "List Users",
      editingUser: false,
      showSuccess: false,
      showFailure: false,
      successMessage: "",
      failMessage: "",
      currentUser: null,
      currentUserIndex: -1,
      users: [],
      url: "api/users",
      pagination: []
    };
  },
  methods: {
    editUser: function(user) {
      this.currentUser = user;
      this.showSuccess = false;
    },
    deleteUser: function(user) {
      axios.delete("api/users/", { params: { id: user.id } }).then(response => {
        this.showSuccess = true;
        this.successMessage = "User Deleted";
        this.getUsers();
      });
    },
    saveUser: function() {
      this.currentUser = null;
      this.$refs.usersListRef.editingUser = null;
      this.showSuccess = true;
      this.successMessage = "User Saved";
    },
    cancelEdit: function() {
      this.currentUser = null;
      this.$refs.usersListRef.editingUser = null;
    },
    restoreUser: function(user) {
      if (user.deleted_at === null) {
        this.message = "User not Softdeleted";
      } else {
        this.message = "User  Softdeleted";
      }
      /* axios.post("api/users/delete/" + user.id)
        .then(response => {
          // Copy object properties from response.data.data to this.user
          // without creating a new reference
          user.deleted_at = !user.deleted_at;

				} else {
					this.message = 'User  Softdeleted';
				}*/
      axios
        .post("api/users/delete/" + user.id)
        .then(response => {
          // Copy object properties from response.data.data to this.user
          // without creating a new reference
          user.deleted_at = !user.deleted_at;

          //Object.assign(user, response.data.data);
          this.$emit("message", this.message);
        })
        .catch(erros => {
          console.log(erros);
        });
    },
    showPerformance(id) {
      this.$router.push("/statistics/orders/" + id);
    },
    childMessage: function(message) {
      this.showSuccess = true;
      this.successMessage = message;
    },
    toggleBlockUser: function(user) {
      if (user.blocked === 1) {
        this.message = "User Unblocked";
      } else {
        this.message = "User Blocked";
      }
      axios.post("api/users/block/" + user.id).then(response => {
        // Copy object properties from response.data.data to this.user
        // without creating a new reference
        Object.assign(user, response.data.data);
        this.$emit("update-view", user);
        this.$emit("message", this.message);
      });
    },
    getUsers: function() {
      let t = this;
      axios.get(t.url).then(response => {
        console.log(response)
        t.users = response.data.data;
        t.makePagination(response.data);
      }); // ver a estrutura do json
    },
    makePagination(data) {
      var next = "";
      var previous = "";
      if(data.next_page_url != undefined) {
        next = data.next_page_url.replace("http://157.230.136.9/", "");
      } else {
        next = data.next_page_url;
      }
      if(data.prev_page_url != undefined) {
        previous = data.prev_page_url.replace("http://157.230.136.9/", "");
      }else {
        previous = data.prev_page_url;
      }

      let pagination = {
        currentPage: data.current_page,
        lastPage: data.last_page,
        nextPageUrl: next,
        previousPageUrl: previous
      }

      this.pagination = pagination;
      console.log(this.pagination)
    },
    fetchPaginateUsers(url) {
      this.url = url
      this.getUsers();
    }
  },
  components: {
    "user-list": UserList,
    "user-edit": UserEdit
  },
  mounted() {
    this.getUsers();
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