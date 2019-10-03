<template>
  <!-- Modal -->
  <div
    class="modal fade bd-example-modal-xl"
    tabindex="-1"
    role="dialog"
    id="compare"
    aria-labelledby="myLargeModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-xl">
      <div class="modal-content modal-compare">
        <div class="modal-header modal-custom-header">
          <div class="p-1 mt-2 font-weight-bold text-uppercase">Compare List</div>
          <button type="button" class="close white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card compare-card">
            <div class="card-body table-responsive p-0">
              <table class="table table-striped table-hover">
                <tbody>
                  <tr>
                    <td class="font-weight-bold text-left" style="margin-top: 50%">Product</td>
                    <td v-for="item in this.$store.state.compareItems" :key="item.id">
                      <router-link
                        :to="{ name: 'Details', 
                    params: { p_product: item }}"
                        class="text-center d-block"
                        data-dismiss="modal"
                        aria-label="Close"
                      >
                        <img
                          :src="'img/products/' + item.image"
                          class="card-img-top"
                          alt="..."
                          style="width: 250px; margin: 0 auto"
                        />
                      </router-link>
                      <button
                        @click="$store.commit('removeFromCompareItems', item)"
                        class="btn btn-primary-outline d-block text-right"
                      >
                        <i class="fas fa-trash red"></i>
                      </button>
                      <router-link
                        :to="{ name: 'Details', 
                    params: { p_product: item }}"
                        class="text-center black d-block"
                        data-dismiss="modal"
                        aria-label="Close"
                      >{{ item.name }}</router-link>
                    </td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold text-left">Price</td>
                    <td v-for="item in this.$store.state.compareItems" :key="item.id" class="green">
                      {{ item.price | currency }}
                      <span class="black">/ Per Night</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold text-left">Description</td>
                    <td
                      style="max-width: 170px"
                      v-for="item in  this.$store.state.compareItems"
                      :key="item.id"
                      v-html="item.description"
                    ></td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold text-left">Category</td>
                    <td
                      v-for="item in  this.$store.state.compareItems"
                      :key="item.id"
                      class="text-capitalize"
                    >{{ item.category }}</td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold text-left">Capacity</td>
                    <td
                      v-for="item in  this.$store.state.compareItems"
                      :key="item.id"
                      class="text-capitalize"
                    >{{ item.capacity }}</td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold text-left">Size</td>
                    <td
                      v-for="item in  this.$store.state.compareItems"
                      :key="item.id"
                      class="text-capitalize"
                    >{{ item.size }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- modal -->
</template>

<script>
export default {
  props: ["modals"],
  data() {
    return {};
  },
  methods: {
    openCompareItems() {
      Fire.$emit("quantity");
      if (this.$store.state.compareItems.length === 0) {
        $("compare").modal("hide");
      }
    }
  },
  mounted() {
    if (this.$store.state.compareItems.length === 0) {
      $("compare").modal("hide");
    }
  },
  created() {
    Fire.$on("quantity", () => {
      this.openCompareItems();
    });
  }
};
</script>

<style>
.compare-card {
  max-height: 470px;
  overflow-y: auto;
  text-align: center;
}
.modal-compare td {
  min-width: 200px;
}
</style>