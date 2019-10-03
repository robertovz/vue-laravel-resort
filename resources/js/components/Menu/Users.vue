<template>
  <div class="container">
    <div class="row" v-if="$gate.isAdmin()">
      <div class="col-12">
        <div class="card-tools py-5">
          <button class="btn btn-primary" @click="newModal">
            Add new
            <i class="fas fa-user-plus fa-fw"></i>
          </button>
        </div>
        <div class="card">
          <div class="card-header card-admin">
            <h5 class="card-title mb-0 py-2">Users Table</h5>
          </div>
          <div class="card-body table-responsive pt-2 p-0">
            <table class="table table-hover">
              <tbody>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Type</th>
                  <th>Reservations</th>
                  <th>Check Reservations</th>
                  <th>Modify</th>
                </tr>
                <tr v-for="user in users.data" :key="user.id">
                  <td>{{ user.id }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.email }}</td>
                  <td>{{ user.type }}</td>
                  <td>{{ user.reservation.length }}</td>
                  <td>
                    <button class="btn btn-primary" @click="modalCheck(user.id)">
                      <i class="fas fa-calendar-alt"></i>
                    </button>
                  </td>
                  <td>
                    <button class="btn btn-primary" @click="editModal(user)">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-danger" @click="deleteUser(user.id)">
                      <i class="fas fa-trash"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <pagination :data="users" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div
      class="modal fade"
      id="addNew"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLongTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header modal-admin">
            <h5 class="modal-title" id="exampleModalLongTitle" v-if="!editMode">Add new</h5>
            <h5 class="modal-title" id="exampleModalLongTitle" v-if="editMode">Update</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" class="white">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editMode ? updateUser() : createUser()">
            <div class="modal-body">
              <form class="form-group">
                <input
                  type="text"
                  class="form-control"
                  name="name"
                  placeholder="Enter Name"
                  v-model="form.name"
                  :class="{ 'is-invalid': form.errors.has('name') }"
                />
                <has-error :form="form" field="name"></has-error>
              </form>
              <form class="form-group">
                <input
                  type="email"
                  class="form-control"
                  name="email"
                  placeholder="Enter Email"
                  v-model="form.email"
                  :class="{ 'is-invalid': form.errors.has('email') }"
                />
                <has-error :form="form" field="email"></has-error>
              </form>
              <form class="form-group">
                <select
                  name="type"
                  id="type"
                  class="form-control"
                  v-model="form.type"
                  :class="{ 'is-invalid': form.errors.has('type') }"
                >
                  <option value="admin">Admin</option>
                  <option value="user">Standard User</option>
                </select>
                <has-error :form="form" field="type"></has-error>
              </form>
              <form class="form-group">
                <input
                  type="password"
                  class="form-control"
                  name="password"
                  placeholder="Enter Password"
                  v-model="form.password"
                  :class="{ 'is-invalid': form.errors.has('password') }"
                />
                <has-error :form="form" field="password"></has-error>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success" v-if="editMode">Update</button>
              <button type="submit" class="btn btn-primary" v-if="!editMode">Create</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- User Reservations Modal -->
    <div
      class="modal fade bd-example-modal-xl"
      id="modalCheck"
      tabindex="-1"
      role="dialog"
      aria-labelledby="myExtraLargeModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header modal-admin">All Reservations</div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="white">&times;</span>
          </button>
          <div class="modal-body">
            <div class="card" style="overflow: auto">
              <table class="table table-striped table-hover">
                <tbody>
                  <tr>
                    <th>ID</th>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Price</th>
                    <th>is Confirmed?</th>
                    <th>Action</th>
                  </tr>
                  <tr v-for="reservation in reservations.data" :key="reservation.id">
                    <td>{{ reservation.id }}</td>
                    <td>{{ reservation.product_id }}</td>
                    <td>{{ reservation.user_name }}</td>
                    <td>{{ reservation.user_email }}</td>
                    <td>{{ reservation.check_in | myDate }}</td>
                    <td>{{ reservation.check_out | myDate }}</td>
                    <td>{{ reservation.price | currency }}</td>
                    <td>{{ reservation.status == 1 ? "Yes" : "No" }}</td>
                    <td>
                      <button class="btn btn-danger" @click="deleteReservation(reservation.id)">
                        <i class="fas fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="card-footer">
                <pagination :data="reservations" @pagination-change-page="getResultsCheck"></pagination>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Users",
  data() {
    return {
      editMode: false,
      users: {},
      reservations: {},
      form: new Form({
        id: "",
        name: "",
        email: "",
        type: "",
        password: "",
        reservations: ""
      })
    };
  },

  methods: {
    loadUsers() {
      axios.get("api/users").then(({ data }) => (this.users = data));
    },

    createUser() {
      this.form
        .post("/api/users")
        .then(() => {
          Fire.$emit("AfterCreate");
          $("#addNew").modal("hide");
          toast.fire({
            type: "success",
            title: "Signed in successfully"
          });
        })
        .catch(() => {});
    },

    updateUser(id) {
      this.form
        .put("api/users/" + this.form.id)
        .then(() => {
          $("#addNew").modal("hide");
          swal.fire("Updated!", "Information has been updated.", "success");
          Fire.$emit("AfterCreate");
        })
        .catch(() => {});
    },

    editModal(user) {
      this.editMode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(user);
    },

    newModal() {
      this.editMode = false;
      $("#addNew").modal("show");
    },

    deleteUser(id) {
      swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        })
        .then(result => {
          if (result.value) {
            this.form
              .delete("/api/users/" + id)
              .then(() => {
                swal.fire("Deleted!", "Your file has been deleted.", "success");
                Fire.$emit("AfterCreate");
              })
              .catch(() => {
                swal.fire("Failed", "There was something wrong.", "warning");
              });
          }
        });
    },

    getResults(page = 1) {
      axios
        .get("api/users?page=" + page)
        .then(({ data }) => (this.users = data));
    },

    modalCheck(id) {
      this.reservations = {};
      this.check_id = id;
      $("#modalCheck").modal("show");
      axios
        .get(`api/users/${id}/reservations`)
        .then(({ data }) => (this.reservations = data));
    },

    deleteReservation(id) {
      swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        })
        .then(result => {
          if (result.value) {
            this.form
              .delete("/api/reservations/" + id)
              .then(() => {
                swal.fire("Deleted!", "Your file has been deleted.", "success");
                this.modalCheck(this.check_id);
              })
              .catch(() => {
                swal.fire("Failed", "There was something wrong.", "warning");
              });
          }
        });
    },

    getResultsCheck(pageCheck = 1) {
      axios
        .get(`api/users/${this.check_id}/reservations?page=` + pageCheck)
        .then(({ data }) => (this.reservations = data));
    }
  },

  created() {
    this.loadUsers();

    Fire.$on("AfterCreate", () => {
      this.loadUsers();
    });
  }
};
</script>

<style lang="scss">
</style>