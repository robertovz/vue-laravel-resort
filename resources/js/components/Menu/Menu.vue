<template>
  <div class="page-wrapper default-theme sidebar-bg bg1 toggled">
    <div class="navbar navbar-expand-lg navbar-admin">
      <div>
        <button class="btn btn-dark pull-left" @click="toggleMenu">
          <i class="fas fa-bars"></i>
        </button>
      </div>
      <ul class="mx-auto">
        <router-link to="/">Home</router-link>
      </ul>
    </div>
    <nav id="sidebar" class="sidebar-wrapper">
      <div class="sidebar-content">
        <!-- sidebar-brand  -->
        <div class="sidebar-item sidebar-brand">
          <a href="#">pro sidebar</a>
          <a href="#" class="text-right" @click="closeMenu">
            <i class="fas fa-times"></i>
          </a>
        </div>
        <!-- sidebar-header  -->
        <div class="sidebar-item sidebar-header d-flex flex-nowrap">
          <div class="user-pic">
            <img
              class="img-responsive img-rounded"
              src="/img/profile/profile.png"
              alt="User picture"
            />
          </div>
          <div class="user-info">
            <span class="user-name text-capitalize">{{ form.name }}</span>
            <span class="user-role text-capitalize">{{ form.type}}</span>
            <span class="user-status">
              <i class="fa fa-circle"></i>
              <span>Online</span>
            </span>
          </div>
        </div>
        <!-- sidebar-menu  -->
        <div class="sidebar-item sidebar-menu">
          <ul>
            <li class="header-menu" v-if="$gate.isAdmin()">
              <span>General</span>
            </li>
            <li class="sidebar-dropdown" v-if="$gate.isAdmin()">
              <a href="#">
                <i class="fa fa-tachometer-alt"></i>
                <span class="menu-text">Dashboard</span>
              </a >
              <div class="sidebar-submenu">
                <ul>
                  <li>
                    <router-link to="/users">
                      <i class="fas fa-user"></i>
                      <span class="menu-text">Users</span>
                    </router-link>
                  </li>
                  <li>
                    <router-link to="/product">
                      <i class="fa fa-shopping-cart"></i>
                      <span class="menu-text">Products</span>
                    </router-link>
                  </li>
                  <li>
                    <router-link to="/categories">
                      <i class="fas fa-project-diagram"></i>
                      <span class="menu-text">Categories</span>
                    </router-link>
                  </li>
                  <li>
                    <router-link to="/reservations">
                      <i class="fa fa-book"></i>
                      <span class="menu-text">Reservations</span>
                    </router-link>
                  </li>
                </ul>
              </div>
            </li>
            <li class="header-menu">
              <span>Extra</span>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-folder"></i>
                <span class="menu-text">Profile</span>
              </a>
            </li>
            <li>
              <router-link to="/profile">
                <i class="fa fa-cogs"></i>
                <span class="menu-text">Settings</span>
              </router-link>
            </li>
            <li>
              <router-link to="/userboard">
                <i class="fa fa-book"></i>
                <span class="menu-text">My Reservations</span>
              </router-link>
            </li>
          </ul>
        </div>
        <!-- sidebar-menu  -->
      </div>
      <!-- sidebar-footer  -->
      <div class="sidebar-footer">
        <div class="dropdown">
          <a href="#" @click.prevent="logout">
            <i class="fa fa-power-off" style="font-size: 12px"></i> Logout
          </a>
        </div>
      </div>
    </nav>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <router-view :key="$route.fullPath"></router-view>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
  </div>
  <!-- page-wrapper -->
</template>

<script>
export default {
  data() {
    return {
      form: new Form({
        id: "",
        name: "",
        type: ""
      })
    };
  },

  methods: {
    toggleMenu() {
      $(".page-wrapper").toggleClass("toggled");
    },

    closeMenu() {
      $(".page-wrapper").removeClass("toggled");
    },

    logout() {
      axios
        .post("logout")
        .then(response => {
          if (response.status === 302 || 401) {
            console.log("logout");
            this.$router.go();
          } else {
            // throw error and go to catch block
          }
        })
        .catch(error => {});
    }
  },

  mounted() {
    $(".sidebar-dropdown > a").click(function() {
      $(".sidebar-submenu").slideUp(200);
      if (
        $(this)
          .parent()
          .hasClass("active")
      ) {
        $(".sidebar-dropdown").removeClass("active");
        $(this)
          .parent()
          .removeClass("active");
      } else {
        $(".sidebar-dropdown").removeClass("active");
        $(this)
          .next(".sidebar-submenu")
          .slideDown(200);
        $(this)
          .parent()
          .addClass("active");
      }
    });
  },

  created() {
    axios.get("api/profile").then(({ data }) => this.form.fill(data));
  }
};
</script>