<template>
  <div class="container">
    <div class="row mb-5 pb-3 py-5">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-admin">
            <h5 class="card-title mb-0 py-2">Profile</h5>
          </div>
          <div class="card-body">
            <form class="form-horizontal">
              <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12 mx-auto">
                  <form class="form-group">
                    <label for="inputName" class="col-sm-10 control-label">Name</label>
                    <div class="col-sm-12">
                      <input
                        type="text"
                        class="form-control"
                        id="inputName"
                        placeholder="Enter Name"
                        v-model="form.name"
                        :class="{ 'is-invalid': form.errors.has('name') }"
                      />
                      <has-error :form="form" field="name"></has-error>
                    </div>
                  </form>
                  <form class="form-group">
                    <label for="inputEmail" class="col-sm-10 control-label">Email</label>
                    <div class="col-sm-12">
                      <input
                        type="email"
                        class="form-control"
                        id="inputEmail"
                        placeholder="Enter Email"
                        v-model="form.email"
                        :class="{ 'is-invalid': form.errors.has('email') }"
                      />
                      <has-error :form="form" field="email"></has-error>
                    </div>
                  </form>
                  <form class="form-group">
                    <label for="inputPassword" class="col-sm-10 control-label">Password<div>(Leave it empty if not changing)</div></label>
                    
                    <div class="col-sm-12">
                      <input
                        type="password"
                        class="form-control"
                        id="inputPassword"
                        placeholder="Enter Password"
                        v-model="form.password"
                        :class="{ 'is-invalid': form.errors.has('password') }"
                      />
                      <has-error :form="form" field="password"></has-error>
                    </div>
                  </form>
                  <form class="form-group">
                    <div class="col-sm-offset-2 col-sm-12">
                      <button
                        type="submit"
                        class="btn btn-success"
                        @click.prevent="updateInfo"
                      >Update</button>
                    </div>
                  </form>
                </div>
              </div>
            </form>
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
      form: new Form({
        id: "",
        name: "",
        email: "",
        address: "",
        reservations: "",
        password: ""
      })
    };
  },

  methods: {
    updateInfo() {
      if (this.form.password == "") {
        this.form.password = undefined;
      }
      this.form
        .put("api/profile")
        .then(() => {
          swal.fire("Updated!", "Information has been updated.", "success");
          Fire.$emit("AfterCreate");
          this.$Progress.finish();
        })
        .catch(() => {});
    }
  },

  created() {
    axios.get("api/profile").then(({ data }) => this.form.fill(data));
  }
};
</script>