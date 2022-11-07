<template>
  <div class="navbar-container d-flex content align-items-center">

    <!-- Nav Menu Toggler -->
    <ul class="nav navbar-nav d-xl-none">
      <li class="nav-item">
        <b-link
          class="nav-link"
          @click="toggleVerticalMenuActive"
        >
          <feather-icon
            icon="MenuIcon"
            size="21"
          />
        </b-link>
      </li>
    </ul>


    <b-navbar-nav class="nav align-items-center ml-auto">
      <dark-Toggler class="d-none d-lg-block" />
      <b-nav-item-dropdown
        right
        toggle-class="d-flex align-items-center dropdown-user-link"
        class="dropdown-user"
      >
        <template #button-content>
          <div class="d-sm-flex d-none user-nav">
            <p class="user-name font-weight-bolder mb-0">
              {{userData.username}}
            </p>
            <span class="user-status" v-if="userData.is_admin == 1">
              Admin
            </span>
          </div>
          <b-avatar
            size="40"
            variant="light-primary"
            
            :src="`/image/${userData.image}`"
            class="badge-minimal"
            badge-variant="success"
          />
        </template>

       <!--  <b-dropdown-item link-class="d-flex align-items-center">
          <feather-icon
            size="16"
            icon="UserIcon"
            class="mr-50"
          />
          <span>Profile</span>
        </b-dropdown-item> -->

        <b-dropdown-item
          :to="{ name: 'account-setting' }"
          link-class="d-flex align-items-center"
        >
          <feather-icon
            size="16"
            icon="SettingsIcon"
            class="mr-50"
          />
          <span>Setting</span>
        </b-dropdown-item>

        <b-dropdown-item link-class="d-flex align-items-center">
          <feather-icon
            size="16"
            icon="MailIcon"
            class="mr-50"
          />
          <span>Inbox</span>
        </b-dropdown-item>

        <b-dropdown-item link-class="d-flex align-items-center">
          <feather-icon
            size="16"
            icon="CheckSquareIcon"
            class="mr-50"
          />
          <span>Task</span>
        </b-dropdown-item>

        <b-dropdown-item link-class="d-flex align-items-center">
          <feather-icon
            size="16"
            icon="MessageSquareIcon"
            class="mr-50"
          />
          <span>Chat</span>
        </b-dropdown-item>

        <b-dropdown-divider />

        <b-dropdown-item link-class="d-flex align-items-center" @click="logout"> 
          <feather-icon
            size="16"
            icon="LogOutIcon"
            class="mr-50"
          />
          <span>Logout</span>
        </b-dropdown-item>
      </b-nav-item-dropdown>
    </b-navbar-nav>
  </div>
</template>

<script>
import {
  BLink, BNavbarNav, BNavItemDropdown, BDropdownItem, BDropdownDivider, BAvatar,
} from 'bootstrap-vue'
import DarkToggler from '@core/layouts/components/app-navbar/components/DarkToggler.vue'
import ValidateUser from '../../../api/login'
export default {
  components: {
    BLink,
    BNavbarNav,
    BNavItemDropdown,
    BDropdownItem,
    BDropdownDivider,
    BAvatar,

    // Navbar Components
    DarkToggler,
  },
  props: {
    toggleVerticalMenuActive: {
      type: Function,
      default: () => {},
    },
  },
  data(){
    return{
      userData:'',
      userType:'',
      image:''

    }
  },
   mounted() {

  },
  created()
  {
    //console.log("in  navbar.vue comp");
    this.setUserdata();
     this.userData = JSON.parse(localStorage.getItem("userData"));
  },
   methods: {
     setUserdata()
    {
      if(this.$route.params.user)
      {
        console.log('in horizental nav the route params are',this.$route.params.user);
        const userData = JSON.stringify(this.$route.params.user);
        localStorage.setItem('userData', userData);
      }
      
    },
    logout() {
      ValidateUser.logout(
        data=>{
          // console.log(response);
          if(data.success){
            //this.$router.push({ name: 'login'});
          }
        },
        err=>{
          console.log(err);
        }
      )
      // localStorage.removeItem(useJwt.jwtConfig.storageTokenKeyName)
      // localStorage.removeItem(useJwt.jwtConfig.storageRefreshTokenKeyName)

      localStorage.removeItem('userData')

      // this.$ability.update(initialAbility)
    setTimeout(function(){
      window.location.reload();
    },500)
      this.$router.push({ name: 'auth-login' })
    },
  },
}
</script>
