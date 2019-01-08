
<template>
    <v-app>
      
      <!-- SIDEBAR -->
      <v-navigation-drawer app fixed floating 
      clipped v-model="drawer" class="elevation-2" >

      <v-img :aspect-ratio="16/9" src="images/icon/banner_menu.png">
        <v-layout pa-2 column fill-height class="lightbox white--text">
          <v-spacer></v-spacer>
          <v-flex shrink>
            <v-list-tile avatar>
              <v-list-tile-avatar>
                <img src="https://randomuser.me/api/portraits/men/85.jpg">
              </v-list-tile-avatar>

              <v-list-tile-content>
                <v-list-tile-title> username </v-list-tile-title>
              </v-list-tile-content>
          </v-list-tile>
          </v-flex>
        </v-layout>
      </v-img>

      <v-list-tile class="grey lighten-3">
        <v-subheader class="grey--text text--darken-1">MENU</v-subheader>
      </v-list-tile>

      <v-list>
        
        <v-list-tile
          v-for="item in items"
          :key="item.title"
          :to="item.link"
        >
          <v-list-tile-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-tile-action>

          <v-list-tile-content>
            <v-list-tile-title>{{ item.title }}</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
      
      </v-navigation-drawer>

          <v-toolbar id="header" color="primary"
          :clipped-left="$vuetify.breakpoint.lgAndUp"
          fixed dark app height="55px">

            <v-toolbar-title class="title">
              <v-toolbar-side-icon @click.stop="drawer = !drawer">
                <v-icon large>menu</v-icon>
              </v-toolbar-side-icon>
            </v-toolbar-title>
          
            <v-spacer></v-spacer>   
            <v-btn icon @click="handleFullScreen()">
              <v-icon medium>fullscreen</v-icon>
            </v-btn>
            <v-menu offset-y origin="center center" :nudge-bottom="14" transition="scale-transition">
              <v-btn icon flat slot="activator">
              <v-badge color="red" overlap>
                <span slot="badge">3</span>
                <v-icon medium>notifications</v-icon>
              </v-badge>
              </v-btn>
            </v-menu>
            <v-menu offset-y origin="center center" :nudge-bottom="10" transition="slide-y-transition">
              <v-btn icon large flat slot="activator">
                <v-avatar size="30px">
                  <img src="https://randomuser.me/api/portraits/men/85.jpg" alt="UserName"/>
                </v-avatar>
              </v-btn>
              <v-list class="pa-0">
                <v-list-tile v-for="(item,index) in menu_toolbar" :to="!item.href ? { name: item.name } : null" :href="item.href" @click="item.click" ripple="ripple" :disabled="item.disabled" :target="item.target" rel="noopener" :key="index">
                  <v-list-tile-action v-if="item.icon">
                    <v-icon>{{ item.icon }}</v-icon>
                  </v-list-tile-action>
                  <v-list-tile-content>
                    <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                  </v-list-tile-content>
                </v-list-tile>
              </v-list>
            </v-menu>

          </v-toolbar>

        <v-content>

            <v-container fluid>
                  
               <v-slide-y-reverse-transition mode="out-in">

                 <!-- CONTENIDO PRINCIPAL -->
                  <router-view></router-view>

               </v-slide-y-reverse-transition>

            </v-container>

        </v-content>

        <!-- TOP BUTTON SCROLL : COMPONENT -->
        <ui-btntop></ui-btntop>

         <!-- theme setting -->
        <v-btn fab dark flat fixed top="top" right="right" class="setting-fab" color="grey darken-1" @click="openThemeSettings">
          <v-icon>settings</v-icon>
        </v-btn>
        <v-navigation-drawer
          class="setting-drawer"
          temporary
          right
          v-model="rightDrawer"
          hide-overlay
          fixed
          >
          <ui-theme-settings></ui-theme-settings>
        </v-navigation-drawer>        

        <v-footer class="elevation-5" color="grey lighten-3">
            <v-flex text-xs-center xs12>CS & CIA &copy; {{ new Date().getFullYear() }}</v-flex>
        </v-footer>

    </v-app>
    
</template>

<script>

  import Util from './util';

  export default {

    data: () => ({
      // TOOLBAR - MENU
      name: 'app-toolbar',
      drawer: true,
      rightDrawer: false,
      items: [
        { title: 'Home', icon: 'home', link: '/home' },
        { title: 'Empresas', icon: 'domain', link: '/empresas' },
        { title: 'Clientes', icon: 'people', link: '/clientes' },
        { title: 'Productos', icon: 'dashboard', link: '/productos' }
      ],
      menu_toolbar: [
        {
          icon: 'account_circle',
          href: '#',
          title: 'Perfil',
          click: (e) => {
            console.log(e);
          }
        },
        {
          icon: 'remove_circle_outline',
          href: '#',
          title: 'Logout',
          click: (e) => {
           axios.post('/logout').then(response => {
                    location.reload();
                }).catch(error => {
                    console.log(error);
                });
          }
        }
      ],
      right: null,
      // SCROLL TO TOP 
      offsetTop: 0
    }),
    methods: {
      // FULL SCREEN
      handleFullScreen () {
        Util.toggleFullScreen();
      },
      openThemeSettings () {
        this.$vuetify.goTo(0);
        this.rightDrawer = (!this.rightDrawer);
      }
    }
  }
</script>

<style>
  a:hover {
    text-decoration:none;
  }
</style>

<style lang="css" scoped>

  .setting-fab { 
    top:8%!important; 
    right:0;
    border-radius:0  
  }

</style>





