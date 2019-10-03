<template>
  <div class="container">
    <div class="row" v-if="$gate.isAdmin()">
      <div class="col-12">
        <div class="card-tools py-5">
          <button class="btn btn-primary" @click="newModal">
            Add new
            <i class="fas fa-plus fa-fw"></i>
          </button>
        </div>
        <div class="card">
          <div class="card-header card-admin">
            <h5 class="card-title mb-0 py-2">Products Table</h5>
          </div>
          <div class="card-body table-responsive pt-2 p-0">
            <table class="table table-hover">
              <tbody>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Price</th>
                  <th>Category</th>
                  <th>Description</th>
                  <th>Capacity</th>
                  <th>Size</th>
                  <th>Check Reservations</th>
                  <th>Modify</th>
                </tr>
                <tr v-for="product in products.data" :key="product.id">
                  <td>{{ product.id }}</td>
                  <td>{{ product.name }}</td>
                  <td>{{ product.price | currency }}</td>
                  <td>{{ product.category }}</td>
                  <td width="220" class="d-block">{{ product.description }}</td>
                  <td>{{ product.capacity }}</td>
                  <td>{{ product.size }}</td>
                  <td>
                    <button class="btn btn-primary" @click="modalCheck(product.id)">
                      <i class="fas fa-calendar-alt"></i>
                    </button>
                  </td>
                  <td>
                    <button class="btn btn-primary" @click="editModal(product)">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-danger" @click="deleteProduct(product.id)">
                      <i class="fas fa-trash"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <pagination :data="products" @pagination-change-page="getResults"></pagination>
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
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header modal-admin">
            <h5 class="modal-title" id="exampleModalLongTitle" v-if="!editMode">Add new</h5>
            <h5 class="modal-title" id="exampleModalLongTitle" v-if="editMode">Update</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" class="white">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editMode ? updateProduct() : createProduct()">
            <div class="modal-body">
              <div class="row">
                <div class="col-md-8">
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
                      type="text"
                      class="form-control"
                      name="price"
                      placeholder="Enter Price"
                      v-model="form.price"
                      :class="{ 'is-invalid': form.errors.has('price') }"
                    />
                    <has-error :form="form" field="price"></has-error>
                  </form>
                  <form class="form-group">
                    <select name="type" id="category" class="form-control" v-model="form.category">
                      <option
                        v-for="category in categories"
                        :key="category.id"
                        :value="category.name"
                      >{{ category.name }}</option>
                    </select>
                  </form>
                  <form class="form-group">
                    <vue-editor
                      aria-placeholder="Short description for product"
                      v-model="form.description"
                      :class="{ 'is-invalid': form.errors.has('description') }"
                    />
                    <has-error :form="form" field="description"></has-error>
                  </form>
                </div>
                <div class="col-md-4">
                  <form class="form-group">
                    <label for="product_image">Product Image</label>
                    <input type="file" class="form-control" @change="uploadImage" />
                  </form>
                  <form class="form-group">
                    <input
                      type="text"
                      class="form-control"
                      name="capacity"
                      placeholder="Enter Capacity"
                      v-model="form.capacity"
                      :class="{ 'is-invalid': form.errors.has('capacity') }"
                    />
                    <has-error :form="form" field="capacity"></has-error>
                  </form>
                  <form class="form-group">
                    <input
                      type="text"
                      class="form-control"
                      name="size"
                      placeholder="Enter Size"
                      v-model="form.size"
                      :class="{ 'is-invalid': form.errors.has('size') }"
                    />
                    <has-error :form="form" field="size"></has-error>
                  </form>
                </div>
              </div>
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

    <!-- Product Reservations Modal -->
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
                    <th>User ID</th>
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
                    <td>{{ reservation.user_id }}</td>
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
  data() {
    return {
      page: 1,
      editMode: false,
      products: {},
      categories: {},
      reservations: {},
      check_id: "",
      form: new Form({
        id: "",
        name: "",
        price: "",
        category: "",
        description: "",
        image: "",
        capacity: "",
        size: ""
      })
    };
  },

  methods: {
    loadProducts() {
      axios.get("api/products").then(({ data }) => (this.products = data));
    },

    createProduct() {
      this.form
        .post("api/products")
        .then(() => {
          Fire.$emit("AfterCreate");
          $("#addNew").modal("hide");
          toast.fire({
            type: "success",
            title: "Created in successfully"
          });
          this.$Progress.finish();
        })
        .catch(() => {});
    },

    updateProduct() {
      this.form
        .put("api/products/" + this.form.id)
        .then(() => {
          $("#addNew").modal("hide");
          swal.fire("Updated!", "Information has been updated.", "success");
          Fire.$emit("AfterCreate");
        })
        .catch(() => {});
    },

    editModal(product) {
      this.editMode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(product);
    },

    newModal() {
      this.editMode = false;
      this.form.reset();
      $("#addNew").modal("show");
    },

    uploadImage(e) {
      if (e.target.files[0]) {
        let file = e.target.files[0];

        var reader = new FileReader();

        reader.onload = file => {
          this.form.image = reader.result;
        };

        reader.readAsDataURL(file);
      }
    },

    deleteProduct(id) {
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
              .delete("/api/products/" + id)
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
        .get("api/products?page=" + page)
        .then(({ data }) => (this.products = data));
    },

    modalCheck(id) {
      this.reservations = {};
      this.check_id = id;
      $("#modalCheck").modal("show");
      axios
        .get(`api/products/${id}/reservations`)
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
        .get(`api/products/${this.check_id}/reservations?page=` + pageCheck)
        .then(({ data }) => (this.reservations = data));
    }
  },

  created() {
    this.loadProducts();
    Fire.$on("AfterCreate", () => {
      this.loadProducts();
    });

    axios
      .get("api/categories")
      .then(({ data }) => (this.categories = data.data));
  }
};
</script>

<style lang="scss">
</style>